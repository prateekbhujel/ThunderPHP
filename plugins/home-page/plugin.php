<?php


dd(plugin_http_dir());

add_action('view', function() {

	dd("<span style='color: cyan;'>This is from the home-page plugin view hook<span>");
});

add_action('controller', function() {


});

