<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('facebook.php');

  $config = array(
    'appId' => '654113804625150',
    'secret' => 'd1c769373a57894865dec1b84d16cfcd',
    'fileUpload' => true,
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();

  $photo =get_field('image'); // Path to the photo on the local filesystem
if ($user_id) {

} else {
    $loginUrl = $facebook->getLoginUrl();
    header('Location:' . $loginUrl . '&scope=user_photos,publish_stream');
}
?>


  <?php
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        // Upload to a user's profile. The photo will be in the
        // first album in the profile. You can also upload to
        // a specific album by using /ALBUM_ID as the path 
		$message= 'Test';
        $args = array('message' => $message);
                copy($photo, 'tmp/file.jpg');
                $args['image'] = '@' . realpath('tmp/file.jpg');
                $data = $facebook->api('/me/photos', 'post', $args);
                unlink('tmp/file.jpg');
        //echo '<pre>Photo ID: ' . $ret_obj['id'] . '</pre>';
        //echo '<br /><a href="' . $facebook->getLogoutUrl() . '">logout</a>';
      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
		//$loginUrl = $facebook->getLoginUrl();
        //header('Location:' . $loginUrl . '&scope=user_photos,publish_stream');
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

      // No user, print a link for the user to login
      // To upload a photo to a user's wall, we need photo_upload  permission
      // We'll use the current URL as the redirect_uri, so we don't
      // need to specify it here.
	 // $loginUrl = $facebook->getLoginUrl();
     // header('Location:' . $loginUrl . '&scope=user_photos,publish_stream');

    }

  ?>

