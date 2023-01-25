# SystemSettingsOverride v2: Override MODX system settings from the file system

A free extra for MODX 2 and MODX 3 brought to you by [Maple](https://www.mapledesign.co.uk/modx/), the UK's leading MODX experts.

# Why?
When developing a MODX site locally and deploying to production and staging environments, you often need different system settings for each environment. For example to
* override SMTP details
* point to a different Elasticsearch server
* change the error_reporting level.

# How does this extra work?
This extra allows you to override system settings from the file system. It does this by checking for a file called `.system_settings.ini` in the MODX `core/config` directory. If this file exists, it will be parsed and the system settings with the same keys will be overridden.

# Limitations
This plugin hooks into the earliest MODX lifecycle events it can. This means that it cannot override settings accessed before the `OnMODXInit` event. This includes settings accessed in the `core/config/config.inc.php` file.

# Installation instructions
This plugin requires PHP 7.4+ and is tested with PHP 8.1+.

### Step 1: create the plugin

1. Create a new Plugin in the MODX Manager
2. Name the plugin SystemSettingsOverride
3. Copy the contents of [`plugin.php`](plugin.php) into the plugin
4. Set the plugin to run on the following events:
     * `OnMODXInit`
     * `OnHandleRequest`
     * `pdoToolsOnFenomInit` (optional)
5. Save the plugin

### Step 2: create the system settings

Create a new file at `core/config/system_settings.php` containing the following:

```php
<?php

return [
    'sample_setting_key' => 'setting_value',
    'sample_setting_key2' => 'setting_value',
];
```

Congratulations, you have added your first MODX system_settings! :tada:

This file should contain system settings that work for all environments.

#### Environment specific settings
For system setting overrides specific to one environment (`dev`, `staging`, `production`), create a file called `system_settings.local.php` in the `core/config` directory. This file should contain the same PHP structure as `system_settings.php` but you only need to include the settings that you want to override.

Example:

```php
<?php

return [
    'sample_setting_key' => 'my_dev_environment_value',
];
```

### Step 3: Exclude `system_settings.local.php` from Git

If you use Git, you need to exclude the local settings from being committed, or they will affect all deployments. Open your `.gitignore` file and add the following line:

    /core/config/system_settings.local.php

# Frequently Asked Questions

### Why did you build this?
5 years ago I wrote an extra called [modx-dotenv](https://github.com/pbowyer/modx-dotenv/tree/master) that did something similar. It didn't integrate as deeply into MODX as it could have. This extra is a rewrite of that extra. It is much more robust and integrates much more deeply into MODX.

[Others](https://community.modx.com/t/environmental-variables/4057) have asked for this feature in the past. I hope this extra helps.

### Why doesn't the extra work with MODX 3?
Edit: Apparently it does work with MODX3. However I'm not testing it on MODX3 at present.

Original answer: It's because of funding. I write what my clients need. If you need this extra for MODX 3, please [get in touch](https://www.mapledesign.co.uk/contact/) to sponsor development.
