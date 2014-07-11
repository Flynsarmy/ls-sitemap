<?

	class SiteMap_Module extends Core_ModuleBase {

		protected function createModuleInfo() {
			return new Core_ModuleInfo(
				"Site Map",
				"Adds a sitemap to your store",
				"Flynsarmy" );
		}

		public function subscribeEvents() {
			Backend::$events->addEvent('cms:onExtendPageModel', $this, 'extend_page_model');
			Backend::$events->addEvent('cms:onExtendPageForm', $this, 'extend_page_form');
			Backend::$events->addEvent('cms:onGetPageFieldOptions', $this, 'get_page_field_options');
		}

		public function extend_page_model($page, $context) {
			$page->define_column('sitemap_visible', 'Appears on site map')->defaultInvisible()->listTitle('Sitemap Visible');
			$page->define_column('sitemap_priority', 'Priority on site map')->defaultInvisible()->listTitle('Sitemap Priority');
			$page->define_column('sitemap_changefreq', 'Change Frequency on site map')->defaultInvisible()->listTitle('Sitemap Change Frequency');
		}

		public function extend_page_form($page, $context) {
			if ($context != 'content')
			{
				$page->add_form_field('sitemap_visible', 'full')->tab('Visibility')->renderAs(frm_checkbox);
				$page->add_form_field('sitemap_priority', 'left')->tab('Visibility')->renderAs(frm_text);
				$page->add_form_field('sitemap_changefreq', 'right')->tab('Visibility')->renderAs(frm_dropdown);
			}
		}

		public function listSettingsItems() {
			$result = array(
				array(
					'icon'=>'/modules/sitemap/resources/images/sitemap.png',
					'title'=>'Sitemap Configuration',
					'url'=>'/sitemap/config/',
					'description'=>'Setup the sitemap',
					'sort_id'=>300
				)
			);

			return $result;
		}

		public function register_access_points() {
			return array(
				'sitemap.xml' =>'generate_sitemap',
				'ls_sitemap' => 'generate_sitemap'
			);
		}

		public function generate_sitemap() {
			$sitemap = new Sitemap_Generator();
			$sitemap->generate();
			$sitemap->send();
		}

		public function get_page_field_options($field_name, $current_value) {
			if ( $field_name != 'sitemap_changefreq' )
				return false;

			$values = Sitemap_Config::$CHANGE_FREQS;

			if ($current_value != -1 && array_key_exists($values, $current_value) )
				return $values[$current_value];

			return $values;
		}

	}