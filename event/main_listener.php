<?php
/**
 *
 * List Manager.
 *
 * @copyright (c) 2021, AdrianB
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace adrianb11\listmanager\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * List Manager Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup' 				=> 'load_language_on_setup',
			'core.page_header'				=> 'add_page_header_link',
			'core.permissions'				=> 'add_permissions',
			'core.display_forums_after' 	=> 'display_board',
		];
	}

	/* @var \phpbb\language\language */
	protected $language;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;
	
	/* @var \phpbb\request\request */
	protected $request;
	
	/* @var \adrianb11\listmanager\core\boards */
	protected $boards;
	
	/* @var \phpbb\auth\auth */
	protected $auth;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language				$language
	 * @param \phpbb\controller\helper				$helper
	 * @param \phpbb\template\template				$template
	 * @param \phpbb\request\request 				$request
	 * @param \adrianb11\listmanager\core\boards	$boards
	 * @param \phpbb\auth\auth 						$auth
	 */
	public function __construct(\phpbb\language\language $language, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\request\request $request, \adrianb11\listmanager\core\boards $boards, \phpbb\auth\auth $auth)
	{
		$this->language = $language;
		$this->helper   = $helper;
		$this->template = $template;
		$this->request 	= $request;
		$this->boards	= $boards;
		$this->auth		= $auth;
	}
	
	/**
     * Load the language file
     *
     * @param \phpbb\event\data $event The event object
     */
    public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = [
            'ext_name' => 'adrianb11/listmanager',
            'lang_set' => 'common',
        ];
        $event['lang_set_ext'] = $lang_set_ext;
    }

	/**
	 * Add a link to the controller in the forum navbar
	 */
	public function add_page_header_link()
	{
		/**
		 * Check permissions first
		 */
		if ($this->auth->acl_get('u_adrianb11_listmanager_manage_boards'))
		{
			$this->template->assign_vars([
				'CAN_VIEW_CP'			=> $this->auth->acl_get('u_adrianb11_listmanager_manage_boards'),
				'U_LISTMANAGER_PAGE'	=> $this->helper->route('adrianb11_listmanager_manage'),
			]);
		}
	}

	/**
	 * Add permissions to the ACP -> Permissions settings page
	 * This is where permissions are assigned language keys and
	 * categories (where they will appear in the Permissions table):
	 * actions|content|forums|misc|permissions|pm|polls|post
	 * post_actions|posting|profile|settings|topic_actions|user_group
	 *
	 * Developers note: To control access to ACP, MCP and UCP modules, you
	 * must assign your permissions in your module_info.php file. For example,
	 * to allow only users with the a_new_adrianb11_listmanager permission
	 * access to your ACP module, you would set this in your acp/main_info.php:
	 *    'auth' => 'ext_adrianb11/listmanager && acl_a_board'
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function add_permissions($event)
	{
		// Add new permission category
		$categories = $event['categories'];
		$categories['listmanager'] = 'List Manager';

		// Permissions
		$permissions = $event['permissions'];
		
		// Admin Permissions
		$permissions['a_adrianb11_listmanager_manage'] 						= ['lang' => 'ACL_A_LISTMANAGER_MANAGE', 'cat' => 'listmanager'];

		// Registered User permissions
		$permissions['u_adrianb11_listmanager_manage_boards'] 				= ['lang' => 'ACL_U_LISTMANAGER_MANAGE_BOARDS', 'cat' => 'listmanager'];
		$permissions['u_adrianb11_listmanager_manage_boards_add'] 			= ['lang' => 'ACL_U_LISTMANAGER_MANAGE_BOARDS_ADD', 'cat' => 'listmanager'];
		$permissions['u_adrianb11_listmanager_manage_boards_delete'] 		= ['lang' => 'ACL_U_LISTMANAGER_MANAGE_BOARDS_DELETE', 'cat' => 'listmanager'];
		$permissions['u_adrianb11_listmanager_view_boards'] 				= ['lang' => 'ACL_U_LISTMANAGER_VIEW_BOARDS', 'cat' => 'listmanager'];

		// Save permissions and categories
		$event['categories'] = $categories;
		$event['permissions'] = $permissions;
	}
	
	/**
	 * Displays board in forum
	 */
	public function display_board()
	{
		$forum_id = $this->request->variable('f', '999');
		
		$this->boards->render_board($forum_id);
	}
}
