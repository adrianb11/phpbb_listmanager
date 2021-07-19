<?php
/**
 *
 * List Manager.
 *
 * @copyright (c) 2021, AdrianB
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACP_LISTMANAGER_TITLE'										=> 'List Manager Module',
	'ACP_LISTMANAGER'											=> 'List Manager Settings',
	'ACP_LISTMANAGER_SETTING_SAVED'								=> 'Settings have been saved successfully!',
	'LOG_ACP_LISTMANAGER_SETTINGS'								=> '<strong>List Manager settings updated</strong>',
	'ACP_LISTMANAGER_ENABLED'									=> 'Is the module enabled?',
	'ACP_LISTMANAGER_VERSION'									=> 'Current List Manager Version',
	'ACP_LISTMANAGER_DEFAULT_QTY_CARDS'							=> 'How many cards per board to show by default?',
	'ACP_LISTMANAGER_THEME_SETTINGS'							=> 'Theme Specific Settings',
	'ACP_LISTMANAGER_THEME_SETTINGS_DESCRIPTION'				=> 'You can change certain theme specific settings if you are using a customised theme.  Do not change anything here if you don\'t understand how it works.  <br />Default values are shown beneath each section.',
	'ACP_LISTMANAGER_FADE_LENGTH'								=> 'Length of time to fade background',
	'ACP_LISTMANAGER_FADE_LENGTH_DEFAULT'						=> '&emsp;Default is : <strong><em>100</em></strong>',
	'ACP_LISTMANAGER_POST_PROFILE'								=> 'Should the post profile element be displayed (true/false)?',
	'ACP_LISTMANAGER_POST_PROFILE_DEFAULT'						=> '&emsp;Default is : <strong><em>true</em></strong>',
	'ACP_LISTMANAGER_ELEMENTREPLACE_VIEWTOPIC'					=> 'Enter a list of elements to remove when viewing topics.',
	'ACP_LISTMANAGER_ELEMENTREPLACE_VIEWTOPIC_DEFAULT'			=> '&emsp;Must be a comma separated list of elements.<br />&emsp;Default is : <strong><em>#page-header, #page-footer, .online-list, .jumpbox-return, .actions-jump</em></strong>',
	'ACP_LISTMANAGER_ELEMENTREPLACE_CREATEPOST'					=> 'Enter a list of elements to remove when creating a new post.',
	'ACP_LISTMANAGER_ELEMENTREPLACE_CREATEPOST_DEFAULT'			=> '&emsp;Must be a comma separated list of elements.<br />&emsp;Default is : <strong><em>#page-header, #page-footer</em></strong>',
	'ACP_LISTMANAGER_ELEMENTREPLACE_FORMSUBMIT'					=> 'Enter a list of elements to remove when submitting a form.',
	'ACP_LISTMANAGER_ELEMENTREPLACE_FORMSUBMIT_DEFAULT'			=> '&emsp;Must be a comma separated list of elements.<br />&emsp;Default is : <strong><em>#page-header, #page-footer</em></strong>',
	'ACP_LISTMANAGER_ELEMENTREPLACE_LOADDRAFT'					=> 'Enter a list of elements to remove when loading drafts.',
	'ACP_LISTMANAGER_ELEMENTREPLACE_LOADDRAFT_DEFAULT'			=> '&emsp;Must be a comma separated list of elements.<br />&emsp;Default is : <strong><em>#postingbox, #attach-panel, #poll-panel</em></strong>',
	'ACP_LISTMANAGER_ELEMENTREPLACE_POSTPROFILE'				=> 'Enter a list of elements to remove if the post profile is not shown.',
	'ACP_LISTMANAGER_ELEMENTREPLACE_POSTPROFILE_DEFAULT'		=> '&emsp;Must be a comma separated list of elements.<br />&emsp;Default is : <strong><em>.postprofile</em></strong>',
	'ACP_LISTMANAGER_SUBMITARRAY'								=> 'Enter a list of button names which should be watched when submitting forms.',
	'ACP_LISTMANAGER_SUBMITARRAY_DEFAULT'						=> '&emsp;Must be a comma separated list of names.<br />&emsp;Default is : <strong><em>load, preview, post</em></strong>',
	'ACP_LISTMANAGER_POSTREPLYTEXT'								=> 'Enter a list of button names which should be watched to post a reply.',
	'ACP_LISTMANAGER_POSTREPLYTEXT_DEFAULT'						=> '&emsp;Must be a comma separated list of names.<br />&emsp;Default is : <strong><em>Post a reply, Reply with quote</em></strong>',
	'ACP_LISTMANAGER_POSTBUTTONSTEXT'							=> 'Enter a list of button names which should be watched when reloading a card.',
	'ACP_LISTMANAGER_POSTBUTTONSTEXT_DEFAULT'					=> '&emsp;Must be a comma separated list of names.<br />&emsp;Default is : <strong><em>Edit post, Delete post, Report this post, Reply with quote</em></strong>',
	'ACP_LISTMANAGER_NODELOCATION_POSTREPLY'					=> 'Enter JavaScript to correctly select the button or &lt;a&gt; element when clicking a post reply button.',
	'ACP_LISTMANAGER_NODELOCATION_POSTREPLY_DEFAULT'			=> '&emsp;Must be a comma separated list of names with no spaces.<br />&emsp;Default is : <strong><em>target,parentElement</em></strong>',
	'ACP_LISTMANAGER_NODELOCATION_SUBMITBUTTON'					=> 'Enter JavaScript to correctly select the button or &lt;a&gt; element when clicking a submit button.',
	'ACP_LISTMANAGER_NODELOCATION_SUBMITBUTTON_DEFAULT'			=> '&emsp;Must be a comma separated list of names with no spaces.<br />&emsp;Default is : <strong><em>target</em></strong>',
	'ACP_LISTMANAGER_NODELOCATION_POSTBUTTONS'					=> 'Enter JavaScript to correctly select the button or &lt;a&gt; element when clicking a post button.',
	'ACP_LISTMANAGER_NODELOCATION_POSTBUTTONS_DEFAULT'			=> '&emsp;Must be a comma separated list of names with no spaces.<br />&emsp;Default is : <strong><em>target,parentElement</em></strong>',
	'ACP_LISTMANAGER_NODEARRAYCSS_BGFADEELEMENTOUT'				=> 'Enter an array of html elements and CSS changes to apply to them when fading out the background (closing the popup window).',
	'ACP_LISTMANAGER_NODEARRAYCSS_BGFADEELEMENTOUT_DEFAULT'		=> '&emsp;Must be valid JavaScript ObjectArray.<br />&emsp;Default is : <strong><em>{"body": {"overflow": "auto"}}</em></strong>',
	'ACP_LISTMANAGER_NODEARRAYCSS_BGFADEELEMENTIN'				=> 'Enter an array of html elements and CSS changes to apply to them when fading in the background (loading/creating a post)',
	'ACP_LISTMANAGER_NODEARRAYCSS_BGFADEELEMENTIN_DEFAULT'		=> '&emsp;Must be valid JavaScript ObjectArray.<br />&emsp;Default is : <strong><em>{"body": {"overflow": "hidden"}}</em></strong>',
	'ACP_LISTMANAGER_NODEARRAYCSS_VIEWPOSTELEMENT'				=> 'Enter an array of html elements and CSS changes to apply to them when viewing a topic',
	'ACP_LISTMANAGER_NODEARRAYCSS_VIEWPOSTELEMENT_DEFAULT'		=> '&emsp;Must be valid JavaScript ObjectArray.<br />&emsp;Default is : <strong><em>{"#wrap": {"min-width": "0px"}}</em></strong>',
	'ACP_LISTMANAGER_NODEARRAYCSS_NEWPOSTELEMENT'				=> 'Enter an array of html elements and CSS changes to apply to them when creating a new topic',
	'ACP_LISTMANAGER_NODEARRAYCSS_NEWPOSTELEMENT_DEFAULT'		=> '&emsp;Must be valid JavaScript ObjectArray.<br />&emsp;Default is : <strong><em>{"#wrap": {"min-width": "0px"}}</em></strong>',
	'ACP_LISTMANAGER_NODEARRAYCSS_FORMSUBMITELEMENT'			=> 'Enter an array of html elements and CSS changes to apply to them when submitting a form',
	'ACP_LISTMANAGER_NODEARRAYCSS_FORMSUBMITELEMENT_DEFAULT'	=> '&emsp;Must be valid JavaScript ObjectArray.<br />&emsp;Default is : <strong><em>{"#wrap": {"min-width": "0px"}}</em></strong>',
	'ACP_LISTMANAGER_NODEARRAYCSS_POSTPROFILEELEMENT'			=> 'Enter an array of html elements and CSS changes to apply to them when removing the post profile',
	'ACP_LISTMANAGER_NODEARRAYCSS_POSTPROFILEELEMENT_DEFAULT'	=> '&emsp;Must be valid JavaScript ObjectArray.<br />&emsp;Default is : <strong><em>{".postbody": {"width": "100%"}}</em></strong>',
]);
