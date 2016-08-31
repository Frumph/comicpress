== Developers == 

Tyler Martin @mindfaucet - Creator
http://mindfaucet.net

Philip Hofer @frumph - Lead Developer
http://frumph.net

Rene Wolf @ kniebremser - Contributor

Kristi Hansen @kmhcreative - Contributor

== Theme Documentation == 

ComicPress is a configurable theme, layouts to colors.

It is primarily to be used with the Comic Easel plugin.

== ComicPress 4.* ==

ComicPress now does not include comic running code, this is handled with the plugin Comic Easel.

You will need to use the ComicPress to Comic Easel migrator plugin if you are migrating from old < 2.9.* version of ComicPress.

Please read information and faqs on comiceasel.com for more information regarding using ComicPress for your webcomic.

== Requires ==

WordPress: 4.6
PHP:       5.4

== Changelog ==
= 4.4 =
* Compliance check for 4.6 of Wordpress
* Probably breadcrumb fix for property error when trying to retrieve $parent_id
* options $tab reference fix with strict php implemented

= 4.3.2 =
* Added no column - no l/r sidebars layout option
* Fixed the featured image thumbnail to only appear on posts - fixes for custom post types that might display
* replaced deprecated function get_currentuserinfo() with is_user_logged_in and wp_get_current_user

= 4.3.x =
* added:   missed labels in costumizer
* added:   extended WP_Customize_Control with new range sliders with output bubbles
* added:   new range slider CSS to options.css
* added: ` no_IE_range.js` to handle old IE that doesn’t understand range sliders
* fixed:   "back to top" function
* fixed:   schema Mecha colors for menu changed from yellow to #fcff00
* fixed:   HTML errors in author.php
* fixed:   HTML errors in the Back-End
* updated: breadcumps to version: 2015.09.14
* updated: german translation
* changed: convert colors in style.css and options.css from #xxx to #xxxxxx  NO COLOR CHANGES
* removed: outdated border referenes in options.php for Back-End

= 4.3 =
* re-added: widget "posts calender"
* reworked: all ComicPress options pages
* fixed: problems with costumizer layout and header
* fixed: some little errors in widget "classic bookmark"
* removed: widget "google translaor"
* wp_title filter removed and now using WordPress's default one
* layout is controlled in the customizer now
* templates for individual character and location for comic easel users landing pages added
* author pages restyled
* tons and tons of CSS changes, no elements were renamed mainly colorizations, margin's removed etc.
* adjustable site width & sidebars in the customizer
* zappbar support for responsive, mobile friendly comicpress
* added layout options to the costumizer
* added locations taxonomy template, for comic easel, for custom location pages 
* added new CSS requirements for theme review team for screen readers
* added theme_support('title_tag') per requirements of theme review team
* re-added Post/Comic "Moods" for github version
* re-added blog.php template for github version
* changed HTML 5 compliancy for posts footer, header
* changed custom-header.php fixes to remove the option to remove header text
* changed widgets/ section now uses get_template_part so you can overwrite widgets/* files in the child theme
* changed functions/ section now uses get_template_part so you can overwrite functions/* files in the child theme
* changed author page Date of registration displayed now translated and with the date format of WP Settings
* changed author page layout for contact infos
* changed minor CSS Styles
* updated instant.js to v2.4
* updated cvi_text_lib.js to 1.03
* updated screenshot 880x660 per requirements of theme review team
* updated german translation
* fixed various js errors
* fixed the widgets for PHP 5.4 minimal to remove deprecated notices
* revamped the customizer
* moved above-blog sidebar location
* removed tab layout in comicpress options
* removed all CSS styling for the dropdown selectors
* removed comicpress_themeinfo('data') calls that overlap standard WordPress ones
* removed archive-year template for posts 

= 4.2.2 =
* translation and typo fixes by Kniebremser
* removed unused functions
* removed unused images
* minor change for blognav-prev and next by Kniebremser
* breadcrumbs update by Kniebremser
* revamped the customizr to work with WP 4.1+
* fixed custom-header.php to remove the checkbox
* removed all defaults from customizr and set base to no-scheme
* using get_template_part for loading of functions and widgets now
* added add_theme_support('title_tag') removed wp_title from header.php

= 4.2.1 =
* Translation string for description in style.css thanks kniebremser
* Translation strings for Customizer

= 4.2 =
* No longer saves data to the database unless you click save in the comicpress options
* logic change on featured image for non-comics
* fixed a few localization strings that weren't set properly to 'comicpress' 
* fixed a few strings that weren't set as translatable localization
* removed suggested plugins completely
* removed help panel completely when updating from old version of comicpress (migration help)
* removed extra " from circle me line in functions.php
* word change for describing youtube channel for the social icons in the menubar
* sidebar.php cleanup so it shows empty if it executes from a plugin
* several comicpress->jetpack plugin adjustments
* removed the blog.php template per request from theme review teams many silly requirements
* option added on the general tab to enable the project wonderful asyncronus code into the header
* above-blog sidebar shows on all pages now - not just the home page
* checkbox in appearance -> header now works in conjunction with the make hotspot option in the customizer
* added value checks in the customizer (sanitization)
* the id="comments" 'discussion' line will now appear whether there are comments or not
* added commented out line in the functions.php that when uncommented will stop wordpress from recompressing images on upload
* updated translation files en_US and de_DE
* updated screenshot


= 4.1 =
* Added LGN and RGN (3 column) layouts back into ComicPress, layout-head.php and layout-foot.php updated
* Fixed problem with customizer not setting defaults
* Added #footer a, #footer a:hover and footer textcolor entries to the customizer which were missing
* Boxed scheme w/blue background image is now the default design
* added sidebar.php as a default to handle plugins that need it
* added missing .uentry entries for search.php 
* Changed the footer widgets to be specific widths instead of percent
* New browser window/tab when clicking social links in the menubar
* Titles no longer link on pages, static or otherwise
* Regenerated .pot/.mo files 
* Readded the default height and width for the custom header image in case the auto-sensing one doesn't work
* The home link .menu-item-home and the downarrows in the menubar can now all be skinned, i.e. replaced with your own images if you want to; I left examples inside the style.css for the home button
* Calendar widget removed for ComicPress; since Comic Easel has one, will re-add in a newer version when I update it to the new WordPress code; otherwise it's a liability until then
* Options to allow changing media content width in posts and pages
* a couple spelling fixes
* option to change the media width inside posts
* fix for 2 column wide layouts having that extra wide sidebar (that was a bug)
* random default avatar adjustments to work with facebook commenting / as user
* a plethora of author page fixes/adjustments


= 4.0.6 =
* Adjusted the page titles function in displaypost.php to allow the titles to be clicked on search and archive results /bugfix

= 4.0.4 =
* Archive pages now display comic thumbnails for ComiC Easel if show archives as links enabled
* CSS: body.wide set properly for when the sidebars get removed!important
* CSS: .header-info padding removal when used as click block
* CSS: 780px 980px #page instead of 782/982 .. extra 2px was wrong, fixed


= 4.0.3 =
* Correctly attribute the height to auto for images inside posts.
* fixed the archive - asc/desc setting in the comicpress options
* added #pagenav to the customizer for the uentry section for link:hover
* style.css added #pagenav to the rounded-style class
* show the customizer jquery ONLY on the customizer page!bugfix
* added high society scheme


= 4.0.2 =
* Added toggle to make header text into a hotspot for the entire header image.
* Don't show recommended plugins notice (it confuses people into installing them all)
* Better Handling of the help screen when first installing the new ComicPress theme

= 4.0.1 =
* Fixed the 'description' of the theme.

