<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

$lang = Factory::getLanguage(); ?>

<nav class="pagenavigation">

    <ul class="pager">
        <?php if ($row->prev) :
            $direction = $lang->isRtl() ? 'right' : 'left'; ?>
            <li class="previous">
                <a href="<?php echo Route::_($row->prev); ?>" rel="prev">
                    <span>
                        <?php echo $rows[$location - 1]->title; ?>
                    </span>
                    <span class="icon fas fa-arrow-left"></span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($row->next) :
            $direction = $lang->isRtl() ? 'left' : 'right'; ?>
            <li class="next">
                <a href="<?php echo Route::_($row->next); ?>" rel="next">
                    <span>
                        <?php echo htmlspecialchars($rows[$location + 1]->title); ?>
                    </span>
                    <span class="icon fas fa-arrow-right"></span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>