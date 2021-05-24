<?php

namespace adrianb11\listmanager\core;

class boards
{
	/** @var \phpbb\template\template */
	protected $template;
	
	/* @var \phpbb\auth\auth */
	protected $auth;
	
	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var string phpBB root path */
	protected $root_path;
	

	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\auth\auth 					$auth
	 * @param \phpbb\db\driver\driver_interface	$db
	 * @param string 							$root_path
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $root_path)
	{
		$this->template		= $template;
		$this->auth			= $auth;
		$this->db			= $db;
		$this->root_path	= $root_path;
	}
	
	/**
	 * Displays board view
	 *
	 * @param $id
	 */
	public function render_board($id)
	{
		// Is user allowed to view boards?
		if ($this->auth->acl_get('u_adrianb11_listmanager_view_boards') == true)
		{
			$forums_list = $this->get_forums($id);
			
			if (!empty($forums_list))
			{
				$this->template->assign_vars([
					'ISBOARD'			=> true,
					'S_BBCODE_ALLOWED'	=> true,
				]);
				
				$this->load_image_vars();
				
				display_custom_bbcodes();
			
				$topics_list = $this->get_topics($id);
				
				foreach ($forums_list as $forums)
				{
					$this->template->assign_block_vars('lists', [
						'FORUM_ID'			=> $forums['forum_id'],
						'PARENT_ID'			=> $forums['parent_id'],
						'FORUM_NAME'		=> $forums['forum_name'],
						'FORUM_DESC'		=> $forums['forum_desc'],
					]);
					
					if (!empty($topics_list[$forums['forum_id']]))
					{
						foreach ($topics_list[$forums['forum_id']]['topics'] as $topics)
						{
							$this->template->assign_block_vars('topics', [
								'TOPIC_ID'				=> $topics['topic_id'],
								'FORUM_ID'				=> $topics['forum_id'],
								'TOPIC_TITLE'			=> $topics['topic_title'],
								'TOPIC_TIME'			=> $topics['topic_time'],
								'TOPIC_FIRST_POST_ID'	=> $topics['topic_first_post_id'],
								'TOPIC_POSTS_APPROVED'	=> $topics['topic_posts_approved'],
								'TOPIC_LAST_POST_TIME'	=> $topics['topic_last_post_time'],
							]);
							
						}
					}
				}
			}
		}
	}
	
	/**
	 * Gets children of forum
	 *
	 * @param $id
	 * @return array
	 */
	public function get_forums($id)
	{
		// Add sort by left_id
		$sql = 'SELECT forum_id, parent_id, left_id, forum_name, forum_desc
				FROM ' . FORUMS_TABLE . '
				WHERE parent_id IN (
					SELECT forum_id
					FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . $id . ' AND listmanager_isboard = 1
					)';

		$result = $this->db->sql_query($sql);
		$forums = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			// Check if user can see forum else continue
			// Change $row[forum_id] to [left_id]
			$forums[(int) $row['forum_id']]['forum_id'] = $row['forum_id'];
			$forums[(int) $row['forum_id']]['parent_id'] = $row['parent_id'];
			$forums[(int) $row['forum_id']]['left_id'] = $row['left_id'];
			$forums[(int) $row['forum_id']]['forum_name'] = $row['forum_name'];
			$forums[(int) $row['forum_id']]['forum_desc'] = $row['forum_desc'];
		}
		$this->db->sql_freeresult($result);
		
		return $forums;
	}
	
	/**
	 * Gets topics of forum
	 * 
	 * @param $id
	 * @return array
	 */
	public function get_topics($id)
	{
		$sql = 'SELECT topic_id, forum_id, topic_title, topic_time, topic_first_post_id, topic_posts_approved, topic_last_post_time
				FROM ' . TOPICS_TABLE . '
				WHERE forum_id IN (
					SELECT forum_id
					FROM ' . FORUMS_TABLE . '
					WHERE parent_id = ' . $id . '
					)';
				
		$result = $this->db->sql_query($sql);
		$topics = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			// Check if user can see forum else continue
			$topics[(int) $row['forum_id']]['topics'][(int) $row['topic_id']] = $row;
		}
		$this->db->sql_freeresult($result);
		
		return $topics;
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
}