<?php
/**
*
* Who Visited This Topic extension for the phpBB Forum Software package.
* Russian translation by Alecto
*
* @copyright (c) 2015 brunino
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACL_U_WVTT'		=> 'Может видеть тех, кто посещал темы',
	'ACL_U_WVTT_COUNT'		=> 'Может видеть счетчики посещения темы пользователями',
	'ACL_U_WVTT_POPUP'		=> 'Может видеть даты посещения темы',
	'ACL_U_WVTT_PROFILE'		=> 'Может видеть темы, посещенные пользователем (в профиле)',
	'EXTENSION_BY'		=> 'Расширение',
	'WVTT_DETAILS'		=> 'Смотрите подробности',
	'WVTT_PROFILE'		=> 'Последние посещенные темы',
	'WVTT_TITLE'		=> 'Кто просматривал эту тему',
));
