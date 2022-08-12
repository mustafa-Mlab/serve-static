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
  $submenu[] = add_submenu_page(
    'sarve-static/options-settings.php',
    __( 'Update Repo', 'serve_static' ),
    __( 'Update Repo', 'serve_static' ),
    'manage_options',
    'serve-static/update-repo.php',
    'nss_update_repo',
    6
  );
}
add_action( 'admin_menu', 'serve_static_add_settings_page' );


function nss_add_settings_page(){
require_once('admin/gui/settings.php');
}


function nss_build_site(){
require_once('admin/gui/build_site.php');
}


function nss_update_repo(){
require_once('admin/gui/update_repo.php');
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


function nss_build_page($url = NULL , $home = NULL ){
  $localServer = get_option('local-server-address', '');
  $cliFlag = 0;
  $subfoldername = get_option('subfolder-name',  '' );
  if($url == NULL || $home == NULL ){
    $mainURL = $_POST['mainurl'];
    $homeURL = $_POST['homeurl'];
  }else{
    $mainURL = $url;
    $homeURL = $home;
    $cliFlag = 1;
  }

  $pageFlag = 0;
  $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => 'img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist')]; 
  $html = file_get_contents( $mainURL);

  $stringToReplace = [
    '<link rel="stylesheet" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/style.css">',
    '<link rel="icon" type="image/ico" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/public/images/favicon.ico">',
    '<link rel="icon" type="image/png" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/public/images/favicon.png">',
    '<link rel="apple-touch-icon" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/public/images/apple-touch-icon.png">',
    '<link rel="https://api.w.org/" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/" />',
    '<link rel="alternate" type="application/json" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/wp/v2/pages/2151" />',
    '<link rel="canonical" href="https://dev-test.monstar-lab.com/bd/bd-admin/" />',
    '<link rel=\'shortlink\' href=\'https://dev-test.monstar-lab.com/bd/bd-admin/\' />',
    '<link rel="alternate" type="application/json+oembed" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fdev-test.monstar-lab.com%2Fbd%2Fbd-admin%2F" />',
    '<link rel="alternate" type="text/xml+oembed" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fdev-test.monstar-lab.com%2Fbd%2Fbd-admin%2F&#038;format=xml" />',
    '<script type=\'text/javascript\' src=\'https://dev-test.monstar-lab.com/bd/bd-admin/wp-includes/js/jquery/jquery.min.js\' id=\'jquery-core-js\'></script>',
    "<script type='text/javascript' src='https://dev-test.monstar-lab.com/bd/bd-admin/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>",
    '/(<style id=\'global-styles-inline-css\' type=\'text\/css\'>)*(^<\/style>)/m'
  ];

  $stringToReplaceWith = [
    '',
    '',
    '<link rel="icon" type="image/png" href="https://dev-bd-website.s3.ap-northeast-1.amazonaws.com/bd/bd-admin/assets/uploads/2022/07/favicon.png">',
    '<link rel="apple-touch-icon" href="https://dev-bd-website.s3.ap-northeast-1.amazonaws.com/bd/bd-admin/assets/uploads/2022/07/apple-touch-icon.png">',
    '',
    '',
    '',
    '',
    '',
    '',
    '<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>',
    '<script type=\'text/javascript\' src=\'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.0/jquery-migrate.min.js\' ></script>',
    ''
  ];

  $html = str_replace($stringToReplace, $stringToReplaceWith, $html);

  /* Firstly make the folder to write a file */
  $url = substr_replace(substr(parse_url($mainURL)['path'], 1), "", -1) ;
  $subURL = str_replace($homeURL,"", $url);
  $subURL2 = str_replace($subfoldername ."/","", $subURL);
  if($subURL2 === $subfoldername){
    $subURL2 = '';
  }
  $paths = explode('/', $subURL2);
  $localwslash = ($filestructures['localfolder'] == '')? '' : $filestructures['localfolder'] . '/';
  $thisPath = $filestructures['root'] . $localwslash;
  foreach($paths as $key => $path ){
    $filename = $thisPath . $path . '/';
    if (!file_exists($filename)) {
      mkdir( $thisPath .  $path, 0777);
//      echo "The directory ". $path . " was successfully created.<br>";
    } else {
//      echo "The directory ". $path . " exists.<br>";
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

  $myfile = fopen($thisPath . "index.html", "w") or die("Unable to open file!");
  fwrite($myfile, $html);
  fclose($myfile);
  //echo $thisPath .'index.html' ;

  if($pageFlag == 1){
    nss_build_paged_metarial( $pageURL, $prev_page, $homeURL , $subfoldername, $cliFlag );
  }
  if(! $cliFlag) exit();
}

add_action( 'wp_ajax_build_page', 'nss_build_page' );
add_action( 'wp_ajax_nopriv_build_page', 'nss_build_page' );


function nss_build_paged_metarial($url, $prev_page = 0, $homeURL , $subfoldername, $cliFlag ){
  $localServer = get_option('local-server-address', '');
  $mainURL = $url;
  $pageFlag = 0;
  $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => 'img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist')]; 
  $html = file_get_contents( $mainURL);
  /* Firstly make the folder to write a file */

  $stringToReplace = [
    '<link rel="stylesheet" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/style.css">',
    '<link rel="icon" type="image/ico" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/public/images/favicon.ico">',
    '<link rel="icon" type="image/png" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/public/images/favicon.png">',
    '<link rel="apple-touch-icon" href="https://dev-test.monstar-lab.com/bd/bd-admin/assets/themes/monstar_lab/public/images/apple-touch-icon.png">',
    '<link rel="https://api.w.org/" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/" />',
    '<link rel="alternate" type="application/json" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/wp/v2/pages/2151" />',
    '<link rel="canonical" href="https://dev-test.monstar-lab.com/bd/bd-admin/" />',
    '<link rel=\'shortlink\' href=\'https://dev-test.monstar-lab.com/bd/bd-admin/\' />',
    '<link rel="alternate" type="application/json+oembed" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fdev-test.monstar-lab.com%2Fbd%2Fbd-admin%2F" />',
    '<link rel="alternate" type="text/xml+oembed" href="https://dev-test.monstar-lab.com/bd/bd-admin/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fdev-test.monstar-lab.com%2Fbd%2Fbd-admin%2F&#038;format=xml" />',
    '<script type=\'text/javascript\' src=\'https://dev-test.monstar-lab.com/bd/bd-admin/wp-includes/js/jquery/jquery.min.js\' id=\'jquery-core-js\'></script>',
    "<script type='text/javascript' src='https://dev-test.monstar-lab.com/bd/bd-admin/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>",
    '/(<style id=\'global-styles-inline-css\' type=\'text\/css\'>)*(^<\/style>)/m'
  ];

  $stringToReplaceWith = [
    '',
    '',
    '<link rel="icon" type="image/png" href="https://dev-bd-website.s3.ap-northeast-1.amazonaws.com/bd/bd-admin/assets/uploads/2022/07/favicon.png">',
    '<link rel="apple-touch-icon" href="https://dev-bd-website.s3.ap-northeast-1.amazonaws.com/bd/bd-admin/assets/uploads/2022/07/apple-touch-icon.png">',
    '',
    '',
    '',
    '',
    '',
    '',
    '<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>',
    '<script type=\'text/javascript\' src=\'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.0/jquery-migrate.min.js\' ></script>',
    ''
  ];

  $html = str_replace($stringToReplace, $stringToReplaceWith, $html);

  $url = substr_replace(substr(parse_url($mainURL)['path'], 1), "", -1) ;
  $subURL = str_replace($homeURL,"", $url);
  $subURL2 = str_replace($subfoldername ."/","", $subURL);
  $paths = explode('/', $subURL2);
  $localwslash = ($filestructures['localfolder'] == '')? '' : $filestructures['localfolder'] . '/';
  $thisPath = $filestructures['root'] . $localwslash;

  foreach($paths as $key => $path ){
    $filename = $thisPath . $path . '/';
    if (!file_exists($filename)) {
      mkdir( $thisPath .  $path, 0777);
//      echo "The directory ". $path . " was successfully created.<br>";
    } else {
 //     echo "The directory ". $path . " exists.<br>";
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
//  echo $thisPath .'index.html' ;
  if($pageFlag  == 1){
    nss_build_paged_metarial( $pageURL, $prev_page, $homeURL , $subfoldername, $cliFlag );
  }
  if(! $cliFlag) exit();
}



function updateGithubRepo(){
  $a='/home/ubuntu';
  chdir($a);
  $output = shell_exec("sh static-process.sh 2>&1");
  echo "<pre>$output</pre>";
  return json_encode($output);
}


add_action( 'wp_ajax_updateGithubRepo', 'updateGithubRepo' );
add_action( 'wp_ajax_nopriv_updateGithubRepo', 'updateGithubRepo' );



/*  DISABLE GUTENBERG STYLE IN HEADER| WordPress 5.9 */
function nss_deregister_styles() {
  wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'nss_deregister_styles', 100 );


class SERVESTATIC_CLI {

	/**
	 * Returns 'Build Static Site'
	 *
	 * @since  1.0.0
	 * @author Mustafa Kamal Hossain
	 */
	public function build() {
		WP_CLI::line( 'Starting Genaretion of static content' );
    $homeURL = home_url();
    $post_types = get_option( 'static_post_types', '' );
    $postTypes = explode(',', $post_types);
    $posts = get_posts([
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post_type' => $postTypes,
    ]);
    
    $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => '-img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist' )];
    $localFolderPath = explode('/', $filestructures['localfolder']);
    $root = $filestructures['root'];
    foreach( $localFolderPath as $id => $folder){
      if (file_exists($root . $folder)) {
        echo "The directory ".$folder . " exists.<br>";
      } else {
        WP_CLI::line($folder);
        mkdir($root .  $folder, 0777);
        echo "The directory ".$folder . " was successfully created.<br>";
      }
      $root = $root . $folder . '/';
    }
    $assoc_args = [$homeURL];
    $this->generate_posts_progress_bar($posts, $assoc_args);
	}

  /**
 * Displays progress bar to demonstrate progression through a time consuming process.
 *
 * @param Array $args Arguments in array format.
 * @param Array $assoc_args Key value arguments stored in associated array format.
 * @since 1.0.0
 * @author Mustafa Kamal Hossain
 */
public function generate_posts_progress_bar( $args= [], $assoc_args = [] ) {
  $desired_posts_to_generate = count($args);
  $progress = \WP_CLI\Utils\make_progress_bar( 'Generating Content', $desired_posts_to_generate );
  foreach( $args as $key=> $value){
    $link = get_permalink($value);
 //   WP_CLI::line( $value->post_title );
    nss_build_page($link, $assoc_args[0]);
    $progress->tick();
  }

  $progress->finish();
  WP_CLI::success("Content Genaration has Completed, Thanks for being Patients");
  updateGithubRepo();
  }

}

/**
 * Registers our command when cli get's initialized.
 *
 * @since  1.0.0
 * @author Mustafa Kamal
 */
function static_cli_register_commands() {
	WP_CLI::add_command( 'static', 'SERVESTATIC_CLI' );
}

add_action( 'cli_init', 'static_cli_register_commands' );


function make_static_using_CLI($post_id, $post, $update)  {
  //static-build.sh
  // $a='/home/ubuntu';
  // chdir($a);
  // $output = [];
  // $output["shell"] = shell_exec("sh static-build.sh 2>&1");
  // $output["exec"] = exec( "sudo wp static build --allow-root");
  // return json_encode($output);

  $homeURL = home_url();
  $post_types = get_option( 'static_post_types', '' );
  $postTypes = explode(',', $post_types);
  $posts = get_posts([
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'post_type' => $postTypes,
  ]);
  
  $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => 'img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist' )];
  $localFolderPath = explode('/', $filestructures['localfolder']);
  $root = $filestructures['root'];
  foreach( $localFolderPath as $id => $folder){
    if (file_exists($root . $folder)) {
    } else {
      mkdir($root .  $folder, 0777);
    }
    $root = $root . $folder . '/';
  }
  
  foreach( $posts as $key=> $value){
    $link = get_permalink($value);
    nss_build_page($link,$homeURL);
  }
  updateGithubRepo();
}

//add_action('save_post', 'make_static_using_CLI', 30,3);


function make_static_using_CLI2()  {
  $a='/var/www/html/bd/bd-admin';
  chdir($a);
  $output = [];
  //$output["shell"] = shell_exec("sh static-build.sh 2>&1");
  $output["shell"] = shell_exec("wp static build");
  //$output["exec"] = exec( "sudo wp static build --allow-root");
  //updateGithubRepo();
  return json_encode($output);
}
