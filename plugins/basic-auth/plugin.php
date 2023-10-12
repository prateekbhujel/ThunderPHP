<?php


add_action('view', function() {
	
	dd(get_value());
});


add_action('controller', function() {
	
	$arr = ['name'=>'Pratik Bhujel', 'age'=>28];

	set_value($arr);

});

