<?php
/** 
* 
* @package Who Visit This Topic
* @copyright (c) 2014 brunino
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2 
* 
*/ 
namespace bruninoit\wvtt\migrations;
class release_0_1_0_3 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}
	public function update_schema()
	{
	return array(
	array('permission.add', array('u_wvtt')),
	array('permission.permission_set', array('REGISTERED', 'u_wvtt', 'group')),
	array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_wvtt')),
  );
}
}
