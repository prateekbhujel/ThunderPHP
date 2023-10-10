<?php


add_action('controller', function() {
	
	dd($_POST);

});

add_action('after_view', function() {

	echo "<center><div style='color: brown; background-color: #dddd'>Website Copyright &#169 2023 </div></center>";
});

add_action('view', function() {
	echo"<form method='post' style='width:400px; margin: auto; text-align:center; margin-top:50px'>

			<input placeholder='email'/><br>
			<input placeholder='password'/><br><br>
			<button>Login</button>
		</form>";
});

add_action('before_view', function() {

	echo "<center><div><a href=''>Home</a> | About Us | Contact Us</div></center>";
});


