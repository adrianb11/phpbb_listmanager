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

class release_0_1_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['adrianb11_listmanager_version']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_data()
	{
		return [

			// Extension settings
			['config.add', ['adrianb11_listmanager_version', '0.1.0']],
			['config.add', ['adrianb11_listmanager_enabled', 0]],
			
			// Extension permissions
			// Add Admin permissions
			['permission.add', ['a_adrianb11_listmanager_manage']], // Can manage extension settings
			
			// Add Registered User permissions
			['permission.add', ['u_adrianb11_listmanager_manage_boards']], // Can manage boards
			['permission.add', ['u_adrianb11_listmanager_manage_boards_add']], // Can manage boards
			['permission.add', ['u_adrianb11_listmanager_manage_boards_delete']], // Can manage boards
			['permission.add', ['u_adrianb11_listmanager_view_boards']], // Can manage boards
			
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_LISTMANAGER_TITLE'
			]],
			['module.add', [
				'acp',
				'ACP_LISTMANAGER_TITLE',
				[
					'module_basename'	=> '\adrianb11\listmanager\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],
		];
	}
	
	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'forums'			=> [
					'listmanager_isboard'				=> ['BOOL', 0],
				],
			],
		];
	}
	
	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'forums'			=> [
					'listmanager_isboard',
				],
			],
		];
	}
}
