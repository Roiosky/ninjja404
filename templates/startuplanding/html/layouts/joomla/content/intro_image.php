<?php

/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('JPATH_BASE') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;


$params = $displayData->params;
$attribs = json_decode($displayData->attribs);

$template = Factory::getApplication('site')->getTemplate(true);
$tplParams = $template->params;

$leading = (isset($displayData->leading) && $displayData->leading) ? 1 : 0;

if ($leading) {
    $blog_list_image = $tplParams->get('leading_blog_list_image', 'large');
} else {
    $blog_list_image = $tplParams->get('blog_list_image', 'thumbnail');
}

$intro_image = '';
if (isset($attribs->helix_ultimate_image) && $attribs->helix_ultimate_image != '') {
    $full_image_alt_txt = isset($attribs->helix_ultimate_image_alt_txt) && $attribs->helix_ultimate_image_alt_txt != '' ? $attribs->helix_ultimate_image_alt_txt : $displayData->title;

    if ($blog_list_image == 'default') {
        $intro_image = $attribs->helix_ultimate_image;
    } else {
        $intro_image = $attribs->helix_ultimate_image;
        $basename = basename($intro_image);
        $list_image = JPATH_ROOT . '/' . dirname($intro_image) . '/' . File::stripExt($basename) . '_' . $blog_list_image . '.' . File::getExt($basename);
        if (JFile::exists($list_image)) {
            $intro_image = Uri::root(true) . '/' . dirname($intro_image) . '/' . File::stripExt($basename) . '_' . $blog_list_image . '.' . File::getExt($basename);
        }
    }
}
?>
<?php if ($intro_image) : ?>
    <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
        <a class="article-intro-image-wrap" href="<?php echo Route::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>">
        <?php endif; ?>
        <?php if ($leading) { ?>
            <div class="article-intro-image" style="background-image: url(<?php echo $intro_image; ?>);"></div>
        <?php } else { ?>
            <div class="article-intro-image">
                <img src="<?php echo $intro_image; ?>" alt="<?php echo htmlspecialchars($full_image_alt_txt, ENT_COMPAT, 'UTF-8'); ?>">
            </div>
        <?php } ?>
        <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
        </a>
    <?php endif; ?>
<?php else : ?>

    <?php $images = json_decode($displayData->images); ?>
    <?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
        <?php $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro; ?>
        <div class="article-intro-image float-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?>">
            <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
                <a href="<?php echo Route::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>"><img <?php if ($images->image_intro_caption) : ?> <?php echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"'; ?> <?php endif; ?> src="<?php echo htmlspecialchars($images->image_intro, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt, ENT_COMPAT, 'UTF-8'); ?>"></a>
            <?php else : ?><img <?php if ($images->image_intro_caption) : ?> <?php echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption, ENT_COMPAT, 'UTF-8') . '"'; ?> <?php endif; ?> src="<?php echo htmlspecialchars($images->image_intro, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt, ENT_COMPAT, 'UTF-8'); ?>">
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>