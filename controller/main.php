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
    protected $helper;

	public function __construct(\phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, $wvtt_table, \phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\controller\helper $helper)
    {
		$this->template = $template;
		$this->db = $db;
		$this->wvtt_table = $wvtt_table;
		$this->auth = $auth;
		$this->user = $user;
        $this->helper = $helper;
	}
    
	public function handle($topic_id)
	{
  	$page_name=$this->user->lang['WVTT_TITLE'];
  	
    //content start
   //topic title
    $topic_query = "SELECT topic_title
	 FROM " . TOPICS_TABLE . "
	 WHERE topic_id = " . $topic_id . "";
   $topic_query_g = $this->db->sql_query($topic_query);
   $topic_query_arr = $this->db->sql_fetchrow($topic_query_g);
   $topic_title = $topic_query_arr['topic_title'];
   $this->template->assign_var('TOPIC_TITLE', $topic_title);

   
   //list
    $query = "SELECT w.*, u.*
	 FROM " . $this->wvtt_table . " w, " . USERS_TABLE . " u
	 WHERE w.topic_id = " . $topic_id . "
	 AND w.user_id=u.user_id
	 GROUP BY w.user_id";
  $list_query = $this->db->sql_query($query);
  while($list = $this->db->sql_fetchrow($list_query))
    {
    $username = $list['username'];
	$user_colour = ($list['user_colour']) ? ' style="color:#' . $list['user_colour'] . '" class="username-coloured"' : '';
    	$user_id = $list['user_id'];
    if($this->auth->acl_get('u_wvtt_count'))
	{
    	$cont = "SELECT COUNT(user_id) AS total
    	FROM " . $this->wvtt_table . "
    	WHERE  topic_id = " . $topic_id . "
    	AND  user_id = " . $user_id . "";
    	$result = $this->db->sql_query($cont);
    	$visits = (int) $this->db->sql_fetchfield('total');
	}else{
	$visits = null;	
	}
   
	
        $date = "SELECT date
    	FROM " . $this->wvtt_table . "
    	WHERE  topic_id = " . $topic_id . "
    	AND  user_id = " . $user_id . "
        ORDER BY date DESC";
    	$date_query = $this->db->sql_query($date);
    	$date_array = $this->db->sql_fetchrow($date_query);
        $date = $date_array['date'];
        $date = $this->user->format_date($date);
        
     $this->template->assign_block_vars('wvtt_list',array(
	'USERNAME'			=> $username,
	'USERNAME_COLOUR'	        => $user_colour,
	'VISITS'			=> $visits,
	'DATE'				=> $date
	));
    }
	
	if($this->auth->acl_get('u_wvtt_popup'))
		{
		$this->template->assign_var('PERMISSION_VIEW', true);
		}
	if($this->auth->acl_get('u_wvtt_count'))
		{
		$this->template->assign_var('PERMISSION_COUNT', true);
		}
    //content end
    
  	
		return $this->helper->render('wvtt_popup.html', $page_name);
	}
}
