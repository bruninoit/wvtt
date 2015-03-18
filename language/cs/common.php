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
	'WVTT_TITLE'			=> 'Kdo navštívil toto téma',
	'WVTT_PROFILE'			=> 'Poslední navštívené témata',
    'EXTENSION_BY'			=> 'Doplněk od',
    'ACL_U_WVTT'			=> 'Může vidět Kdo navštívil toto téma',
    'ACL_U_WVTT_POPUP'		=> 'Může vidět datumy těch, kdo navštívili téma',
    'ACL_U_WVTT_COUNT'		=> 'Může vidět počty navštívení tématu pro každého, kdo navštívil téma',
    'ACL_U_WVTT_PROFILE'	=> 'Může vidět poslední navštívené témata uživatelů v jejich profilu',
    'WVTT_DETAILS'          => '--Zobrazit detaily--'
));
