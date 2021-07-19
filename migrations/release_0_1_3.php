<?php
/**
 *
 * List Manager.
 *
 * @copyright (c) 2021, AdrianB
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace adrianb11\listmanager\migrations;

class release_0_1_3 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\adrianb11\listmanager\migrations\release_0_1_2'];
	}

	public function update_data()
	{
		return [

			// Extension settings
			['config.add', ['adrianb11_listmanager_default_qty_cards', 100]],
			['config.update', ['adrianb11_listmanager_version', '0.1.3']],

			// Add style settings
			['config.add', ['adrianb11_listmanager_fadelength', 100]],
			['config.add', ['adrianb11_listmanager_postprofile', "1"]],
			['config.add', ['adrianb11_listmanager_elementreplace_viewtopic', '#page-header, #page-footer, .online-list, .jumpbox-return, .actions-jump']],
			['config.add', ['adrianb11_listmanager_elementreplace_createpost', '#page-header, #page-footer']],
			['config.add', ['adrianb11_listmanager_elementreplace_formsubmit', '#page-header, #page-footer']],
			['config.add', ['adrianb11_listmanager_elementreplace_loaddraft', '#postingbox, #attach-panel, #poll-panel']],
			['config.add', ['adrianb11_listmanager_elementreplace_postprofile', '.postprofile']],
			['config.add', ['adrianb11_listmanager_submitarray', 'load, preview, post']],
			['config.add', ['adrianb11_listmanager_postreplytext', 'Post a reply, Reply with quote']],
			['config.add', ['adrianb11_listmanager_postbuttonstext', 'Edit post, Delete post, Report this post, Reply with quote']],
			['config.add', ['adrianb11_listmanager_nodelocation_postreply', 'target, parentElement']],
			['config.add', ['adrianb11_listmanager_nodelocation_submitbutton', 'target']],
			['config.add', ['adrianb11_listmanager_nodelocation_postbuttons', 'target, parentElement']],
			['config.add', ['adrianb11_listmanager_nodearraycss_bgfadeelementout', '{"body": {"overflow": "auto"}}']],
			['config.add', ['adrianb11_listmanager_nodearraycss_bgfadeelementin', '{"body": {"overflow": "hidden"}}']],
			['config.add', ['adrianb11_listmanager_nodearraycss_viewpostelement', '{"#wrap": {"min-width": "0px"}}']],
			['config.add', ['adrianb11_listmanager_nodearraycss_newpostelement', '{"#wrap": {"min-width": "0px"}}']],
			['config.add', ['adrianb11_listmanager_nodearraycss_formsubmitelement', '{"#wrap": {"min-width": "0px"}}']],
			['config.add', ['adrianb11_listmanager_nodearraycss_postprofileelement', '{".postbody": {"width": "100%"}}']],
		];
	}
}
