<?php
/** 
* 
* @package Who Visit This Topic 
* @copyright (c) 2014 brunino
* @translated by Alecto
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
	'WVTT_TITLE'			=> 'Кто просматривал эту тему',
	'WVTT_PROFILE'			=> 'Последние посещенные темы',
        'EXTENSION_BY'			=> 'Расширение',
        'ACL_U_WVTT'			=> 'Может видеть тех, кто посещал темы',
        'ACL_U_WVTT_POPUP'		=> 'Может видеть даты посещения темы',
        'ACL_U_WVTT_COUNT'		=> 'Может видеть счетчики посещения темы пользователями',
        'ACL_U_WVTT_PROFILE'		=> 'Может видеть темы, посещенные пользователем (в профиле)'
));
