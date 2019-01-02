	<div class="col-sm-12  col-md-12 main"> 
		<div class="row">
			<a href="<?=base_url()?>items/create_items" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_create_item');?></a>
		</div>
		<div class="row">
		<div class="box-shadow">
		<div class="table-head"> <?=$this->lang->line('application_items');?></div>
		<div class="table-div">
		<table class="data table" id="items" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th><?=$this->lang->line('application_name');?></th>
			<th><?=$this->lang->line('application_type');?></th>
			<th style="width:50px"><?=$this->lang->line('application_value');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($items as $value):?>

		<tr id="<?=$value->id;?>" >
			<td><?=$value->name;?></td>
			<td><?=$value->type;?></td>
			<td><?=$value->value;?></td>
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>items/delete_items/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
				        <a href="<?=base_url()?>items/update_items/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
		 </div>
		</div>
	 	</div>
	 	<br clear="all">
		
	</div>