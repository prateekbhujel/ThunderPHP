<?php

use \Core\Database;

$image = new \Core\Image;
copy('image.jpg', 'image_resized.jpg');

$image->resize('image_resized.jpg');

add_action('view', function() {
	
	dd(get_value());
});


add_action('controller', function() {
	
	$arr = ['name'=>'Pratik Bhujel', 'age'=>28];

	set_value($arr);

});

