<?php

	require 'functions.php';

	$hero_titles = ['Home','Contact'];
	$hero_titles = do_filter('hero_titles',$hero_titles);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<style type="text/css">
		body{
			font-family: tahoma;
		}
	</style>

	<main style="max-width: 1000px;margin: auto;padding: 4px;">
		<h1>This is a plugin website</h1>
		<div style="display: flex;">
			<div style="flex: 4;background-color: #eee;">
				<div style="padding: 10px;">

					<?php foreach ($hero_titles as $title):?>
						<a href="" style="color:red"><?=$title?></a> | 
					<?php endforeach?>
					
				</div>
				<img src="images/image (3).jpg" style="max-width:100%;padding: 10px;">
			</div>
			<div style="flex: 1;background-color: #ddd;">
				<img src="images/image (1).jpg" style="max-width:100%">
				<img src="images/image (2).jpg" style="max-width:100%">
				<?php do_action('images_section') ?>
				<img src="images/image (5).jpg" style="max-width:100%">
				<img src="images/image (4).jpg" style="max-width:100%">
			</div>
		</div>
	</main>
</body>
</html>