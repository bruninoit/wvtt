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
			'core.viewtopic_assign_template_vars_before'						=> 'viewtopic_add',
			'core.viewtopic_get_post_data' => 'viewtopic_list'
		);
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
			'ext_name' => 'staffit/banlist',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	public function viewtopic_add($event)
	{
		$this->template->assign_vars(array(
			'U_BANLIST_PAGE'	=> $this->helper->route('staffit_banlist_controller'),
			));
	}
	
	public function viewtopic_list($event)
	{
	$topic_id=1;
	$query = "SELECT *
    FROM " . $this->wvtt_table . "
    WHERE topic_id = " . $topic_id . "";
  $list_query = $this->db->sql_query($query);
  while ($list = $this->db->sql_fetchrow($list_query))
    {
     $this->template->assign_block_vars('wvtt_list',array(
	'LAST_TOPIC_LINK'			=> $last_topic_link[$x],
	));
    }
    
    
		$this->template->assign_vars(array(
			'U_BANLIST_PAGE'	=> $this->helper->route('staffit_banlist_controller'),
			));
	}
}
