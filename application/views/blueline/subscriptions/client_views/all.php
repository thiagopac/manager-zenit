<div class="col-sm-12  col-md-12 main">  
   
     <div class="row">
			
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
		<table class="data table" id="csubscriptions" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="hidden-xs" width="70px"><?=$this->lang->line('application_subscription');?></th>
			<th><?=$this->lang->line('application_client');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_issue_date');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_end_date');?></th>
			<th><?=$this->lang->line('application_next_payment');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_status');?></th>
		</thead>
		<?php foreach ($subscriptions as $value):?>

		<tr id="<?=$value->id;?>" >
			<td class="hidden-xs"><?=$core_settings->subscription_prefix;?><?=$value->reference;?></td>
			<td><span class="label label-info"><?php if (!is_object($value->company)) {
    echo $this->lang->line('application_no_client_assigned');
} else {
    echo $value->company->name;
}?></span></td>
			<td class="hidden-xs"><span><?php $unix = human_to_unix($value->issue_date . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?></span></td>
			<td>
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
                                echo 'label-important';
                            }?>" ><?php $unix = human_to_unix($value->next_payment . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; if (($value->end_date < date('Y-m-d') && $value->end_date != '') && $value->next_payment > date('Y-m-d')) {
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
			
		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
		 </div>
		</div>

		
	</div>