# SystemSettingsOverride: Override MODX system settings from the file system

A free extra for MODX 2.7+ brought to you by [Maple](https://www.mapledesign.co.uk/modx/), the UK's leading MODX experts.

# Why?
When developing a MODX site locally and deploying to production and staging environments, you often need different system settings for each environment. For example when you want to override SMTP details, point to a different Elasticsearch server, or to change the error_reporting level.

# How does this extra work?
This extra allows you to override system settings from the file system. It does this by checking for a file called `.system_settings.ini` in the MODX `core/config` directory. If this file exists, it will be parsed and the system settings with the same keys will be overridden.

# Security
Your `.system_settings.ini` file is a security risk. It contains sensitive information that should not be publicly accessible. You should ensure that your web server is configured to prevent access to this file.

### Apache
Block access to all files and directories beginning with `.` except for those needed by Certbot using this snippet below:

```apacheconf
<Directory ~ "/\.(?!well-known\/)">
    Require all denied
</Directory>
```

### Nginx
If you know please open a PR to add this.

### Move the file out of the web root
If you have more control of your server, you can put this file outside the web root. Add a MODX system setting (yes a real one, added via the MODX Manager) called `system_settings_override.file_path` and set the value to the absolute path to your `.system_settings.ini` file. This will allow you to keep your `.system_settings.ini` file outside the web root.

Unfortunately if you do this you will need to keep the override file at the same path on your dev, staging and production servers. If you do not, you will need to manually update the MODX system setting on each server.

# Limitations
This plugin hooks into the earliest MODX lifecycle events it can. This means that it cannot override settings accessed before the `OnMODXInit` event. This includes settings accessed in the `core/config/config.inc.php` file.

# Frequently Asked Questions

### Why did you build this?
5 years ago I wrote an extra called [modx-dotenv](https://github.com/pbowyer/modx-dotenv/tree/master) that did something similar. It didn't integrate as deeply into MODX as it could have. This extra is a rewrite of that extra. It is much more robust and integrates much more deeply into MODX.

[Others](https://community.modx.com/t/environmental-variables/4057) have asked for this feature in the past. I hope this extra helps.

### Why doesn't the extra work with MODX 3?
It's because of funding. I write what my clients need. If you need this extra for MODX 3, please [get in touch](https://www.mapledesign.co.uk/contact/) to sponsor development.
