	<div class="col-sm-12  col-md-12 main">  
       
     <div class="row">
       <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'invoices') {
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
         <div class="table-head"><?=$this->lang->line('application_invoices');?></div>
         <div class="table-div">
		<table class="data table" id="cinvoices" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="70px" class="hidden-xs"><?=$this->lang->line('application_invoice_id');?></th>
			<th><?=$this->lang->line('application_client');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_issue_date');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_due_date');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_value');?></th>
			<th><?=$this->lang->line('application_status');?></th>
		</thead>
		<?php foreach ($invoices as $value):?>

		<tr id="<?=$value->id;?>" >
			<td class="hidden-xs"><?=$core_settings->invoice_prefix;?><?=$value->reference;?></td>
			<td><span class="label label-info"><?php if (is_object($value->company)) {
    echo $value->company->name;
}?></span></td>
			<td class="hidden-xs"><span><?php $unix = human_to_unix($value->issue_date . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?></span></td>
			<td class="hidden-xs"><span class="label <?php if ($value->status == 'Paid') {
    echo 'label-success';
} if ($value->due_date <= date('Y-m-d') && $value->status != 'Paid') {
    echo 'label-important tt" title="' . $this->lang->line('application_overdue');
} ?>"><?php $unix = human_to_unix($value->due_date . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?></span> <span class="hidden"><?=$unix;?></span></td>
			<td class="hidden-xs"><?php if (isset($value->sum)) {
    echo display_money($value->sum, $value->currency);
} ?> </td>
     
			<td><span class="label <?php $unix = human_to_unix($value->sent_date . ' 00:00'); if ($value->status == 'Paid') {
    echo 'label-success';
} elseif ($value->status == 'Sent') {
    echo 'label-warning tt" title="' . date($core_settings->date_format, $unix);
} ?>"><?=$this->lang->line('application_' . $value->status);?></span></td>
		
		</tr>

		<?php endforeach;?>
	 	</table>
            </div>
</div>
      </div>
