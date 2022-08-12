<?php 
  /* Check is diirectory exist otherwise create your own directories */
  
  $filestructures =['root'=> get_option('static_path',  ABSPATH ), 'asset' => 'img', 'styles'=> 'css', 'js' => 'js', 'localfolder' => get_option( 'localfolder', 'dist' )];
  $localFolderPath = explode('/', $filestructures['localfolder']);
  $root = $filestructures['root'];
  foreach( $localFolderPath as $id => $folder){
    if (file_exists($root . $folder)) {
      echo "The directory ".$folder . " exists.<br>";
    } else {
      mkdir($root .  $folder, 0777);
      echo "The directory ".$folder . " was successfully created.<br>";
    }
    $root = $root . $folder . '/';
  }
  $subFolderName = get_option('subfolder-name',  '' );
  $allUrls = [];
  $homeURL = home_url();
  $post_types = get_option( 'static_post_types', '' );
  $postTypes = explode(',', $post_types);
  $posts = get_posts([
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post_type' => $postTypes,
      ]);
  foreach($posts as $key => $post){
   array_push($allUrls , get_permalink($post) );
  }
  $terms = get_terms('ml-expertinsights-category', ['hide_empty' => true]);
  foreach($terms as $key => $value){
    array_push($allUrls , get_category_link($value) );
  }
?>

<div class="wrap">
  <h1 class="wp-heading-inline">Build Static Site</h1>
  <br><br>
  <hr class="wp-header-end">

  <div class="form">
  <div class="progress-report">
  <ul></ul>
  </div>
    <form action="#" id="server_static_builder" name="server_static_builder" method="post">
      <input type="hidden" name="allurl" id="allurl" value='<?= json_encode($allUrls);?>'>
      <input type="text" name="localfolder" id="localfolder" value='<?= get_option('localfolder',  'dist' );?>'>
      <input type="hidden" name="homeurl" id="homeurl" value="<?= $homeURL;?>">
      <input type="hidden" name="subfoldername" id="subfoldername" value="<?= $subFolderName;?>">
      <input type="text" name="post_types" id="post_types" value="<?= $post_types; ?>" size="150">
      <input type="submit" value="Build" name="submit" style="position: fixed; bottom: 50px; right: 2%;">
    </form>

  </div>
</div>
