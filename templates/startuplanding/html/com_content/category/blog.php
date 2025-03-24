<?php

/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');


$app = Factory::getApplication();

$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$doc = Factory::getDocument();
$tpl_params = Factory::getApplication()->getTemplate(true)->params;

?>

<div class="blog<?php echo $this->pageclass_sfx; ?>">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
        </div>
    <?php endif; ?>

    <?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
        <h2>
            <?php echo $this->escape($this->params->get('page_subheading')); ?>
            <?php if ($this->params->get('show_category_title')) : ?>
                <span class="subheading-category"><?php echo $this->category->title; ?></span>
            <?php endif; ?>
        </h2>
    <?php endif; ?>
    <?php echo $afterDisplayTitle; ?>

    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
        <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php endif; ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
        <div class="category-desc clearfix">
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>">
            <?php endif; ?>
            <?php echo $beforeDisplayContent; ?>
            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
            <?php endif; ?>
            <?php echo $afterDisplayContent; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
        <?php if ($this->params->get('show_no_articles', 1)) : ?>
            <p><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $introcount = count($this->intro_items);
    $counter = 1;
    ?>

    <?php if (!empty($this->intro_items)) : ?>
        <div class="article-list">
            <div class="container">
                <div class="row">
                    <?php if ($doc->countModules('bloglist-topright-mod') && $counter === 1) { ?>
                        <div class="col-md-8">
                            <div class="row">
                            <?php } ?>
                            <?php if (!empty($this->lead_items)) : ?>
                                <div class="col-md-12">
                                    <div class="article-list articles-leading clearfix">
                                        <?php foreach ($this->lead_items as &$item) : ?>
                                            <?php $readingTime = floor(str_word_count($item->fulltext) / 200) <= 1 ? 1 : floor(str_word_count($item->fulltext) / 200); ?>
                                            <div class="article<?php echo $item->state == 0 ? ' system-unpublished' : null; ?>" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting" data-reading-time="<?php echo $readingTime; ?>">
                                                <?php
                                                $this->item = &$item;
                                                $this->item->leading = true;
                                                echo $this->loadTemplate('item');
                                                ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div> <!-- //.col-md-12 -->
                            <?php endif; ?>
                            <?php foreach ($this->intro_items as $key => &$item) : ?>
                                <?php $readingTime = floor(str_word_count($item->fulltext) / 200) <= 1 ? 1 : floor(str_word_count($item->fulltext) / 200); ?>
                                <div class="col-lg-<?php echo round(12 / $this->params->get('num_columns')); ?>">
                                    <div class="article <?php echo $item->state == 0 ? ' system-unpublished' : null; ?>" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting" data-reading-time="<?php echo $readingTime; ?>">
                                        <?php
                                        $this->item = &$item;
                                        echo $this->loadTemplate('item');
                                        ?>
                                    </div>
                                </div>

                                <?php if ($doc->countModules('bloglist-topright-mod') && $counter == 2) { ?>
                            </div> <!-- /.col-md-8 -->
                        </div> <!-- /.row -->
                        <div class="col-md-4 sl-blog-right">
                            <!-- top right position -->
                            <?php
                                    jimport('joomla.application.module.helper');
                                    $modules = ModuleHelper::getModules('bloglist-topright-mod');
                                    $attribs['style'] = 'sp_xhtml';

                                    foreach ($modules as $key => $module) {
                                        echo ModuleHelper::renderModule($module, $attribs);
                                    }
                            ?>
                            <!-- // END:: top right position -->
                        </div> <!-- /.col-md-4 -->
                    <?php } ?>

                    <!-- middle position -->
                    <?php if ($doc->countModules('bloglist-middle-mod') && $counter == 2) { ?>
                </div> <!-- //.row -->
            </div> <!-- //.container -->
            <div class="container-fluid">
                <?php
                                    jimport('joomla.application.module.helper');
                                    $modules = ModuleHelper::getModules('bloglist-middle-mod');
                                    $attribs['style'] = 'sp_xhtml';

                                    foreach ($modules as $key => $module) {
                                        echo ModuleHelper::renderModule($module, $attribs);
                                    }    ?>
            </div> <!-- //.container -->
            <div class="container">
                <div class="row">
                <?php } ?>
                <!-- // END:: middle position -->

                <?php if ($doc->countModules('bloglist-bottomright-mod') && $counter == 2) { ?>
                    <div class="col-md-8">
                        <div class="row">
                        <?php } ?>
                        <!-- // END:: middle position -->
                        <?php if ($doc->countModules('bloglist-bottomright-mod') && $counter == $introcount) { ?>
                        </div> <!-- /.col-md-8 -->
                    </div> <!-- /.row -->
                    <div class="col-md-4 sl-blog-right">
                        <!-- top right position -->
                        <?php
                                    jimport('joomla.application.module.helper');
                                    $modules = ModuleHelper::getModules('bloglist-bottomright-mod');
                                    $attribs['style'] = 'sp_xhtml';

                                    foreach ($modules as $key => $module) {
                                        echo ModuleHelper::renderModule($module, $attribs);
                                    }
                        ?>
                        <!-- // END:: top right position -->
                    </div> <!-- /.col-md-4 -->
                <?php } ?>
                <?php
                $counter++;
                endforeach;
                ?>
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div>
    <?php endif; ?>

    <div class="container">
        <?php if (!empty($this->link_items)) : ?>
            <div class="articles-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
            <div class="cat-children">
                <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
                    <h3> <?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
                <?php endif; ?>
                <?php echo $this->loadTemplate('children'); ?>
            </div>
        <?php endif; ?>

        <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
            <nav class="d-flex pagination-wrapper">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                    <?php echo $this->pagination->getPagesLinks(); ?>
                <?php endif; ?>
            </nav>
        <?php endif; ?>

        <!-- top right position -->
        <?php if ($doc->countModules('bloglist-bottom-mod')) {
            jimport('joomla.application.module.helper');
            $modules = ModuleHelper::getModules('bloglist-bottom-mod');
            $attribs['style'] = 'sp_xhtml';

            foreach ($modules as $key => $module) {
                echo ModuleHelper::renderModule($module, $attribs);
            }
        } ?>
        <!-- // END:: top right position -->
    </div> <!-- //.container -->
</div>