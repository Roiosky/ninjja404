<?php

/**
 * @package SP Page Builder
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2024 JoomShaper
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
use JoomShaper\SPPageBuilder\DynamicContent\Services\CollectionsService;

$collections = (new CollectionsService)->fetchAll();
$collections = !empty($collections) ? array_reduce($collections, function ($carry, $item) {
    $value = $item->id;
    $text = $item->title;
    $carry[$value] = $text;
    return $carry;
}, []) : [];

SpAddonsConfig::addonConfig([
    'type'       => 'dynamic-content',
    'addon_name' => 'dynamic_content_text',
    'title'      => Text::_('COM_SPPAGEBUILDER_ADDON_COLLECTION_TEXT'),
    'desc'       => Text::_('COM_SPPAGEBUILDER_ADDON_COLLECTION_TEXT_DESC'),
    'category'   => Text::_('COM_EASYSTORE_ADDON_GROUP_DYNAMIC_CONTENT'),
    'icon'       => '<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.611 4.444a2.167 2.167 0 1 0 0 4.334 2.167 2.167 0 0 0 0-4.334ZM3 6.611a3.611 3.611 0 1 1 7.222 0 3.611 3.611 0 0 1-7.222 0ZM25.389 23.222a2.167 2.167 0 1 0 0 4.334 2.167 2.167 0 0 0 0-4.334Zm-3.611 2.167a3.611 3.611 0 1 1 7.222 0 3.611 3.611 0 0 1-7.222 0Z" fill="#6F7CA3"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.778 6.611c0-.399.323-.722.722-.722h14.444c1.197 0 2.167.97 2.167 2.167v10.833a.722.722 0 1 1-1.444 0V8.056a.722.722 0 0 0-.723-.723H9.5a.722.722 0 0 1-.722-.722ZM23.222 25.389a.722.722 0 0 1-.722.722H8.056a2.167 2.167 0 0 1-2.167-2.167V13.111a.722.722 0 1 1 1.444 0v10.833c0 .4.324.723.723.723H22.5c.399 0 .722.323.722.722Z" fill="#6F7CA3"/><path fill-rule="evenodd" clip-rule="evenodd" d="M21.99 16.212a.722.722 0 0 1 1.02 0l2.379 2.378 2.378-2.378a.722.722 0 0 1 1.021 1.02l-2.684 2.686a1.011 1.011 0 0 1-1.43 0l-2.685-2.685a.722.722 0 0 1 0-1.021ZM10.01 15.789a.722.722 0 0 1-1.02 0L6.61 13.41 4.233 15.79a.722.722 0 0 1-1.021-1.022l2.684-2.684a1.011 1.011 0 0 1 1.43 0l2.685 2.684a.722.722 0 0 1 0 1.022ZM16 11.667c.399 0 .722.323.722.722v8.667a.722.722 0 0 1-1.444 0v-8.667c0-.399.323-.722.722-.722Z" fill="#6F7CA3"/><path fill-rule="evenodd" clip-rule="evenodd" d="M21.056 11.667a.722.722 0 0 1-.723.722h-8.666a.722.722 0 1 1 0-1.445h8.666c.4 0 .723.324.723.723Z" fill="currentColor"/></svg>',
    'settings'   => [
        'content' => [
            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_CONTENT'),
            'fields' => [
                'attribute' => [
                    'type'   => 'attribute',
                    'title'  => Text::_('COM_SPPAGEBUILDER_ADDON_COLLECTION_TEXT_FIELD_SOURCE'),
                    'allowed_types' => ['title', 'alias', 'text', 'rich-text', 'phone', 'email', 'number', 'option', 'date-time', 'link', 'created'],
                    'placeholder' => Text::_('COM_SPPAGEBUILDER_ADDON_COLLECTION_TEXT_FIELD_SOURCE_PLACEHOLDER'),
                ],
                'default_text' => [
                    'type' => 'text',
                    'title' => Text::_('COM_SPPAGEBUILDER_ADDON_COLLECTION_TEXT_FIELD_FALLBACK_TEXT'),
                    'desc' => Text::_('COM_SPPAGEBUILDER_ADDON_COLLECTION_TEXT_FIELD_FALLBACK_TEXT_DESC'),
                    'placeholder' => Text::_('COM_SPPAGEBUILDER_ADDON_COLLECTION_TEXT_FIELD_FALLBACK_TEXT_PLACEHOLDER'),
                    'std' => '',
                ]
            ],
        ],
        'link' => [
            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
            'fields' => [
                'link' => [
                    'type'  => 'link',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
                    'default_tab' => 'page',
                ],
            ],
        ],
        'general' => [
            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_GENERAL'),
            'fields' => [
                'color' => [
                    'type'  => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                ],
                'typography' => [
                    'type'  => 'typography',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_TYPOGRAPHY'),
                ],
                'selector' => [
                    'type'  => 'headings',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_HTML_ELEMENT'),
                    'std'   => 'p',
                ],
                'alignment' => [
                    'type'              => 'alignment',
                    'title'             => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALIGNMENT'),
                    'responsive'        => true,
                    'available_options' => ['left', 'center', 'right'],
                ],
                'alignment_separator' => [
                    'type' => 'separator',
                ],
                'title_text_shadow' => [
                    'type'   => 'boxshadow',
                    'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_TEXT_SHADOW'),
                    'std'    => '0 0 0 transparent',
                    'config' => ['spread' => false],
                ],
            ],
        ],
        'icon' => [
            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON'),
            'fields' => [
                'icon' => [
                    'type'  => 'icon',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ICON'),
                ],
                'icon_position' => [
                    'type' => 'select',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
                    'values' => [
                        'left' => Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                        'right' => Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                    ],
                    'std' => 'left',
                ],
                'icon_gap' => [
                    'type' => 'text',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_GAP'),
                    'std' => '8px',
                ],
                'icon_color' => [
                    'type' => 'color',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                ],
                'icon_size' => [
                    'type' => 'text',
                    'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_SIZE'),
                    'std' => '16px',
                ],
            ],
        ],
        'title_spacing' => [
            'title'  => Text::_('COM_SPPAGEBUILDER_GLOBAL_TITLE_SPACING'),
            'fields' => [
                'title_margin' => [
                    'type'       => 'margin',
                    'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN'),
                    'desc'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_DESC'),
                    'std'        => ['xl' => '0px 0px 0px 0px', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
                    'responsive' => true,
                ],

                'title_padding' => [
                    'type'       => 'padding',
                    'title'      => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                    'desc'       => Text::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
                    'std'        => ['xl' => '0px 0px 0px 0px', 'lg' => '', 'md' => '', 'sm' => '', 'xs' => ''],
                    'responsive' => true,
                ],
            ],
        ],
    ],
]);

