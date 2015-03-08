<?php
/** 
* 
* @package Who Visit This Topic
* @copyright (c) 2014 brunino
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2 
* 
*/ 
namespace bruninoit\wvtt\migrations;
class release_0_1_0_rc2 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}
	public function update_data()
	{
	return array(
	array('permission.add', array('u_wvtt_count', true)),
	array('permission.permission_set', array('REGISTERED', 'u_wvtt_count', 'group', true)),
	array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_wvtt_count', 'rule', true)),
	array('permission.permission_set', array('ROLE_ADMIN_FULL', 'u_wvtt_count', 'rule', true)),
	array('permission.add', array('u_wvtt_profile', true)),
	array('permission.permission_set', array('REGISTERED', 'u_wvtt_profile', 'group', true)),
	array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_wvtt_profile', 'rule', true)),
	array('permission.permission_set', array('ROLE_ADMIN_FULL', 'u_wvtt_profile', 'rule', true)),
  );
}
}
