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
			'core.viewtopic_assign_template_vars_before'			=> 'viewtopic_add',
			'core.viewtopic_get_post_data'					=> 'viewtopic_list'		);
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
	
	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $wvtt_table)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->db = $db;
		$this->user = $user;
		$this->wvtt_table = $wvtt_table;
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
	public function viewtopic_add($event)
	{
//query aggiunta
	}
	
	public function viewtopic_list($event)
	{
	$topic_id=$event['topic_id'];
	$query = "SELECT w.*, u.*
	 FROM " . $this->wvtt_table . " w, " . USER_TABLE . " u
	 WHERE w.topic_id = " . $topic_id . "
	 AND w.user_id=u.user_id
	 GROUP BY w.user_id";
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
     $this->template->assign_block_vars('wvtt_list',array(
	'USERNAME'			=> $username,
	'VISITS'			=> $visits
	));
    }
	}
}
