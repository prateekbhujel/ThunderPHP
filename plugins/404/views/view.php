<link rel="stylesheet" type="text/css" href="<?=plugin_http_path('assets/css/style.css')?>">

<div class="col-md-10 mx-auto p-4">
	<center>
		<h1>Page Not Found</h1>
		<div class="fst-italic">Sorry, the page you are looking for could not be found.</div>

		<form class="input-group my-3 mx-auto" style="max-width: 500px;" autocomplete="off">
			<input type="text" class="form-control" placeholder="Search" value="<?= old_value('find', '', 'get'); ?>" name="find" autofocus="true">
			<button class="input-group-text bg-primary text-white" id=basic-addon1>
				search
			</button>
		</form>

		<?php if(empty($_GET['find'])):?>
			<img src="<?=plugin_http_path('assets/images/404.jpg')?>" style="width: 100%;max-width: 500px;">
		<?php else:?>

			<?php if(!empty($results)):?>
				<div>
					<?php do_action(plugin_id() .'_display_search_results',$results)?>
				</div>
			<?php else:?>
				<div>No results found!</div>
			<?php endif?>
		<?php endif?>
	</center>
</div>


<script src="<?=plugin_http_path('assets/js/plugin.js')?>"></script>