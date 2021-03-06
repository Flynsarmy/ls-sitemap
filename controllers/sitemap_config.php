<?

 class Sitemap_Config extends Backend_Controller {

 	protected $access_for_groups = array(Users_Groups::admin);
 	public $form_edit_title = 'Sitemap Configuration';
	public $form_model_class = 'Sitemap_Params';
	public $implement = 'Db_ListBehavior, Db_FormBehavior';
	public $form_redirect = null;
	public $form_edit_save_flash = 'Sitemap configuration has been saved.';

	public static $CHANGE_FREQS = array(
		'always' => 'Always',
		'hourly' => 'Hourly',
		'daily' => 'Daily',
		'weekly' => 'Weekly',
		'monthly' => 'Monthly',
		'yearly' => 'Yearly',
		'never' => 'Never',
	);

 	public function __construct() {
		parent::__construct();

		//set up the menu tabs
		$this->app_module = 'system';
		$this->app_tab = 'system';
		$this->app_page = 'settings';

		$this->app_module_name = 'System';
		$this->app_page_title = 'Sitemap';
		}

		public function index() {
			try {
				$params = new Sitemap_Params();
				$this->viewData['form_model'] = $params->load();
				$this->viewData['pages'] = Cms_Page::create()->order('theme_id asc')->order('navigation_sort_order asc')->find_all();
				$this->viewData['theming_enabled'] = Cms_Theme::is_theming_enabled();
			}
			catch(exception $ex) {
				$this->_controller->handlePageError($ex);
			}
		}

		public function index_onSave() {
			try {
				$config = new Sitemap_Params();
				$config = $config->load();

				$config->save(post($this->form_model_class, array()), $this->formGetEditSessionKey());

				echo Backend_Html::flash_message('Sitemap configuration has been successfully saved.');
			}
			catch(Exception $ex) {
				Phpr::$response->ajaxReportException($ex, true, true);
			}

			//save pages
			$page_list = Cms_Page::create()->find_all();
			foreach($page_list as $id=>$page) {
				$visible = isset($_POST['pages'][$page->id]['sitemap_visible']);
				$priority = doubleval($_POST['pages'][$page->id]['sitemap_priority']);
				$changefreq = $_POST['pages'][$page->id]['sitemap_changefreq'];

				Db_DbHelper::query("
					update pages
					set
						sitemap_visible=:visible,
						sitemap_priority=:priority,
						sitemap_changefreq=:changefreq
					where id=:id
				", array(
					'visible' => $visible,
					'priority' => $priority,
					'changefreq' => $changefreq,
					'id' => $page->id
				));
			}
		}

 }