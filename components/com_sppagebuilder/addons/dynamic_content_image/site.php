<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2025 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;
use JoomShaper\SPPageBuilder\DynamicContent\Site\CollectionHelper;

class SppagebuilderAddonDynamic_content_image extends SppagebuilderAddons
{
    public function render()
    {   
        $settings = $this->addon->settings;
        $class = $settings->class ?? '';

        if (empty($settings->attribute)) {
            return '';
        }

        if (empty($settings->dynamic_item)) {
            $settings->dynamic_item = CollectionHelper::getDetailPageData();
        }

        if (is_object($settings->dynamic_item)) {
            $settings->dynamic_item = json_decode(json_encode($settings->dynamic_item), true);
        }

        if (empty($settings->dynamic_item)) {
            return 'No data!';
        }

        $src = CollectionHelper::getDynamicContentData($settings->attribute, $settings->dynamic_item) ?? '';
        $aspectRatio = $settings->aspect_ratio ?? '';

        if ($aspectRatio === 'custom') {
            $aspectRatio = $settings->custom_aspect_ratio ?? '';
        }

        if ($aspectRatio === 'none') {
            $aspectRatio = '';
        }

        $imageFit = $settings->image_fit ?? 'cover';

        $variables = [
            '--sppb-dc-image-fit' => $imageFit,
            '--sppb-dc-aspect-ratio' => $aspectRatio,
        ];
        $cssVariables = '';

        foreach ($variables as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $cssVariables .= $key . ': ' . $value . '; ';
        }

        $linkAttributes = [
            'href' => '',
            'target' => '',
            'rel' => '',
            'has_link' => false,
        ];
        $link = $settings->link ?? null;
        $hasLink = false;

        if (!empty($link)) {
            $linkOptions = [
                'url' => CollectionHelper::createDynamicContentLink($link, CollectionHelper::prepareItemForLink($settings->dynamic_item, $settings->attribute)),
                'target' => $link->new_tab ? '_blank' : null,
                'nofollow' => $link->nofollow ?? null,
                'noreferrer' => $link->noreferrer ?? null,
                'noopener' => $link->noopener ?? null,
            ];
            $linkAttributes = CollectionHelper::generateLinkAttributes($linkOptions);
        }

        $wrapperSelector = 'div';
        $attributes = '';
        $hasLink = $linkAttributes['has_link'] ?? false;

        if ($hasLink) {
            $wrapperSelector = 'a';
            $attributes .= 'href="' . $linkAttributes['href'] . '"';
            $attributes .= $linkAttributes['target'] ? ' target="' . $linkAttributes['target'] . '"' : '';
            $attributes .= $linkAttributes['rel'] ? ' rel="' . $linkAttributes['rel'] . '"' : '';
        }

        if (strpos($src, 'http') === false) {
            $src = Uri::root(true) . '/' . $src;
        }

        $output = '<' . $wrapperSelector . ' class="sppb-dynamic-content-image-wrapper ' . $class . '" style="' . $cssVariables . '" ' . $attributes . '>';
        $output .= '<img src="' . $src . '" alt="Dynamic Content Image" class="sppb-dynamic-content-image" style="object-fit: ' . $imageFit . '; aspect-ratio: ' . $aspectRatio . ';" />';
        $output .= '</' . $wrapperSelector . '>';

        return $output;
    }

    public function css()
    {
        $css = '';

        $addon_id   = '#sppb-addon-' . $this->addon->id;
        $settings   = $this->addon->settings;
        $cssHelper  = new CSSHelper($addon_id);

        $isEffectsEnabled = (isset($settings->is_effects_enabled) && $settings->is_effects_enabled) ? $settings->is_effects_enabled : 0;

        if ($isEffectsEnabled) {
            $settings->image_effects = $cssHelper::parseCssEffects($settings, 'image_effects');
        }

        $imageEffectStyle = $cssHelper->generateStyle(
            '.sppb-dynamic-content-image-wrapper .sppb-dynamic-content-image',
            $settings,
            ['image_effects' => 'filter'],
            false
        );

        $transformCss = $cssHelper->generateTransformStyle(
            '.sppb-dynamic-content-image-wrapper',
            $settings,
            'transform'
        );

        $imageBorderRadius = $cssHelper->generateStyle(
            '.sppb-dynamic-content-image-wrapper',
            $settings,
            ['radius' => 'border-radius'],
            ['border_radius' => false],
            ['border_radius' => 'spacing']
        );

        $imageBorderStyle = $cssHelper->border('.sppb-dynamic-content-image-wrapper', $settings, 'border');

        $imageWrapperStyle = $cssHelper->generateStyle(
            '.sppb-dynamic-content-image-wrapper',
            $settings,
            ['width' => 'width', 'height' => 'height'],
            'px'
        );

        $imageMarginPaddingStyle = $cssHelper->generateStyle(
            '.sppb-dynamic-content-image-wrapper',
            $settings,
            ['margin' => 'margin', 'padding' => 'padding'],
            false
        );

        $staticStyles = $cssHelper->generateStyle(
            '.sppb-dynamic-content-image-wrapper', $settings, [], '', [], [], false,
            'width: 100%; overflow: hidden; aspect-ratio: var(--sppb-dc-aspect-ratio);'
        );
        $staticImageStyles = $cssHelper->generateStyle(
            '.sppb-dynamic-content-image-wrapper .sppb-dynamic-content-image', $settings, [], '', [], [], false,
            'width: 100%; height: 100%; object-fit: var(--sppb-dc-image-fit);'
        );

        $css .= $staticStyles;
        $css .= $staticImageStyles;
        $css .= $imageWrapperStyle;
        $css .= $imageBorderStyle;
        $css .= $imageBorderRadius;
        $css .= $imageEffectStyle;
        $css .= $transformCss;
        $css .= $imageMarginPaddingStyle;

        return $css;
    }

    public static function getTemplate() {
		$lodash = new Lodash('#sppb-addon-{{ data.id }}');
		$output  = '<style type="text/css">';

		$output .= $lodash->generateTransformCss('', 'data.transform');

		$output .= '</style>';

		return $output;
	}
}
