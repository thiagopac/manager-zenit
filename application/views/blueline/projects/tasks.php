
<div id="main">
<div id="options">
			<a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/add" class="btn" data-toggle="modal"><?=$this->lang->line('application_add_task');?></a>
		</div>
	 	<div class="table_head"><img src="<?=base_url()?>assets/img/tasks.png"><h6><?=$this->lang->line('application_tasks');?></h6></div>
		<table class="data" id="tasks" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="listicon"></th>
			<th><?=$this->lang->line('application_name');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($project->project_has_tasks as $value):?>

		<tr id="<?=$value->id;?>" class="<?=$value->status;?>">
			<td class="<?=$value->status;?>"></td>
			<td><?=$value->name;?></td>
			<td class="option">
				<a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/delete/<?=$value->id;?>" rel="<?=$value->name;?>" class="delete confirm"><?=$this->lang->line('application_delete');?></a>
				<a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/update/<?=$value->id;?>" class="edit" data-toggle="modal"><?=$this->lang->line('application_edit');?></a>
			</td>
			<td class="option btn-group">
				<a class="btn btn-mini po" rel="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>projects/tasks/<?=$project->id;?>/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon-trash"></i></a>
				<a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/update/<?=$value->id;?>" class="btn btn-mini" data-toggle="modal"><i class="icon-edit"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
		<?php if($project->project_has_tasks == NULL){ echo '<tr class="noborder"><td width="120px"> No Tasks yet</td><td></td><td ></td></tr>';}?>
	 	</table>
	 	<br clear="all">

	</div>