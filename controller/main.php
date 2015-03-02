<?php
/**
*
* @package Who Visited This Topic
* @copyright (c) 2015 BruninoIt
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace bruninoit\wvtt\controller;
class main
{
  protected $auth;
	protected $template;
	protected $db;
	protected $wvtt_table;
	protected $user;

	public function __construct(\phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, $wvtt_table, \phpbb\auth\auth $auth, \phpbb\user $user)	{
		$this->template = $template;
		$this->db = $db;
		$this->wvtt_table = $wvtt_table;
		$this->auth = $auth;
		$this->user = $user;
	
	public function handle($topic_id)
	{
  	$page_name=$this->user->lang['WVTT_TITLE'];
  	
  	//content start
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
    }
	if($this->auth->acl_get('u_wvtt'))
		{
		$this->template->assign_var('PERMISSION_VIEW', true);
		}
    //content end
  	
  	
		return $this->helper->render('wvtt_popup.html', $page_name);
	}
}
