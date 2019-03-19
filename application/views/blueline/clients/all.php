<div class="col-sm-12  col-md-12 main">
		<div class="row">
			<a href="<?=base_url()?>clients/company/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_new_company');?></a>
		</div>
		<div class="row">
		<div class="box-shadow">
		<div class="table-head"> <?=$this->lang->line('application_companies');?></div>
		<div class="table-div">
		<table class="data table" id="clients" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>

			<th class="hidden-xs" style="width:70px"><?=$this->lang->line('application_company_id');?></th>
			<th><?=$this->lang->line('application_company_name');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_primary_contact');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_email');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_city');?>/<?=$this->lang->line('application_province');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($companies as $value):?>

		<tr  id="<?=$value->id;?>" ><td class="hidden-xs" style="width:70px"><?=$core_settings->company_prefix;?><?php if (isset($value->reference)) {
    echo $value->reference;
} ?></td>

			<td><span class="label label-info"><?php if (is_object($value)) {
    echo $value->name;
} else {
    echo $this->lang->line('application_no_company_assigned');
}?></span></td>
			<td class="hidden-xs"><?php if (is_object($value->client)) {
    echo $value->client->firstname . ' ' . $value->client->lastname;
} else {
    echo $this->lang->line('application_no_contact_assigned');
} ?></td>
			<td class="hidden-xs"><?php if (is_object($value->client)) {
    echo $value->client->email;
} else {
    echo $this->lang->line('application_no_contact_assigned');
}?></td>
			<!-- <td class="hidden-xs"><?php echo $value->website = empty($value->website) ? '-' : '<a target="_blank" href="http://' . $value->website . '">' . $value->website . '</a>' ?></td> -->
			<td class="hidden-xs"><?php echo $value->city ?>/<?php echo $value->province ?></td>
			<td class="option" width="8%">
				        <button type="button" title="<?=$this->lang->line('application_delete'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/company/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
				        <a href="<?=base_url()?>clients/company/update/<?=$value->id;?>"  title="<?=$this->lang->line('application_edit_client'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			</td>
		</tr>
		<?php endforeach;?>
	 	</table>
	 	<br clear="all">

	</div>
</div>
