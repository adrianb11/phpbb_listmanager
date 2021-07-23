<?php

namespace adrianb11\listmanager\core;

class boards
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\content_visibility */
	protected $content_visibility;

	/* @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\user */
	protected $user;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\cache\service */
	protected $cache;

	/* @var \phpbb\config\config */
	protected $config;

	/* @var string phpBB root path */
	protected $root_path;

	/* @var string phpEx */
	protected $php_ext;


	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\content_visibility 		$content_visibility
	 * @param \phpbb\auth\auth 					$auth
	 * @param \phpbb\user 						$user
	 * @param \phpbb\db\driver\driver_interface	$db
	 * @param \phpbb\cache\service 				$cache
	 * @param \phpbb\config\config				$config
	 * @param string 							$root_path
	 * @param string							$php_ext
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\content_visibility $content_visibility, \phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\cache\service $cache, \phpbb\config\config $config, $root_path, $php_ext)
	{
		$this->template				= $template;
		$this->content_visibility 	= $content_visibility;
		$this->auth					= $auth;
		$this->user 				= $user;
		$this->db					= $db;
		$this->cache 				= $cache;
		$this->config				= $config;
		$this->root_path			= $root_path;
		$this->php_ext				= $php_ext;
	}

	/**
	 * Displays board view
	 *
	 * @param $id
	 */
	public function render_board($id)
	{
		// Start session
		$this->user->session_begin();
		$this->auth->acl($this->user->data);

		// Is user allowed to view boards?
		if ($this->auth->acl_get('u_adrianb11_listmanager_view_boards') == true)
		{

			$sql_from = FORUMS_TABLE . ' f';

			$sql = "SELECT f.*
			FROM $sql_from
			WHERE f.forum_id = $id AND listmanager_isboard = 1";
			$result = $this->db->sql_query($sql);
			$forum_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($forum_data)
			{
				$this->template->assign_vars([
					'ISBOARD'			=> true,
					'S_BBCODE_ALLOWED'	=> true,
				]);

				// Load config into array and sent to template
				$configArray = array();
				foreach ($this->config_settings_array() as $key => $value) {
					$configArray[$value] = $this->config[$key];
				}

				$this->template->assign_vars($configArray);

				$this->load_image_vars();

				display_custom_bbcodes();

				if ($forum_data['left_id'] != $forum_data['right_id'] - 1)
				{
					$board_data = $this->get_forum_list($forum_data);

					foreach ($board_data as $row_id => $row)
					{
						$this->template->assign_block_vars('lists', $row);

						$this->get_topic_list($row_id);
					}
				}
			}
		}
	}

	/**
	 * Load images
	 */
	public function load_image_vars()
	{
		$this->template->assign_vars([
			'PLUS_ICON_PNG'			=> $this->root_path . 'ext/adrianb11/listmanager/styles/all/theme/images/plus_icon.png',
		]);
	}

	/**
	 * Create settings array used to assign template variables
	 * @return array
	 */
	public function config_settings_array()
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

	/**
	 * Display Forums
	 *
	 * This file is part of the phpBB Forum Software package.
	 *
	 * @copyright (c) phpBB Limited <https://www.phpbb.com>
	 * @license GNU General Public License, version 2 (GPL-2.0)
	 *
	 * For full copyright and license information, please see
	 * the docs/CREDITS.txt file.
	 *
	 * @param string $root_data
	 * @return array
	 */
	public function get_forum_list($root_data = '')
	{
		$forum_rows = $forum_ids = $active_forum_ary = array();

		$sql_where = 'left_id > ' . $root_data['left_id'] . ' AND left_id < ' . $root_data['right_id'];

		$sql_array = array(
			'SELECT'	=> 'f.*',
			'FROM'		=> array(
				FORUMS_TABLE		=> 'f'
			),
			'LEFT_JOIN'	=> array(),
		);

		$sql_ary = array(
			'SELECT'	=> $sql_array['SELECT'],
			'FROM'		=> $sql_array['FROM'],
			'LEFT_JOIN'	=> $sql_array['LEFT_JOIN'],

			'WHERE'		=> $sql_where,

			'ORDER_BY'	=> 'f.left_id',
		);

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);

		$branch_root_id = $root_data['forum_id'];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$forum_id = $row['forum_id'];

			// Category with no members
			if ($row['forum_type'] == FORUM_CAT && ($row['left_id'] + 1 == $row['right_id']))
			{
				continue;
			}

			// Skip branch
			if (isset($right_id))
			{
				if ($row['left_id'] < $right_id)
				{
					continue;
				}
				unset($right_id);
			}

			if (!$this->auth->acl_get('f_list', $forum_id))
			{
				// if the user does not have permissions to list this forum, skip everything until next branch
				$right_id = $row['right_id'];
				continue;
			}

			if ($row['parent_id'] == $root_data['forum_id'] || $row['parent_id'] == $branch_root_id)
			{
				// Direct child of current branch
				$forum_rows[$forum_id] = $row;

				if ($row['forum_type'] == FORUM_CAT && $row['parent_id'] == $root_data['forum_id'])
				{
					$branch_root_id = $forum_id;
				}
			}
		}
		$this->db->sql_freeresult($result);

		// Used to tell whatever we have to create a dummy category or not.
		$forum_row = array();
		foreach ($forum_rows as $row)
		{
			$forum_row[$row['forum_id']] = array(
				'S_AUTH_READ'			=> $this->auth->acl_get('f_read', $row['forum_id']),
				'S_LOCKED_FORUM'		=> ($row['forum_status'] == ITEM_LOCKED) ? true : false,
				'S_NO_READ_ACCESS'		=> false,
				'U_POST_NEW_TOPIC'		=> ($this->auth->acl_get('f_post', $row['forum_id'])) ? append_sid("{$this->root_path}posting.$this->php_ext", 'mode=post&amp;f=' . $row['forum_id']) : '',

				'FORUM_ID'				=> $row['forum_id'],
				'FORUM_NAME'			=> $row['forum_name'],
				'FORUM_DESC'			=> generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
			);

			// Ok, if someone has only list-access, we only display the forum list.
			// We also make this circumstance available to the template in case we want to display a notice. ;)
			if (!$this->auth->acl_gets('f_read', 'f_list_topics', $row['forum_id']))
			{
				$forum_row[$row['forum_id']]['S_NO_READ_ACCESS'] = true;
			}
		}
		return $forum_row;
	}

	/**
	 * get_topic_list
	 *
	 * This file is part of the phpBB Forum Software package.
	 *
	 * @copyright (c) phpBB Limited <https://www.phpbb.com>
	 * @license       GNU General Public License, version 2 (GPL-2.0)
	 *
	 * For full copyright and license information, please see
	 * the docs/CREDITS.txt file.
	 *
	 * @param int $forum_id
	 */
	public function get_topic_list($forum_id = 0)
	{
		// Check if the user has actually sent a forum ID with his/her request
		// If not give them a nice error page.
		if (!$forum_id)
		{
			trigger_error('NO_FORUM');
		}

		$sql_from = FORUMS_TABLE . ' f';

		$sql = "SELECT f.*
		FROM $sql_from
		WHERE f.forum_id = $forum_id";
		$result = $this->db->sql_query($sql);
		$forum_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$forum_data)
		{
			trigger_error('NO_FORUM');
		}

		// Grab icons
		$icons = $this->cache->obtain_icons();

		// Grab all topic data
		$rowset = $topic_list = array();

		$sql_approved = ' AND ' . $this->content_visibility->get_visibility_sql('topic', $forum_id, 't.');

		$sql_where = 't.forum_id = ' . $forum_id;

		// Grab just the sorted topic ids
		$sql_ary = array(
			'SELECT'	=> 't.topic_id',
			'FROM'		=> array(
				TOPICS_TABLE => 't',
			),
			'WHERE'		=> "$sql_where
		AND t.topic_type IN (" . POST_NORMAL . ', ' . POST_STICKY . ")
		$sql_approved",
			'ORDER_BY'	=> 't.topic_type DESC, t.topic_last_post_time DESC, t.topic_last_post_id DESC',
		);

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, 100);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$topic_list[] = (int) $row['topic_id'];
		}
		$this->db->sql_freeresult($result);

		// For storing shadow topics
		$shadow_topic_list = array();

		if (count($topic_list))
		{
			// SQL array for obtaining topics/stickies
			$sql_array = array(
				'SELECT'		=> 't.*',
				'FROM'			=> array(
					TOPICS_TABLE		=> 't'
				),
				'WHERE'			=> $this->db->sql_in_set('t.topic_id', $topic_list),
			);

			// If store_reverse, then first obtain topics, then stickies, else the other way around...
			// Funnily enough you typically save one query if going from the last page to the middle (store_reverse) because
			// the number of stickies are not known
			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($row['topic_status'] == ITEM_MOVED)
				{
					$shadow_topic_list[$row['topic_moved_id']] = $row['topic_id'];
				}

				$rowset[$row['topic_id']] = $row;
			}
			$this->db->sql_freeresult($result);
		}
		else
		{
			$this->template->assign_block_vars('lists.list_topics', array(
				'NO_TOPICS'	=> true,
				'FORUM_ID'	=> $forum_id,
			));
		}

		// If we have some shadow topics, update the rowset to reflect their topic information
		if (count($shadow_topic_list))
		{
			// SQL array for obtaining shadow topics
			$sql_array = array(
				'SELECT'	=> 't.*',
				'FROM'		=> array(
					TOPICS_TABLE		=> 't'
				),
				'WHERE'		=> $this->db->sql_in_set('t.topic_id', array_keys($shadow_topic_list)),
			);

			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$orig_topic_id = $shadow_topic_list[$row['topic_id']];

				// If the shadow topic is already listed within the rowset (happens for active topics for example), then do not include it...
				if (isset($rowset[$row['topic_id']]))
				{
					// We need to remove any trace regarding this topic. :)
					unset($rowset[$orig_topic_id]);
					unset($topic_list[array_search($orig_topic_id, $topic_list)]);

					continue;
				}

				// Do not include those topics the user has no permission to access
				if (!$this->auth->acl_gets('f_read', 'f_list_topics', $row['forum_id']))
				{
					// We need to remove any trace regarding this topic. :)
					unset($rowset[$orig_topic_id]);
					unset($topic_list[array_search($orig_topic_id, $topic_list)]);

					continue;
				}

				// We want to retain some values
				$row = array_merge($row, array(
					'topic_moved_id'	=> $rowset[$orig_topic_id]['topic_moved_id'],
					'topic_status'		=> $rowset[$orig_topic_id]['topic_status'],
					'topic_type'		=> $rowset[$orig_topic_id]['topic_type'],
					'topic_title'		=> $rowset[$orig_topic_id]['topic_title'],
				));

				// Shadow topics are never reported
				$row['topic_reported'] = 0;

				$rowset[$orig_topic_id] = $row;
			}
			$this->db->sql_freeresult($result);
		}
		unset($shadow_topic_list);

		// Okay, lets dump out the page ...
		if (count($topic_list))
		{
			foreach ($topic_list as $topic_id)
			{
				$row = &$rowset[$topic_id];

				// Generate all the URIs ...
				$view_topic_url_params = 'f=' . $row['forum_id'] . '&amp;t=' . $topic_id;
				$view_topic_url = $this->auth->acl_get('f_read', $forum_id) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", $view_topic_url_params) : false;

				$topic_unapproved = (($row['topic_visibility'] == ITEM_UNAPPROVED || $row['topic_visibility'] == ITEM_REAPPROVE) && $this->auth->acl_get('m_approve', $row['forum_id']));
				$posts_unapproved = ($row['topic_visibility'] == ITEM_APPROVED && $row['topic_posts_unapproved'] && $this->auth->acl_get('m_approve', $row['forum_id']));
				$topic_deleted = $row['topic_visibility'] == ITEM_DELETED;

				// Send vars to template
				$topic_row = array(
					'FORUM_ID'					=> $row['forum_id'],
					'TOPIC_ID'					=> $topic_id,
					'TOPIC_AUTHOR'				=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'TOPIC_AUTHOR_COLOUR'		=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),

					'VIEWS'						=> $row['topic_views'],
					'TOPIC_TITLE'				=> censor_text($row['topic_title']),

					'TOPIC_ICON_IMG'			=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
					'TOPIC_ICON_IMG_WIDTH'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['width'] : '',
					'TOPIC_ICON_IMG_HEIGHT'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['height'] : '',
					'ATTACH_ICON_IMG'			=> ($this->auth->acl_get('u_download') && $this->auth->acl_get('f_download', $row['forum_id']) && $row['topic_attachment']) ? $this->user->img('icon_topic_attach', $this->user->lang['TOTAL_ATTACHMENTS']) : '',
					'UNAPPROVED_IMG'			=> ($topic_unapproved || $posts_unapproved) ? $this->user->img('icon_topic_unapproved', ($topic_unapproved) ? 'TOPIC_UNAPPROVED' : 'POSTS_UNAPPROVED') : '',

					'S_TOPIC_TYPE'				=> $row['topic_type'],
					'S_USER_POSTED'				=> isset($row['topic_posted']) && $row['topic_posted'],
					'S_TOPIC_REPORTED'			=> !empty($row['topic_reported']) && $this->auth->acl_get('m_report', $row['forum_id']),
					'S_TOPIC_UNAPPROVED'		=> $topic_unapproved,
					'S_POSTS_UNAPPROVED'		=> $posts_unapproved,
					'S_TOPIC_DELETED'			=> $topic_deleted,
					'S_HAS_POLL'				=> (bool) $row['poll_start'],
					'S_TOPIC_LOCKED'			=> $row['topic_status'] == ITEM_LOCKED,
					'S_TOPIC_MOVED'				=> $row['topic_status'] == ITEM_MOVED,

					'U_VIEW_TOPIC'				=> $view_topic_url,
				);

				$this->template->assign_block_vars('lists.list_topics', $topic_row);

				unset($rowset[$topic_id]);
			}
		}
	}
}
