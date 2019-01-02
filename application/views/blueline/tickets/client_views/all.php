<div class="col-sm-13  col-md-12 main">

    <div class="row">
			<a href="<?=base_url()?>ctickets/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_create_new_ticket');?></a>

			<div class="btn-group pull-right-responsive margin-right-3">
	          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'ctickets') {
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
			<div class="btn-group pull-right-responsive margin-right-3">

			<ul class="dropdown-menu pull-right bulk-dropdown" role="menu">

	                <li data-action="close"><a id="" href="#"><?=$this->lang->line('application_close');?></a></li>


			</ul>

			</div>
		</div>
	<div class="row">
		<div class="box-shadow">
		<div class="table-head"><?=$this->lang->line('application_tickets');?></div>
		<div class="table-div">
		<table class="data-sorting table" id="ctickets" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="hidden-xs" style="width:70px"><?=$this->lang->line('application_ticket_id');?></th>
			<th style="width:50px"><?=$this->lang->line('application_status');?></th>
			<th class="hidden-xs no_sort" style="width:5px; padding-right: 5px;"><i class="icon dripicons-star"></i></th>
			<th><?=$this->lang->line('application_subject');?></th>

			<th class="hidden-xs"><?=$this->lang->line('application_queue');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_client');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_owner');?></th>
		</thead>
		<?php foreach ($ticket as $value):?>
			<?php $lable = false; if ($value->status == 'new') {
    $lable = 'label-important';
} elseif ($value->status == 'open') {
    $lable = 'label-warning';
} elseif ($value->status == 'closed') {
    $lable = 'label-success';
} elseif ($value->status == 'reopened') {
    $lable = 'label-warning';
} ?>
		<tr id="<?=$value->id;?>" >
			<td  class="hidden-xs" style="width:70px"><?=$value->reference;?></td>
			<td style="width:50px"><span class="label <?php echo $lable; ?>"><?=$this->lang->line('application_ticket_status_' . $value->status);?></span></td>
			<?php if (is_object($value->user)) {
    $user_id = $value->user->id;
} else {
    $user_id = false;
}?>
			<td  class="hidden-xs" style="width:15px"><?php if ($value->updated == '1') {
    ?><i class="icon dripicons-star"></i><?php
} else {
        ?> <i class="icon dripicons-star" style="opacity: 0.2;"></i><?php
    } ?></td>
			<td><?=$value->subject;?></td>
			<td class="hidden-xs"><span><?php if (is_object($value->queue)) {
        echo $value->queue->name;
    }?></span></td>
			<td class="hidden-xs"><?php if (!is_object($value->company)) {
        echo '<span class="label">' . $this->lang->line('application_no_client_assigned') . '</span>';
    } else {
        echo '<span class="label label-info">' . $value->company->name . '</span>';
    }?></td>
			<td class="hidden-xs"><?php if (!is_object($value->user)) {
        echo '<span class="label">' . $this->lang->line('application_not_assigned') . '</span>';
    } else {
        echo '<span class="label label-info">' . $value->user->firstname . ' ' . $value->user->lastname . '</span>';
    }?></td>

		</tr>

		<?php endforeach;?>
	 	</table>

		 </div>
		</div>
	</div>
	</div>
