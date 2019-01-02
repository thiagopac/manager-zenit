	<div class="col-sm-12  col-md-12 main">  
    <div class="row tile-row">
    <?php $month2 = $month != 0 ? $month : date('m'); $year = $year ? $year : date('Y')?>
      <div class="col-md-3 col-xs-6 tile">
          <div class="icon-frame hidden-xs"><i class="ion-ios-calendar-outline"></i> </div><h1> <?php if (isset($expenses_this_month)) {
    echo $expenses_this_month;
} ?> <span><?=$this->lang->line('application_expenses');?></span></h1><h2><?php echo $days_in_this_month == 12 ? $this->lang->line('application_in') . ' ' . $year : $this->lang->line('application_in') . ' ' . $this->lang->line('application_' . date('M', strtotime($year . '-' . $month2 . '-01'))); ?></h2></div>
      <div class="col-md-3 col-xs-6 tile"><div class="icon-frame secondary hidden-xs"><i class="ion-ios-cart"></i> </div><h1> <?php if ($expenses_owed_this_month[0]->owed != '') {
    echo display_money(sprintf('%01.2f', round($expenses_owed_this_month[0]->owed, 2)));
} else {
    echo '0.00';
} ?> </h1><h2><?=$this->lang->line('application_owed_in');?> <?php echo $days_in_this_month == 12 ? $year : $this->lang->line('application_' . date('M', strtotime($year . '-' . $month2 . '-01')));?></h2></div>
      <div class="col-md-6 col-xs-12 tile hidden-xs">
      <div style="width:97%; margin-top: -4px; margin-bottom: 17px; height: 80px;">
            <canvas id="tileChart" width="auto" height="80"></canvas>
        </div>
      </div>
    
    </div>   
     <div class="row">
      <a href="<?=base_url()?>expenses/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_create_expense');?></a>
      <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php echo $year; ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=date('Y');?>/<?=$month?>"><?=date('Y');?></a></li>

                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=date('Y') - 1;?>/<?=$month?>"><?=date('Y') - 1;?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=date('Y') - 2;?>/<?=$month?>"><?=date('Y') - 2;?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=date('Y') - 3;?>/<?=$month?>"><?=date('Y') - 3;?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=date('Y') - 4;?>/<?=$month?>"><?=date('Y') - 4;?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=date('Y') - 5;?>/<?=$month?>"><?=date('Y') - 5;?></a></li>
          </ul>
      </div>
      <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php echo $month != 0 ? $this->lang->line('application_' . date('M', strtotime('2015-' . $month . '-01'))) : $this->lang->line('application_all'); ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/0"><?=$this->lang->line('application_all');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/01"><?=$this->lang->line('application_Jan');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/02"><?=$this->lang->line('application_Feb');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/03"><?=$this->lang->line('application_Mar');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/04"><?=$this->lang->line('application_Apr');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/05"><?=$this->lang->line('application_May');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/06"><?=$this->lang->line('application_Jun');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/07"><?=$this->lang->line('application_Jul');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/08"><?=$this->lang->line('application_Aug');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/09"><?=$this->lang->line('application_Sep');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/10"><?=$this->lang->line('application_Oct');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/11"><?=$this->lang->line('application_Nov');?></a></li>
                    <li><a href="<?=base_url()?>expenses/filter/<?=$user_id?>/<?=$year?>/12"><?=$this->lang->line('application_Dec');?></a></li>

          </ul>
      </div>
      <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php if (isset($username)) {
    echo $username->firstname . ' ' . $username->lastname;
} else {
    echo $this->lang->line('application_show_expenses_from_agent');
} ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
          <li><a href="<?=base_url()?>expenses/filter/0/<?=$year?>/<?=$month?>"><?=$this->lang->line('application_all');?></a></li>
            <?php foreach ($userlist as $user):?>
                  <li><a href="<?=base_url()?>expenses/filter/<?=$user->id?>/<?=$year?>/<?=$month?>"><?=$user->firstname . ' ' . $user->lastname?></a></li>
              <?php endforeach;?>
          </ul>
      </div>
    </div>  
      <div class="row">
      <div class="box-shadow">
         <div class="table-head"><?=$this->lang->line('application_expenses');?></div>
         <div class="table-div">
		<table class="data table noclick" id="expenses" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="30px" class="hidden-xs"><?=$this->lang->line('application_id');?></th>
      <th width="30px" class="hidden-xs no-sort"><?=$this->lang->line('application_status');?></th>
      <th width="5px" class="no-sort"></th>
      
			<th ><?=$this->lang->line('application_description');?></th>
      <th class="hidden-xs"><?=$this->lang->line('application_category');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_date');?></th>
			<th><?=$this->lang->line('application_value');?></th>
      <th class="hidden-xs"><?=$this->lang->line('application_tax');?></th>
      <th class="hidden-xs"><?=$this->lang->line('application_balance');?></th>

			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php 
    $sum = 0;
    foreach ($expenses as $value):
      $sum = $sum + $value->value;

      ?>
		<tr id="<?=$value->id;?>" >
			<td class="hidden-xs"><?=$value->id;?></td>
      <td class="hidden-xs">
          <i class="icon dripicons-media-record tt <?php if ($value->status == 'Paid') {
          echo 'icon-green';
      } elseif ($value->status == 'Open') {
          echo 'icon-red';
      }?>" title="<?=$this->lang->line('application_' . $value->status);?>"></i>
      </td>
      <td><?php if ($value->attachment != '') {
          echo '<a href="' . base_url() . 'expenses/attachment/' . $value->id . '" style="color: #505458;"><i class="icon dripicons-paperclip tt" title="' . $value->attachment_description . '"></i></a>';
      }?></td>
			<td><?php if (!empty($value->description)) {
          echo $value->description;
      }?></td>
      <td class="hidden-xs" ><span class="label label-info"><?=$value->category;?></span></td>
      <td class="hidden-xs">
        <span><?php $unix = human_to_unix($value->date . ' 00:00'); echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?></span>
      </td>
			<td class="minus ">
        <span class="<?php if (is_object($value->invoice)) {
          echo 'plus tt" title="' . $this->lang->line('application_rebilled_on_invoice') . ' #' . $value->invoice->reference;
      }?>"><?=display_money(sprintf('%01.2f', round($value->value, 2)));?></span>
      </td>
      <td class="hidden-xs minus ">
        <span><?=display_money(sprintf('%01.2f', round($value->value - (($value->value / (100 + $value->vat)) * 100), 2)));?></span>
      </td>
      <td class="hidden-xs bold">
        <?=display_money(sprintf('%01.2f', round($sum, 2)));?>
      </td>


		
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>expenses/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
				        <a href="<?=base_url()?>expenses/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>


            </div>

    </div>
      </div>

<script>
$(document).ready(function(){ 

//chartjs
<?php

                                $days = [];
                                $data = '';
                                $labels = '';
                                foreach ($expenses_due_this_month_graph as $value) {
                                    $days[$value->date] = $value->owed;
                                }
                                $i = 1;
                                while ($i <= $days_in_this_month) {
                                    $selected_day = $days_in_this_month == 12 ? $i : $year . '-' . $month2 . '-' . $i;
                                    $y = 0;
                                    if (isset($days[$selected_day])) {
                                        $y = $days[$selected_day];
                                    }
                                    $d = date_parse_from_format('Y-m-d', $selected_day);
                                    $labels .= $days_in_this_month == 12 ? '"' . sprintf('%1$02d', $selected_day) . '",' : '"' . $d['day'] . '",';
                                    $data .= '"' . sprintf('%01.2f', round($y, 2)) . '",';
                                    $i++;
                                }
                                ?>

    var ctx = document.getElementById("tileChart").getContext("2d");
    var myBarChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [<?=$labels?>],
        datasets: [
        {
          label: "<?=$this->lang->line('application_owed');?>",
          backgroundColor: "rgba(237, 85, 101, 0.3)",
          borderColor: "rgba(237, 85, 101, 1)",
          pointBorderColor: "rgba(51, 195, 218, 0)",
          pointBackgroundColor: "rgba(237, 85, 101, 1)",
          pointHoverBackgroundColor: "rgba(237, 85, 101, 1)",
          pointHitRadius: 25,
          pointRadius: 2,
          borderWidth: 2,
          data: [<?=$data;?>]
        }]
      },
       options: {
        title: {
            display: true,
            text: ' '
        },
        maintainAspectRatio: false,
        tooltips:{
          enabled: true,
        },
        legend:{
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: { 
                        display: false, 
                        lineWidth: 2,
                        color: "rgba(237, 85, 101, 0)"
                      },
            ticks: {
                        beginAtZero:true,
                        display: false,
                    }
          }],
          xAxes: [{
             gridLines: { 
                        display: false, 
                        lineWidth: 2,
                        color: "rgba(237, 85, 101, 0)"
                      },
            ticks: {
                        beginAtZero:true,
                        display: false,
                    }
          }]
        }
      }

    });
});
</script>