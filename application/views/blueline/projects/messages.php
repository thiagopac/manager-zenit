
<div id="main">
<div id="options">
			<a href="<?=base_url()?>projects/update/<?=$project->id;?>" class="btn" data-toggle="modal"><?=$this->lang->line('application_edit_project');?>Edit Project</a>
			<a href="<?=base_url()?>projects/create" class="btn" data-toggle="modal"><?=$this->lang->line('application_upload_media');?>Upload Media</a>
			<a href="<?=base_url()?>projects/tracking/<?=$project->id;?>" class="icon_clock"><?php if(empty($project->tracking)){ echo "Start";}else {echo "Stop";} ?> Tracking</a>
			
		</div>

		<div class="col1">
		<div class="table_head"><h6>Project Details</h6></div>
		<div class="subcont">
		<ul><li><span>Project ID:</span> <?=$project->reference;?></li>
		<li><span>Project Name:</span> <?=$project->name;?></li>
		<li><span>Client:</span> <a href="<?=base_url()?>clients/view/<?=$project->client->id;?>"><?=$project->company->name;?></a></li>
		<li><span>Start Date:</span> <?=$project->start;?></li>
		<li><span>Deadline:</span> <?=$project->end;?></li>
		</ul>
		</div>
	 	</div>	
	 	<div class="col2">
		<div class="table_head"><h6>Timer</h6></div>
		<div class="subcont">
		<ul><li><span>Time spent:</span> <?=$time_spent;?></li>
		<li><span>Project Name:</span> <?=$project->name;?></li>
		<li><span>Client:</span> <a href="<?=base_url()?>clients/view/<?=$project->client->id;?>"><?=$project->company->name;?></a></li>
		<li><span>Start Date:</span> <?=$project->start;?></li>
		<li><span>Deadline:</span> <?=$project->end;?></li>
		</ul>
		</div>
	 	</div>
	 	<br clear="both"><br>
		<div class="table_head"><img src="<?=base_url()?>assets/img/tasks.png"><h6>Tasks</h6></div>
		<div>test</div>
		<br clear="both"><br>
	 	<div class="table_head"><img src="<?=base_url()?>assets/img/tasks.png"><h6>Tasks</h6></div>
		<table class="data" id="tasks" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="5%"></th>
			<th>Name</th>
			<th>Action</th>
		</thead>
		<?php foreach ($project->project_has_tasks as $value):?>

		<tr id="<?=$value->id;?>" class="done">
			<td><?=$value->status;?></td>
			<td><?=$value->name;?></td>
			<td class="option">
				<a href="<?=base_url()?>projects/delete/<?=$value->id;?>" rel="<?=$value->name;?>" class="delete confirm">Delete</a>
				<a href="<?=base_url()?>projects/update/<?=$value->id;?>" class="edit" data-toggle="modal">Edit</a>
			</td>
		</tr>

		<?php endforeach;?>
		<?php if($project->project_has_tasks == NULL){ echo '<tr class="noborder"><td width="120px"> No Tasks yet</td><td></td><td ></td><td ></td><td ></td></tr>';}?>
	 	</table>
	 	<br clear="all">

	</div>