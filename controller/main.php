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
namespace bruninoit\wvtt\controller;

/**
* Just do it
*/
class main
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string table_prefix */
	protected $table_prefix;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth                     $auth                Authentication object
	* @param \phpbb\controller\helper             $controller_helper   Controller helper object
	* @param \phpbb\db\driver\driver_interface    $db                  Database object
	* @param \phpbb\template\template             $template            Template object
	* @param \phpbb\user                          $user                User object
	* @param string                               $table_prefix        table_prefix
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\controller\helper $controller_helper, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user, $table_prefix)
	{
		$this->auth = $auth;
		$this->controller_helper = $controller_helper;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->table_prefix = $table_prefix;
	}

	/**
	 * Show details popup
	 *
	 * @param object $topic_id The topic id
	 * @return null
	 * @access public
	 */
	public function handle($topic_id)
	{
		$sql = 'SELECT topic_title
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . (int) $topic_id;
		$result = $this->db->sql_query($sql);
		$this->template->assign_var('TOPIC_TITLE', (string) censor_text($this->db->sql_fetchfield('topic_title')));
		$this->db->sql_freeresult($result);

		$sql = 'SELECT w.user_id, MAX(w.date) AS visit_date, u.username, u.user_colour, COUNT(w.user_id) AS user_visits
			FROM ' . $this->table_prefix . 'wvtt w, ' . USERS_TABLE . ' u
			WHERE w.topic_id = ' . (int) $topic_id . '
				AND w.user_id = u.user_id
			GROUP BY w.user_id';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
    {
			$this->template->assign_block_vars('userrow',array(
				'USERNAME' => get_username_string('username', $row['user_id'], $row['username'], $row['user_colour']),
				'USERNAME_COLOUR' => get_username_string('colour', $row['user_id'], $row['username'], $row['user_colour']),
				'USERNAME_FULL' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),

				'TOPIC_VISITS' => $row['user_visits'],
				'LAST_VISIT_TIME' => $this->user->format_date($row['visit_date']),

				'U_USERNAME' => get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour']),
			));
		}
		$this->db->sql_freeresult($result);

		// switches
		$this->template->assign_var('S_DISPLAY_VISITED_TOPICS', $this->auth->acl_get('u_wvtt_popup'));
		$this->template->assign_var('S_DISPLAY_COUNTER', $this->auth->acl_get('u_wvtt_count'));

		return $this->controller_helper->render('wvtt_popup.html', $this->user->lang['WVTT_TITLE']);
	}
}
