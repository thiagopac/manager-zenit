<div class="col-sm-12  col-md-12 main">  
	<div id="options" class="row">
			<a href="<?=base_url()?>quotations/quoteforms" class="btn btn-primary"><?=$this->lang->line('application_custom_quotation_forms');?></a>
			<div class="btn-group margintop5 pull-right nav-tabs" data-toggle="buttons-radio">
				<?php foreach ($submenu as $name => $value):?>
	                <a class="btn btn-primary" id="<?php $val_id = explode('/', $value); if (!is_numeric(end($val_id))) {
    echo end($val_id);
} else {
    $num = count($val_id) - 2;
    echo $val_id[$num];
} ?>" href="<?=site_url($value);?>"><?=$name?></a>
	            <?php endforeach;?>
	            
			</div>
			<script type="text/javascript">$(document).ready(function() { 
	            	$('.nav-tabs #<?php $last_uri = end(explode('/', uri_string())); if ($val_id[count($val_id) - 2] != 'filter') {
    echo end($val_id);
} else {
    echo $last_uri;
} ?>').button('toggle'); });
	        </script> 

		</div>
		<div class="row">
		<div class="box-shadow">	
		<div class="table-head"><?=$this->lang->line('application_quotations');?></div>
		<div class="table-div">
		<table class="table data" id="custom_quotations_requests" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="20px" class="hidden-xs"><?=$this->lang->line('application_quotation_id');?></th>
			<th><?=$this->lang->line('application_status');?></th>
			<th><?=$this->lang->line('application_quotation');?></th>
			<th><?=$this->lang->line('application_issue_date');?></th>
			<th><?=$this->lang->line('application_worker');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($quotations as $value):?>

		<tr id="<?=$value->id;?>" >
			<td class="hidden-xs"><?=$value->id;?></td>
			<td><span class="label <?php if ($value->status == 'New') {
    echo 'label-important';
} elseif ($value->status == 'Accepted') {
    echo 'label-success';
} elseif ($value->status == 'Reviewed') {
    echo 'label-warning';
} ?>"><?=$this->lang->line('application_' . $value->status);?></span></td>
			<td class="hidden-xs"><?php if (is_object($value->customquote)) {
    echo $value->customquote->name;
} else {
    echo '-';
};?></td>
			<td><span class="label"><?php $unix = human_to_unix($value->date); echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format . ' ' . $core_settings->date_time_format, $unix); ?></span></td>
			<td><span class="label"><?php if (is_object($value->user)) {
    echo $value->user->firstname;
    echo ' ' . $value->user->lastname;
} else {
    echo '-';
}?></span></td>
			
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>quotations/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
				        <a href="<?=base_url()?>quotations/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
		</div>
	</div>