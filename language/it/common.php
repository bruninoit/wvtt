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
	    'WVTT_TITLE'			=> 'Chi ha visto questo topic',
	    'WVTT_PROFILE'			=> 'Ultimi topic visti',
	    'EXTENSION_BY'			=> 'Estensione creata da',
	    'ACL_U_WVTT'		=> 'Può vedere Chi Ha Visto un Topic',
	    'ACL_U_WVTT_POPUP'		=> 'Può vedere le date di visulazizzazione dei topic',
	    'ACL_U_WVTT_COUNT'		=> 'Può vedere il numero di visualizzazioni di un topic',
	    'ACL_U_WVTT_PROFILE'		=> 'Può vedere gli ultimi topic visti da un utente (nei profili)'
));
