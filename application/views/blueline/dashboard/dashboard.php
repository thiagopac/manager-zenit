<style>
  @media (max-width: 767px){
  .content-area {
      padding: 0;
  }
  .row.mainnavbar {
    margin-bottom: 0px;
    margin-right: 0px;
  }
}

</style>

<div class="grid">
  <div class="grid__col-md-7 dashboard-header">
        <h1><?=sprintf($this->lang->line('application_welcome_back'), $this->user->firstname);?></h1>
        <small><?=sprintf($this->lang->line('application_welcome_subline'), $messages_new[0]->amount, $event_count_for_today);?></small>
      </div>
      <div class="grid__col-md-5 dashboard-header hidden-xs">
          <!--<div class="grid grid--bleed grid--justify-end">
              <div class="grid__col-4 grid__col-lg-3 grid--align-self-center">
                <h6><?/*=$this->lang->line('application_tasks');*/?></h6>
                  <h2><?/*=count($tasks);*/?></h2>
              </div>
              <?php /*if($tickets_access){ */?>
              <div class="grid__col-4 grid__col-lg-3 grid--align-self-center">
                  <h6><?/*=$this->lang->line('application_tickets');*/?></h6>
                  <h2><?/*=$ticketcounter;*/?></h2>
              </div>
              <?php /*} */?>
              <div class="grid__col-4 grid__col-lg-3 grid--align-self-center">
                <h6><?/*=$this->lang->line('application_clients');*/?></h6>
                <h2><?/*=$clientcounter;*/?></h2>
              </div>
          </div>-->

          <div class="">
              <div class="btn-group pull-right margin-right-3">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      <?php if (isset($active_task_filter)) {
                          echo $this->lang->line('application_due_' . $active_task_filter);
                      } else {
                          echo $this->lang->line('application_task_filter');
                      } ?>
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu pull-right" role="menu">
                      <li>
                          <a id="all" href="<?=base_url()?>dashboard/taskfilter/all">
                              <?=$this->lang->line('application_due_all');?>
                          </a>
                      </li>
                      <li>
                          <a id="delayed" href="<?=base_url()?>dashboard/taskfilter/delayed">
                              <?=$this->lang->line('application_due_delayed');?>
                          </a>
                      </li>
                      <li>
                          <a id="today" href="<?=base_url()?>dashboard/taskfilter/today">
                              <?=$this->lang->line('application_due_today');?>
                          </a>
                      </li>
                      <li>
                          <a id="two" href="<?=base_url()?>dashboard/taskfilter/two">
                              <?=$this->lang->line('application_due_two');?>
                          </a>
                      </li>
                      <li>
                          <a id="week" href="<?=base_url()?>dashboard/taskfilter/week">
                              <?=$this->lang->line('application_due_week');?>
                          </a>
                      </li>
                      <li>
                          <a id="weekahead" href="<?=base_url()?>dashboard/taskfilter/weekahead">
                              <?=$this->lang->line('application_due_weekahead');?>
                          </a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>


    <div class="grid__col-sm-12 grid__col-md-8 grid__col-lg-9 grid__col--bleed">
      <div class="grid grid--align-content-start">
<?php if($this->user->admin == "1"){ ?>
        <!--<div class="grid__col-12 update-panel">
          <div class="tile-base box-shadow">
              <div class="panel-heading red"><span class="title red"><?/*=$this->lang->line('application_update_available');*/?></span><span id="hideUpdate"class="pull-right"><i class="ion-close"></i></span></div>
              <div class="panel-content"><h2><a href="<?/*=base_url()*/?>settings/updates"><?/*=$this->lang->line('application_new_update_is_ready');*/?></a></h2></div>
              <div class="panel-footer">Version <span id="versionnumber"></span></div>
          </div>
        </div>-->

<!-- DASHBOARD - QUADRO DE PAGAMENTOS FEITOS DO MODULO FINANCEIRO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
            <div class="tile-base box-shadow tile-with-icon">
                  <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-analytics-outline"></i></div>
                  <div class="tile-small-header">
                      <?=$this->lang->line('application_'.$month);?> <?=$this->lang->line('application_payments');?>
                  </div>
                  <div class="tile-body">
                      <div class="number" id="number1"><?php if(empty($payments)){echo display_money(0, $core_settings->currency, 0);}else{echo display_money($payments, $core_settings->currency); }?></div>
                  </div>
                  <div class="tile-bottom">
                      <div class="progress tile-progress tt"
                      title="<?=display_money($payments);?> / <?=display_money($paymentsOutstandingMonth);?>">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$paymentsForThisMonthInPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$paymentsForThisMonthInPercent?>%"></div>
                      </div>
                  </div>
            </div>
        </div> -->

<!-- DASHBOARD - QUADRO DE PAGAMENTOS PENDENTES DO MODULO FINANCEIRO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
            <div class="tile-base box-shadow">
                <div class="tile-icon hidden-md hidden-xs">
                    <i class="ion-ios-information-outline"></i>
                </div>
                <div class="tile-small-header">
                    <?=$this->lang->line('application_total_outstanding');?>
                </div>
                <div class="tile-body">
                    <div class="number" id="number2"><?php if(empty($paymentsoutstanding)){echo display_money(0, $core_settings->currency, 0);}else{echo display_money($paymentsoutstanding, $core_settings->currency); } ?></div>
                </div>
                <div class="tile-bottom">
                    <div class="progress tile-progress tile-progress--red tt"
                        title="<?=display_money($totalIncomeForYear);?> / <?=display_money($paymentsoutstanding);?>">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?=$paymentsOutstandingPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$paymentsOutstandingPercent?>%">
                    </div>
                    </div>
                </div>
            </div>
        </div> -->
<!-- DASHBOARD - QUADRO DE PROJETOS EM ABERTO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6  grid__col-md-6 grid__col-lg-3">
            <a href="<?=base_url();?>projects/filter/open" class="tile-base box-shadow">
            <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-lightbulb-outline"></i></div>
            <div class="tile-small-header"><?=$this->lang->line('application_open_projects');?></div>
              <div class="tile-body">
                  <?=$projects_open;?><small> / <?=$projects_all;?></small>
              </div>
              <div class="tile-bottom">
                      <div class="progress tile-progress tile-progress--green" >
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openProjectsPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openProjectsPercent?>%"></div>
                      </div>
                  </div>
            </a>
        </div> -->

<!-- DASHBOARD - QUADRO DE PROJETOS CONCLUÍDOS -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6  grid__col-md-6 grid__col-lg-3">
            <a href="<?=base_url();?>projects/filter/closed" class="tile-base box-shadow">
            <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-lightbulb-outline"></i></div>
            <div class="tile-small-header"><?=$this->lang->line('application_closed_projects');?></div>
              <div class="tile-body">
                  <?=$projects_open;?><small> / <?=$projects_all;?></small>
              </div>
              <div class="tile-bottom">
                      <div class="progress tile-progress tile-progress--green" >
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openProjectsPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openProjectsPercent?>%"></div>
                      </div>
                  </div>
            </a>
        </div> -->

<!-- DASHBOARD - QUADRO DE FATURAS EM ABERTO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
            <a href="<?=base_url();?>invoices/filter/open" class="tile-base box-shadow">
            <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-paper-outline"></i></div>
            <div class="tile-small-header"><?=$this->lang->line('application_open_invoices');?></div>
              <div class="tile-body">
                  <?=$invoices_open;?><small> / <?=$invoices_all;?></small>
              </div>
              <div class="tile-bottom">
                      <div class="progress tile-progress tile-progress--orange">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openInvoicePercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openInvoicePercent?>%"></div>
                      </div>
                  </div>
            </a>
        </div> -->


<?php } ?>
        <div class="grid__col-12">

            <span id="task-list" class="">
                <div class="box-shadow">
                    <div class="table-head">
                        <?=$this->lang->line('application_tasks');?>
                    </div>
                    <div class="table-div">
                        <table class="data table" id="tasks" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th class="hidden-xs">
                                    <?=$this->lang->line('application_task_name');?>
                                </th>
                                <th>
                                    <?=$this->lang->line('application_start_date');?> ➔ <?=$this->lang->line('application_due_date');?>
                                </th>
                                <th class="hidden-xs">
                                    <?=$this->lang->line('application_project');?>
                                </th>
                                <th class="hidden-xs">
                                    <?=$this->lang->line('application_assigned_to');?>
                                </th>
                                <th class="hidden-xs">
                                    <?=$this->lang->line('application_expiration');?>
                                </th>
                                <th>
                                    <?=$this->lang->line('application_action');?>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $i = 0;

                            $count7ahead = 0;
                            $count7 = 0;
                            $count2 = 0;
                            $count1 = 0;
                            $countDelayed = 0;

                            foreach ($tasks as $task): $i = $i + 1;?>
                                <tr id="<?=$task->id;?>">
                                    <td class="hidden-xs">
                                        <span class="static-color-preview" style="background-color:<?=$value->color?>"></span>
                                        <?=$task->name;?>
                                    </td>
                                    <td>
                                        <?=fnDateYMDHItoDMYHI($task->start_date);?> ➔ <?=fnDateYMDHItoDMYHI($task->due_date);?>
                                    </td>
                                    <td>
                                        <?=$task->project->name;?>
                                    </td>
                                    <td class="hidden-xs">
                                        <?=$task->user->firstname;?>
                                    </td>
                                    <td class="hidden-xs">
                                        <?
                                        $now = new DateTime();
                                        $due_date = new DateTime($task->due_date);

                                            $current =  strtotime(date('Y-m-d H:i'));
                                            $interval = $due_date->diff($now);

                                            if ($due_date > $now) {

                                                if ($interval->d >= 7) {
                                                    $color = "label-gray";
                                                    $remainingTime = $interval->format("%ad %hh");
                                                    $count7ahead++;
                                                }else if($interval->d > 2 && $interval->d < 7){
                                                    $color = "label-green";
                                                    $remainingTime = $interval->format("%ad %hh");
                                                    $count7++;
                                                }else if($interval->d >= 1 && $interval->d <= 2){
                                                    $color = "label-blue";
                                                    $remainingTime = $interval->format("%ad %hh");
                                                    $count2++;
                                                }else if($interval->d >= 0 && $interval->d < 1){
                                                    $color = "label-yellow";
                                                    $remainingTime = $interval->format("%ad %hh");

                                                    if ($interval->d == 0 && $interval->h != 0){
                                                        $remainingTime = $interval->format("%hh %im");
                                                    }else if ($interval->d == 0 && $interval->h == 0){
                                                        $remainingTime = $interval->format("%im");
                                                    }

                                                    $count1++;
                                                }

                                                echo "<span aria-sort='ascending' id='<?=$interval->d?>' class='label dashboard-label $color'>" . $remainingTime . "</span>";

                                            }else {
                                                echo '<span class="label dashboard-label label-red">' . $this->lang->line('application_delayed_task') . '</span>';
                                                $countDelayed++;
                                            }

                                        ?>
                                    </td>
                                    <td class="option" width="5%">
                                        <a href="<?=base_url()?>projects/tasks/<?=$task->project_id;?>/update/<?=$task->id;?>" class="btn-option tt" title="<?=$this->lang->line('application_edit_project'); ?>" data-toggle="mainmodal">
                                            <i class="icon dripicons-gear"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </span>
        </div>

        <div class="grid__col-12">
                  <?php if($tickets_access){ ?>
                    <div class="stdpad stdpad--auto-height box-shadow"><div class="table-head"><?=$this->lang->line('application_new_tickets');?></div>
                        <div class="table-div">
                            <table class="table" id="tickets" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                            <thead>
                              <th class="hidden-xs no_sort" style="width:5px; padding-right: 5px;"><i class="icon dripicons-star"></i></th>
                              <th><?=$this->lang->line('application_subject');?></th>

                              <th class="hidden-xs hidden-md"><?=$this->lang->line('application_queue');?></th>
                              <th class="hidden-xs"><?=$this->lang->line('application_client');?></th>
                              <th class="hidden-xs hidden-md"><?=$this->lang->line('application_owner');?></th>
                            </thead>
                            <?php foreach ($ticket as $value):?>
                            <tr id="<?=$value->id;?>" >
                              <?php if(is_object($value->user)){$user_id = $value->user->id; }else{ $user_id = FALSE; }?>
                              <td  class="hidden-xs" style="width:15px"><?php if($value->updated == "1" && $user_id == $this->user->id){?><i class="icon dripicons-star" style="color: #d48b2a;"></i><?php }else{?> <i class="icon dripicons-star" style="opacity: 0.2;"></i><?php } ?></td>
                              <td><?=$value->subject;?></td>
                              <td class="hidden-xs hidden-md"><span><?php if(is_object($value->queue)){ echo $value->queue->name;}?></span></td>
                              <td class="hidden-xs"><?php if(!is_object($value->company)){echo '<span class="label">'.$this->lang->line('application_no_client_assigned').'</span>'; }else{ echo '<span class="label label-info">'.$value->company->name.'</span>'; }?></td>
                              <td class="hidden-xs hidden-md"><?php if(!is_object($value->user)){echo '<span class="label">'.$this->lang->line('application_not_assigned').'</span>'; }else{ echo '<span class="label label-info">'.$value->user->firstname.' '.$value->user->lastname.'</span>'; }?></td>

                            </tr>

                            <?php endforeach;?>

                            </table>
                            <?php if(empty($ticket)) { ?>
                                      <div class="empty">
                                          <i class="ion-ios-pricetags"></i><br>
                                          <?=$this->lang->line('application_no_new_tickets');?>
                                      </div>
                            <?php } ?>

                            </div>
                    </div>
          <?php } ?>
        </div>

      </div>
    </div>

        <div class="grid__col-sm-12 grid__col-md-4 grid__col-lg-3 grid__col--bleed">
           <div class="grid grid--align-content-start">

           <div class="grid__col-12 ">
                      <div class="stdpad box-shadow"><div class="table-head"><?=$this->lang->line('application_task_chart');?></div>
                          <canvas id="task-chart" width="200" height="auto" style="margin-bottom: -5px;"></canvas>
                      </div>
                </div>

                <div class="grid__col-12">
                <?php if(in_array("calendar", $module_permissions)){ ?>
                    <div class="stdpad stdpad--auto-height stdpad--calendar stdpad--blue box-shadow">
                        <div class="table-head"><?=$this->lang->line('application_calendar');?>
                        <span class="pull-right">
                              <i class="ion-android-sunny calendar-style-toggle calendar-style-light"></i>
                              <i class="ion-android-sunny calendar-style-toggle calendar-style-dark hidden"></i>
                        </span></div>
                        <div id='dashboardCalendar'></div>
                    </div>
                <?php } ?>
                </div>

        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){

  $(document).on("click", '.calendar-style-toggle', function (e) {
      $(".calendar-style-toggle").toggleClass("hidden");
      $(".stdpad--calendar").toggleClass("stdpad--blue");
      if($(".calendar-style-light").hasClass("hidden")){
          localStorage.setItem("calendar_style_light", "1");
      }else{
          localStorage.removeItem("calendar_style_light");
      }
  });
  if(localStorage.calendar_style_light == "1"){
    $(".calendar-style-toggle").toggleClass("hidden");
    $(".stdpad--calendar").toggleClass("stdpad--blue");
  }
  $('#dashboardCalendar').fullCalendar({
        lang: '<?=$langshort;?>',
        header:{
            left:   'prev',
            center: 'title',
            right:  'next'
          },
          <?php if($core_settings->calendar_google_api_key != "" && $core_settings->calendar_google_event_address != ""){ ?>
          googleCalendarApiKey: '<?=$core_settings->calendar_google_api_key;?>',

          eventSources: [

            {
                googleCalendarId: '<?=$core_settings->calendar_google_event_address;?>',
                className: 'google-event',

            }

        ], <?php } ?>

          events: [

                    <?php if(isset($project_events)) echo $project_events; ?>
                    <?php if(isset($events_list)) echo $events_list; ?>
                  ],

              eventRender: function(event, element) {
                  element.attr('title', event.title);

                  if(event.source.className[0] == "google-event"){
                    element.attr('target', "_blank");
                  }
                  if(event.modal == 'true'){
                    element.attr('data-toggle', "mainmodal");
                  }
                  if(event.title != ''){
                    element.attr('title', event.title);

                    var tooltip = event.title;
                  $(element).attr("data-original-title", tooltip)
                  $(element).tooltip({ container: "body", trigger: 'hover', delay: { "show": 100, "hide": 50 }})
                  }

                  element.css('background-color', event.bgColor);

              }

  });


});
</script>

  <script type="text/javascript">
    $(document).ready(function(){

        var ctx = document.getElementById('task-chart').getContext('2d');
        var taskChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Atrasada', 'Vencendo hoje', 'Vencendo em 2 dias', 'Vencendo em 1 semana', 'Vencendo acima de 1 semana'],
                datasets: [{
                    label: '# of Votes',
                    data: [<?=$countDelayed?>, <?=$count1?>, <?=$count2?>, <?=$count7?>, <?=$count7ahead?>],
                    backgroundColor: [
                        '#ec492c',
                        '#ffbd30',
                        '#3498db',
                        '#27ae60',
                        '#95a5a6'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        display: false,
                        ticks: {
                            beginAtZero: true,
                            drawBorder: false
                        },gridLines: {
                            display:false,
                            drawBorder: false
                        }
                    }]
                },
                legend: {
                    display: true,
                    fullWidth: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                    }
                }
            }
        });

    });
  </script>
