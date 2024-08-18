<div class="table table-responsive">
	<table class="table table-striped table-bordered">
		<tr>
			<th>S.N</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Image</th>
			<th>Gender</th>
			<th>Roles</th>
			<th>Created At</th>
			<th>Updated At</th>
			<th>
				<button class="btn btn-bd-primary btn-sm">
					<i class="fas fa-plus me-2"></i> Add new
				</button>
			</th>
		</tr>
		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<tr>	
					
					<td><?=esc($row->id)?></td>
					
					<td>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>" class="text-decoration-none text-info">
							<?=esc($row->first_name)?>
						</a>
					</td>
					
					<td>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>" class="text-decoration-none text-info">
							<?=esc($row->last_name)?>
						</a>	
					</td>
					
					<td>
						<img src="<?=get_image($row->image)?>" class="img-thumbnail" style="width:80px;height:80px;object-fit: cover;">
					</td>
					
					<td><?=esc(ucfirst($row->gender))?></td>
					
					<td>
						Roles
					</td>
					
					<td><?=get_date($row->date_created)?></td>
					
					<td><?=get_date($row->date_updated)?></td>
					
					<td>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>">
							<button class="btn btn-primary btn-sm">
								<i class="fas fa-eye me-2"></i>View
							</button>			
						</a>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
							<button class="btn btn-warning btn-sm">
								<i class="fas fa-pen-to-square me-2"></i>Edit
							</button>
						</a>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/delete/<?=$row->id?>">
							<button class="btn btn-danger btn-sm">
								<i class="fas fa-times me-2"></i>Delete
							</button>			
						</a>
					</td>
				</tr>
			<?php endforeach;?>
		<?php endif;?>
	</table>
</div>