<?php

/* Wordpress-supported theme options
 */

if ( ! isset( $content_width ) ) $content_width = 980;
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );

function custom_background()  {
	// Add theme support for Custom Background
	$background_args = array(
		'default-color'          => 'ffffff',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-background', $background_args );
}

$defaults = array(
	'default-image'          => get_template_directory_uri() . '/images/logo.gif',
	'random-default'         => false,
	'width'                  => 178,
	'height'                 => 118,
	'flex-height'            => false,
	'flex-width'             => false,
	'default-text-color'     => '',
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $defaults );

// Hook into the 'after_setup_theme' action
add_action( 'after_setup_theme', 'custom_background' );

load_theme_textdomain( 'corporateslave', get_template_directory().'/languages' );
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
	

/* corporateslave-specific Theme Options
 */

class Corporate_Slave_Options {
	
	private $sections;
	private $checkboxes;
	private $settings;

	public function __construct() {

		// This will keep track of the checkbox options for the validate_settings function.
		$this->checkboxes = array();
		$this->settings = array();
		$this->get_settings();
		
		$this->sections['general']      = __( 'General Settings' );
		$this->sections['appearance']   = __( 'Appearance' );
		$this->sections['reset']        = __( 'Reset to Defaults' );
		$this->sections['about']        = __( 'About' );
		
		add_action( 'admin_menu', array( &$this, 'add_pages' ) );
		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		
		if ( ! get_option( 'corporateslave_options' ) )
			$this->initialize_settings();
		
	}
	
	public function add_pages() {
		
		$admin_page = add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'manage_options', 'corporateslave-options', array( &$this, 'display_page' ) );
		
		add_action( 'admin_print_scripts-' . $admin_page, array( &$this, 'scripts' ) );
		add_action( 'admin_print_styles-' . $admin_page, array( &$this, 'styles' ) );
		
	}
	
	public function create_setting( $args = array() ) {
		
		$defaults = array(
			'id'      => 'default_field',
			'title'   => __( 'Default Field' ),
			'desc'    => __( 'This is a default description.' ),
			'std'     => '',
			'type'    => 'text',
			'section' => 'general',
			'choices' => array(),
			'class'   => ''
		);
			
		extract( wp_parse_args( $args, $defaults ) );
		
		$field_args = array(
			'type'      => $type,
			'id'        => $id,
			'desc'      => $desc,
			'std'       => $std,
			'choices'   => $choices,
			'label_for' => $id,
			'class'     => $class
		);
		
		if ( $type == 'checkbox' )
			$this->checkboxes[] = $id;
		
		add_settings_field( $id, $title, array( $this, 'display_setting' ), 'corporateslave-options', $section, $field_args );
	}
	
	public function display_page() {
		
		echo '<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2>' . __( 'Theme Options' ) . '</h2>';
	
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true )
			echo '<div class="updated fade"><p>' . __( 'Theme options updated.' ) . '</p></div>';
		
		echo '<form action="options.php" method="post">';
	
		settings_fields( 'corporateslave_options' );
		echo '<div class="ui-tabs">
			<ul class="ui-tabs-nav">';
		
		foreach ( $this->sections as $section_slug => $section )
			echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';
		
		echo '</ul>';
		do_settings_sections( $_GET['page'] );
		
		echo '</div>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes' ) . '" /></p>
		
	</form>';
	
	echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
			var sections = [];';
			
			foreach ( $this->sections as $section_slug => $section )
				echo "sections['$section'] = '$section_slug';";
			
			echo 'var wrapped = $(".wrap h3").wrap("<div class=\"ui-tabs-panel\">");
			wrapped.each(function() {
				$(this).parent().append($(this).parent().nextUntil("div.ui-tabs-panel"));
			});
			$(".ui-tabs-panel").each(function(index) {
				$(this).attr("id", sections[$(this).children("h3").text()]);
				if (index > 0)
					$(this).addClass("ui-tabs-hide");
			});
			$(".ui-tabs").tabs({
				fx: { opacity: "toggle", duration: "fast" }
			});
			
			$("input[type=text], textarea").each(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "")
					$(this).css("color", "#999");
			});
			
			$("input[type=text], textarea").focus(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "") {
					$(this).val("");
					$(this).css("color", "#000");
				}
			}).blur(function() {
				if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")) {
					$(this).val($(this).attr("placeholder"));
					$(this).css("color", "#999");
				}
			});
			
			$(".wrap h3, .wrap table").show();
			
			// This will make the "warning" checkbox class really stand out when checked.
			// I use it here for the Reset checkbox.
			$(".warning").change(function() {
				if ($(this).is(":checked"))
					$(this).parent().css("background", "#c00").css("color", "#fff").css("fontWeight", "bold");
				else
					$(this).parent().css("background", "none").css("color", "inherit").css("fontWeight", "normal");
			});
			
			// Browser compatibility
			if ($.browser.mozilla) 
			         $("form").attr("autocomplete", "off");
		});
	</script>
</div>';
		
	}
	
	public function display_section() {
		// left for future?
	}
	
	public function display_about_section() {
		echo '<p>Theme Name: <a href="http://samdevol.com">Corporate Slave</a></p>';
		echo '<p>Description: This template is a modified version of Corporate Slave, by <a href="http://www.dream-logic.com">dreamLogic</a> </p>';
		echo '<p>Author: <a href="http://samdevol.com">Sam Devol</a></p>';
		echo '<p>Version: 0.99</p>';
		echo '<p>License: <a href="http://www.gnu.org/licenses/gpl.html">GNU General Public License (GPL) version 3</a></p>';
	}
	
	public function display_setting( $args = array() ) {
		
		extract( $args );
		
		$options = get_option( 'corporateslave_options' );
		
		if ( ! isset( $options[$id] ) && $type != 'checkbox' )
			$options[$id] = $std;
		elseif ( ! isset( $options[$id] ) )
			$options[$id] = 0;
		
		$field_class = '';
		if ( $class != '' )
			$field_class = ' ' . $class;
		
		switch ( $type ) {
			
			case 'heading':
				echo '</td></tr><tr valign="top"><td colspan="2"><h4>' . $desc . '</h4>';
				break;
			
			case 'checkbox':
				
				echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="corporateslave_options[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
				
				break;
			
			case 'select':
				echo '<select class="select' . $field_class . '" name="corporateslave_options[' . $id . ']">';
				
				foreach ( $choices as $value => $label )
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
				
				echo '</select>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'radio':
				$i = 0;
				foreach ( $choices as $value => $label ) {
					echo '<input class="radio' . $field_class . '" type="radio" name="corporateslave_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
					if ( $i < count( $options ) - 1 )
						echo '<br />';
					$i++;
				}
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'textarea':
				echo '<textarea class="' . $field_class . '" id="' . $id . '" name="corporateslave_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'password':
				echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="corporateslave_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'text':
			default:
		 		echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="corporateslave_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
		 		
		 		if ( $desc != '' )
		 			echo '<br /><span class="description">' . $desc . '</span>';
		 		
		 		break;
		 	
		}
		
	}
	
	public function get_settings() {
		
/* General Settings
 */		
		$this->settings['toppostcat'] = array(
			'title'   => __( 'Category for top-post' ),
			'desc'    => __( 'Most recent post from this (single) category will be displayed as Top Post (and NOT be displayed anywhere else on the page). Default is 2.<br />Leave this empty if you do not want to display a Top Post.<br /><em>Format: <strong>2</strong> where 2 = category number 2.</em> Please Note: This post will <strong>not</strong> be duplicated anywhere else on the page' ),
			'std'     => '7',
			'type'    => 'text',
			'section' => 'general'
		);
		
		$this->settings['col1cats'] = array(
			'title'   => __( 'Category(s) for Column 1' ),
			'desc'    => __( 'Add categories by number as described for the function <a href="http://codex.wordpress.org/Template_Tags/query_posts">query_posts()</a> (e.g., 2,6,17,38 or 12,-7),. Default is 2.<br/><em>Format: <strong>12,-7</strong> = include category number 12 and exclude category 7.</em>' ),
			'std'     => '6',
			'type'    => 'text',
			'section' => 'general'
		);
		
		$this->settings['col2cats'] = array(
			'title'   => __( 'Category(s) for Column 2' ),
			'desc'    => __( 'Add categories by number as described for the function <a href="http://codex.wordpress.org/Template_Tags/query_posts">query_posts()</a> (e.g., 2,6,17,38 or 12,-7),. Default is 8.<br/><em>Format: <strong>12,-3</strong> = include category number 12 and exclude category 7.</em>' ),
			'std'     => '8',
			'type'    => 'text',
			'section' => 'general'
		);
		
		
/* Appearance
 */		
		$this->settings['bodyfontsize'] = array(
			'section' => 'appearance',
			'title'   => __( 'Body text font size' ),
			'desc'    => __( 'The base font size globally affects all font sizes throughout your blog. This can be in any unit (e.g., px, pt, em), but I suggest using a percentage (%). Default is 75%.<br/><em>Format: <strong>Xy</strong> where X = a number and y = its units.</em>' ),
			'type'    => 'text',
			'std'     => '75%'
		);
		
		$this->settings['bodyfontfamily'] = array(
			'section' => 'appearance',
			'title'   => __( 'Body font family' ),
			'desc'    => __( 'Select a font family. Note: <em>Fallbacks are in parenthesis, e.g.; (Georgia).</em>' ),
			'type'    => 'radio',
			'std'     => 'verdana, geneva, sans-serif',
			'choices' => array(
				'verdana, geneva, sans-serif' => 'Verdana (Georgia)',
				'times new roman, times, serif' => 'Times New Roman (Serif)',
				'arial, helvetica, sans-serif' => 'Arial (Helvetica)'
			)
		);
		
		$this->settings['headerfontfamily'] = array(
			'section' => 'appearance',
			'title'   => __( 'Header font family' ),
			'desc'    => __( 'This selects the font for headings (h1, h2, h3, etc.) and other elements throughout your blog. Note: <em>Fallbacks are in parenthesis, e.g.; (Georgia).</em>' ),
			'type'    => 'radio',
			'std'     => 'verdana, geneva, sans-serif',
			'choices' => array(
				'verdana, geneva, sans-serif' => 'Verdana (Georgia)',
				'times new roman, times, serif' => 'Times New Roman (Serif)',
				'arial, helvetica, sans-serif' => 'Arial (Helvetica)'
			)
		);
		
		$this->settings['postentryalignment'] = array(
			'section' => 'appearance',
			'title'   => __( 'Text alignment in posts' ),
			'desc'    => __( 'Choose one for the text alignment of the post body text. Default is justified.' ),
			'std'     => 'justified',
			'type'    => 'radio',
			'choices' => array(
				'justified' => 'Justified',
				'left' => 'Left',
				'right' => 'Right'
			)
		);
		
		$this->settings['wrapperwidth'] = array(
			'section' => 'appearance',
			'title'   => __( 'Layout Width' ),
			'desc'    => __( 'Set the overall width of content in the browser window. This can be in any unit (e.g., px, pt, em), but I suggest using % for a fluid layout. Default is 90%.<br /><em>Format: <strong>Xy</strong> where X = a number and y = its units.</em>' ),
			'std'     => '90%',
			'type'    => 'text'
		);
		
		$this->settings['sidebaraddin'] = array(
			'section' => 'appearance',
			'title'   => __( 'Display the additional text in sidebar content' ),
			'desc'    => __( 'If checked, the sidebar content below will appear in the sidebar throughout the blog, except on single post pages. Default is unchecked.' ),
			'type'    => 'checkbox',
			'std'     => 0
		);
		
		$this->settings['sidebartext'] = array(
			'section' => 'appearance',
			'title'   => __( 'Additional text for sidebar (bottom of sidebar)' ),
			'desc'    => __( 'Add/edit content for the sidebar section. This text must be parsed in HTML tags. You can use HTML, but beware of special characters: i.e., &amp; = <code>&amp;amp;</code>. Remember that this text <em>will not appear</em> unless "Sidebar Add-in" is checked above. Default is <em>Thanks for visiting!</em>' ),
			'std'     => 'Thanks for visiting!',
			'type'    => 'textarea'
		);
		
		$this->settings['footeraddin'] = array(
			'section' => 'appearance',
			'title'   => __( 'Display the additional text in footer content' ),
			'desc'    => __( 'If checked, the footer content below will appear in the footer throughout the blog. Default is unchecked.' ),
			'type'    => 'checkbox',
			'std'     => 0
		);
		
		$this->settings['footertext'] = array(
			'section' => 'appearance',
			'title'   => __( 'Additional text for footer (bottom)' ),
			'desc'    => __( 'This text is placed within <code>&lt;p&gt;...&lt;/p&gt;</code> tags. Beware of special characters: i.e., &amp; = <code>&amp;amp;</code>. Remember that this text <em>will not appear</em> unless "Footer Add-in" is checked above. Default is <em>Hope your day is just smashing!</em>' ),
			'std'     => 'Hope your day is just smashing!',
			'type'    => 'textarea'
		);
		
		$this->settings['favicon'] = array(
			'section' => 'appearance',
			'title'   => __( 'Favicon' ),
			'desc'    => __( 'Enter the URL to your custom favicon. It should be 16x16 pixels in size.' ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['custom_css'] = array(
			'section' => 'appearance',
			'title'   => __( 'Custom Styles' ),
			'desc'    => __( 'Enter any custom CSS here to apply it to your theme.' ),
			'std'     => '',
			'type'    => 'textarea',
			'class'   => 'code'
		);
				
/* Reset corporateslave options
 */		
		$this->settings['reset_theme'] = array(
			'section' => 'reset',
			'title'   => __( 'Reset theme' ),
			'type'    => 'checkbox',
			'std'     => 0,
			'class'   => 'warning',
			'desc'    => __( 'Check this box and click "Save Changes" below to reset theme options to their defaults.' )
		);
		
	}
	
	public function initialize_settings() {
		
		$default_settings = array();
		foreach ( $this->settings as $id => $setting ) {
			if ( $setting['type'] != 'heading' )
				$default_settings[$id] = $setting['std'];
		}
		
		update_option( 'corporateslave_options', $default_settings );
		
	}

	public function register_settings() {
		
		register_setting( 'corporateslave_options', 'corporateslave_options', array ( &$this, 'validate_settings' ) );
		
		foreach ( $this->sections as $slug => $title ) {
			if ( $slug == 'about' )
				add_settings_section( $slug, $title, array( &$this, 'display_about_section' ), 'corporateslave-options' );
			else
				add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'corporateslave-options' );
		}
		
		$this->get_settings();
		
		foreach ( $this->settings as $id => $setting ) {
			$setting['id'] = $id;
			$this->create_setting( $setting );
		}
		
	}

	public function scripts() {
		
		wp_print_scripts( 'jquery-ui-tabs' );
		
	}
	
	public function styles() {
		
		wp_register_style( 'corporateslave-admin', get_template_directory_uri() . '/corporateslave-options.css' );
		wp_enqueue_style( 'corporateslave-admin' );
		
	}

	public function validate_settings( $input ) {
		
		if ( ! isset( $input['reset_theme'] ) ) {
			$options = get_option( 'corporateslave_options' );
			
			foreach ( $this->checkboxes as $id ) {
				if ( isset( $options[$id] ) && ! isset( $input[$id] ) )
					unset( $options[$id] );
			}
			
			return $input;
		}
		return false;
		
	}
	
}

$theme_options = new Corporate_Slave_Options();


/*
Plugin Name: Hot Dates
Plugin URI: http://www.supriyadisw.net/2006/07/hot-dates
Description: Adds a little date blocks on wordpress.
Version: 1.0
Author: Supriyadi Slamet Widodo
Author URI: http://www.supriyadisw.net
*/
function show_hot_dates_head_content($param) {
  if (is_single()) echo'<style type="text/css">@import url(' . get_stylesheet_directory_uri() . '/hotDates.css);</style>';
  return $param;
  }
add_action('wp_head', 'show_hot_dates_head_content');

function hotDates() { 
  echo '<div class="dateblock">';
  echo '<div class="month">';
  the_time('M');
  echo '</div>';
/*  echo '<div class="year">';
  the_time('Y');
  echo '</div>'; */
  echo '<div class="day">';
  the_time('j');
  echo '</div></div>';
 }
/*
	End of Plugin Name: Hot Dates
*/

function email_immunizer($text) {
	return preg_replace('%((mailto:)?([\w\d][\w\d$.-]*[\w\d]@[\w\d][\w\d.-]*[\w\d]\.[a-z0-9]{2,5}))%ie', 'antispambot(\'$1\')', $text);
}

add_filter('the_author_email', 'email_immunizer', 9);
add_filter('the_content', 'email_immunizer', 9);
add_filter('the_excerpt', 'email_immunizer', 9);

add_filter('comment_author_email', 'email_immunizer', 9);
add_filter('comment_text', 'email_immunizer', 9);
add_filter('comment_excerpt', 'email_immunizer', 9);

add_filter('the_content_rss', 'email_immunizer', 9);
add_filter('the_excerpt_rss', 'email_immunizer', 9);
add_filter('comment_text_rss', 'email_immunizer', 9);


/* Call sidebar/menus
 */
 
if( function_exists('register_sidebar') ) {
	register_sidebar( array (
		'name' => 'Main Sidebar',
	) );
}

function register_corporateslave_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'corporateslave','Primary Menu' ),
      'extra-menu' => __( 'corporateslave','Bottom Menu' )
    )
  );
}
add_action( 'init', 'register_corporateslave_menus' );

/* corporateslave search
 */
 
function widget_corporateslave_search() {
?>
<li id="search">
	<h2><label for="s">Search</label></h2>
	<form id="searchform" method="get" action="<?php echo home_url(); ?>/">
		<div>
			<input id="s" name="s" type="text" value="<?php echo esc_html($s, 1); ?>" tabindex="1" size="10" />
			<br/>
			<input id="searchsubmit" name="searchsubmit" type="submit" value="Find" tabindex="2" />
		</div>
	</form> 
</li>
<?php
}
if ( function_exists('register_sidebar_widget') )
    wp_register_sidebar_widget(__('Search','corporateslave'), 'widget_corporateslave_search','');

function corporateslave_option( $option ) {
	$options = get_option( 'corporateslave_options' );
	if ( isset( $options[$option] ) )
		return $options[$option];
	else
		return false;
}
?>