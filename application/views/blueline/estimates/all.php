	<div class="col-sm-12  col-md-12 main">  
    
     <div class="row">
      <a href="<?=base_url()?>estimates/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_create_estimate');?></a>
      <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'estimates') {
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
         <div class="table-head"><?=$this->lang->line('application_estimates');?></div>
         <div class="table-div">
		<table class="data table" id="estimates" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="70px" class="hidden-xs"><?=$this->lang->line('application_estimate_id');?></th>
			<th ><?=$this->lang->line('application_client');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_issue_date');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_total');?></th>
			<th><?=$this->lang->line('application_status');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($estimates as $value):
        $change_date = '';
        switch ($value->estimate_status) {
          case 'Open': $label = 'label-default'; break;
          case 'Accepted': $label = 'label-success'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($value->estimate_accepted_date . ' 00:00')) . '"'; break;
          case 'Sent': $label = 'label-warning'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($value->estimate_sent . ' 00:00')) . '"'; break;
          case 'Declined': $label = 'label-important'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($value->estimate_accepted_date . ' 00:00')) . '"'; break;
          case 'Invoiced': $label = 'label-chilled'; $change_date = 'title="' . $this->lang->line('application_Accepted') . ' ' . date($core_settings->date_format, human_to_unix($value->issue_date . ' 00:00')) . '"'; break;
          case 'Revised': $label = 'label-warning'; $change_date = 'title="' . $this->lang->line('application_Revised') . ' ' . date($core_settings->date_format, human_to_unix($value->estimate_accepted_date . ' 00:00')) . '"'; break;

          default: $label = 'label-default'; break;
        } ?>
		<tr id="<?=$value->id;?>" >
			<td class="hidden-xs"><?=$core_settings->estimate_prefix;?><?=$value->estimate_reference;?></td>
			<td><span class="label label-info"><?php if (is_object($value->company)) {
            echo $value->company->name;
        }?></span></td>
			<td class="hidden-xs"><span><?php $unix = human_to_unix($value->issue_date . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?></span></td>
			<td class="hidden-xs"><?=display_money(sprintf('%01.2f', round($value->sum, 2)));?></td>
			<td><span class="label  <?=$label?> tt" <?=$change_date;?>><?=$this->lang->line('application_' . $value->estimate_status);?></span></td>
		
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>estimates/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
				        <a href="<?=base_url()?>estimates/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
            </div>
      </div>
      </div>
