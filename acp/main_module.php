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
 * List Manager ACP module.
 */
class main_module
{
	/**
	 * @var string
	 */
	public $page_title;

	/**
	 * @var string
	 */
	public $tpl_name;

	/**
	 * @var string
	 */
	public $u_action;

	/**
	 * Main ACP module
	 *
	 * @param int    $id   The module ID
	 * @param string $mode The module mode (for example: manage or settings)
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $language, $template, $request, $config, $user, $phpbb_container;
		
		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_listmanager_body';
		
		// Set the page title for our ACP page
		$this->page_title = $language->lang('ACP_LISTMANAGER_TITLE');

		//
		$log = $phpbb_container->get('log');
		
		add_form_key('adrianb11_listmanager_settings');

		// Create an array to collect errors that will be output to the user
		$errors = [];
		
		// If submit, save settings
		if ($request->is_set_post('submit'))
		{
			// Check if form key is valid
			if (!check_form_key('adrianb11_listmanager_settings'))
			{
				$errors[] = $language('FORM_INVALID');
			}

			// If $errors array is empty proceed
			if (empty($errors))
			{
				// Save the settings
				$this->save_settings();

				// Add option settings change action to the admin log
				$log->add('admin', $user->data['user_id'], $user->ip, 'LOG_ACP_LISTMANAGER_SETTINGS');

				// Option settings have been updated
				// Confirm this to the user and provide link back to previous page
				trigger_error($language->lang('ACP_LISTMANAGER_SETTING_SAVED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);
		
		// Assign template variables
		$template->assign_vars([
			'LISTMANAGER_ENABLED'						=> $config['adrianb11_listmanager_enabled'],
			'LISTMANAGER_VERSION'						=> $config['adrianb11_listmanager_version'],
			'U_ACTION'									=> $this->u_action,
			'S_ERROR'									=> $s_errors,
			'ERROR_MSG'									=> $s_errors ? implode('<br />', $errors) : '',
		]);
	}

	/**
	 *
	 */
	public function save_settings()
	{
		global $config, $request;

		$config->set('adrianb11_listmanager_enabled', $request->variable('adrianb11_listmanager_enabled', 0));
	}
}
