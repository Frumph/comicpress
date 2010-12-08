ComicPress 2.9*
based on ComicPress by Tyler Martin, developed by Philip M. Hofer (Frumph)
Contact Email: philip@frumph.net

ComicPress 2.9* is released under GNU General Public License, v3 (or newer)
Information on the GNU General Public License can be found here: http://www.opensource.org/licenses/gpl-3.0.html

ComicPress 2.9 is a 'parent' theme now. Which means that there are specifics to installing the theme with wordpress now. Read about what this is, here. http://frumph.net/wordpress/comicpress-2-9-parent-child-theme-relationship/

Unlike previous versions of the theme ComicPress 2.9 requires that the theme be installed into the wp-content/themes/comicpress directory. That means the themes index.php file would be here: /wp-content/themes/comicpress/index.php

Also, previous versions of ComicPress that have the same name in the style.css THEME NAME: ComicPress will cause a conflict. Make sure that whatever old versions you are using are removed from your themes directory.


Requirements

   1. Wordpress
   2. MySQL database connection
   3. PHP 5
   4. Proper access for wordpress to write read/write files to your installation. 

Installation Instructions

   1. Install WordPress from http://wordpress.org/ follow their tutorials.
   2. Install ComicPress 2.9 into a directory called "comicpress" in lowercase in your theme directory. Do not install it in a directory UNDER comicpress, install it INTO that directory. Copy the files from the zip file with your ftp program into /wp-content/themes/comicpress
   3. Install ComicPress Manager into the /wp-content/plugins/ or use the plugins -> add new option in the dashboard.
   4. Install Theme Companion into /wp-content/plugins/ or use the plugins -> add new option in the dashboard.
   5. In your wordpress dashboard administration area, /wp-admin/ go to Appearance -> Themes and select the ComicPress 2.9 theme or associated child theme that you installed.
   6. In your wordpress dashboard administration go to Post -> Categories and add 2 categories, add "Comic" and "Blog", so you will have 3 categories, Comic, Blog and Uncategorized categories.
   7. Go to Plugins -> Installed, you should see a list of your plug-ins including ComicPress Manager and Theme Companion, activate them then click on the Dashboard link on the left.
   8. Go to ComicPress Manager plugin area called "ComicPress" on your dashboard. Dashboard -> ComicPress (not to be confused with comicpress options in the appearance area) and click on the "Manager Config" link, so Dashboard -> ComicPress -> Manager Config. Inside the Manager config click the first run -> "Make Directories" link that comes up. This will create your comic comic-rss and comic-archive folders.
   9. Go to Dashboard -> ComicPress -> ComicPress Config and set your blog category, comic category and make sure the directories are set correctly for your comics. Manager config probably sent you here already.
  10. Go to Dashboard -> Appearance -> ComicPress Options and select the theme style you want to use and click save. Go through all the different tabs and get overwhelmed by all the options.
  11. Go to Dashboard -> ComicPress -> Upload, upload your first comic. Remember the file names need to be in this format YYYY-MM-DD-title-of-comic.ext ext = jpg png gif swf example: 2009-08-26-I-have-been-assimilated.jpg is perfectly valid for a file name, do NOT use any non alpha characters like $#!+@%^&*(){}[] just letters, numbers and dashes. Also if your setting a title, do NOT use a number as the title. 2009-08-26-1.jpg <-- Will cause problems, do not use numbers only.
  12. Go to to your site, see the results. Rinse - repeat step 11 as often as necessary. 


WPMU / Multisite Installation

   1. Same as above except add the following:
   2. Inside the theme is a "wpmu" DIRECTORY inside that directory is the file comicpress_manager_wpmu.php copy that file to the /wp-content/mu-plugins/ directory. 
   2a. this file is not needed anymore with the new versions of CPM and Multisite.


Additional Note

The 'core' theme ComicPress 2.9 is as we said a 'parent' theme. That means when you install ComicPress 2.9 you receive the basic minimal css version of ComicPress. Silver theme from ComicPress 2.8 is now a child theme available as a separate download.

ComicPress 2.9 also has available in the download are the ComicPress Silver and ComicPress Boxed child themes. Both of these basic child themes are installed like regular themes into your wp-content/themes directories on your wordpress installs.

When making changes to ComicPress for your look and feel that you want we HIGHLY recommend that you do it with theme companion or a child theme - using the boxed or silver themes as a reference on how to achieve this and NOT editing the original wp-content/themes/comicpress code. This way you can update comicpress without losing your custom look of your site.