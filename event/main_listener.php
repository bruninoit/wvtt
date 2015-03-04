<?php
/**
*
* @package Who Visit This Topic
* @copyright (c) 2013 Bruninoit
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
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
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.viewtopic_get_post_data'					=> 'viewtopic_actions',
			'core.permissions'						=> 'permission_wvtt',
			'core.delete_user_after'					=> 'delete_user_view'
			);
	}
	/* @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\user */
	protected $user;
	protected $wvtt_table;
	protected $root_path;
	protected $phpEx;
	/** @var \phpbb\auth\auth */
	protected $auth;
	
	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $root_path, $phpEx, $wvtt_table, \phpbb\auth\auth $auth)	{
		$this->template = $template;
		$this->db = $db;
		$this->user = $user;
		$this->wvtt_table = $wvtt_table;
		$this->root_path = $root_path;
		$this->phpEx   = $phpEx;
		$this->auth = $auth;
	}

	public function delete_user_view($event)
	{
	$userid_array=$event['user_ids'];
	$cont = count($userid_array);
	for($i=0;$i<$cont;$i++)
	{
	$user_id=$userid_array[$i];
	$sql = 'DELETE FROM ' . $this->wvtt_table . '
	WHERE user_id = ' . $user_id . '';
	$this->db->sql_query($sql);	
	}
	}

	public function permission_wvtt($event)
	{
	$permissions = $event['permissions'];
	$permissions['u_wvtt'] = array('lang' => 'ACL_U_WVTT', 'cat' => 'misc');
	$permissions['u_wvtt_popup'] = array('lang' => 'ACL_U_WVTT_POPUP', 'cat' => 'misc');
	$event['permissions'] = $permissions;
	}
	
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'bruninoit/wvtt',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	public function viewtopic_actions($event)
	{
    $topic_id=$event['topic_id'];
    $user_id=$this->user->data['user_id'];
    
    //query insert
    if($user_id!=1)
      	{
      	$date=time();
    	$sql_arr = array(
    	'user_id'    => $user_id,
    	'topic_id'        => $topic_id,
    	'date'	=> $date
		);
		$sql_insert = 'INSERT INTO ' . $this->wvtt_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
		$this->db->sql_query($sql_insert);
		}
    
    
    //list
  if($this->auth->acl_get('u_wvtt'))
    { //permission start
    $query = "SELECT w.*, u.*
	 FROM " . $this->wvtt_table . " w, " . USERS_TABLE . " u
	 WHERE w.topic_id = " . $topic_id . "
	 AND w.user_id=u.user_id
	 GROUP BY w.user_id
	 ORDER BY w.user_id";
  $list_query = $this->db->sql_query($query);
  while ($list = $this->db->sql_fetchrow($list_query))
    {
    	$username = $list['username'];
	$user_colour = ($list['user_colour']) ? ' style="color:#' . $list['user_colour'] . '" class="username-coloured"' : '';
    	$user_id = $list['user_id'];
    	$date = $list['date'];
    	$cont = "SELECT COUNT(user_id) AS total
    	FROM " . $this->wvtt_table . "
    	WHERE  topic_id = " . $topic_id . "
    	AND  user_id = " . $user_id . "";
    	$result = $this->db->sql_query($cont);
    	$visits = (int) $this->db->sql_fetchfield('total');
    	$url = "{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&u={$user_id}";
     $this->template->assign_block_vars('wvtt_list',array(
	'USERNAME'			=> $username,
	'USERNAME_COLOUR'	        => $user_colour,
	'VISITS'			=> $visits,
	'URL'				=> $url,
	'DATE'				=> $date
	));
    }//permission end
	if($this->auth->acl_get('u_wvtt'))
		{
		$this->template->assign_var('PERMISSION_VIEW', true);
		}
	if($this->auth->acl_get('u_wvtt_popup'))
		{
		$this->template->assign_var('PERMISSION_POPUP', true);
		}
	$url_popup="{$this->root_path}app.{$this->phpEx}/wvtt/{$topic_id}";
	$this->template->assign_var('URL_POPUP', $url_popup);
    }
    }
}

