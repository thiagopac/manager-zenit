	
	<div class="col-sm-12  col-md-12 main">  
     <div class="row">
			<a href="<?=base_url()?>subscriptions/create" class="btn btn-primary" data-toggle="mainmodal"> <?=$this->lang->line('application_create_subscription');?></a>
			
			<div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'subscriptions') {
    echo $this->lang->line('application_' . $last_uri);
} else {
    echo $this->lang->line('application_all');
} ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <?php foreach ($submenu as $name => $value):?>
	                <li><a id="<?php $val_id = explode('/', $value); if (!is_numeric(end($val_id))) {
    echo end($val_id);
} else {
    $num = count($val_id) - 2;
    echo $val_id[$num];
} ?>" href="<?=site_url($value);?>"><?=$name?></a></li>
	            <?php endforeach;?>
          </ul>
      </div>


		</div>
		<div class="row">
		<div class="box-shadow">
		<div class="table-head"><?=$this->lang->line('application_subscriptions');?></div>
		<div class="table-div">
		<table class="data table" id="subscriptions" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="hidden-xs" width="70px"><?=$this->lang->line('application_subscription');?></th>
			<th><?=$this->lang->line('application_client');?></th>
			<th class="hidden-xs hidden-md"><?=$this->lang->line('application_issue_date');?></th>
			<th class="hidden-xs hidden-md"><?=$this->lang->line('application_end_date');?></th>
			<th><?=$this->lang->line('application_next_payment');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_status');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($subscriptions as $value):?>

		<tr id="<?=$value->id;?>" >
			<td class="hidden-xs"><?=$core_settings->subscription_prefix;?><?=$value->reference;?></td>
			<td><span class="label label-info"><?php if (!is_object($value->company)) {
    echo $this->lang->line('application_no_client_assigned');
} else {
    echo $value->company->name;
}?></span></td>
			<td class="hidden-xs hidden-md"><span><?php $unix = human_to_unix($value->issue_date . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?></span></td>
			<td class="hidden-xs hidden-md">
					<span class="label <?php if ($value->status == 'Active') {
    echo ' ';
}
                            if ($value->end_date <= date('Y-m-d') && $value->end_date != '' && $value->status != 'Inactive') {
                                $ended = true;
                                echo ' label-success tt" title="' . $this->lang->line('application_subscription_has_ended');
                            } elseif ($value->end_date == '') {
                                echo ' label-success tt" title="' . $this->lang->line('application_unlimited');
                            } ?>">
							<?php if ($value->end_date != '') {
                                $unix = human_to_unix($value->end_date . ' 00:00');
                                echo '<span class="hidden">' . $unix . '</span> ';
                                echo date($core_settings->date_format, $unix);
                            } else {
                                echo '<i class="ion-ios-infinite row_icon"></i>';
                            }?>
					</span>
			</td>
			<td class="hidden-xs"><span class="label <?php if ($value->status == 'Active' && $value->next_payment > date('Y-m-d')) {
                                echo 'label-success';
                            } if ($value->next_payment < date('Y-m-d') && $value->status != 'Inactive' && ($value->end_date > date('Y-m-d') || $value->end_date == '')) {
                                echo 'label-important tt" title="' . $this->lang->line('application_new_invoice_required');
                            } ?>"><?php $unix = human_to_unix($value->next_payment . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; if (($value->end_date < date('Y-m-d') && $value->end_date != '') && $value->next_payment > date('Y-m-d')) {
                                echo $this->lang->line('application_payments_closed');
                            } else {
                                echo date($core_settings->date_format, $unix);
                            }?></span></td>
			<td><span class="label <?php if ($value->status == 'Active') {
                                echo 'label-success';
                            } else {
                                echo 'label-important';
                            } ?>"><?php if (($value->end_date <= date('Y-m-d') && $value->end_date != '') && $value->status != 'Inactive') {
                                echo $this->lang->line('application_ended');
                            } else {
                                echo $this->lang->line('application_' . $value->status);
                            } ?></span></td>
			
			 <td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>subscriptions/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
				        <a href="<?=base_url()?>subscriptions/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			       </td>
		</tr>

		<?php endforeach;?>
	 	</table>
		 </div>
		</div>
	 	</div>

		
	</div>