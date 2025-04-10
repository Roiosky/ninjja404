<?php

/**
 * @package     SP Simple Portfolio
 * @subpackage  mod_spsimpleportfolio
 *
 * @copyright   Copyright (C) 2010 - 2024 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access!');

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\Installer;

class com_spsimpleportfolioInstallerScript
{
    
    public function uninstall($parent)
    {
        $status = new stdClass;
        $status->modules = array();
        $manifest = $parent->getParent()->manifest;
        
        // Uninstall Modules
        $modules = $manifest->xpath('modules/module');
        foreach ($modules as $module)
        {
            $name = (string)$module->attributes()->module;
            $client = (string)$module->attributes()->client;
            
            $db = Factory::getDBO();
            $query = $db->getQuery(true);
            $query->select($db->quoteName('extension_id'));
            $query->from($db->quoteName('#__extensions'));
            $query->where($db->quoteName('type') . ' = ' . $db->quote('module'));
            $query->where($db->quoteName('element') . ' = ' . $db->quote($name));
            $db->setQuery($query);
            $extension_id = $db->loadResult();

            if (!empty($extension_id))
            {
                $installer = new Installer;
                $result = $installer->uninstall('module', $extension_id);
                $status->modules[] = array('name' => $name, 'client' => $client, 'result' => $result);
            }
        }
    }
    
    public function postflight($type, $parent) {

        if ($type == 'uninstall')
        {
            return true;
        }

        $db = Factory::getDbo();
        $src = $parent->getParent()->getPath('source');
        $manifest = $parent->getParent()->manifest;

        // update database
        $columns = $db->getTableColumns('#__spsimpleportfolio_items');
        
        if (!isset($columns['client']))
        {
            try
            {
                $db = Factory::getDbo();
                
                if ($db->getServerType() === 'postgresql') {
                    $queryStr = 'ALTER TABLE "#__spsimpleportfolio_items" ADD COLUMN client VARCHAR(100) NOT NULL';
                } else {
                    $queryStr = "ALTER TABLE `#__spsimpleportfolio_items` ADD `client` varchar(100) NOT NULL AFTER `description`";
                }

                $db->setQuery($queryStr);
                $db->execute();
            }
            catch (Exception $e)
            {
                $parent->getParent()->abort($e->getMessage());
                return false;
            }
        }
        
        // Install Modules
        $modules = $manifest->xpath('modules/module');
        foreach ($modules as $module)
        {
            $name = (string)$module->attributes()->module;
            $client = (string)$module->attributes()->client;
            $path = $src . '/modules/' . $name;
            $position = (isset($module->attributes()->position) && $module->attributes()->position) ? (string)$module->attributes()->position : '';
            $ordering = (isset($module->attributes()->ordering) && $module->attributes()->ordering) ? (string)$module->attributes()->ordering : 0;
            
            $installer = new Installer;
            $result = $installer->install($path);
        }

        $extensions = [
            ['type' => 'plugin', 'name' => 'spsimpleportfolio', 'group' => 'finder'],
        ];

        foreach ($extensions as $key => $extension) {
            $ext       = $parent->getParent()->getPath('source') . '/' . $extension['type'] . 's/' . $extension['group'] . '/' . $extension['name'];
            $installer = new Installer();
            $installer->install($ext);

            if ($extension['type'] === 'plugin') {
                $db    = Factory::getDbo();
                $query = $db->getQuery(true);

                $fields     = [$db->quoteName('enabled') . ' = 1'];
                $conditions = [
                    $db->quoteName('type') . ' = ' . $db->quote($extension['type']),
                    $db->quoteName('element') . ' = ' . $db->quote($extension['name']),
                    $db->quoteName('folder') . ' = ' . $db->quote($extension['group']),
                ];

                $query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
                $db->setQuery($query);
                $db->execute();
            }
        }
    }
}