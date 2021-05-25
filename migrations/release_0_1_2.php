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

class release_0_1_2 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\adrianb11\listmanager\migrations\release_0_1_1'];
	}

	public function update_data()
	{
		return [

			// Extension settings
			['config.update', ['adrianb11_listmanager_version', '0.1.2']],
		];
	}
}
