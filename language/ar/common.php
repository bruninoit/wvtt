<?php
/**
*
* Who Visited This Topic extension for the phpBB Forum Software package.
* Arabic translation by Bassel Taha Alhitary (http://www.alhitary.net)
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
'ACL_U_WVTT'		=> 'يستطيع مُشاهدة الإضافة : من قرأ هذا الموضوع',
'ACL_U_WVTT_COUNT'		=> 'يستطيع مُشاهدة عدد مشاهدات الموضوع لكل عضو',
'ACL_U_WVTT_POPUP'		=> 'يستطيع مُشاهدة التاريخ في الإضافة : من قرأ هذا الموضوع',
'ACL_U_WVTT_PROFILE'		=> 'يستطيع مُشاهدة "آخر المواضيع التي قراءها" (في الملف الشخصي)',	
'EXTENSION_BY'		=> 'الإضافة بواسطة',	
'WVTT_DETAILS'		=> 'انظر التفاصيل',
'WVTT_PROFILE'		=> 'آخر المواضيع التي قراءها',
'WVTT_TITLE'		=> 'من قرأ هذا الموضوع',
));
