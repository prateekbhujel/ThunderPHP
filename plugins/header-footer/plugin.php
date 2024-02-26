<?php

/**
 * Plugin name: Header and Footer
 * Author: Pratik Bhujel
 * Description: This plugin containes Heaader and footer page.
 * 
 **/


add_action('before_view',function(){

	require plugin_path('views/header.php');
});


add_action('after_view',function(){

	require plugin_path('views/footer.php');
});




