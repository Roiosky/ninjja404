<?php

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Version;
use JoomShaper\SPPageBuilder\DynamicContent\Supports\Arr;

/**
 * Trait for managing app configs
 */
trait AppConfig
{
	/**
	 * App config
	 * @TODO: will be implemented later.
	 *
	 * @return void
	 */
	public function appConfig()
	{
		$method = $this->getInputMethod();
		$this->checkNotAllowedMethods(['POST', 'PUT', 'DELETE', 'PATCH'], $method);


		$this->getAppConfig();
	}

	private function getAppConfig()
	{
		if (!\class_exists('SpPgaeBuilderBase'))
		{
			require_once JPATH_ROOT . '/components/com_sppagebuilder/builder/classes/base.php';
		}

		if (!\class_exists('SppagebuilderHelper'))
		{
			require_once JPATH_ROOT . '/administrator/components/com_sppagebuilder/helpers/sppagebuilder.php';
		}

		$mediaParams = ComponentHelper::getParams('com_media');
		$cParams = ComponentHelper::getParams('com_sppagebuilder');

		$allowedFileExtensions = $mediaParams->get('restrict_uploads_extensions', '');
		$restrictUploads = $mediaParams->get('restrict_uploads', 0);
		$allowedFileExtensions = $restrictUploads ? explode(',', $allowedFileExtensions) : [];
		$allowedFileExtensions = array_map('strtolower', $allowedFileExtensions);

		$model = $this->getModel('Appconfig');

		$pages = $model->getPageList();
		$menus = $model->getMenus();
		$popups = $model->getPopupList();
		$categories = $model->getCategories();
		$easyStoreCategories = $model->getEasyStoreCategories();
		$accessLevels = $model->getAccessLevels();
		$languages = $model->getLanguages();
		$modules = SpPgaeBuilderBase::getModuleAttributes();

		$languageOptions = $this->convertToOptions($languages);
		$allLanguage = (object) [
			'label' => Text::_('JALL'),
			'value' => '*'
		];

		array_unshift($languageOptions, $allLanguage);

		$version = SppagebuilderHelper::getVersion();
		$preReleaseVersions = ['alpha', 'beta', 'rc'];
		$isPreRelease = false;

		foreach ($preReleaseVersions as $preReleaseVersion)
		{
			if (\stripos($version, $preReleaseVersion) !== false)
			{
				$isPreRelease = true;
				break;
			}
		}

		$googleFontCategories = [
			(object) [
				'label' => Text::_('COM_SPPAGEBUILDER_FONT_CATEGORY_SERIF'),
				'value' => 'serif'
			],
			(object) [
				'label' => Text::_('COM_SPPAGEBUILDER_FONT_CATEGORY_SANS_SERIF'),
				'value' => 'sans-serif'
			],
			(object) [
				'label' => Text::_('COM_SPPAGEBUILDER_FONT_CATEGORY_DISPLAY'),
				'value' => 'display'
			],
			(object) [
				'label' => Text::_('COM_SPPAGEBUILDER_FONT_CATEGORY_HANDWRITING'),
				'value' => 'handwriting'
			],
			(object) [
				'label' => Text::_('COM_SPPAGEBUILDER_FONT_CATEGORY_MONOSPACE'),
				'value' => 'monospace'
			]
		];

		$version = new Version();
		$JoomlaVersion = $version->getShortVersion();

		$response = (object) [
			'pages' => $pages,
			'menus' => $this->convertToOptions($menus),
			'popups' => $this->convertToOptions($popups),
			'categories' => $this->convertCategoriesToOptions($categories),
			'easystore_categories' => $easyStoreCategories,
			'modules' => $modules['moduleName'] ?? [],
			'module_positions' => $modules['modulePosition'] ?? [],
			'access_levels' => $this->convertToOptions($accessLevels),
			'article_categories' => SpPgaeBuilderBase::getArticleCategories(),
			'languages' => $languageOptions,
			'font_awesome_icons' => SpPgaeBuilderBase::getIconList(),
			'version' => SppagebuilderHelper::getVersion(),
			'editor' => (object) [
				'theme' => $JoomlaVersion < 4 ? 'modern' : 'silver',
			],
			'media_path' => '/' . $mediaParams->get('file_path', 'images'),
			'media_upload_max_size' => $mediaParams->get('upload_maxsize', 0) * 1024 * 1024,
			'is_pre_release' => $isPreRelease,
			'google_font_categories' => $googleFontCategories,
			'has_google_font_api_key' => !empty($cParams->get('google_font_api_key', '')),
			'is_google_fonts_disabled' => (bool) $cParams->get('disable_google_fonts', 0),
			'enable_frontend_editing' => (bool) $cParams->get('enable_frontend_editing', 1),
			'enable_ai'	=> (bool) $cParams->get('enable_ai', 1),
			'permissions' => $model->getUserPermissions(),
			'user_id' => Factory::getUser()->id ?? null,
			'is_easystore_installed' => ApplicationHelper::isEasyStoreInstalled(),
			'list_product_page_id' => ApplicationHelper::getStorePageId('storefront'),
			'single_product_page_id' => ApplicationHelper::getStorePageId('single'),
			'collection_page_id' => ApplicationHelper::getStorePageId('collection'),
			'is_pro' => ApplicationHelper::isProVersion(),
			'allowed_file_extensions' => $allowedFileExtensions,
			'collections' => $model->getCollections(),
		];

		$this->sendResponse($response);
	}

	public function getPermissions()
	{
		$pageId = $this->getInput('page_id', 0, 'INT');
		$model = $this->getModel('Appconfig');

		$this->sendResponse($model->getUserPermissions($pageId));
	}

	private function convertToOptions(array $values)
	{
		$options = [];

		foreach ($values as $value)
		{
			$option = (object) [
				'label' => $value->title,
				'value' => $value->id
			];

			$options[] = $option;
		}

		return $options;
	}

	private function convertCategoriesToOptions(array $categories)
	{
		$options = [];

		foreach ($categories as $category)
		{
			$option = (object) [
				'label' => str_repeat('- ', max(0, $category->level - 1)) . $category->title,
				'value' => $category->id
			];

			$options[] = $option;
		}

		return $options;
	}
}
