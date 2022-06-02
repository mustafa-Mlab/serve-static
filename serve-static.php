<?php
/**
 * @link    http://mkhossain.com/development/plugins/serve-static
 * @package Serve Static
 * @since   1.0.0
 * @version 1.0.0
 * 
 * @wordpress-plugin
 * Plugin Name: Serve Static
 * Plugin URI: http://mkhossain.com/development/plugins/serve-static
 * Description: This plugin will help to make a static site using WordPress, in this way ther will be no server required at all, no RDS or Database. 
 * Author: MD Mustafa Kamal Hossain	
 * Version: 1.0.0
 * Author URI: http://mkhossain.com
 * Text Domain: serve_static
 * Domain Path: /languages
 */


 // Make sure we don't expose any info if called directly
if ( ! defined( 'ABSPATH' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}


// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

if ( ! defined( 'SERVE_STATIC_FILE' ) ) {
  define( 'SERVE_STATIC_FILE', __FILE__ );
}

if ( ! defined( 'SERVE_STATIC_PATH' ) ) {
  define( 'SERVE_STATIC_PATH', plugin_dir_path(SERVE_STATIC_FILE ));
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SERVE_STATIC_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/activator.php
 */
function activate_serve_static() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/activator.php';
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/deactivator.php
 */
function deactivate_serve_static() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deactivator.php';
}

register_activation_hook( __FILE__, 'activate_serve_static' );
register_deactivation_hook( __FILE__, 'deactivate_serve_static' );


/**
 * Register a custom menu page.
 */
function serve_static_add_settings_page() {
  add_menu_page(
      __( 'Serve Static', 'serve_static' ),
      'Serve Static Settings',
      'manage_options',
      'sarve-static/options-settings.php',
      'nss_add_settings_page',
      plugins_url( 'serve-static/images/icon.png' ),
      6
  );
  $submenu = [];
  $submenu[] = add_submenu_page(
    'sarve-static/options-settings.php',
    __( 'Build site', 'serve_static' ),
    __( 'Build site', 'serve_static' ),
    'manage_options',
    'serve-static/build-site.php',
    'nss_build_site',
    6
  );
  
  // $submenu[] = add_submenu_page(
  //   'wp-copier/options-settings.php',
  //   __( 'Content refactor', 'serve_static' ),
  //   __( 'Content refactor', 'serve_static' ),
  //   'manage_options',
  //   'wp-copier/content_replair.php',
  //   'nss_repair_content',
  //   7
  // );
}
add_action( 'admin_menu', 'serve_static_add_settings_page' );


function nss_add_settings_page(){
require_once('admin/gui/settings.php');
}


function nss_build_site(){
require_once('admin/gui/build_site.php');
}


function nss_repair_content(){
require_once('admin/gui/repair_content.php');
}


/**
 * Enqueue a script in the WordPress admin on copier page.
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function nss_add_custom_css_to_admin( $hook ) {
  if ( 'toplevel_page_sarve-static/options-settings' == $hook || 'serve-static-settings_page_serve-static/build-site' == $hook ) {
    
    wp_enqueue_script( 'server_static_custom_js', plugin_dir_url( __FILE__ ) . 'admin/assets/admin.js', array('jquery'), '1.0' );
    wp_localize_script(
      'server_static_custom_js',
      'ajax',
      array(
          'ajaxurl' => admin_url('admin-ajax.php')
      )
    );
    wp_enqueue_style( 'server_static_custom_css', plugin_dir_url( __FILE__ ) . 'admin/assets/admin.css', '', '1');
  }
}
add_action( 'admin_enqueue_scripts', 'nss_add_custom_css_to_admin' );


function nss_build_page(){
  $localServer = get_option('local-server-address', '');
  $mainURL = $_POST['mainurl'];
  $pageFlag = 0;
  $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => 'img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist')]; 
  $homeURL = $_POST['homeurl'];
  $subfoldername = $_POST['subfoldername'];
  $html = file_get_contents( $mainURL);
  /* Firstly make the folder to write a file */
  $url = substr_replace(substr(parse_url($mainURL)['path'], 1), "", -1) ;
  $subURL = str_replace($homeURL,"", $url);
  $subURL2 = str_replace($subfoldername ."/","", $subURL);
  if($subURL2 === $subfoldername){
    $subURL2 = '';
  }
  $paths = explode('/', $subURL2);
  $thisPath = $filestructures['root'] . $filestructures['localfolder'] . '/';
  foreach($paths as $key => $path ){
    $filename = $thisPath . $path . '/';
    if (!file_exists($filename)) {
      mkdir( $thisPath .  $path, 0777);
      echo "The directory ". $path . " was successfully created.<br>";
    } else {
      echo "The directory ". $path . " exists.<br>";
    }
    $thisPath = $thisPath . $path . '/';
  }

  $re = '/(<a\s[^>]*href\s*=\s*([\"\']?))*(?:\/page\/)([^\" >]*?)/Ui';
  preg_match_all($re, $html, $matches, PREG_SET_ORDER, 0);
  if( !empty($matches)){
    $pageFlag = 1;
    $matches = end($matches);
    $prev_page =  $matches[0];
    $pageURL = rtrim( preg_replace('/\/page\/\d+/', '', $mainURL, 1)  , '/') . $prev_page ;
  }else{
    $pageFlag = 0;
  }
  
  // $pattern = '/(<a\s[^>]*href\s*=\s*([\"\']?))(?:https:\/\/dev\-test.monstar\-lab.com\/bd)([^\" >]*?)/Ui';
  $rehome = str_replace("/","\/",$homeURL);
  $rehome = str_replace("-","\-",$rehome);
  $pattern = '/(<a\s[^>]*href\s*=\s*([\"\']?))(?:' . $rehome . ')([^\" >]*?)/Ui';
  // $html = preg_replace($pattern, '${1}http://cache-bd.localhost${3}', $html);
  $html = preg_replace($pattern, '${1}'. $localServer .'${3}', $html);
  /* Now write html in file */
  $myfile = fopen($thisPath . "index.html", "c") or die("Unable to open file!");
  fwrite($myfile, $html);
  fclose($myfile);
  echo $thisPath .'/index.html' ;

  if($pageFlag == 1){
    nss_build_paged_metarial( $pageURL, $prev_page, $homeURL , $subfoldername );
  }
  exit();
}

add_action( 'wp_ajax_build_page', 'nss_build_page' );
add_action( 'wp_ajax_nopriv_build_page', 'nss_build_page' );


function nss_build_paged_metarial($url, $prev_page = 0, $homeURL , $subfoldername ){
  $localServer = get_option('local-server-address', '');
  $mainURL = $url;
  $pageFlag = 0;
  $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => 'img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist')]; 
  $html = file_get_contents( $mainURL);
  /* Firstly make the folder to write a file */
  $url = substr_replace(substr(parse_url($mainURL)['path'], 1), "", -1) ;
  $subURL = str_replace($homeURL,"", $url);
  $subURL2 = str_replace($subfoldername ."/","", $subURL);
  $paths = explode('/', $subURL2);
  $thisPath = $filestructures['root'] . $filestructures['localfolder'] . '/';
  foreach($paths as $key => $path ){
    $filename = $thisPath . $path . '/';
    if (!file_exists($filename)) {
      mkdir( $thisPath .  $path, 0777);
      echo "The directory ". $path . " was successfully created.<br>";
    } else {
      echo "The directory ". $path . " exists.<br>";
    }
    $thisPath = $thisPath . $path . '/';
  }
  $re = '/(<a\s[^>]*href\s*=\s*([\"\']?))*(?:\/page\/)([^\" >]*?)/Ui';
  preg_match_all($re, $html, $matches, PREG_SET_ORDER, 0);
  if( !empty($matches)){
    $matches = end($matches);
    if($matches[0] !== $prev_page) {
      $pageFlag = 1;
      $pageURL = preg_replace('/\/page\/\d+/', '', $mainURL, 1) . $matches[0] ;
      $prev_page = $matches[0];
    }else{
      $pageFlag = 0;
    }
  }else{
    $pageFlag = 0;
  }
  /* Now grab the content from url */
  // $pattern = '/(<a\s[^>]*href\s*=\s*([\"\']?))(?:https:\/\/dev\-test.monstar\-lab.com\/bd)([^\" >]*?)/Ui';
  $rehome = str_replace("/","\/",$homeURL);
  $rehome = str_replace("-","\-",$rehome);
  $pattern = '/(<a\s[^>]*href\s*=\s*([\"\']?))(?:' . $rehome . ')([^\" >]*?)/Ui';

  // $html = preg_replace($pattern, '${1}http://cache-bd.localhost${3}', $html);
  $html = preg_replace($pattern, '${1}' . $localServer . '${3}', $html);
  /* Now write html in file */
  $myfile = fopen($thisPath . "index.html", "w") or die("Unable to open file!");
  fwrite($myfile, $html);
  fclose($myfile);
  echo $thisPath .'/index.html' ;
  if($pageFlag  == 1){
    nss_build_paged_metarial( $pageURL, $prev_page, $homeURL , $subfoldername );
  }
  exit();
}
