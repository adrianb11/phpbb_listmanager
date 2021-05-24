<?php
/**
 *
 * List Manager.
 *
 * @copyright (c) 2021, AdrianB
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace adrianb11\listmanager\controller;

/**
 * List Manager main controller.
 */
class board_manage_controller
{

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\path_helper */
	protected $path_helper;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var string phpBB root path */
	protected $root_path;

	/* @var string phpEx */
	protected $php_ext;

	/** @var \phpbb\language\language */
	protected $language;


	/**
	 * Constructor
	 *
	 * @param \phpbb\controller\helper			$helper
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\auth\auth					$auth
	 * @param \phpbb\db\driver\driver_interface	$db
	 * @param \phpbb\path_helper				$path_helper
	 * @param \phpbb\request\request			$request
	 * @param string							$root_path
	 * @param string							$phpExt
	 * @param \phpbb\language\language			$language
	 */
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\path_helper $path_helper, \phpbb\request\request $request, $root_path, $phpExt, \phpbb\language\language $language)
	{
		$this->helper			= $helper;
		$this->template			= $template;
		$this->auth				= $auth;
		$this->db				= $db;
		$this->path_helper		= $path_helper;
		$this->request 			= $request;
		$this->root_path		= $root_path;
		$this->php_ext			= $phpExt;
		$this->language			= $language;
	}

	/**
	 * Main function.  Generates board manager.
	 */
	public function handle()
	{
		// Add user delete permission
		$this->template->assign_var('ACL_DELETE_BOARD', $this->auth->acl_get('u_adrianb11_listmanager_manage_boards_delete'));

		$current_boards = $this->get_boards(append_sid("{$this->root_path}viewforum.{$this->php_ext}"));

		if (!empty($current_boards))
		{
			$this->template->assign_var('BOARDS_EXIST', true);

			foreach ($current_boards as $row)
			{
				$this->template->assign_block_vars('forums', [
					'ID'			=> $row['forum_id'],
					'NAME'			=> $row['forum_name'],
					'DESC'			=> $row['forum_desc'],
					'URL'			=> $row['forum_url'],
					'REMOVE_URL'	=> $this->helper->route('adrianb11_listmanager_remove_board', ['id' => $row['forum_id']]),
				]);
			}
		}

		// Is user allowed to add boards?
		if ($this->auth->acl_get('u_adrianb11_listmanager_manage_boards_add') == true)
		{
			$forum_box = $this->make_forum_select(false);

			$this->template->assign_vars([
				'CATEGORY_BOX'	=> $forum_box,
				'U_ACTION'		=> $this->helper->route('adrianb11_listmanager_add_board'),
			]);
		}

		return $this->helper->render('@adrianb11_listmanager/listmanager_control_panel.html');
	}

	/**
	 * Removes a board
	 *
	 * @param $id
	 */
	function remove_board($id)
	{
		// Check if user can view forum
		if ($this->auth->acl_get('u_adrianb11_listmanager_manage_boards_delete'))
		{
			$sql = 'UPDATE ' . FORUMS_TABLE . '
			SET ' . FORUMS_TABLE . '.listmanager_isboard = 0
			WHERE forum_id = ' . $id;

			$this->db->sql_query($sql);
			$affected_rows = $this->db->sql_affectedrows();

			echo '<pre>';
			print_r($affected_rows);
			echo '</pre>';

			$message = $this->language->lang('LISTMANAGER_BOARD_REMOVED', $id);
		}
		else
		{
			$message = $this->language->lang('LISTMANAGER_PERMISSIONS_REQUIRED');
		}

		trigger_error($message . '<br><a href="' . $this->helper->route('adrianb11_listmanager_manage') . '">' . $this->language->lang('LISTMANAGER_RETURN') . '</a>');
	}

	/**
	 * Adds a board
	 */
	function add_board()
	{
		if ($this->auth->acl_get('u_adrianb11_listmanager_manage_boards_add'))
		{
			if ($this->request->is_set_post('submit'))
			{
				if ($this->request->is_set('forum_id'))
				{
					$id = $this->request->variable('forum_id', '');

					// Check if user can view forum
					if ($this->auth->acl_gets('f_list', $id))
					{
						// Check if parent is not already a board
						$sql = 'SELECT listmanager_isboard, forum_id
						FROM ' . FORUMS_TABLE . '
						WHERE forum_id IN (
							SELECT parent_id
							FROM ' . FORUMS_TABLE . '
							WHERE forum_id = ' . $id . '
						)';

						$result = $this->db->sql_query($sql);
						$rowset = array();
						while ($row = $this->db->sql_fetchrow($result))
						{
							$rowset[0] = $row;
						}
						$this->db->sql_freeresult($result);

						// If forum does not have a parent or parent is not a board then proceed
						if (empty($rowset) || $rowset[0]['listmanager_isboard'] == 0)
						{
							// Check if selected forum is not already a board
							$sql = 'SELECT listmanager_isboard, forum_id
							FROM ' . FORUMS_TABLE . '
							WHERE forum_id = ' . $id;

							$result = $this->db->sql_query($sql);
							$rowset = array();
							while ($row = $this->db->sql_fetchrow($result))
							{
								$rowset[0] = $row;
							}
							$this->db->sql_freeresult($result);

							// Forum has been found and is not already a board
							if (!empty($rowset))
							{
								if ($rowset[0]['listmanager_isboard'] == 0)
								{
									$sql = 'UPDATE ' . FORUMS_TABLE . '
									SET ' . FORUMS_TABLE . '.listmanager_isboard = 1
									WHERE forum_id = ' . $id;

									$this->db->sql_query($sql);

									// Forum has ben added as a board
									$message = $this->language->lang('LISTMANAGER_FORUM_ADDED', $id);
								}
								else
								{
									// Selected forum is already a board
									$message = $this->language->lang('LISTMANAGER_FORUM_ALREADY_ADDED', $id);
								}
							}
							else
							{
								// Forum ID was not found
								$message = $this->language->lang('LISTMANAGER_FORUM_ID_NOT_FOUND', $id);
							}
						}
						else
						{
							// Parent forum is a board
							$message = $this->language->lang('LISTMANAGER_FORUM_PARENT_ALREADY_ADDED', $id);
						}
					}
					else
					{
						// User does not have permissions to view selected forum or forum id does not exist
						$message = $this->language->lang('LISTMANAGER_PERMISSIONS_REQUIRED_VIEW');
					}
				}
				else
				{
					// No forum has been selected
					$message = $this->language->lang('LISTMANAGER_NO_FORUM_SELECTED');
				}
			}
			else
			{
				// Form key is invalid
				$message = $this->language->lang('LISTMANAGER_FORM_KEY_INVALID');
			}
		}
		else
		{
			// Additional permissions are required to add a board
			$message = $this->language->lang('LISTMANAGER_PERMISSIONS_REQUIRED');
		}
		trigger_error($message . '<br><a href="' . $this->helper->route('adrianb11_listmanager_manage') . '">' . $this->language->lang('LISTMANAGER_RETURN') . '</a>');
	}

	/**
	 * Simple modified version of jumpbox, just lists authed forums
	 *
	 * @param bool $return_array
	 * @return array|string
	 */
	function make_forum_select($return_array = false)
	{
		// This query is identical to the jumpbox one
		$sql = 'SELECT forum_id, forum_name, forum_desc, parent_id, forum_type, forum_flags, forum_options, left_id, right_id, listmanager_isboard
			FROM ' . FORUMS_TABLE . '
			ORDER BY left_id ASC';
		$result = $this->db->sql_query($sql);

		$rowset = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rowset[(int) $row['forum_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		$right = 0;
		$padding_store = array('0' => '');
		$padding = '';
		$forum_list = ($return_array) ? array() : '';

		// Sometimes it could happen that forums will be displayed here not be displayed within the index page
		// This is the result of forums not displayed at index, having list permissions and a parent of a forum with no permissions.
		// If this happens, the padding could be "broken"

		foreach ($rowset as $row)
		{
			if ($row['left_id'] < $right)
			{
				$padding .= '&nbsp; &nbsp;';
				$padding_store[$row['parent_id']] = $padding;
			}
			else if ($row['left_id'] > $right + 1)
			{
				$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : '';
			}

			$right = $row['right_id'];
			$disabled = false;

			// Check if user can see forum
			if (!$this->auth->acl_gets('f_list', $row['forum_id']))
			{
				continue;
			}

			// Check if parent forum is a board and if true, set option as disabled.
			if ($row['parent_id'] != 0)
			{
				if ($rowset[$row['parent_id']]['listmanager_isboard'] != 0 )
				{
					$disabled = true;
				}
			}

			// Check if forum is a board and if true, set option as disabled.
			if ($row['listmanager_isboard'] != 0)
			{
				$disabled = true;
			}

			if ($return_array)
			{
				// Include some more information...
				$selected = false;
				$forum_list[$row['forum_id']] = array_merge(array('padding' => $padding, 'selected' => ($selected && !$disabled), 'disabled' => $disabled), $row);
			}
			else
			{
				$forum_list .= '<option value="' . $row['forum_id'] . '"' . (($disabled) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $padding . $row['forum_name'] . " - " . $row['forum_desc'] . '</option>';
			}
		}
		unset($padding_store, $rowset);

		return $forum_list;
	}

	/**
	 * Get list of current boards
	 *
	 * @param $action
	 * @return array
	 */
	function get_boards($action)
	{
		// This query is identical to the jumpbox one
		$sql = 'SELECT forum_id, forum_name, forum_desc, parent_id, forum_type, forum_flags, forum_options, left_id, listmanager_isboard
			FROM ' . FORUMS_TABLE . '
			WHERE listmanager_isboard != 0
			ORDER BY left_id ASC';
		$result = $this->db->sql_query($sql);

		$rowset = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$rowset[(int) $row['forum_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		foreach ($rowset as $row)
		{
			// Check if user can see forum
			if (!$this->auth->acl_gets('f_list', $row['forum_id']))
			{
				unset($rowset[$row['forum_id']]);
				continue;
			}

			$rowset[$row['forum_id']]['forum_url'] = $this->path_helper->append_url_params($action, array('f' => $row['forum_id']));
		}
		return $rowset;
	}
}
