<?php

/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2019 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined('_JEXEC') or die('Restricted access');

class SppagebuilderAddonStartuplanding_rating extends SppagebuilderAddons {

    public function render() {
        $settings = $this->addon->settings;
        $class = (isset($settings->class) && $settings->class) ? ' ' . $settings->class : '';
        $class .= (isset($settings->alignment) && $settings->alignment) ? ' ' . $settings->alignment : ' sppb-text-center';
        $title = (isset($settings->title) && $settings->title) ? $settings->title : '';
        $heading_selector = (isset($settings->heading_selector) && $settings->heading_selector) ? $settings->heading_selector : 'h2';
        $use_link = (isset($settings->use_link) && $settings->use_link) ? $settings->use_link : false;
        $title_link = ($use_link) ? ((isset($settings->title_link) && $settings->title_link) ? $settings->title_link : '') : false;
        $link_target = (isset($settings->link_new_tab) && $settings->link_new_tab) ? 'rel="noopener noreferrer" target="_blank"' : '';
        $title_icon = (isset($settings->title_icon) && $settings->title_icon) ? $settings->title_icon : '';
        $title_icon_position = (isset($settings->title_icon_position) && $settings->title_icon_position) ? $settings->title_icon_position : 'before';
        $title_icon_color = (isset($settings->title_icon_color) && $settings->title_icon_color) ? $settings->title_icon_color : '';
        $client_rating = (isset($settings->client_rating) && $settings->client_rating) ? $settings->client_rating : 4.5;
        $inline_layout = (isset($settings->inline_layout) && $settings->inline_layout) ? $settings->inline_layout : 0;

        $inline_layout_active = '';
        if($inline_layout){
            $inline_layout_active = 'inline-layout';
        }

        $output = '';
        if($title) {
            $output .= '<div class="sppb-addon sppb-addon-header sl-addon-rating' . ' ' . $inline_layout_active . ' ' . $class . '">';
            if((isset($settings->rating_score) && $settings->rating_score) || (isset($settings->inline_layout) && $settings->inline_layout)){
            $output .= '<div class="d-flex align-items-center">';
            }
            if((isset($settings->rating_score) && $settings->rating_score) && !$settings->rating_score_position){
            $output .= '<div class="rating-counter">' . $client_rating . '</div>';
            }
            $output .= '<div class="sl-addon-rating-title-wrapper">';
            $output .= '<div class="sppb-testimonial-carousel-client-rating"><span class="sppb-testimonial-carousel-rating"></span></div>';
            if((isset($settings->rating_score) && $settings->rating_score) && $settings->rating_score_position && $settings->inline_layout){
            $output .= '<div class="rating-counter">' . $client_rating . '</div>';
            }
            $output .= ($title_link) ? '<a '. $link_target .' href="'. $title_link .'">' : '';
            $output .= '<'.$heading_selector.' class="sppb-addon-title">';
            if($title_icon && $title_icon_position == 'before') {
                $output .= '<span class="fa '. $title_icon . ' sppb-addon-title-icon" aria-hidden="true"></span> ';
            }
            $output .= nl2br($title);
            if($title_icon && $title_icon_position == 'after') {
                $output .= ' <span class="fa '. $title_icon . ' sppb-addon-title-icon" aria-hidden="true"></span>';
            }
            $output .= '</'.$heading_selector.'>';
            $output .= ($title_link) ? '</a>' : '';
            $output .= '</div>';
            if((isset($settings->rating_score) && $settings->rating_score) && $settings->rating_score_position && !$settings->inline_layout){
            $output .= '<div class="rating-counter">' . $client_rating . '</div>';
            }
            if((isset($settings->rating_score) && $settings->rating_score) || (isset($settings->inline_layout) && $settings->inline_layout)){
            $output .= '</div>';
            }
            $output .= '</div>';
        }

        return $output;
    }

    public function css() {
        $addon_id = '#sppb-addon-' . $this->addon->id;
        $settings = $this->addon->settings;

        $style = '';
        $style_sm = '';
        $style_xs = '';

        $style .= (isset($settings->title_margin) && trim($settings->title_margin)) ? 'margin: ' . $settings->title_margin  . '; ' : '';
        $style .= (isset($settings->title_text_transform) && trim($settings->title_text_transform)) ? 'text-transform: ' . $settings->title_text_transform  . '; ' : '';
        $style_sm .= (isset($settings->title_margin_sm) && trim($settings->title_margin_sm)) ? 'margin: ' . $settings->title_margin_sm  . '; ' : '';
        $style_xs .= (isset($settings->title_margin_xs) && trim($settings->title_margin_xs)) ? 'margin: ' . $settings->title_margin_xs  . '; ' : '';

        $style .= (isset($settings->title_padding) && trim($settings->title_padding)) ? 'padding: ' . $settings->title_padding  . '; ' : '';
        $style_sm .= (isset($settings->title_padding_sm) && trim($settings->title_padding_sm)) ? 'padding: ' . $settings->title_padding_sm  . '; ' : '';
        $style_xs .= (isset($settings->title_padding_xs) && trim($settings->title_padding_xs)) ? 'padding: ' . $settings->title_padding_xs  . '; ' : '';
        
        $rating_score = (isset($settings->rating_score_font_size) && trim($settings->rating_score_font_size)) ? 'font-size: ' . $settings->rating_score_font_size  . 'px; ' : '';
        $rating_score_sm = (isset($settings->rating_score_font_size_sm) && trim($settings->rating_score_font_size_sm)) ? 'font-size: ' . $settings->rating_score_font_size_sm  . 'px; ' : '';
        $rating_score_xs = (isset($settings->rating_score_font_size_xs) && trim($settings->rating_score_font_size_xs)) ? 'font-size: ' . $settings->rating_score_font_size_xs  . 'px; ' : '';

        $heading_selector = (isset($settings->heading_selector) && $settings->heading_selector) ? $settings->heading_selector : 'h2';

        $title_icon = (isset($settings->title_icon) && $settings->title_icon) ? $settings->title_icon : '';
        $title_icon_color = (isset($settings->title_icon_color) && $settings->title_icon_color) ? $settings->title_icon_color : '';

        if(isset($settings->title_text_shadow) && is_object($settings->title_text_shadow)){
            $ho = (isset($settings->title_text_shadow->ho) && $settings->title_text_shadow->ho != '') ? $settings->title_text_shadow->ho.'px' : '0px';
            $vo = (isset($settings->title_text_shadow->vo) && $settings->title_text_shadow->vo != '') ? $settings->title_text_shadow->vo.'px' : '0px';
            $blur = (isset($settings->title_text_shadow->blur) && $settings->title_text_shadow->blur != '') ? $settings->title_text_shadow->blur.'px' : '0px';
            $color = (isset($settings->title_text_shadow->color) && $settings->title_text_shadow->color != '') ? $settings->title_text_shadow->color : '';

            if(!empty($color)){
                $style .= "text-shadow: {$ho} {$vo} {$blur} {$color};";
            }
        }
        $css = '';
        if($rating_score){
            $css .= $addon_id . ' .rating-counter{ ' . $rating_score . ' }';
        }
        if ($style) {
            $css .= $addon_id . ' ' . $heading_selector . '.sppb-addon-title {' . $style . '}';
        }

        if($title_icon && $title_icon_color) {
            $css .= $addon_id . ' ' . $heading_selector . '.sppb-addon-title .sppb-addon-title-icon {color: ' . $title_icon_color . '}';
        }

        if ($style_sm) {
            $css .= '@media (min-width: 768px) and (max-width: 991px) {';
                $css .= $addon_id . ' ' . $heading_selector . '.sppb-addon-title {' . $style_sm . '}';
            $css .= '}';
        }

        if ($style_xs) {
            $css .= '@media (max-width: 767px) {';
                $css .= $addon_id . ' ' . $heading_selector . '.sppb-addon-title {' . $style_xs . '}';
            $css .= '}';
        }
        if ($rating_score_sm) {
            $css .= '@media (min-width: 768px) and (max-width: 991px) {';
                $css .= $addon_id . ' .rating-counter{ ' . $rating_score_sm . ' }';
            $css .= '}';
        }

        if ($rating_score_xs) {
            $css .= '@media (max-width: 767px) {';
                $css .= $addon_id . ' .rating-counter{ ' . $rating_score_xs . ' }';
            $css .= '}';
        }
        
        $css .= $addon_id .  ' .sppb-testimonial-carousel-rating:before {';
        $css .= 'width:'.((20 * $settings->client_rating)-5).'%';
        $css .='}';
        return $css;
    }

    public static function getTemplate() {
        $output = '
        <#
            var inline_layout_active = "";
            if(data.inline_layout){
                inline_layout_active = "inline-layout";
            }

            var link_target = (data.link_new_tab) ? \'target="_blank"\' : "" ;

            var margin = "";
			var margin_sm = "";
			var margin_xs = "";
			if(data.title_margin){
				if(_.isObject(data.title_margin)){
                    if(data.title_margin.md.trim() != ""){
                        margin = data.title_margin.md.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
                    if(data.title_margin.sm.trim() != ""){
                        margin_sm = data.title_margin.sm.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
                    if(data.title_margin.xs.trim() != ""){
                        margin_xs = data.title_margin.xs.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
				} else {
                    if(data.title_margin.trim() != ""){
                        margin = data.title_margin.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
				}

			}

            var rating_font = "";
			var rating_font_sm = "";
			var rating_font_xs = "";
			if(data.rating_score_font_size){
				if(_.isObject(data.rating_score_font_size)){
                    if(data.rating_score_font_size.md.trim() != ""){
                        rating_font = data.rating_score_font_size.md.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
                    if(data.rating_score_font_size.sm.trim() != ""){
                        rating_font_sm = data.rating_score_font_size.sm.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
                    if(data.rating_score_font_size.xs.trim() != ""){
                        rating_font_xs = data.rating_score_font_size.xs.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
				} else {
                    if(data.rating_score_font_size.trim() != ""){
                        rating_font_size = data.rating_score_font_size.split(" ").map(item => {
                            if(_.isEmpty(item)){
                                return "0";
                            }
                            return item;
                        }).join(" ")
                    }
				}

			}

			var padding = "";
			var padding_sm = "";
			var padding_xs = "";
			if(data.title_padding){
				if(_.isObject(data.title_padding)){
					if(data.title_padding.md.trim() !== ""){
						padding = data.title_padding.md.split(" ").map(item => {
							if(_.isEmpty(item)){
								return "0";
							}
							return item;
						}).join(" ")
					}

					if(data.title_padding.sm.trim() !== ""){
						padding_sm = data.title_padding.sm.split(" ").map(item => {
							if(_.isEmpty(item)){
								return "0";
							}
							return item;
						}).join(" ")
					}

					if(data.title_padding.xs.trim() !== ""){
						padding_xs = data.title_padding.xs.split(" ").map(item => {
							if(_.isEmpty(item)){
								return "0";
							}
							return item;
						}).join(" ")
					}
				} else {
					padding = data.title_padding.split(" ").map(item => {
						if(_.isEmpty(item)){
							return "0";
						}
						return item;
					}).join(" ")
				}

            }
            
            var titleTextShadow = "";
			if(_.isObject(data.title_text_shadow)){
				let ho = data.title_text_shadow.ho || 0,
					vo = data.title_text_shadow.vo || 0,
					blur = data.title_text_shadow.blur || 0,
					color = data.title_text_shadow.color || 0;

                titleTextShadow = ho+\'px \'+vo+\'px \'+blur+\'px \'+color;
			}
        #>
        <style type="text/css">
            #sppb-addon-{{ data.id }} {{ data.heading_selector }}.sppb-addon-title{
                margin: {{ margin }};
                padding: {{ padding }};
                text-shadow: {{ titleTextShadow }};
                text-transform: {{ data.title_text_transform }};
            }
            #sppb-addon-{{ data.id }} .rating-counter{
                font-size: {{ rating_font }}px;
            }

            <# if(data.title_icon && data.title_icon_color) { #>
                #sppb-addon-{{ data.id }} {{ data.heading_selector }}.sppb-addon-title .sppb-addon-title-icon {
                    color: {{ data.title_icon_color }}
                }
            <# } #>
            #sppb-addon-{{ data.id }} .sppb-testimonial-carousel-rating:before {
                width:{{((20 * data.client_rating)-5)}}%;
            }
            @media (min-width: 768px) and (max-width: 991px) {
                #sppb-addon-{{ data.id }} {{ data.heading_selector }}.sppb-addon-title{
                    margin: {{ margin_sm }};
                    padding: {{ padding_sm }};
                }
                #sppb-addon-{{ data.id }} .rating-counter{
                    font-size: {{ rating_font_sm }}px;
                }
            }
            @media (max-width: 767px) {
                #sppb-addon-{{ data.id }} {{ data.heading_selector }}.sppb-addon-title{
                    margin: {{ margin_xs }};
                    padding: {{ padding_xs }};
                }
                #sppb-addon-{{ data.id }} .rating-counter{
                    font-size: {{ rating_font_xs }}px;
                }
            }
        </style>
        
        <div class="sppb-addon sppb-addon-header sl-addon-rating {{inline_layout_active}} {{data.class}}  {{ data.alignment }}">
        <# if(data.rating_score || data.inline_layout){ #>
        <div class="d-flex align-items-center">
        <# }
        if(data.rating_score && !data.rating_score_position){ #>
        <div class="rating-counter">{{data.client_rating}}</div>
        <# } #>
        <div class="sl-addon-rating-title-wrapper">
        <div class="sppb-testimonial-carousel-client-rating"><span class="sppb-testimonial-carousel-rating"></span></div>
        <# if(data.rating_score && data.rating_score_position && data.inline_layout){ #>
        <div class="rating-counter">{{data.client_rating}}</div>
        <# } #>
        <#
        let heading_selector = data.heading_selector || "h2";
        if(data.use_link && data.title_link){ #><a {{ link_target }} href=\'{{ data.title_link }}\'><# }
        #>
        <{{ heading_selector }} class="sppb-addon-title">
            <# if(data.title_icon && data.title_icon_position == "before"){ #><span class="fa {{ data.title_icon }} sppb-addon-title-icon"></span> <# } #>
            <span class="sp-inline-editable-element" data-id={{data.id}} data-fieldName="title" contenteditable="true">{{{ data.title }}}</span>
            <# if(data.title_icon && data.title_icon_position == "after"){ #> <span class="fa {{ data.title_icon }} sppb-addon-title-icon"></span><# } #>
            </{{ heading_selector }}>
        <# if(data.use_link && data.title_link){ #></a><# } #>
        </div>
        <# if(data.rating_score && data.rating_score_position && !data.inline_layout){ #>
        <div class="rating-counter">{{data.client_rating}}</div>
        <# } 
        if(data.rating_score || data.inline_layout && data.inline_layout){ #>
        </div>
        <# } #>
        </div>
        ';

        return $output;
    }
}
