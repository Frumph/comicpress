<?php

/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since ComicPress 4.2
 */

function comicpress_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return false;
	}
}

/*	CUSTOM RANGE SLIDERS WITH VALUE BUBBLE

	Extends WP_Customize_Control with two new range slider controls
	adding either a <span> or an <input> after the range slider to
	show the current value.  The <span> version is read-only, but
	the <input> version allows entering the value directly, which
	is sync'd to range slider and validated against any min/max
	set for the range slider.  Except on IE9 or lower, which shows
	range sliders as text fields and does not obey min/max params.
	
	CSS is in theme /css/options.css
	< IE 10 exclusion in /js/no_IE_range.js
*/
if (class_exists('WP_Customize_Control')) {
	/*	These extensions both use inline javascript so you don't have to enqueue a script just for them */
	class WP_Customize_Range_Control extends WP_Customize_Control {
		/*	Range Slider with READ ONLY output bubble after */
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label); ?></span>
				<span class="description customize-control-description"><?php echo esc_html( $this->description); ?></span>
				<input class="custorange" type="range" id="input-<?php echo esc_html( $this->id ); ?>" <?php $this->link(); ?> value="<?php echo esc_html( $this->value() ); ?>" <?php $this->input_attrs(); ?> onmousemove="if(this.focus){this.nextElementSibling.innerHTML=this.value;}" ontouchmove="if(this.focus){this.nextElementSibling.innerHTML=this.value;}">
				<span class="range-value"><?php echo esc_html( $this->value() ); ?></span>
			</label>
			<?php	
		}
	}
	class WP_Customize_RangeAndText_Control extends WP_Customize_Control {
		/* 	Range Slider with Input Bubble */
		public function render_content() {
			$min = ''; $max = '';
			$attrs = $this->input_attrs;
			foreach ($attrs as $key=>$val) {
				if ($key=='min') { $min = $val;}
				if ($key=='max') { $max = $val;}
			}
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label); ?></span>
				<span class="description customize-control-description"><?php echo esc_html( $this->description); ?></span>
				<input class="custorange" type="range" id="input-<?php echo esc_html( $this->id ); ?>" <?php $this->link(); ?> value="<?php echo esc_html( $this->value() ); ?>" <?php $this->input_attrs(); ?> onmousemove="if(this.focus){this.nextElementSibling.firstElementChild.value=this.value;}" ontouchmove="if(this.focus){this.nextElementSibling.firstElementChild.value=this.value;}">
				<span class="range-value">
				<input type="text" class="range-value" value="<?php echo esc_html( $this->value() ); ?>" onchange="var min='<?php echo $min; ?>';var max='<?php echo $max; ?>';
				if(this.focus){
					if(min!=''&&this.value<parseInt(min)){
						this.value = parseInt(min);
					} else if (max!=''&&this.value>parseInt(max)) {
						this.value = parseInt(max);
					} else {};
					this.parentNode.previousElementSibling.value=this.value
				};
				"></span>
			</label>
			<?php
		}
	}
}

class comicpress_Customize {

	/**
	* This hooks into 'customize_register' (available as of WP 3.4) and allows
 	* you to add new sections and controls to the Theme Customize screen.
 	* 
 	* Note: To enable instant preview, we have to actually write a bit of custom
 	* javascript. See live_preview() for more.
 	* 
	* @see add_action('customize_register',$func)
 	* @param \WP_Customize_Manager $wp_customize
	* @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 	* @since ComicPress 4.2
 	*/

	public $css_array = Array();
	
	public static function register($wp_customize) {
		
		$wp_customize->remove_section('colors');
//		$wp_customize->remove_section('title_tagline');
		$wp_customize->add_section('comicpress-scheme-options' , array('title' => __( 'Layout Options', 'comicpress' ), 'priority' => 10, 'capability' => 'edit_theme_options','description' => __( 'Allows you to customize layout settings for ComicPress.', 'comicpress' )));
//		$wp_customize->add_section('comicpress-background-colors' , array('title' => __( 'Background Colors', 'comicpress' ), 'capability' => 'edit_theme_options'));
		$wp_customize->add_section('colors' , array('title' => __( 'Background Colors', 'comicpress' ), 'description' => __( 'Colors that are in the background of each of the sections.', 'comicpress' ), 'priority' => 20, 'capability' => 'edit_theme_options'));
		$wp_customize->add_section('comicpress-text-colors' , array('title' => __( 'Text Colors', 'comicpress' ), 'priority' => 30, 'capability' => 'edit_theme_options'));
		$wp_customize->add_section('comicpress-link-colors' , array('title' => __( 'Link Colors', 'comicpress' ), 'priority' => 40, 'capability' => 'edit_theme_options'));
		$wp_customize->add_section('comicpress-logo-options', array('title' => __( 'Logo', 'comicpress' ), 'priority' => 50, 'capability' => 'edit_theme_options'));

		$wp_customize->add_setting( 'comicpress-customize-select-layout', array('default' => '3c', 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'wp_filter_nohtml_kses'));
		
		$choices = array(
			'3c' => __( '3 Column (default)', 'comicpress' ),
			'3cl' => __( '3 Column, both sidebars on left', 'comicpress' ),
			'3cr' => __( '3 Column, both sidebars on right', 'comicpress' ),
			'2cl' => __( '2 Column, sidebar on left', 'comicpress' ),
			'2cr' => __( '2 Column, sidebar on right', 'comicpress' ),
			'ncl' => __( 'No Columns, no L/R sidebars', 'comicpress'),
		);
		
		if (function_exists('ceo_pluginfo')) {
			$choices['3clgn'] = __( '3 Column, Graphic Novel style, main sidebar on left', 'comicpress' );
			$choices['3crgn'] = __( '3 Column, Graphic Novel style, main sidebar on right', 'comicpress' );
		}

		$wp_customize->add_control( 'comicpress-customize-select-layout-control' , array(
				'label' => __( 'Choose a layout', 'comicpress' ),
				'settings' => 'comicpress-customize-select-layout',
				'section' => 'comicpress-scheme-options',
				'type' => 'select',
				'choices' => $choices
			));
		
		$wp_customize->add_setting( 'comicpress-customize-select-scheme', array('default' => 'none', 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'wp_filter_nohtml_kses'));
		$wp_customize->add_control( 'comicpress-customize-select-scheme-control' , array(
				'label' => __( 'Choose a scheme', 'comicpress' ),
				'settings' => 'comicpress-customize-select-scheme',
				'section' => 'comicpress-scheme-options',
				'type' => 'select',
				'choices' => array(
					'none' => __( 'No Scheme', 'comicpress' ),
					'boxed' => __( 'Boxed', 'comicpress' ),
					'sandy' => __( 'Sandy', 'comicpress' ),
					'mecha' => __( 'Mecha', 'comicpress' ),
					'ceasel' => __( 'CEasel', 'comicpress' ),
					'high' => __( 'High Society', 'comicpress' )
				)
			));
			
		$wp_customize->add_setting( 'comicpress-customize-range-site-width', array('default' => '980', 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'wp_filter_nohtml_kses'));
		$wp_customize->add_control( new WP_Customize_RangeAndText_Control( $wp_customize, 'comicpress-customize-range-site-width', array(
				'label' => __( 'Site Width Control', 'comicpress' ),
				'description' => __( 'Minimum value is 780px, maximum is 1600px width - Currently saved at:', 'comicpress' ).' '.get_theme_mod('comicpress-customize-range-site-width', 980).'px',
				'settings' => 'comicpress-customize-range-site-width',
				'section' => 'comicpress-scheme-options',
				'type' => 'range',
				'input_attrs' => array(
					'min' => 780,
					'max' => 1600,
					'step' => 2,
				),
		)));
		
		$wp_customize->add_setting( 'comicpress-customize-range-left-sidebar-width', array('default' => '200', 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'wp_filter_nohtml_kses'));
		$wp_customize->add_control( new WP_Customize_Range_Control( $wp_customize, 'comicpress-customize-range-left-sidebar-width-control' , array(
				'label' => __( 'Left Sidebar Width', 'comicpress' ),
				'description' => __( 'Minimum value is 200px, maximum is 400px width - Currently saved at:', 'comicpress' ).' '.get_theme_mod('comicpress-customize-range-left-sidebar-width', 200).'px',
				'settings' => 'comicpress-customize-range-left-sidebar-width',
				'section' => 'comicpress-scheme-options',
				'type' => 'range',
				'input_attrs' => array(
					'min' => 200,
					'max' => 400,
					'step' => 2,
				),
		)));
		
		$wp_customize->add_setting( 'comicpress-customize-range-right-sidebar-width', array('default' => '200', 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'wp_filter_nohtml_kses'));
		$wp_customize->add_control( new WP_Customize_Range_Control( $wp_customize, 'comicpress-customize-range-right-sidebar-width-control' , array(
				'label' => __( 'Right Sidebar Width', 'comicpress' ),
				'description' => __( 'Minimum value is 200px, maximum is 400px width - Currently saved at:', 'comicpress' ).' '.get_theme_mod('comicpress-customize-range-right-sidebar-width', 200).'px',
				'settings' => 'comicpress-customize-range-right-sidebar-width',
				'section' => 'comicpress-scheme-options',
				'type' => 'range',
				'input_attrs' => array(
					'min' => 200,
					'max' => 400,
					'step' => 2,
				),
		)));

		$wp_customize->add_setting( 'comicpress-customize-detach-footer', array('default' => false, 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'comicpress_sanitize_checkbox'));
		$wp_customize->add_control( 'comicpress-customize-detach-footer-control', array(
				'settings' => 'comicpress-customize-detach-footer',
				'label' => __('Detach Footer', 'comicpress'),
				'description' => __( 'Detach the footer to below the main content? (Already appears detached on some schemes *but isn\'t)', 'comicpress' ),
				'section' => 'comicpress-scheme-options',
				'type' => 'checkbox'
			));

		$wp_customize->add_setting( 'comicpress-customize-checkbox-rounded', array('default' => false, 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'comicpress_sanitize_checkbox'));
		$wp_customize->add_control( 'comicpress-customize-checkbox-rounded-control', array(
				'settings' => 'comicpress-customize-checkbox-rounded',
				'label' => __('Rounded Corners', 'comicpress'),
				'description'    => __( 'Rounded corners on Post/Page Navigation Sections', 'comicpress' ),
				'section'  => 'comicpress-scheme-options',
				'type'     => 'checkbox'
			));
			
		$wp_customize->add_setting( 'comicpress-customize-checkbox-header-hotspot', array('default' => false, 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'comicpress_sanitize_checkbox'));
		$wp_customize->add_control( 'comicpress-customize-checkbox-header-hotspot-control', array(
					'settings' => 'comicpress-customize-checkbox-header-hotspot',
					'label' => __('Clickable Header Image', 'comicpress'),
					'description' => __( 'Make the header title and description become a clickable hotspot for the entire header? (If you do the logo will not display right)', 'comicpress' ),
					'section'  => 'header_image',
					'type'     => 'checkbox'
					));

		$wp_customize->add_setting( 'comicpress-customize[logo]', array('default' => '', 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'comicpress-customize-logo-image', array('label' => __( 'Logo, 120px height x 160px width', 'comicpress' ), 'section'  => 'comicpress-logo-options', 'settings' => 'comicpress-customize[logo]')));
		
		if (function_exists('ceo_pluginfo')) {
			$wp_customize->add_setting( 'comicpress-customize-comic-in-column', array('default' => false, 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'comicpress_sanitize_checkbox'));
			$wp_customize->add_control( 'comicpress-customize-comic-in-column-control', array(
						'settings' => 'comicpress-customize-comic-in-column',
						'label'    => __( 'Comic in content column?', 'comicpress' ),
						'description' => __('Put the comic into the content column?  This must be done for the Graphic Novel Layouts.', 'comicpress'),
						'section'  => 'comicpress-scheme-options',
						'type'     => 'checkbox'
						));
		}
		
		$css_array = array(
			// Background Colors
			array('slug' => 'page_background', 'description' => '#page', 'section' => 'colors', 'label' => __( 'Entire Content Area', 'comicpress' ), 'default' => ''),
			array('slug' => 'header_background', 'description' => '#header', 'section' => 'colors', 'label' => __( 'Header', 'comicpress' ), 'default' => ''),
			array('slug' => 'menubar_background', 'description' => '#menubar-wrapper', 'section' => 'colors', 'label' => __( 'Menubar', 'comicpress' ), 'default' => ''),
			array('slug' => 'menubar_submenu_background', 'description' => '.menu ul li ul li a', 'section' => 'colors', 'label' => __( 'Menubar Dropdown', 'comicpress' ), 'default' => ''),
			array('slug' => 'menubar_mouseover_background', 'description' => '.menu ul li a:hover', 'section' => 'colors', 'label' => __( 'Menubar When Mouseover', 'comicpress' ), 'default' => ''),
			array('slug' => 'breadcrumb_background', 'description' => '#breadcrumb-wrapper', 'section' => 'colors', 'label' => __( 'Breadcrumbs', 'comicpress' ), 'default' => ''),
			array('slug' => 'content_wrapper_background', 'description' => '#content-wrapper', 'section' => 'colors', 'label' => __( 'Content Area Below Menubar', 'comicpress' ), 'default' => ''),
			array('slug' => 'subcontent_wrapper_background', 'description' => '#subcontent-wrapper', 'section' => 'colors', 'label' => __( 'Content Area Below Comic', 'comicpress' ), 'default' => ''),
			array('slug' => 'narrowcolumn_widecolumn_background', 'description' => '#content-column', 'section' => 'colors', 'label' => __( 'Content Column', 'comicpress' ), 'default' => ''),
			array('slug' => 'post_page_navigation_background', 'description' => '.uentry, #comment-wrapper, #wp-paginav, #pagenav', 'section' => 'colors', 'label' => __( 'Entire Post Area', 'comicpress' ), 'default' => ''),
			array('slug' => 'post_info_background', 'description' => '.post-info', 'section' => 'colors', 'label' => __( 'Top Section of a Post', 'comicpress' ), 'default' => ''),
			array('slug' => 'comment_background', 'description' => '.comment, #comment-wrapper #wp-paginav', 'section' => 'colors', 'label' => __( 'Comment Section', 'comicpress' ) , 'default' => ''),
			array('slug' => 'comment_meta_data_background', 'description' => '.comment-meta-data', 'section' => 'colors', 'label' => __( 'Comment Info. Line', 'comicpress' ), 'default' => ''),
			array('slug' => 'bypostauthor_background', 'description' => '.bypostauthor', 'section' => 'colors', 'label' => __( 'Comments Made By Post Author', 'comicpress' ), 'default' => ''),
			array('slug' => 'bypostauthor_meta_data_background', 'description' => '.bypostauthor .comment-meta-data', 'section' => 'colors', 'label' => __( 'Info. Line Of Post Author', 'comicpress' ), 'default' => ''),
			array('slug' => 'footer_background', 'description' => '#footer', 'section' => 'colors', 'label' => __( 'Footer', 'comicpress' ), 'default' => ''),
			// Text Colors
			array('slug' => 'content_text_color', 'description' => 'body', 'section' => 'comicpress-text-colors', 'label' => __( 'Sitewide Textcolor', 'comicpress' ), 'default' => ''),
			array('slug' => 'header_textcolor', 'description' => '#header', 'section' => 'comicpress-text-colors', 'label' => __( 'Header', 'comicpress' ), 'default' => ''),
			array('slug' => 'header_description_textcolor', 'description' => '.header-info .description', 'section' => 'comicpress-text-colors', 'label' => __( 'Site Description', 'comicpress' ), 'default' => ''),
			array('slug' => 'breadcrumb_textcolor', 'description' => '#breadcrumb-wrapper', 'section' => 'comicpress-text-colors', 'label' => __( 'Breadcrumbs', 'comicpress' ), 'default' => ''),
			array('slug' => 'lrsidebar_widgettitle_textcolor', 'description' => 'h2.widget-title', 'section' => 'comicpress-text-colors', 'label' => __( 'Widget Titles', 'comicpress' ), 'default' => ''),
			array('slug' => 'lrsidebar_textcolor', 'description' => '.sidebar', 'section' => 'comicpress-text-colors', 'label' => __( 'Sidebar', 'comicpress' ), 'default' => ''),
			array('slug' => 'posttitle_textcolor', 'description' => 'h2.post-title', 'section' => 'comicpress-text-colors', 'label' => __( 'Non-Link Post Titles', 'comicpress' ), 'default' => ''),
			array('slug' => 'pagetitle_textcolor', 'description' => 'h2.page-title', 'section' => 'comicpress-text-colors', 'label' => __( 'Page Titles', 'comicpress' ), 'default' => ''),
			array('slug' => 'postinfo_textcolor', 'description' => '.post-info', 'section' => 'comicpress-text-colors', 'label' => __( 'Top Section of a Post', 'comicpress' ), 'default' => ''),
			array('slug' => 'post_page_navigation_textcolor', 'description' => '.uentry, #comment-wrapper, #wp-paginav', 'section' => 'comicpress-text-colors', 'label' => __( 'Post/Page Comments', 'comicpress' ), 'default' => ''),
			array('slug' => 'footer_textcolor', 'description' => '#footer', 'section' => 'comicpress-text-colors', 'label' => __( 'Footer', 'comicpress' ), 'default' => ''),
			array('slug' => 'footer_copyright_textcolor', 'description' => '.copyright-info', 'section' => 'comicpress-text-colors', 'label' => __( 'Copyright', 'comicpress' ), 'default' => ''),
			// Link Colors
			array('slug' => 'content_link_acolor', 'description' => 'body a:link', 'section' => 'comicpress-link-colors', 'label' => __( 'Sitewide Linkcolor', 'comicpress' ), 'default' => ''),
			array('slug' => 'content_link_vcolor', 'description' => 'body a:visited', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'content_link_hcolor', 'description' => 'body a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'header_title_acolor', 'description' => '#header h1 a', 'section' => 'comicpress-link-colors', 'label' => __( 'Header', 'comicpress' ), 'default' => ''),
			array('slug' => 'header_title_hcolor', 'description' => '#header h1 a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'menubar_top_acolor', 'description' => '.menu ul li a:link, .menu ul li a:visited, .mininav-prev a, .mininav-next a', 'section' => 'comicpress-link-colors', 'label' => __( 'Menubar', 'comicpress' ), 'default' => ''),
			array('slug' => 'menubar_hcolor', 'description' => '.menu ul li a:hover, .menu ul li a.selected, .menu ul li ul li a:hover, .menunav a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'menubar_sub_acolor', 'description' => '.menu ul li ul li a:link, .menu ul li ul li a:visited', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'breadcrumb_acolor', 'description' => '.breadcrumbs a', 'section' => 'comicpress-link-colors', 'label' => __( 'Breadcrumbs', 'comicpress' ), 'default' => ''),
			array('slug' => 'breadcrumb_hcolor', 'description' => '.breadcrumbs a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'sidebar_acolor', 'description' => '.sidebar .widget a', 'section' => 'comicpress-link-colors', 'label' => __( 'Sidebar Widget', 'comicpress' ), 'default' => ''),
			array('slug' => 'sidebar_hcolor', 'description' => '.sidebar .widget a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'postpagenav_acolor', 'description' => '.entry a, .blognav a, #paginav a, #pagenav a', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'postpagenav_hcolor', 'description' => '.entry a:hover, .blognav a:hover, #paginav a:hover, #pagenav a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'footer_acolor', 'description' => '#footer a', 'section' => 'comicpress-link-colors', 'label' => __( 'Footer', 'comicpress' ), 'default' => ''),
			array('slug' => 'footer_hcolor', 'description' => '#footer a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => ''),
			array('slug' => 'footer_copyright_acolor', 'description' => '.copyright-info a', 'section' => 'comicpress-link-colors', 'label' => __( 'Copyright', 'comicpress' ), 'default' => ''),
			array('slug' => 'footer_copyright_hcolor', 'description' => '.copyright-info a:hover', 'section' => 'comicpress-link-colors', 'label' => '', 'default' => '')
		);
		
		// Additions for CE
		if (function_exists('ceo_pluginfo')) {
			$css_array[] = array('slug' => 'comic_wrap_background', 'description' => '#comic-wrap', 'section' => 'colors', 'label' => __( 'Comic Area', 'comicpress' ), 'default' => '');
			$css_array[] = array('slug' => 'comic_wrap_textcolor', 'description' => '#comic-wrap', 'section' => 'comicpress-text-colors', 'label' => '', 'default' => '');
			$css_array[] = array('slug' => 'comic_nav_background', 'description' => 'table#comic-nav-wrapper', 'section' => 'colors', 'label' => __( 'Default Comic Navigation', 'comicpress' ), 'default' => '');
			$css_array[] = array('slug' => 'comic_nav_textcolor', 'description' => '.comic-nav', 'section' => 'comicpress-text-colors', 'label' => __( 'Default Nav Normal Text Color', 'comicpress' ), 'default' => '');
			$css_array[] = array('slug' => 'comic_nav_acolor', 'description' => '.comic-nav a:link, .comic-nav a:visited', 'section' => 'comicpress-link-colors', 'label' => __( 'Default Navigation Link', 'comicpress' ), 'default' => '');
			$css_array[] = array('slug' => 'comic_nav_hcolor', 'description' => '.comic-nav a:hover', 'section' => 'comicpress-link-colors', 'label' => __( 'Default Navigation Hover', 'comicpress' ), 'default' => '');
		}
		
		$priority_value = 11;
		foreach ($css_array as $setinfo) {
			$setinfo_register_name = 'comicpress-customize['.$setinfo['slug'].']';
			$default = (isset($setinfo['default'])) ? $setinfo['default'] : '';
			$wp_customize->add_setting($setinfo_register_name, array('default' => $default, 'type' => 'theme_mod', 'capability' => 'edit_theme_options', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_hex_color'));
			$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						$setinfo['slug'],
						array('label' => $setinfo['label'], 'description' => $setinfo['description'], 'section' => $setinfo['section'], 'settings' => $setinfo_register_name, 'priority' => $priority_value)
						)
					);
			$priority_value++;
//			$wp_customize->get_setting($setinfo['slug'])->transport = 'postMessage';
		}
      
	
      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 * 
	 * Used by hook: 'wp_head'
	 * 
	 * @see add_action('wp_head',$func)
	 * @since MyTheme 1.0
	 */
	public static function header_output() {
		
		$style_output = '';
		$settings_array = array(
			// background colors
			array('slug' => 'page_background', 'element' => '#page', 'style' => 'background-color', 'default' => '', 'important' => true),
			array('slug' => 'header_background', 'element' => '#header', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'menubar_background', 'element' => '#menubar-wrapper', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'menubar_submenu_background', 'element' => '.menu ul li ul li a', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'menubar_mouseover_background', 'element' => '.menu ul li a:hover, .menu ul li a.selected', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'breadcrumb_background', 'element' => '#breadcrumb-wrapper', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'content_wrapper_background', 'element' => '#content-wrapper', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'subcontent_wrapper_background', 'element' => '#subcontent-wrapper', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'narrowcolumn_widecolumn_background', 'element' => '.narrowcolumn, .widecolumn', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'post_page_navigation_background', 'element' => '.uentry, #comment-wrapper, #wp-paginav, .blognav, #pagenav', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'post_info_background', 'element' => '.post-info', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'comment_background', 'element' => '.comment, #comment-wrapper #wp-paginav', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'comment_meta_data_background', 'element' => '.comment-meta-data', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'bypostauthor_background', 'element' => '.bypostauthor', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'bypostauthor_meta_data_background', 'element' => '.bypostauthor .comment-meta-data', 'style' => 'background-color', 'default' => '',  'important' => true),
			array('slug' => 'footer_background', 'element' => '#footer', 'style' => 'background-color', 'default' => '',  'important' => true),
			// text colors
			array('slug' => 'content_text_color', 'element' => 'body', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'header_textcolor', 'element' => '#header', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'header_description_textcolor', 'element' => '.header-info', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'breadcrumb_textcolor', 'element' => '#breadcrumb-wrapper', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'lrsidebar_widgettitle_textcolor', 'element' => 'h2.widget-title', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'lrsidebar_textcolor', 'element' => '.sidebar', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'posttitle_textcolor', 'element' => 'h2.post-title', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'pagetitle_textcolor', 'element' => 'h2.page-title', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'postinfo_textcolor', 'element' => '.post-info', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'post_page_navigation_textcolor', 'element' => '.uentry, #comment-wrapper, #wp-paginav', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'footer_text', 'element' => '#footer', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'footer_copyright_textcolor', 'element' => '.copyright-info', 'style' => 'color', 'default' => '',  'important' => true),
			// link colors
			array('slug' => 'content_link_acolor', 'element' => 'a:link, a:visited', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'content_link_vcolor', 'element' => 'a:visited', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'content_link_hcolor', 'element' => 'a:hover', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'content_link_vcolor', 'element' => 'a:visited', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'header_title_acolor', 'element' => '#header h1 a:link, #header h1 a:visited', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'header_title_hcolor', 'element' => '#header h1 a:hover', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'menubar_top_acolor', 'element' => '.menu ul li a:link, .menu ul li a:visited, .mininav-prev a, .mininav-next a, a.menunav-rss', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'menubar_hcolor', 'element' => '.menu ul li a:hover, .menu ul li a.selected, .menu ul li ul li a:hover, .menunav a:hover, a.menunav-rss:hover', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'menubar_sub_acolor', 'element' => '.menu ul li ul li a:link, .menu ul li ul li a:visited', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'breadcrumb_acolor', 'element' => '.breadcrumbs a', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'breadcrumb_hcolor', 'element' => '.breadcrumbs a:hover', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'sidebar_acolor', 'element' => '.sidebar .widget a', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'sidebar_hcolor', 'element' => '.sidebar .widget a:hover', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'postpagenav_acolor', 'element' => '.entry a, .blognav a, #paginav a, #pagenav a', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'postpagenav_hcolor', 'element' => '.entry a:hover, .blognav a:hover, #paginav a:hover, #pagenav a:hover', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'footer_acolor', 'element' => '#footer a', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'footer_hcolor', 'element' => '#footer a:hover', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'footer_copyright_acolor', 'element' => '.copyright-info a', 'style' => 'color', 'default' => '',  'important' => true),
			array('slug' => 'footer_copyright_hcolor', 'element' => '.copyright-info a:hover, .blognav a:hover, #paginav a:hover', 'style' => 'color', 'default' => '',  'important' => true),
			);
			
		if (function_exists('ceo_pluginfo')) {
			$settings_array[] = array('slug' => 'comic_wrap_background', 'element' => '#comic-wrap', 'style' => 'background-color', 'default' => '',  'important' => true);
			$settings_array[] = array('slug' => 'comic_wrap_textcolor', 'element' => '#comic-wrap', 'style' => 'color', 'default' => '',  'important' => true);
			$settings_array[] = array('slug' => 'comic_nav_background', 'element' => 'table#comic-nav-wrapper', 'style' => 'background-color', 'default' => '',  'important' => true);
			$settings_array[] = array('slug' => 'comic_nav_textcolor', 'element' => '.comic-nav', 'style' => 'color', 'default' => '',  'important' => true);
			$settings_array[] = array('slug' => 'comic_nav_acolor', 'element' => '.comic-nav a:link, .comic-nav a:visited', 'style' => 'color', 'default' => '#FFFFFF',  'important' => true);
			$settings_array[] = array('slug' => 'comic_nav_hcolor', 'element' => '.comic-nav a:hover', 'style' => 'color', 'default' => '#F00',  'important' => true);
			
		}
      ?>
<!--Customizer CSS-->
<style type="text/css">
<?php
	$customize = get_theme_mod('comicpress-customize');

// get defaults here:
	$default_width = 980;
	$comicpress_options = comicpress_load_options();
// if the theme mod returns no value for a selected layout at all but cp_options exists
	if (isset($comicpress_options['layout']) && !intval(get_theme_mod('comicpress-customize-select-layout', 0))) {
		switch ($comicpress_options['layout']) {
			case '2cl':
			case '2cr':
			case 'ncl':
				$default_width = 780;
				break;
			case '3c':
			case '3cl':
			case '3cr':
			case '3clw':
			case '3crw':
			case '3clgn':
			case '3crgn':
			default:
				$default_width = 980;
				break;
		}
	}

	$page_width = intval(get_theme_mod('comicpress-customize-range-site-width', $default_width));
	$layout = get_theme_mod('comicpress-customize-select-layout', '3c');
	$comic_width = intval($page_width) + 40;
	$scheme = get_theme_mod('comicpress-customize-select-scheme', 'none');
	$left_sidebar_width = get_theme_mod('comicpress-customize-range-left-sidebar-width', 200)+4;
	$right_sidebar_width = get_theme_mod('comicpress-customize-range-right-sidebar-width', 200)+4;
	$style_output = '';
	if (($scheme !== 'sandy') && ($scheme !== 'high')) {
		$style_output .= "\t#page { width: ".$page_width."px; max-width: ".$page_width."px; }\r\n";
	} else {
		if (($scheme == 'sandy') || ($scheme == 'high'))
			$style_output .= "\t#page, #page-wide { width: ".$comic_width."px!important; max-width: 100%!important; }\r\n";
		$style_output .= "\t#header, #menubar-wrapper, #breadcrumb-wrapper, #subcontent-wrapper, #footer, #footer-sidebar-wrapper { width: ".$page_width."px; max-width: ".$page_width."px; }\r\n";
		$style_output .= "\t#comic-wrap { max-width: 100%; }\r\n";
	}
	$content = '';
	$content_width = '';
	switch ($layout) {
		case 'ncl':
			$add_width = 0;
			$content_width = $page_width + $add_width;
			break;
		case '2cl':
			$add_width = 0;
			if ($scheme == 'ceasel') $add_width = $add_width + 2;
			if ($scheme = 'high') $add_width = $add_width + 6;
			$content_width = $page_width - ($left_sidebar_width + $add_width);
			break;
		case '2cr':
			$add_width = 6;
			if ($scheme == 'ceasel') $add_width = $add_width + 2;
			$content_width = $page_width - ($right_sidebar_width + $add_width);
			break;
		case '3clgn':
			$add_width = 6;
			if ($scheme == 'ceasel') $add_width = $add_width + 4; 
			$content_width = $page_width - ($left_sidebar_width + $add_width);
			$add_inside = 4;
			if ($scheme == 'high') $add_inside = $add_inside + 4;
			$inside_content_width = $content_width - ($right_sidebar_width + $add_inside);
			break;
		case '3crgn':
			$add_width = 6;
			if ($scheme == 'ceasel') $add_width = $add_width + 2;
			$content_width = $page_width - ($right_sidebar_width + $add_width);
			$add_inside = 4;
			if ($scheme == 'high') $add_inside = $add_inside + 4;
			$inside_content_width = $content_width - ($left_sidebar_width + $add_inside);
			break;
		case '3c':
		case '3cl':
		case '3cr':
		default: 
			$add_width = 10;
			if ($scheme == 'ceasel') $add_width = $add_width +2;
			$content_width = $page_width - ($left_sidebar_width + $right_sidebar_width + $add_width);
			break;
		
	}
	$style_output .= "\t#add-width { width: ".$add_width."px; }\r\n";
	$style_output .= "\t#content-column { width: ".$content_width."px; max-width: 100%; }\r\n";
	if (!empty($inside_content_width)) {
		if ($scheme == 'high') {
			$style_output .= "\t#content { width: ".$inside_content_width."px; padding-right: 4px; max-width: 100%; }\r\n";
		} else 
			$style_output .= "\t#content { width: ".$inside_content_width."px; max-width: 100%; }\r\n";
	}
	$style_output .= "\t#sidebar-right { width: ".$right_sidebar_width."px; }\r\n";
	$style_output .= "\t#sidebar-left { width: ".$left_sidebar_width."px; }\r\n";
	foreach ($settings_array as $setting) {
		$content = $setting['default'];
		if (isset($customize[$setting['slug']])) $content = $customize[$setting['slug']];
		$important = ($setting['important']) ? '!important' : '';
		if (!empty($content) && $content) $style_output .= "\t".$setting['element'].' { '.$setting['style'].': '.$content.$important."; }\r\n";
	}
	if (isset($customize['logo']) && !empty($customize['logo'])) {
		$style_output .= "\t.header-info { display: inline-block; float: left; padding: 0; }\r\n";
		$style_output .= "\t.header-info h1 { margin: 0; padding: 0; background: url(\"".$customize['logo']."\") top left no-repeat; background-size: contain; display: cover; }\r\n";
		$style_output .= "\t.header-info h1 a { padding: 0; margin: 0; height: 120px; width: 180px; text-indent: -9999px; white-space: nowrap; overflow: hidden; display: block;}\r\n";
		$style_output .= "\t.header-info .description { display: none!important; }\r\n";
	}
	echo $style_output;
?>
</style>
<!--/Customizer CSS-->
      <?php
   }
   
   /**
    * This outputs the javascript needed to automate the live settings preview.
    * Also keep in mind that this function isn't necessary unless your settings 
    * are using 'transport'=>'postMessage' instead of the default 'transport'
    * => 'refresh'
    * 
    * Used by hook: 'customize_preview_init'
    * 
    * @see add_action('customize_preview_init',$func)
    * @since MyTheme 1.0
    */
	public static function live_preview() {
		wp_enqueue_script(
			'comicpress-themecustomizer', // Give the script a unique ID
			get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
			array(  'jquery', 'customize-preview' ), // Define dependencies
			'', // Define a version (optional)
			true // Specify whether to put in footer (leave this true)
		);
	}

}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'comicpress_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'comicpress_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'comicpress_Customize' , 'live_preview' ) );

add_filter('body_class', 'comicpress_customize_body_class');

function comicpress_customize_body_class($classes = array()){
	$classes[] = 'scheme-'.get_theme_mod('comicpress-customize-select-scheme', 'none');
	if (get_theme_mod('comicpress-customize-checkbox-rounded', false)) $classes[] = 'rounded-posts';
	if (function_exists('ceo_pluginfo') && get_theme_mod('comicpress-customize-comic-in-column', false)) $classes[] = 'cnc';
	return $classes;
}

function controls_stylesheet() {
	wp_enqueue_style('comicpress-options-style', get_template_directory_uri() . '/options/options.css');
}
add_action( 'admin_enqueue_scripts', 'controls_stylesheet' );

function no_IE_range(){
	wp_enqueue_script('no_IE_range', get_template_directory_uri() . '/js/no_IE_range.js');
}
add_action( 'admin_enqueue_scripts', 'no_IE_range');