<?php
/** 
* 
* @package Who Visit This Topic 
* @copyright (c) 2014 brunino
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2 
* 
*/ 
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'WVTT_TITLE'			=> 'Who Visited This Topic',
        'EXTENSION_BY'			=> 'Extension By',
        'ACL_U_WVTT'			=> 'Can view Who Visited A Topic',
        'ACL_U_WVTT_POPUP'		=> 'Can view the dates of who visited a topic',
));
