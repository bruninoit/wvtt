<?php
/** 
* 
* @package Who Visit This Topic 
* @copyright (c) 2014 brunino
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2 
* 
* Translated By : Bassel Taha Alhitary - www.alhitary.net
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
	'WVTT_TITLE'			=> 'من قرأ هذا الموضوع',
	'WVTT_PROFILE'			=> 'آخر المواضيع التي قراءها',
        'EXTENSION_BY'			=> 'الإضافة بواسطة ',
        'ACL_U_WVTT'			=> 'يستطيع مُشاهدة الإضافة : من قرأ هذا الموضوع',
        'ACL_U_WVTT_POPUP'		=> 'يستطيع مُشاهدة التاريخ في الإضافة : من قرأ هذا الموضوع',
        'ACL_U_WVTT_COUNT'		=> 'يستطيع مُشاهدة عدد مشاهدات الموضوع لكل عضو',
        'ACL_U_WVTT_PROFILE'		=> 'يستطيع مُشاهدة "آخر المواضيع التي قراءها" (في الملف الشخصي)'
));
