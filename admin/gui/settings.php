<?php
 $checkboxArray = [];
 $flag = false;
 if( isset($_POST['list']) && !empty($_POST['checkboxArray']) && !empty($_POST['static_path'])){
   if( isset($_POST['subfolder-name']) && !empty( $_POST['subfolder-name'])){
    update_option('subfolder-name', $_POST['subfolder-name'], '' );
   }
   if( isset($_POST['localfolder']) && !empty( $_POST['localfolder'])){
    update_option('localfolder', $_POST['localfolder'], '' );
   }
   if( isset($_POST['local-server-address']) && !empty( $_POST['local-server-address'])){
    update_option('local-server-address', $_POST['local-server-address'], '' );
  }else{
     update_option('local-server-address', '', '' );
  }
   update_option('static_path', $_POST['static_path'], ABSPATH );
   update_option('make_static', (int)$_POST['static_status'], false);
   foreach($_POST['checkboxArray'] as $key => $value){
     array_push($checkboxArray, $value);
    }
    update_option('static_post_types', implode(',', $checkboxArray), true);
    $flag = true;
 }else{
   $checkboxArray = explode(',', get_option( 'static_post_types', [] )) ;
   $flag = true;
 }

?>
<div class="wrap">
  <h1 class="wp-heading-inline">SERVE STATIC SETTINGS</h1>
  <br><br>
  <hr class="wp-header-end" />
</div>
<?php 
 
  $post_types = get_post_types( Array( 'public' => true ) );
  unset($post_types['revision']);
  unset($post_types['nav_menu_item']);
  unset($post_types['custom_css']);
  unset($post_types['customize_changeset']);
  unset($post_types['oembed_cache']);
  unset($post_types['user_request']);
  unset($post_types['attachment']);
  unset($post_types['wp_global_styles']);
  unset($post_types['wp_navigation']);
  if($post_types){ ?>
    <div class="form">
      <form action="#" name="list_form" method="post">
      <!--  -->
      <label for="status">Function Status </label>
      <select name="static_status" id="static_status">
        <option value="1" <?= (get_option('make_static', false) )? 'selected':''; ?> >Enable</option>
        <option value="0"<?= (get_option('make_static', false) )? '':'selected'; ?>>Disable</option>
      </select>
      <br><br>
      <label for="static_path">Path to store data</label>
      <input type="text" name="static_path" id="static_path" value="<?= get_option('static_path',  ABSPATH );?>" size="200" /> dist/
      <br><br> 
      <label for="subfolder-name">Subfolder Name</label>
      <input type="text" name="subfolder-name" id="subfolder-name" value="<?= get_option('subfolder-name',  '' );?>" width="200" />
      <br><br> 
      <label for="localfolder">Local Folder</label>
      <input type="text" name="localfolder" id="localfolder" value="<?= get_option('localfolder',  'dist' );?>" width="200" />
      <br><br> 
      <label for="local-server-address">Local Server Address</label>
      <input type="text" name="local-server-address" id="local-server-address" value="<?= get_option('local-server-address', home_url(). 'dist') ;?>" size="200" />
      <br><br> 
        <?php foreach($post_types as $key => $post_type){ ?>
          <label> 
            <input type="checkbox" name="checkboxArray[]" class="postTypeInputBox" value="<?= $post_type; ?>" <?= ( $flag && in_array($post_type , $checkboxArray)) ? 'checked' :''; ?>>
            <?= ucfirst($post_type); ?>
          </label><br>  
        <?php } ?>
        <br><br>
        <input type="submit" value="Get Post Types List" name="list" >
      </form>
    <br>
    <br>
    </div>
    <?php
  }
?>