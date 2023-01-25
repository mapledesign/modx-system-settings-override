<?php
declare(strict_types=1);

/**
 * SystemSettingsOverride v2.0.0
 *
 * This plugin is based on ClientConfig by Mark Hamstra
 * https://github.com/modmore/ClientConfig/blob/master/core/components/clientconfig/elements/plugins/clientconfig.plugin.php
 *
 * Thank you Mark for the code you've released!
 *
 * SystemSettingsOverride is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * SystemSettingsOverride is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SystemSettingsOverride; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

$eventName = $modx->event->name;

switch ($eventName) {
    case 'OnMODXInit':
    case 'OnHandleRequest':
    case 'pdoToolsOnFenomInit':
        $settings = [];

        $file = MODX_CORE_PATH . 'config/system_settings.php';
        if (file_exists($file)) {
            $settings = require $file;
        } else {
            $modx->log(modX::LOG_LEVEL_DEBUG, 'SystemSettingsOverride: File ' . $file . ' does not exist.');
        }

        $file = MODX_CORE_PATH . 'config/system_settings.local.php';
        if (file_exists($file)) {
            $settings = array_merge($settings, require $file);
        } else {
            $modx->log(modX::LOG_LEVEL_DEBUG, 'SystemSettingsOverride: File ' . $file . ' does not exist.');
        }

        if (count($settings) === 0) {
            return;
        }

        /* Make settings available as [[++tags]] */
        $modx->setPlaceholders($settings, '+');

        /* Make settings available as $modx->config['tags'] */
        foreach ($settings as $key => $value) {
            if ($oldValue = $modx->getOption($key)) {
                $modx->log(modX::LOG_LEVEL_DEBUG, "Overriding system setting {$key} with value '{$value}' (previously '{$oldValue}')");
            }
            $modx->setOption($key, $value);
        }

        break;
}

return;
