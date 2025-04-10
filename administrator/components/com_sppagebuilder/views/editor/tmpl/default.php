<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2025 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

//no direct access
defined('_JEXEC') or die('restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$doc = Factory::getDocument();

$assetBase = JPATH_ROOT . '/administrator/components/com_sppagebuilder/assets/editor/dist/js/';
$includeBase = Uri::root(true) . '/administrator/components/com_sppagebuilder/assets/editor/dist/js/';

if (!class_exists('SppagebuilderHelperSite'))
{
	require_once JPATH_ROOT . '/components/com_sppagebuilder/helpers/helper.php';
}

if (\file_exists($assetBase . 'bundle.min.js'))
{
	$doc->addScript($includeBase . 'bundle.min.js', ['version' => SppagebuilderHelperSite::getVersion(true)], ['defer' => true]);
	$doc->addScript($includeBase . 'vendors.min.js', ['version' => SppagebuilderHelperSite::getVersion(true)], ['defer' => true]);
}
elseif (\file_exists($assetBase . 'bundle.js'))
{
	$doc->addScript($includeBase . 'bundle.js', ['version' => SppagebuilderHelperSite::getVersion(true)], ['defer' => true]);
	$doc->addScript($includeBase . 'vendors.js', ['version' => SppagebuilderHelperSite::getVersion(true)], ['defer' => true]);
}

$doc->addScriptDeclaration('Joomla.pagebuilderBase = "' . Uri::root() . '"');

if (!\class_exists('SppagebuilderHelper'))
{
	require_once JPATH_ROOT . '/administrator/components/com_sppagebuilder/helpers/sppagebuilder.php';
}

?>

<div id="pagebuilder-backend-editor"></div>