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
	'LISTMANAGER_NOTIFICATION'						=> 'List Manager notification',

	'LISTMANAGER_PAGE'								=> 'List Manager CP',
	'LISTMANAGER_VIEWING'							=> 'Viewing List Manager page',

	'LISTMANAGER_VIEW_BOARDS'						=> 'Manage Current Boards',
	'LISTMANAGER_CREATE_BOARDS'						=> 'Create New Board',
	'LISTMANAGER_TITLE'								=> 'List Manager',
	'LISTMANAGER_CREATE_CARD_TITLE'					=> 'Create New Card ...',
	'LISTMANAGER_TOPIC_LOADING_TEXT'				=> 'Please wait while the topic is loading...',
	'LISTMANAGER_FORUM_NAME'						=> 'Forum Name',
	'LISTMANAGER_FORUM_DESC'						=> 'Forum Description',
	'LISTMANAGER_FORUM_ACTION'						=> 'Action',
	'LISTMANAGER_VIEW_BOARD'						=> 'View Board',
	'LISTMANAGER_DELETE_BOARD'						=> 'Delete Board',

	'LISTMANAGER_PERMISSIONS_REQUIRED'				=> 'You do not have the required permissions to do this!',
	'LISTMANAGER_BOARD_REMOVED'						=> 'Board ID%s Removed',
	'LISTMANAGER_RETURN'							=> 'Return to previous page.',
	'LISTMANAGER_FORUM_ADDED'						=> 'Forum id %s has been added as a new board.',
	'LISTMANAGER_FORUM_ALREADY_ADDED'				=> 'Forum id %s is already a board.',
	'LISTMANAGER_FORUM_PARENT_ALREADY_ADDED'		=> 'Forum id %s\'s parent is already a board.',
	'LISTMANAGER_PERMISSIONS_REQUIRED_VIEW'			=> 'You do not have permission to view this forum.',
	'LISTMANAGER_NO_FORUM_SELECTED'					=> 'No forum has selected.',
	'LISTMANAGER_FORUM_ID_NOT_FOUND'				=> 'Forum id %s has not been found.',
	'LISTMANAGER_FORM_KEY_INVALID'					=> 'Invalid form key supplied.',
]);
