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
        'WVTT_TITLE'                    => 'Wer hat dieses Thema besucht?',
        'WVTT_PROFILE'                  => 'Zuletzt besuchte Themen',
        'EXTENSION_BY'                  => 'Erweiterung von ', 
        'ACL_U_WVTT'                    => 'Kann sehen, wer ein Thema besucht hat',
        'ACL_U_WVTT_POPUP'              => 'Kann sehen, wann ein Thema von einem Benutzer besucht wurde',
        'ACL_U_WVTT_COUNT'              => 'Kann sehen, wie oft ein Thema von einem Benutzer besucht wurde',
        'ACL_U_WVTT_PROFILE'            => 'Kann im Profil eines Benutzers sehen, welche Themen zuletzt besucht wurden'
));
