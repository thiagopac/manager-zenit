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
          <div class="grid grid--bleed grid--justify-end">
              <div class="grid__col-4 grid__col-lg-3 grid--align-self-center">
                <h6><?=$this->lang->line('application_tasks');?></h6>
                  <h2><?=count($tasks);?></h2>
              </div>
              <?php if($tickets_access){ ?>
              <div class="grid__col-4 grid__col-lg-3 grid--align-self-center">
                  <h6><?=$this->lang->line('application_tickets');?></h6>
                  <h2><?=$ticketcounter;?></h2>
              </div>
              <?php } ?>
              <div class="grid__col-4 grid__col-lg-3 grid--align-self-center">
                <h6><?=$this->lang->line('application_clients');?></h6>
                <h2><?=$clientcounter;?></h2>
              </div>
          </div>
      </div>


    <div class="grid__col-sm-12 grid__col-md-8 grid__col-lg-9 grid__col--bleed">
      <div class="grid grid--align-content-start">
<?php if($this->user->admin == "1"){ ?>
        <div class="grid__col-12 update-panel">
          <div class="tile-base box-shadow">
              <div class="panel-heading red"><span class="title red"><?=$this->lang->line('application_update_available');?></span><span id="hideUpdate"class="pull-right"><i class="ion-close"></i></span></div>
              <div class="panel-content"><h2><a href="<?=base_url()?>settings/updates"><?=$this->lang->line('application_new_update_is_ready');?></a></h2></div>
              <div class="panel-footer">Version <span id="versionnumber"></span></div>
          </div>
        </div>

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

<!-- DASHBOARD - GRÁFICO DE ESTATÍSTICAS: RENDIMENTO - DESPESAS = LUCRO -->
        <!-- <div class="grid__col-12">
          <div class="tile-base box-shadow no-padding" >
                      <div class="tile-extended-header">
                          <div class="grid tile-extended-header">
                              <div class="grid__col-4">
                                  <h5><?=$this->lang->line('application_statistics');?> </h5>
                                  <div class="btn-group">
                                <button type="button" class="tile-year-selector dropdown-toggle" data-toggle="dropdown">
                                  <?=$year;?> <i class="ion-ios-arrow-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu--small" role="menu">
                                  <li><a href="<?=base_url()?>dashboard/year/<?=date("Y");?>"><?=date("Y");?></a></li>
                                  <li><a href="<?=base_url()?>dashboard/year/<?=date("Y")-1;?>"><?=date("Y")-1;?></a></li>
                                  <li><a href="<?=base_url()?>dashboard/year/<?=date("Y")-2;?>"><?=date("Y")-2;?></a></li>
                                  <li><a href="<?=base_url()?>dashboard/year/<?=date("Y")-3;?>"><?=date("Y")-3;?></a></li>
                                  <li><a href="<?=base_url()?>dashboard/year/<?=date("Y")-4;?>"><?=date("Y")-4;?></a></li>
                                  <li><a href="<?=base_url()?>dashboard/year/<?=date("Y")-5;?>"><?=date("Y")-5;?></a></li>
                                </ul>
                          </div>
                              </div>
                              <div class="grid__col-8">
                                    <div class="grid grid--bleed grid--justify-end">
                                        <div class="grid__col-md-3 tile-text-right">
                                            <h5><?=$this->lang->line('application_income');?></h5>
                                            <h1><?=display_money($totalIncomeForYear, false);?></h1>
                                        </div>
                                        <div class="grid__col-md-3 tile-text-right tile-negative">
                                            <h5><?=$this->lang->line('application_expenses');?></h5>
                                            <h1><?=display_money($totalExpenses, false);?></h1>
                                        </div>
                                        <div class="grid__col-md-3 tile-text-right tile-positive">
                                            <h5><?=$this->lang->line('application_profit');?></h5>
                                            <h1><?=display_money($totalProfit, false);?></h1>
                                        </div>
                                  </div>
                              </div>
                              <div class="grid__col-12 grid__col--bleed grid--align-self-end">
                                  <div class="tile-body">
                                      <canvas id="tileChart" width="auto" height="70" style="margin-bottom: -5px;"></canvas>
                                  </div>
                              </div>
                            </div>
                          </div>
                    </div>
        </div> -->


<?php } ?>

        <div class="grid__col-12">
                  <?php if(isset($tasks))
                  { ?>
                    <div class="stdpad box-shadow">
                        <div class="table-head"><?=$this->lang->line('application_my_open_tasks');?></div>

<!--                        CABEÇALHO COM DADOS DE TAREFAS -->
<!--                        <table class="table" id="tickets" rel="--><?//=base_url()?><!--" cellspacing="0" cellpadding="0">-->
<!--                            <thead>-->
<!--                            <th class="hidden-xs no_sort" style="width:5px; padding-right: 5px;"><i class="icon dripicons-star"></i></th>-->
<!--                            <th>--><?//=$this->lang->line('application_subject');?><!--</th>-->
<!---->
<!--                            <th class="hidden-xs hidden-md">--><?//=$this->lang->line('application_queue');?><!--</th>-->
<!--                            <th class="hidden-xs">--><?//=$this->lang->line('application_client');?><!--</th>-->
<!--                            <th class="hidden-xs hidden-md">--><?//=$this->lang->line('application_owner');?><!--</th>-->
<!--                            </thead>-->
<!--                        </table>-->
                        <div id="main-nano-wrapper" class="nano">
                            <div class="nano-content">
                                <ul id="jp-container" class="todo jp-container">
                                    <?php
                                    $count = 0;
                                    $projectname = "";
                                    foreach ($tasks as $value):
                                        $count = $count+1;
                                        if(is_object($value->project) && $projectname != $value->project->name)
                                        {
                                            $projectname = $value->project->name;
                                            echo "<h5>".$projectname."</h5>";
                                        }
                                    ?>
                                    <li class="<?=$value->status;?> priority<?=$value->priority;?> list-item">
                                        <span class="lbl-">
                                            <p class="truncate"><input name="form-field-checkbox" type="checkbox" class="checkbox-nolabel task-check" data-link="<?=base_url()?>projects/tasks/<?=$value->project_id;?>/check/<?=$value->id;?>" <?=$value->status;?>/>
                                                <a href="<?=base_url()?>projects/view/<?=$value->project_id;?>"><?=$value->name;?></a>
                                            </p>
                                        </span>
                                        <span class="pull-right hidden-xs" style="margin-top: -43px;">
                                              <?php if ($value->public != 0) {  ?><span class="list-button"><i class="icon dripicons-preview tt" title="" data-original-title="<?=$this->lang->line('application_task_public');?>"></i></span><?php } ?>
                                              <a href="<?=base_url()?>projects/tasks/<?=$value->project_id;?>/update/<?=$value->id;?>" class="edit-button" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                                        </span>
                                    </li>
                                    <?php
                                    endforeach;
                                    if($count == 0)
                                    { ?>
                                        <div class="empty">
                                          <i class="ion-checkmark-round"></i><br>
                                          <?=$this->lang->line('application_no_tasks_yet');?>
                                        </div>
                              <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
            <?php } ?>
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
                      <div class="stdpad box-shadow"><div class="table-head"><?=$this->lang->line('application_project_activities');?></div>
                        <div id="main-nano-wrapper" class="nano">
                          <div class="nano-content">
                            <ul class="activity__list">
                                <?php foreach ($recent_activities as $value) { ?>
                                    <li>
                                        <h3 class="activity__list--header">
                                            <?php echo time_ago($value->datetime); ?>
                                        </h3>
                                        <p class="activity__list--sub truncate">
                                            <?php if(is_object($value->user))
                                                  {
                                                        echo $value->user->firstname." ".$value->user->lastname;
                                                       echo (is_object($value->project)) ? ' <a href="'.base_url().'projects/view/'.$value->project->id.'">'.$value->project->name."</a>" : "";

                                                  } ?>
                                        </p>
                                        <div class="activity__list--body">
                                            <?=character_limiter(str_replace(array("\r\n", "\r", "\n",), "",strip_tags($value->message)), 260); ?>
                                        </div>
                                    </li>
                                <?php } ?>
                                <?php if(empty($recent_activities)) { ?>
                                          <div class="empty">
                                              <i class="ion-ios-people"></i><br>
                                              <?=$this->lang->line('application_no_recent_activities');?>
                                          </div>
                                <?php } ?>
                            </ul>
                          </div>
                        </div>
                  </div>
                </div>

                <div class="grid__col-12">
                  <?php if(isset($message)){ ?>
                      <div class="stdpad box-shadow">
                          <div class="table-head"><?=$this->lang->line('application_recent_messages');?></div>

                              <ul class="dash-messages">
                                  <?php foreach ($message as $value):?>
                                      <li>
                                          <a href="<?=base_url()?>messages">
                                            <img class="userpic img-circle" src="
                                              <?php
                                                if($value->userpic_u){
                                                  echo get_user_pic($value->userpic_u, $value->email_u);
                                                }else{
                                                  echo get_user_pic($value->userpic_c, $value->email_c);
                                                }
                                                ?>
                                              "/>
                                              <div class="pull-left" style="width: 78%;">
                                                  <p class="dash-messages__header truncate">
                                                      <?php if($value->status == "New"){ echo '<span class="new"><i class="icon dripicons-mail"></i></span>';}?>
                                                      <?=$value->subject;?>
                                                  </p>
                                                  <p class="dash-messages__name">
                                                  <?php if($value->sender_u){echo $value->sender_u;}else{ echo $value->sender_c; } ?>
                                                  </p>
                                              </div>
                                              <br clear="all">
                                              <!-- <small><?php echo time_ago($value->time); ?></small> -->
                                              <p class="dash-messages__body">
                                                  <?=character_limiter(str_replace(array("\r\n", "\r", "\n",), "",strip_tags($value->message)), 70); ?>
                                              </p>
                                          </a>
                                      </li>
                                  <?php endforeach;?>
                                  <?php if(empty($message)) { ?>
                                      <div class="empty">
                                          <i class="ion-ios-chatbubble"></i><br>
                                          <?=$this->lang->line('application_no_messages');?>
                                      </div>
                                  <?php } ?>
                              </ul><br/>
                             </div>
                  <?php } ?>

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

              },
              eventClick: function(event) {
                if (event.url && event.modal == 'true') {
                  NProgress.start();
                  var url = event.url;

                  if (url.indexOf('#') === 0) {
                    $('#mainModal').modal('open');
                  } else {
                    $.get(url, function(data) {
                        $('#mainModal').modal();
                        $('#mainModal').html(data);
                      }).done(function() { NProgress.done();  });
                  }
                  return false;
                }
              }

  });


    <!-- DASHBOARD - GRÁFICO DE ESTATÍSTICAS: RENDIMENTO - DESPESAS = LUCRO -->
  //  COMENTARIOS DOS JS

  //chartjs
  <?php //if($this->user->admin == "1"){ ?>
  // var ctx = document.getElementById("tileChart");
  //var myChart = new Chart(ctx, {
  //  type: 'line',
  //  data: {
  //    labels: [<?//=$labels?>//],
  //    datasets: [{
  //      label: "<?//=$this->lang->line("application_owed");?>//",
  //      backgroundColor: "rgba(215,112,173,0.3)",
  //      borderColor: "rgba(215,112,173,1)",
  //      pointBorderColor: "rgba(0,0,0,0)",
  //      pointBackgroundColor: "#ffffff",
  //      pointHoverBackgroundColor: "rgba(237, 85, 101, 0.5)",
  //      pointHitRadius: 25,
  //      pointRadius: 1,
  //      data: [<?//=$line2?>//], /!* Demo Data => [387, 1108, 987, 2100, 2900, 1023, 1897, 1438, 4100,2861,1000,3872], *!/
  //    },{
  //      label: "<?//=$this->lang->line("application_received");?>//",
  //      backgroundColor: "rgba(79,193,233,0.6)",
  //      borderColor: "rgba(79, 193, 233, 1)",
  //      pointBorderColor: "rgba(0,0,0,0)",
  //      pointBackgroundColor: "#ffffff",
  //      pointHoverBackgroundColor: "rgba(79, 193, 233, 1)",
  //      pointHitRadius: 25,
  //      pointRadius: 1,
  //      data: [<?//=$line1?>//], /!* Demo Data => [1702, 2310, 1900, 3800, 4123, 3000, 3210, 5439, 3000,4000,3234,5539], *!/
  //    },
  //    ]
  //  },
  //  options: {
  //    tooltips:{
  //      xPadding: 10,
  //      yPadding: 10,
  //      cornerRadius:2,
  //      mode: 'label',
  //      multiKeyBackground: 'rgba(0,0,0,0.2)'
  //    },
  //    legend:{
  //      display: false
  //    },
  //    scales: {
  //      yAxes: [{
  //        display: false,
  //        ticks: {
  //                    beginAtZero:true
  //                }
  //      }],
  //      xAxes: [{
  //        display: false
  //      }]
  //    }
  //  }
  //});

  //Count up settings
  //var options = {
  //  useEasing : true,
  //  useGrouping : true,
  ////  <?////=get_money_format();?>
  //  
  //};
  //var number1 = new CountUp("number1", 0, <?php //if(empty($payments)){echo 0;}else{echo $payments; }?>//, 2, 1.5, options);
  // number1.start();

  //var number2 = new CountUp("number2", 0, <?php //if(empty($paymentsoutstanding)){echo 0;}else{echo $paymentsoutstanding; }?>//, 2, 1.5, options);
  // number2.start();
<?php //} ?>



  function tick(){
    $('ul.dash-messages li:first').slideUp('slow', function () { $(this).appendTo($('ul.dash-messages')).fadeIn('slow'); });
  }
  function tick2(){
   // $('ul.activity__list li:first').slideUp('slow', function () { $(this).appendTo($('ul.activity__list')).fadeIn('slow'); });
  }
  <?php if(count($message) > 4){ ?>
  setInterval(function(){ tick() }, 5000);
  <?php } ?>
   <?php if(count($recent_activities) > 4){ ?>
  setInterval(function(){ tick2() }, 8000);
  <?php } ?>
  $('ul.notificationlist li').click(function(){
    $('ul.notificationlist li:first').slideUp('slow', function () { $(this).appendTo($('ul.notificationlist')).fadeIn('slow'); });
  });




});
</script>

<?php if($this->user->admin == "1"){ ?>
  <script type="text/javascript">
    $(document).ready(function(){

      <?php if ($firstlogin) : ?>
        $.get('<?= base_url() ?>agent/welcome', function(data) {
            $("#mainModal").modal();
            $("#mainModal").html(data);
        });

      <?php endif; ?>
      var url = "<?=base_url()?>settings/checkForUpdates";

      $('#hideUpdate').click(function(){
        var versionnumber = $("#versionnumber").html();
            var updatename = 'hideUpdate'+versionnumber;
            localStorage.setItem('hideupdate', updatename);
            $(".update-panel").velocity({'opacity': '0', 'height': '0px', 'padding-top': '0px'}, "easeOutQuint");
      });


    <?php if($this->user->admin == "1"){ ?>
      $.getJSON(url, function(data) { console.log(data.newUpdate);
          if(data.newUpdate == true){
            var updateid = 'hideUpdate'+data.lastupdate;
            if(localStorage.getItem('hideupdate') != updateid){
                $("#versionnumber").html(data.lastupdate);
                $(".update-panel").velocity({'opacity': '1', 'height': '122px', 'padding-top': '15px'}, "easeOutQuint");
              }
          }
          });

  <?php } ?>
    });
  </script>
  <?php } ?>
