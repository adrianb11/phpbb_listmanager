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

class release_0_1_4 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\adrianb11\listmanager\migrations\release_0_1_4'];
	}

	public function update_data()
	{
		return [

			// Extension settings
			['config.update', ['adrianb11_listmanager_version', '0.1.4']],
			['config.update', ['adrianb11_listmanager_nodearraycss_postprofileelement', '{".postbody": {"width": "100%"},".post-buttons":{"padding-right": "50px"}}']],
			['config.update', ['adrianb11_listmanager_nodelocation_postreply', 'target,parentElement']],
			['config.update', ['adrianb11_listmanager_nodelocation_postbuttons', 'target,parentElement']],
		];
	}
}
