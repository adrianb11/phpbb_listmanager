<?php
/**
 *
 * List Manager.
 *
 * @copyright (c) 2021, AdrianB
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace adrianb11\listmanager\acp;

/**
 * List Manager ACP module info.
 */
class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\adrianb11\listmanager\acp\main_module',
			'title'		=> 'ACP_LISTMANAGER_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_LISTMANAGER',
					'auth'	=> 'ext_adrianb11/listmanager && acl_a_adrianb11_listmanager_manage',
					'cat'	=> ['ACP_LISTMANAGER_TITLE'],
				],
			],
		];
	}
}
