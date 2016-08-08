<?php
/**
*
* @package Who Visit This Topic
* @copyright (c) 2016 ABDev
* @copyright (c) 2015 Bruninoit
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @namespace
*/
namespace bruninoit\wvtt\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\content_visibility */
	protected $content_visibility;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var string table_prefix */
	protected $table_prefix;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth                     $auth                Authentication object
	* @param \phpbb\content_visibility            $content_visibility  Content visibility object
	* @param \phpbb\controller\helper             $controller_helper   Controller helper object
	* @param \phpbb\db\driver\driver_interface    $db                  Database object
	* @param \phpbb\template\template             $template            Template object
	* @param \phpbb\user                          $user                User object
	* @param string                               $phpbb_root_path     phpbb_root_path
	* @param string                               $php_ext             phpEx
	* @param string                               $table_prefix        table_prefix
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\content_visibility $content_visibility, \phpbb\controller\helper $controller_helper, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext, $table_prefix)
	{
		$this->auth = $auth;
		$this->content_visibility = $content_visibility;
		$this->controller_helper = $controller_helper;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->table_prefix = $table_prefix;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup' => 'load_language_on_setup',
			'core.permissions' => 'permission_wvtt',
			'core.memberlist_view_profile' => 'profile_list_wvtt',
			'core.delete_user_after' => 'delete_user_view',
			'core.viewtopic_get_post_data' => 'viewtopic_actions',
		);
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];

		$lang_set_ext[] = array(
			'ext_name' => 'bruninoit/wvtt',
			'lang_set' => 'common',
		);

		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* Add user permissions to manage extension
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function permission_wvtt($event)
	{
		$permissions = $event['permissions'];

		$permissions['u_wvtt'] = array('lang' => 'ACL_U_WVTT', 'cat' => 'misc');
		$permissions['u_wvtt_popup'] = array('lang' => 'ACL_U_WVTT_POPUP', 'cat' => 'misc');
		$permissions['u_wvtt_count'] = array('lang' => 'ACL_U_WVTT_COUNT', 'cat' => 'misc');
		$permissions['u_wvtt_profile'] = array('lang' => 'ACL_U_WVTT_PROFILE', 'cat' => 'misc');

		$event['permissions'] = $permissions;
	}

	/**
	* Show last visited topics list in the profile page
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function profile_list_wvtt($event)
	{
		$member = $event['member'];

		// retrieve the user profile id
		$user_id = (int) $member['user_id'];

		if ($this->auth->acl_get('u_wvtt_profile'))
		{
			$this->template->assign_var('S_DISPLAY_VISITED_TOPICS', true);

			// check forums this user can see
			$forum_ary = array();
			$forum_read_ary = $this->auth->acl_getf('f_read');

			foreach ($forum_read_ary as $forum_id => $is_auth)
			{
				if ($is_auth['f_read'])
				{
					$forum_ary[] = (int) $forum_id;
				}
			}
			$forum_ary = array_unique($forum_ary);

			if (sizeof($forum_ary))
			{
				// list five latest viewed topics
				$sql = 'SELECT t.topic_id, t.topic_title, f.forum_id, w.date
					FROM ' . FORUMS_TABLE . ' f, ' . TOPICS_TABLE . ' t, ' . $this->table_prefix . 'wvtt w
					WHERE ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary, 'f.') . '
						AND t.topic_moved_id = 0
						AND t.topic_visibility = 1
						AND w.user_id = ' . $user_id . '
						AND w.topic_id = t.topic_id
						AND f.forum_id = t.forum_id
					ORDER BY w.date DESC';
				$result = $this->db->sql_query_limit($sql, 5);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->template->assign_block_vars('topicrow',array(
						'TOPIC_TITLE' => censor_text($row['topic_title']),
						'LAST_VISIT_TIME' => $this->user->format_date($row['date']),

						'U_VIEW_TOPIC' => append_sid("{$this->phpbb_root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $row['forum_id'] . '&amp;t=' . (int) $row['topic_id']),
					));
				}
				$this->db->sql_freeresult($result);
			}

			// switch
			$this->template->assign_var('S_LAST_VISIT_TIME', $this->auth->acl_get('u_wvtt_popup'));
		}
	}

	/**
	* Delete views
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function delete_user_view($event)
	{
		$users_ary = $event['user_ids'];

		$users_cnt = count($users_ary);

		$users_ids = array();
		for ($i = 0; $i < $users_cnt; ++$i)
		{
			$users_ids[] = (int) $users_ary[$i];
		}

		$sql = 'DELETE FROM ' . $this->table_prefix . 'wvtt WHERE user_id IN (' . implode(', ', $users_ids) . ')';
		$this->db->sql_query($sql);
	}

	/**
	* Show last visited topics list in the viewtopic page
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_actions($event)
	{
    $topic_id = (int) $event['topic_id'];

    if ($this->user->data['user_id'] != ANONYMOUS)
		{
			$sql_ary = array(
				'user_id' => $this->user->data['user_id'],
				'topic_id' => $topic_id,
				'date' => time(),
			);

			$sql_insert = 'INSERT INTO ' . $this->table_prefix . 'wvtt ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql_insert);
		}

		if ($this->auth->acl_get('u_wvtt'))
		{
			$sql = 'SELECT w.user_id, w.topic_id, u.username, u.user_id, u.user_colour, u.user_type, COUNT(w.user_id) AS user_visits
				FROM ' . $this->table_prefix . 'wvtt w, ' . USERS_TABLE . ' u
				WHERE w.topic_id = ' . $topic_id . '
					AND w.user_id = u.user_id
				GROUP BY w.user_id
				ORDER BY w.user_id';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!$this->auth->acl_get('a_') && $row['user_type'] == USER_IGNORE)
				{
					continue;
				}

				$topic_visits = 0;
				if ($this->auth->acl_get('u_wvtt_count'))
				{
					$topic_visits = (int) $row['user_visits'];
				}

				$this->template->assign_block_vars('userrow',array(
					'USERNAME' => get_username_string('username', $row['user_id'], $row['username'], $row['user_colour']),
					'USERNAME_COLOUR' => get_username_string('colour', $row['user_id'], $row['username'], $row['user_colour']),
					'USERNAME_FULL' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),

					'TOPIC_VISITS' => $topic_visits,

					'U_USERNAME' => get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour']),
				));
			}
			$this->db->sql_freeresult($result);

			// switches
			$this->template->assign_var('S_DISPLAY_VISITED_TOPICS', $this->auth->acl_get('u_wvtt'));
			$this->template->assign_var('S_ENABLE_POPUP', $this->auth->acl_get('u_wvtt_popup'));
			$this->template->assign_var('S_DISPLAY_COUNTER', $this->auth->acl_get('u_wvtt_count'));

			$this->template->assign_var('URL_POPUP', $this->controller_helper->route('bruninoit_wvtt_controller', array('topic_id' => $topic_id)));
		}
	}
}
