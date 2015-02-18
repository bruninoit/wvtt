<?php
/** 
* 
* @package StaffIt - Top Ten Topics 
* @copyright (c) 2014 brunino
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2 
* 
*/ 
namespace staffit\toptentopics\migrations;
class release_0_1_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['toptentopics_forum']);
	}
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}
	public function update_data()
	{
    return array(
        'add_tables' => [
            $this->table_prefix . 'wvtt' => [
                'COLUMNS' => [
                    'user_id'        => ['VCHAR', ''],
                    'topic_id'        => ['MTEXT', ''],
                ],
            ],
        ],
    );
}

public function revert_schema()
{
    return array(
        'drop_tables' => [
            $this->table_prefix . 'wvtt',
        ],
    );
}
 
			)),
		);
	}
}
