# WordPress DB Cleaner #

A very simple plugin that lets you clean up tables left over from previous deleted sites on a multisite installation. 
While WordPress will delete the tables it creates for a new site, tables created by plugins will remain.

This plugin adds a page under tools. In the textfield on this page, a list of site IDs can be given. The plugin will go through and delete all the tables that contain that ID.

Multiple IDs can be given my comma seperating them.

# License # 

MIT License. A copy can be found in the root of this repository.
