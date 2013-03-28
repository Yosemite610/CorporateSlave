0.95
Description:
Here is a newsletter-style 2-column with sidebar theme for WordPress which allows some control over which categories are displayed in each column as well as a Top Post functionality for a full-width 'featured' post. I included the WordPress Theme Toolkit by Ozh for user-friendliness. This theme is a modified version of Corporate Slave, by dreamLogic .

For style and functionality I have included some plugins: HotDates by Supriyadi Slamet Widodo, Sociable by Peter Harkins, Get Recent Comments by Krischan Jodies, Live Comment Preview by Jeff Minard and Iacovos Constantinou, Optimal Title by Aaron Schaefer and Related Posts by By Alexander Malov & Mike Lu. Some of these are incorporated into the theme, others included in this zip.

The plugins above should be installed for this theme to function as intended. If you don't want to use any of the plugins, that's alright, just verify everything is working ok. All the plugin calls in the theme use a if_exists, so if it's not there, it doesn't get called.

Changes 8/8/2007:
Incorporated some plugins into functions.php for convenience: Optimal Title, Hot Dates, Email Immunizer and a tweaked version of Advanced WYSIWIG Editor, and removed 'sociable'. Added the Top Post functionality (for a full-width 'featured' post). Top Post takes the latest post in a category (category set in the themes options under Presentation), displays it at the top (full-width) and makes sure it is not repeated in either column below.

Instructions for installation and configuration:

   1. Download the latest version from here: http://www.samdevol.com/wordpress-theme-corporate-slave/

   2. Open up the .zip file.

   3. Drop/copy the plugins folder and themes folder to your site’s wp-content/ directory.

   4. Activate the newly installed plugins.

   5. Go into your sites Admin area, go to Presentation:Themes and select Corporate Slave.

   6. Go directly to Presentation:Corporate Slave Options and enter the category numbers you want to appear in each column.

   7. Click on the Store Options button and you should be set!

To adjust the space at the top of the sidebar, look in style.css for:
#sidebar{overflow:hidden;float:right;border-right:#CCC 1px solid;text-align:right;margin-top:31px;width:175px;margin-right:-1px;margin-left:-30%;}

and change the top-margin: setting.

A note about category numbers and selection: This theme uses the query_posts() function using ONLY the ‘cat=’ Category Parameter, e.g.; you could enter anything like:
12
7
7,12
-3
12,7,-3
etc., etc. Although you can have multiple positive numbers, you can only have one negative (I don't know why, it's a query_posts limitation).
