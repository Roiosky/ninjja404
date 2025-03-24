<?php
/**
 * @package     SP Simple Portfolio
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die();

$doc = Factory::getDocument();
$doc->addStylesheet( Uri::root(true) . '/components/com_spsimpleportfolio/assets/css/spsimpleportfolio.css' );

//video
if($this->item->video) {
	$video = parse_url($this->item->video);

	switch($video['host']) {
		case 'youtu.be':
		$video_id 	= trim($video['path'],'/');
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
		$video_id 	= trim($video['path'],'/');
		$video_src 	= "//player.vimeo.com/video/" . $video_id;
	}
}
?>

<div id="sp-simpleportfolio" class="sp-simpleportfolio sp-simpleportfolio-view-item">
	<div class="sp-simpleportfolio-info">
		<div class="sp-simpleportfolio-created">
			<?php echo HTMLHelper::_('date', $this->item->created_on, Text::_('DATE_FORMAT_LC3')); ?>
		</div>
		<!-- // client avatar -->
		<?php if(isset($this->item->client_avatar) && $this->item->client_avatar){ ?>
			<div class="sp-simpleportfolio-client text-center">
					<div class="sp-simpleportfolio-client-avatar">
						<?php if(isset($this->item->url) && $this->item->url){ ?>
						<a target="_blank" href="<?php echo $this->item->url; ?>">
						<?php } ?>
						<img class="d-inline" src="<?php echo Uri::root() . $this->item->client_avatar?>" alt="<?php echo $this->item->title; ?>">
						<?php if(isset($this->item->url) && $this->item->url){ ?>
						</a>
						<?php } ?>
					</div>
			</div> <!-- /.sp-simpleportfolio-client -->
		<?php } // has project client logo or name ?>
		<div class="sp-simpleportfolio-image">
			<?php if($this->item->video) { ?>
				<div class="sp-simpleportfolio-embed">
					<iframe src="<?php echo $video_src; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>
			<?php } else { ?>
				<?php if($this->item->image) { ?>
					<img class="sp-simpleportfolio-img" src="<?php echo $this->item->image; ?>" alt="<?php echo $this->item->title; ?>">
				<?php } else { ?>
					<img class="sp-simpleportfolio-img" src="<?php echo $this->item->thumbnail; ?>" alt="<?php echo $this->item->title; ?>">
				<?php } ?>
			<?php } ?>
		</div>
		<div class="sp-simpleportfolio-tags">
			<?php echo implode(', ', $this->item->tags); ?>
		</div>
		<h2 class="sp-simpleportfolio-title"><?php echo $this->item->title; ?></h2>
	</div>

	<!-- Description -->
	<div class="sp-simpleportfolio-details clearfix">
		<div class="sp-simpleportfolio-description">
			<?php echo HTMLHelper::_('content.prepare', $this->item->description); ?>
		</div>
	</div>
</div>
