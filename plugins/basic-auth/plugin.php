<?php

use \Core\Database;

$image = new \Core\Image;
copy('image.jpg', 'image_cropped.jpg');

$image->crop('image_cropped.jpg', 100,1000);

$image->getThumbnail('image.jpg', 500, 400);

add_action('view', function() {
	
	dd(get_value());
});


add_action('controller', function() {
	
	$arr = ['name'=>'Pratik Bhujel', 'age'=>28];

	set_value($arr);

});

