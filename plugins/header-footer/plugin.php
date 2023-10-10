<?php


add_action('after_view', function() {

	echo "<center><div style='color: brown; background-color: #dddd'>Website Copyright &#169 2023 </div></center>";
});


add_action('before_view', function() {

	echo "<center><div><a href=''>Home</a> | About Us | Contact Us</div></center>";
});


