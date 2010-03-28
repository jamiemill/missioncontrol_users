# MissionControl Users Plugin

This is a plugin for the [MissionControl CMS](http://github.com/jamiemill/missioncontrol). Whilst it is fairly self-contained it is really designed to be used in that context and probably won't work anywhere else.

## Features

This handles user registration, login/logout, activation etc. Each user has a `Profile` model which can be overridden in each site (by copying `missioncontrol_plugins/users/models/profile.php` to `plugins/users/models/profile.php`) and extended with as many other attributes and associations as necessary for the site.

TODO: Explain different types of site - registration, instant vs approved activation etc.

Copyright (c) 2009-2010 Jamie Mill - jamiermill/a/gmail.com