<?php

add_action('view', function() {

	require plugin_path('includes/login.view.php');
});


add_action('controller', function() {

	$img = new \Core\Image;
	$img->getThumbnail('image.jpg', 200, 300);


});

