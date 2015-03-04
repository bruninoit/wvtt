<?php
/** 
* 
* @package Who Visit This Topic
* @copyright (c) 2014 brunino
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2 
* 
*/ 
namespace bruninoit\wvtt\migrations;
class release_0_1_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}
	public function update_schema()
	{
return array(
			'add_tables'	=> array(
				$this->table_prefix . 'wvtt'	=> array(
					'COLUMNS'	=> array(
						'user_id'						=> array('UINT', null),
						'topic_id'						=> array('UINT', null),
						'date'							=> array('TIMESTAMP', 0),
					),
				),
			),
		);

	}
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'wvtt'
			),
		);
	}

}
