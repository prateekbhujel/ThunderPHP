<?php


add_action('controller', function() {



});

add_action('before_view', function() {

	require plugin_path('includes\header.view.php');
});


add_action('view', function() {
	
	$limit  = 10;
	$pager  = new \Core\Pager($limit, 2);
	$offset = $pager->offset;
	$pager->display();

});


add_action('after_view', function() {

	require plugin_path('includes/footer.view.php');
});



