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
				$log->add('admin', $user->data['user_id'], $user->ip, $language->lang('LOG_ACP_LISTMANAGER_SETTINGS'));

				// Option settings have been updated
				// Confirm this to the user and provide link back to previous page
				trigger_error($language->lang('ACP_LISTMANAGER_SETTING_SAVED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);

		$template_vars = array();
		foreach ($this->settings_array() as $setting => $value) {
			$template_vars[$value] = $config[$setting];
		}

		$template_vars['LISTMANAGER_VERSION'] = $config['adrianb11_listmanager_version'];
		$template_vars['U_ACTION'] = $this->u_action;
		$template_vars['S_ERROR'] = $s_errors;
		$template_vars['ERROR_MSG'] = $s_errors ? implode('<br />', $errors) : '';

		$template->assign_vars($template_vars);
	}

	/**
	 *
	 */
	public function save_settings()
	{
		global $config, $request;

		foreach ($this->settings_array() as $setting => $value) {
			$config->set($setting, $request->variable($setting,''));
		}
	}

	public function settings_array()
	{
		return array(
			'adrianb11_listmanager_enabled'								=> 'LISTMANAGER_ENABLED',
			'adrianb11_listmanager_default_qty_cards'					=> 'LISTMANAGER_DEFAULT_QTY_CARDS',
			'adrianb11_listmanager_fadelength'							=> 'LISTMANAGER_FADE_LENGTH',
			'adrianb11_listmanager_postprofile'							=> 'LISTMANAGER_POST_PROFILE',
			'adrianb11_listmanager_elementreplace_viewtopic'			=> 'LISTMANAGER_ELEMENTREPLACE_VIEWTOPIC',
			'adrianb11_listmanager_elementreplace_createpost'			=> 'LISTMANAGER_ELEMENTREPLACE_CREATEPOST',
			'adrianb11_listmanager_elementreplace_formsubmit'			=> 'LISTMANAGER_ELEMENTREPLACE_FORMSUBMIT',
			'adrianb11_listmanager_elementreplace_loaddraft'			=> 'LISTMANAGER_ELEMENTREPLACE_LOADDRAFT',
			'adrianb11_listmanager_elementreplace_postprofile'			=> 'LISTMANAGER_ELEMENTREPLACE_POSTPROFILE',
			'adrianb11_listmanager_submitarray'							=> 'LISTMANAGER_SUBMITARRAY',
			'adrianb11_listmanager_postreplytext'						=> 'LISTMANAGER_POSTREPLYTEXT',
			'adrianb11_listmanager_postbuttonstext'						=> 'LISTMANAGER_POSTBUTTONSTEXT',
			'adrianb11_listmanager_nodelocation_postreply'				=> 'LISTMANAGER_NODELOCATION_POSTREPLY',
			'adrianb11_listmanager_nodelocation_submitbutton'			=> 'LISTMANAGER_NODELOCATION_SUBMITBUTTON',
			'adrianb11_listmanager_nodelocation_postbuttons'			=> 'LISTMANAGER_NODELOCATION_POSTBUTTONS',
			'adrianb11_listmanager_nodearraycss_bgfadeelementout'		=> 'LISTMANAGER_NODEARRAYCSS_BGFADEELEMENTOUT',
			'adrianb11_listmanager_nodearraycss_bgfadeelementin'		=> 'LISTMANAGER_NODEARRAYCSS_BGFADEELEMENTIN',
			'adrianb11_listmanager_nodearraycss_viewpostelement'		=> 'LISTMANAGER_NODEARRAYCSS_VIEWPOSTELEMENT',
			'adrianb11_listmanager_nodearraycss_newpostelement'			=> 'LISTMANAGER_NODEARRAYCSS_NEWPOSTELEMENT',
			'adrianb11_listmanager_nodearraycss_formsubmitelement'		=> 'LISTMANAGER_NODEARRAYCSS_FORMSUBMITELEMENT',
			'adrianb11_listmanager_nodearraycss_postprofileelement'		=> 'LISTMANAGER_NODEARRAYCSS_POSTPROFILEELEMENT'
		);
	}
}
