<?php

/**
 * @package     SP Simple Portfolio
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

//Load the method jquery script.
HTMLHelper::_('jquery.framework');
$doc = Factory::getDocument();
$doc->addStylesheet(Uri::root(true) . '/components/com_spsimpleportfolio/assets/css/featherlight.min.css');
$doc->addStylesheet(Uri::root(true) . '/components/com_spsimpleportfolio/assets/css/spsimpleportfolio.css');
$doc->addScript(Uri::root(true) . '/components/com_spsimpleportfolio/assets/js/jquery.shuffle.modernizr.min.js');
$doc->addScript(Uri::root(true) . '/components/com_spsimpleportfolio/assets/js/featherlight.min.js');
$doc->addScript(Uri::root(true) . '/components/com_spsimpleportfolio/assets/js/spsimpleportfolio.js');

if ($this->params->get('show_page_heading') && $this->params->get('page_heading')) {
	echo "<h1 class='page-header'>" . $this->params->get('page_heading') . "</h1>";
}
?>

<div id="sp-simpleportfolio" class="sp-simpleportfolio-classic-layout sp-simpleportfolio-classic sp-simpleportfolio-view-items layout-<?php echo $this->layout_type; ?>">

	<?php
	//Videos
	foreach ($this->items as $key => $this->item) {
		if ($this->item->video) {
			$video = parse_url($this->item->video);

			switch ($video['host']) {
				case 'youtu.be':
					$video_id 	= trim($video['path'], '/');
					$video_src 	= '//www.youtube.com/embed/' . $video_id;
					break;

				case 'www.youtube.com':
				case 'youtube.com':
					parse_str($video['query'], $query);
					$video_id 	= $query['v'];
					$video_src 	= '//www.youtube.com/embed/' . $video_id;
					break;

				case 'vimeo.com':
				case 'www.vimeo.com':
					$video_id 	= trim($video['path'], '/');
					$video_src 	= "//player.vimeo.com/video/" . $video_id;
			}

			echo '<iframe class="sp-simpleportfolio-lightbox" src="' . $video_src . '" width="500" height="281" id="sp-simpleportfolio-video' . $this->item->id . '" style="border:none;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
	}
	?>

	<div class="sp-simpleportfolio-items-wrap sppb-row">
		<?php
		$countItem = 1;
		$oddIndex = array();
		$evenIndex = array();
		$indexIds = array();
		foreach ($this->items as $key => $this->item) {
			if (($countItem % 2 === 0) && !in_array($this->item->id, $indexIds)) {
				array_push($evenIndex, $this->item);
				array_push($indexIds, $this->item->id);
			} elseif (!in_array($this->item->id, $indexIds)) {
				array_push($oddIndex, $this->item);
				array_push($indexIds, $this->item->id);
			}
			$countItem++;
		}
		?>
		<div class="sppb-col-sm-6">
			<?php foreach ($oddIndex as $key => $portfolio_item) { ?>
				<div class="sp-simpleportfolio-item" data-groups='[<?php echo $portfolio_item->groups; ?>]'>
					<div class="sp-simpleportfolio-item-wrap">
						<a class="full-link" href="<?php echo $portfolio_item->url; ?>"></a>
						<div class="sp-simpleportfolio-overlay-wrapper clearfix">
							<?php if ($portfolio_item->video) { ?>
								<span class="sp-simpleportfolio-icon-video"></span>
							<?php } ?>

							<img class="sp-simpleportfolio-img" src="<?php echo $portfolio_item->thumb; ?>" alt="<?php echo $portfolio_item->title; ?>">
						</div>
						<div class="sp-simpleportfolio-info">
							<?php
							// client avatar
							if (isset($portfolio_item->client_avatar) && $portfolio_item->client_avatar) { ?>
								<div class="sp-simpleportfolio-client">
									<div class="sp-simpleportfolio-client-avatar">
										<?php if (isset($portfolio_item->client_url) && $portfolio_item->client_url) { ?>
											<a target="_blank" href="<?php echo $portfolio_item->client_url; ?>">
											<?php } ?>
											<img src="<?php echo Uri::root() . $portfolio_item->client_avatar ?>" alt="<?php echo $portfolio_item->title; ?>">
											<?php if (isset($portfolio_item->client_url) && $portfolio_item->client_url) { ?>
											</a>
										<?php } ?>
									</div>
								</div> <!-- /.sp-simpleportfolio-client -->
							<?php } // has project client logo or name 
							?>
							<div class="sp-simpleportfolio-tags">
								<?php echo implode(', ', $portfolio_item->tags); ?>
							</div>
							<h4 class="sp-simpleportfolio-title">
								<a href="<?php echo $portfolio_item->url; ?>">
									<?php echo $portfolio_item->title; ?>
								</a>
							</h4>
						</div>
					</div>
				</div>
			<?php } ?>
		</div> <!-- //sppb-col-sm-6 -->

		<div class="sppb-col-sm-6 masorary-gap">
			<?php foreach ($evenIndex as $key => $portfolio_item) { ?>
				<div class="sp-simpleportfolio-item" data-groups='[<?php echo $portfolio_item->groups; ?>]'>
					<div class="sp-simpleportfolio-item-wrap">
						<a class="full-link" href="<?php echo $portfolio_item->url; ?>"></a>
						<div class="sp-simpleportfolio-overlay-wrapper clearfix">
							<?php if ($portfolio_item->video) { ?>
								<span class="sp-simpleportfolio-icon-video"></span>
							<?php } ?>
							<img class="sp-simpleportfolio-img" src="<?php echo $portfolio_item->thumb; ?>" alt="<?php echo $portfolio_item->title; ?>">
						</div>
						<div class="sp-simpleportfolio-info">
							<?php
							// client avatar
							if (isset($portfolio_item->client_avatar) && $portfolio_item->client_avatar) { ?>
								<div class="sp-simpleportfolio-client">
									<div class="sp-simpleportfolio-client-avatar">
										<?php if (isset($portfolio_item->client_url) && $portfolio_item->client_url) { ?>
											<a target="_blank" href="<?php echo $portfolio_item->client_url; ?>">
											<?php } ?>
											<img src="<?php echo Uri::root() . $portfolio_item->client_avatar ?>" alt="<?php echo $portfolio_item->title; ?>">
											<?php if (isset($portfolio_item->client_url) && $portfolio_item->client_url) { ?>
											</a>
										<?php } ?>
									</div>
								</div> <!-- /.sp-simpleportfolio-client -->
							<?php } // has project client logo or name 
							?>
							<div class="sp-simpleportfolio-tags">
								<?php echo implode(', ', $portfolio_item->tags); ?>
							</div>
							<h4 class="sp-simpleportfolio-title">
								<a href="<?php echo $portfolio_item->url; ?>">
									<?php echo $portfolio_item->title; ?>
								</a>
							</h4>
						</div>
					</div>
				</div>
			<?php } ?>
		</div> <!-- //sppb-col-sm-6 -->
	</div>

	<?php if ($this->pagination->pagesTotal > 1) : ?>
		<div class="pagination">
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
</div>