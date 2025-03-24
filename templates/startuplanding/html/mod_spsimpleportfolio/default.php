<?php
/**
 * @package     SP Simple Portfolio
 * @subpackage  mod_spsimpleportfolio
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die;
jimport('joomla.filesystem.file');

$layout_type = $params->get('layout_type', 'default');
?>
<div id="mod-sp-simpleportfolio" class="sp-simpleportfolio sp-simpleportfolio-view-items layout-<?php echo str_replace('_', '-', $layout_type); ?> <?php echo $moduleclass_sfx; ?>">
	<?php if ($params->get('show_filter', 1)) { ?>
		<div class="sp-simpleportfolio-filter">
			<ul>
				<li class="active" data-group="all"><a href="#"><?php echo JText::_('MOD_SPSIMPLEPORTFOLIO_SHOW_ALL'); ?></a></li>
				<?php foreach ($tagList as $filter) { ?>
					<li data-group="<?php echo $filter->alias; ?>"><a href="#"><?php echo $filter->title; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>

	<div class="sp-simpleportfolio-items-wrap sppb-row">
		<?php
		// Limit to 4 items
		$limitedItems = array_slice($items, 0, 4);
		$countItem = 1;
		$oddItems = [];
		$evenItems = [];

		foreach ($limitedItems as $item) {
			if ($countItem % 2 === 0) {
				$evenItems[] = $item;
			} else {
				$oddItems[] = $item;
			}
			$countItem++;
		}
		?>
		<div class="sppb-col-sm-6">
			<?php foreach ($oddItems as $item) { ?>
				<div class="sp-simpleportfolio-item" data-groups='[<?php echo $item->groups; ?>]'>
					<div class="sp-simpleportfolio-item-wrap">
						<a class="full-link" href="<?php echo $item->url; ?>"></a>
						<div class="sp-simpleportfolio-overlay-wrapper clearfix">
							<?php if ($item->video) { ?>
								<span class="sp-simpleportfolio-icon-video"></span>
							<?php } ?>
							<img class="sp-simpleportfolio-img" src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>">
						</div>
						<div class="sp-simpleportfolio-info">
							<?php if (!empty($item->client_avatar)) { ?>
								<div class="sp-simpleportfolio-client">
									<div class="sp-simpleportfolio-client-avatar">
										<img src="<?php echo JURI::root() . $item->client_avatar; ?>" alt="<?php echo $item->title; ?>">
									</div>
								</div>
							<?php } ?>
							<div class="sp-simpleportfolio-tags">
								<?php echo implode(', ', $item->tags); ?>
							</div>
							<h4 class="sp-simpleportfolio-title">
								<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
							</h4>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="sppb-col-sm-6 masorary-gap">
			<?php foreach ($evenItems as $item) { ?>
				<div class="sp-simpleportfolio-item" data-groups='[<?php echo $item->groups; ?>]'>
					<div class="sp-simpleportfolio-item-wrap">
						<a class="full-link" href="<?php echo $item->url; ?>"></a>
						<div class="sp-simpleportfolio-overlay-wrapper clearfix">
							<?php if ($item->video) { ?>
								<span class="sp-simpleportfolio-icon-video"></span>
							<?php } ?>
							<img class="sp-simpleportfolio-img" src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>">
						</div>
						<div class="sp-simpleportfolio-info">
							<?php if (!empty($item->client_avatar)) { ?>
								<div class="sp-simpleportfolio-client">
									<div class="sp-simpleportfolio-client-avatar">
										<img src="<?php echo JURI::root() . $item->client_avatar; ?>" alt="<?php echo $item->title; ?>">
									</div>
								</div>
							<?php } ?>
							<div class="sp-simpleportfolio-tags">
								<?php echo implode(', ', $item->tags); ?>
							</div>
							<h4 class="sp-simpleportfolio-title">
								<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
							</h4>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
