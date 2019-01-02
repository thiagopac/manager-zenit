<div id="main">
<div id="options">
			<a href="<?=base_url()?>cprojects/media/<?=$project->id;?>/add" class="btn" data-toggle="modal"><?=$this->lang->line('application_add_media');?></a>
		</div>
	 	<div class="table_head"><img src="<?=base_url()?>assets/img/media.png"><h6><?=$this->lang->line('application_media');?></h6></div>
		<table class="data" id="media" rel="<?=base_url()?>cprojects/media/<?=$project->id;?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="listicon"></th>
			<th><?=$this->lang->line('application_name');?></th>
			<th><?=$this->lang->line('application_filename');?></th>
			<th><?=$this->lang->line('application_description');?></th>
			<th><?=$this->lang->line('application_phase');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($project->project_has_files as $value):?>

		<tr id="<?=$value->id;?>">
			<td id="icon" class="<?php $type = explode('.', $value->filename); echo $type[1]; ?>"></td>
			<td><?=$value->name;?></td>
			<td><?=$value->filename;?></td>
			<td><?=$value->description;?></td>
			<td><?=$value->phase;?></td>
			<td class="option btn-group">
				<a class="btn btn-mini po" rel="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>cprojects/media/<?=$project->id;?>/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon-trash"></i></a>
				<a href="<?=base_url()?>cprojects/media/<?=$project->id;?>/update/<?=$value->id;?>" class="btn btn-mini" data-toggle="mainmodal"><i class="icon-edit"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	<br clear="all">

	</div>