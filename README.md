# Serve Static
A simple plugin to searve wordpress content as static site

## Development Details 
- Contributors: Mustafa Kamal Hossain
- Tags: Serverless databaseless, nosql, queryless, htmlSite
- Requires at least: 5.5
- Tested up to: 5.9
- Stable tag: 1.0.0
- Multisite Compitable: Yes
- License: GPLv3
- License URI: https://www.gnu.org/licenses/gpl-3.0.html

Migrate content from one live site to another.


## Description 

This plugin specificly build to make a wordpress site static, so that there will be no database and no queries at all. this will help to speed up the site. 

**Installation** 

This process defines you the steps to follow either you are installing through WordPress or Manually from FTP.

**From within WordPress**

1. Visit 'Plugins > Add New'
2. Search for Serve Static
3. Activate Serve Static from your Plugins page.
4. Go to "after activation" below.

**Manually**

1. Upload the `serve-staticr` folder to the `/wp-content/plugins/` directory
2. Activate Serve Static through the 'Plugins' menu in WordPress
3. Go to "after activation" below.

**After activation**

1. Go to the Serve Static settings page.
2. Enable the function from select box.
3. Enter the path where static site will be stored. Make sure the path parent must be under same usere which running the server. (www-data)
4. Enter subfolder name as the site placed. In our case our main WP site is in `bd-admin` folder, where as we are storing content inside `bd` folder and also bd folder is a subfolder of our site. so we will write `bd/bd-admin`. so that while creating the static version of this site our function will replace all links `example.com/bd/bd-admin` to `example.com`. 
5. Enter Local folder name (if any). if you want to store static site from a subfolder yow need to enter subfolder address. But do not use `/` in end. like your site is `example.com` and you want to keep all static content in `bd` subfolder. you need to write `bd` here. but if your site link is `example.com/bd` you do not need to put anything here
6. Enter Local server address. this part is used to replace link with `homeurl` or easy to say the static content site link will be here.
7. Check the post types you want to show in your static site. 
8. Press GET POST TYPES LIST Button.

## Now your settings are complete. 
You can build the site in two ways, one is Ajax calling from backend another is php from server.
* For ajax calling:
1. once you have completed all update and checked in WP site. if you think you are ready to build the site now. click on "Build site" link. 
2. check if all required post types list are exist or not. if you need to update setting please go settings page and fix that again.
3. Once you confirm the settings are ok, click build site button and wait until build is complete and the report is showing `DONE`
4. onece it is done it will be updated to github repo.

* For PHP Build from server:
1. As usual please confirm all changes are done and well reflected on WP site, also the settings are ok from settings page then click on build site and update repo link.
please wait until it shows the report of github repo.

And it is done.

** Upcoming features:
1. add github repo from backend.
2. Create github repo from backend.
3. Create corn job to to done the task.
