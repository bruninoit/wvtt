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
			'core.viewtopic_get_post_data'					=> 'viewtopic_actions'		);
	}
	/* @var \phpbb\controller\helper */
	protected $helper;
	/* @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\user */
	protected $user;
	protected $wvtt_table;
	protected $root_path;
	protected $phpEx;
	
	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $root_path, $phpEx, $wvtt_table)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->db = $db;
		$this->user = $user;
		$this->wvtt_table = $wvtt_table;
		$this->root_path = $root_path;
		$this->phpEx   = $phpEx;
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
    if($user_id=!=1)
      	{
    	$sql_arr = array(
    	'user_id'    => $user_id,
    	'topic_id'        => $topic_id
		);
		$sql_insert = 'INSERT INTO ' . $this->wvtt_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
		$this->db->sql_query($sql_insert);
		}
    
    
    //list
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
    	$user_id = $list['user_id'];
    	$cont = "SELECT COUNT(user_id) AS total
    	FROM " . $this->wvtt_table . "
    	WHERE  topic_id = " . $topic_id . "
    	AND  user_id = " . $user_id . "";
    	$result = $this->db->sql_query($cont);
    	$visits = (int) $this->db->sql_fetchfield('total');
    	$url = "{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&u={$user_id}";
     $this->template->assign_block_vars('wvtt_list',array(
	'USERNAME'			=> $username,
	'VISITS'			=> $visits,
	'URL'				=> $url
	));
    }
   
    }
}
