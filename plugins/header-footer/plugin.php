<?php

/**
 * Plugin name: Header and Footer
 * Author: Pratik Bhujel
 * Description: This plugin containes Heaader and footer page.
 * 
 **/


add_action('before_view',function(){

	$links 				 = [];

	$link 		 		= (object)[];
	$link->id 	 		= 0;
	$link->title 		= 'Home';
	$link->slug  		= 'home';
	$link->icon  		= '';
	$link->permission  	= '';
	$links[] 	 		= $link;

	$links = do_filter(plugin_id().'_before_menu_links', $links);

	require plugin_path('views/header.php');
});


add_action('after_view',function(){

	require plugin_path('views/footer.php');
});




