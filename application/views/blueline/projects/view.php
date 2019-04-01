

          <div class="row">
              <div class="col-xs-12 col-sm-12">

  <div class="row tile-row tile-view">
      <div class="col-md-1 col-xs-3">
      <div class="percentage easyPieChart" id="tile-pie" data-percent="<?=$project->progress;?>"><span><?=$project->progress;?>%</span></div>

      </div>
      <div class="col-md-11 col-xs-9 smallscreen">
        <!--    Prefixo e ID do banco de dados retirado da view de projetos / ESCONDIDO      -->
<!--          <h1><span class="nobold">#--><?//=$core_settings->project_prefix;?><!----><?//=$project->reference;?><!--</span> - --><?//=$project->name;?><!--</h1>-->
          <h1><span class="nobold"><?=$project->name;?></h1>
         <p class="truncate description"><?=$project->description;?></p>
      </div>

      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active hidden-xs"><a href="#projectdetails-tab" aria-controls="projectdetails-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_project_details');?></a></li>

          <li role="presentation" class="hidden-xs dropdown">
              <a  href="#"
                  class="dropdown-toggle"
                  data-toggle="dropdown"
                  aria-controls="myTabDrop1-contents"
                  aria-expanded="false">
                  <span id="departments-drop-menu"><?=$this->lang->line('application_departments');?></span>
                  <span class="caret"></span>
              </a>

              <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents" id="department-menu">
                  <?php foreach ($departments as $department): ?>
                  <li role="presentation">
                      <a href="#milestones-tab" aria-controls="tasks-tab" role="tab" class="department-link" data-name="<?=$department->name?>" id="department_<?=$department->id?>" data-toggle="tab">
                          <?=$department->name?>
                      </a>
                  </li>
                  <?php endforeach; ?>
              </ul>
          </li>

        <li role="presentation" class="hidden-xs"><a href="#gantt-tab" class="resize-gantt" aria-controls="gantt-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_gantt');?></a></li>

        <li role="presentation" class="hidden-xs"><a href="#media-tab" class="media-tab-trigger" aria-controls="media-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_files');?></a></li>

        <li role="presentation" class="hidden-xs"><a href="#notes-tab" aria-controls="notes-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_notes');?></a></li>

       <?php if ($invoice_access) {
        ?>
        <li role="presentation" class="hidden-xs"><a href="#invoices-tab" aria-controls="invoices-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_invoices'); ?></a></li>
       <?php
    } ?>
        <li role="presentation" class="hidden-xs"><a href="#activities-tab" aria-controls="activities-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_activities');?></a></li>

        <li role="presentation" class="dropdown visible-xs">
            <a  href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-controls="myTabDrop1-contents"
                aria-expanded="false">
                <span id="project-overview-dropdown-menu"><?=$this->lang->line('application_overview');?> </span>

                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
              <li role="presentation"><a href="#projectdetails-tab" aria-controls="projectdetails-tab" role="tab" class="project-overview-menu" data-name="<?=$this->lang->line('application_project_details');?>" data-toggle="tab"><?=$this->lang->line('application_project_details');?></a></li>
             <!-- <li role="presentation"><a href="#tasks-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?php /*if ($mytasks != 0) {
        */?><span class="badge submenu-badge"><?/*=$mytasks*/?></span><?php
/*    } */?><?/*=$this->lang->line('application_tasks');*/?></a></li>-->
<!--              <li role="presentation" ><a href="#milestones-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab">--><?//=$this->lang->line('application_milestones');?><!--</a></li>-->
                <?php foreach ($departments as $department): ?>
                    <li role="presentation">
                        <a href="#milestones-tab" aria-controls="tasks-tab" role="tab"  class="project-overview-menu" data-name="<?=$department->name?>" id="department_<?=$department->id?>" data-toggle="tab">
                            <?=$department->name?>
                        </a>
                    </li>
                <?php endforeach; ?>
              <li role="presentation" ><a href="#gantt-tab" class="resize-gantt project-overview-menu" aria-controls="gantt-tab" data-name="<?=$this->lang->line('application_gantt');?>" role="tab" data-toggle="tab"><?=$this->lang->line('application_gantt');?></a></li>
              <li role="presentation"><a href="#media-tab" aria-controls="media-tab"  class="media-tab-trigger project-overview-menu" data-name="<?=$this->lang->line('application_files');?>"  role="tab" data-toggle="tab"><?=$this->lang->line('application_files');?></a></li>
              <li role="presentation"><a href="#notes-tab" aria-controls="notes-tab" class="project-overview-menu" data-name="<?=$this->lang->line('application_notes');?>"  role="tab" data-toggle="tab"><?=$this->lang->line('application_notes');?></a></li>

              <li role="presentation"><a href="#activities-tab" aria-controls="activities-tab" class="project-overview-menu" data-name="<?=$this->lang->line('application_activities');?>"  role="tab" data-toggle="tab"><?=$this->lang->line('application_activities');?></a></li>
            </ul>
        </li>

        <li class="pull-right">
          <a href="<?=base_url()?>projects/copy/<?=$project->id;?>" class="btn-option tt" title="<?=$this->lang->line('application_copy_project');?>" data-toggle="mainmodal"><i class="icon dripicons-duplicate"></i></a>

        </li>
        <li class="pull-right">
          <?php if ($project->sticky == 0) {
        ?>
                <a class="tt" title="<?=$this->lang->line('application_add_to_quick_access'); ?>" href="<?=base_url()?>projects/sticky/<?=$project->id; ?>"><i class="icon dripicons-star"></i></a>
              <?php
    } else {
        ?>
                <a class="tt" title="<?=$this->lang->line('application_add_to_quick_access'); ?>" href="<?=base_url()?>projects/sticky/<?=$project->id; ?>"><i class="icon dripicons-star"></i></a>
              <?php
    } ?>
        </li>
        <li class="pull-right">
          <a href="<?=base_url()?>projects/update/<?=$project->id;?>" data-toggle="mainmodal" class="tt" title="<?=$this->lang->line('application_edit_project'); ?>" data-target="#mainModal"><i class="icon dripicons-gear"></i></a>
        </li>
        <li class="pull-right">
          <?php if (!empty($project->tracking)) {
        ?>

            <a href="<?=base_url()?>projects/tracking/<?=$project->id; ?>" class="tt red project-global-timer" title="<?=$this->lang->line('application_stop_timer'); ?>" ><span id="timerGlobal" class="badge"></span></a>
            <script>$( document ).ready(function() { startTimer("","<?=$timertime; ?>", "#timerGlobal"); });</script>
          <?php
    } else {
        ?>
<!--            <a href="--><?//=base_url()?><!--projects/tracking/--><?//=$project->id; ?><!--" class="tt" title="--><?//=$this->lang->line('application_start_timer'); ?><!--"><i class="icon dripicons-clock"></i> </a>-->
          <?php
    } ?>
       </li>
       <li class="pull-right">
          <?php if ($project->id < $last_project->id) {
        ?>
            <a href="<?=base_url()?>projects/view/<?=$project->id+1; ?>" class="tt" title="<?=$this->lang->line('application_next'); ?>"><i class="icon dripicons-arrow-thin-right"></i> </a>
          <?php
    } ?>
       </li>
       <li class="pull-right">
          <?php if ($project->id-1 > $first_project->id) {
        ?>
            <a href="<?=base_url()?>projects/view/<?=$project->id-1; ?>" class="tt" title="<?=$this->lang->line('application_back'); ?>"><i class="icon dripicons-arrow-thin-left"></i> </a>
           <?php
    } ?>
       </li>


      </ul>


    </div>


              </div>
          </div>
   <div class="tab-content">

<div class="row tab-pane fade in active" role="tabpanel" id="projectdetails-tab">

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
           <div class="box-shadow">
            <div class="table-head"><?=$this->lang->line('application_project_details');?> <span class=" pull-right option-icon"> <a href="<?=base_url()?>projects/update/<?=$project->id;?>" data-toggle="mainmodal" data-target="#mainModal"><i class="icon dripicons-gear"></i></a></span></div>

                <div class="subcont">
                  <ul class="details col-xs-12 col-sm-12">
                    <li><span><?=$this->lang->line('application_project_id');?></span> <?=$core_settings->project_prefix;?><?=$project->reference;?></li>

                    <li><span><?=$this->lang->line('application_client');?></span> <?php if (!is_object($project->company)) {
        ?> <a href="#" class="label label-default"><?php echo $this->lang->line('application_no_client_assigned');
    } else {
        ?><a class="label label-success" href="<?=base_url()?>clients/view/<?=$project->company->id; ?>"><?php echo $project->company->name;
    } ?></a></li>
                    <li><span><?=$this->lang->line('application_start_date');?></span> <?php  $unix = human_to_unix($project->start); echo date($core_settings->date_format, $unix);?></li>
                    <li><span><?=$this->lang->line('application_deadline');?></span> <?php  $unix = human_to_unix($project->end); echo date($core_settings->date_format, $unix);?></li>
<!--                    <li><span>--><?//=$this->lang->line('application_project');?><!-- - --><?//=$this->lang->line('application_time_spent');?><!--</span> --><?//=$time_spent;?><!-- <a href="--><?//=base_url()?><!--projects/timer_reset/--><?//=$project->id;?><!--" class="tt" title="--><?//=$this->lang->line('application_reset_timer');?><!--"><i class="icon dripicons-time-reverse"></i></a> <a href="--><?//=base_url()?><!--projects/timer_set/--><?//=$project->id;?><!--" data-toggle="mainmodal" class="tt" style="    margin-left: 7px;" title="--><?//=$this->lang->line('application_timer_set');?><!--"><i class="icon dripicons-clock"></i></a></li>-->
<!--                    <li><span>--><?//=$this->lang->line('application_tasks');?><!-- - --><?//=$this->lang->line('application_time_spent');?><!--</span> --><?//=Project::getAllTasksTime($project->id);?><!-- </li>-->

                    <li><span><?=$this->lang->line('application_created_on');?></span> <?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $project->datetime); ?></li>
                  </ul>
                  <br clear="both">
                </div>

        </div>
               </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-shadow">
                        <div class="table-head"><?=$this->lang->line('application_project_statistic');?> </div>
                         <div class="tile-base no-padding">
                          <div class="tile-extended-header">
                            <div class="grid tile-extended-header">
                                <div class="grid__col-6">
                                    <h5><?=$this->lang->line('application_task_statistics_for');?></h5>
                                    <h1><?=$this->lang->line('application_this_week');?></h1>
                                </div>
                                <div class="grid__col-6">
                                      <div class="grid grid--bleed grid--justify-end">
                                          <!--
                                          <div class="grid__col-md-8 tile-text-right tile-positive">
                                              <h5>Profit</h5>
                                              <h1> 4,167.25</h1>
                                          </div> -->
                                    </div>
                                </div>
                                <div class="grid__col-12 grid__col--bleed grid--align-self-end">
                                    <div class="tile-body">
                                        <canvas id="projectChart" width="auto" height="80" style="margin-bottom:-5px"></canvas>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
              </div>

               <div class="row">
                  <div class="col-sm-12 col-md-4">
                        <div class="tile-base tile-with-icon box-shadow">
                              <div class="tile-icon hidden-md hidden-sm" style="margin: -11px 36px 2px 0px;"><i class="ion-ios-people-outline"></i></div>
                              <div class="tile-small-header">
                                  <?=$this->lang->line('application_staff_assigned');?>
                              </div>
                              <div class="tile-body">
                                  <div class="number" id="number1">
                                  <?=$assigneduserspercent?> %
                                  </div>
                              </div>
                              <div class="tile-bottom">
                                  <div class="progress tile-progress tile-progress--red" >
                                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$assigneduserspercent?>%"></div>
                                  </div>
                              </div>
                        </div>
                        <br>
                  </div>

                  <div class="col-sm-12 col-md-4">
                        <div class="tile-base tile-with-icon box-shadow">
                              <div class="tile-icon hidden-md hidden-sm"><i class="ion-ios-calendar-outline"></i></div>
                              <div class="tile-small-header">
                                  <?=$this->lang->line('application_days_left');?>
                              </div>
                              <div class="tile-body">
                                  <div class="number" id="number1">
                                  <?=$time_left?><small> / <?=$time_days?></small>
                                  </div>
                              </div>
                              <div class="tile-bottom">
                                  <div class="progress tile-progress tile-progress--green" >
                                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$timeleftpercent?>%"></div>
                                  </div>
                              </div>
                        </div>
                        <br>
                  </div>


                  <div class="col-sm-12 col-md-4">
                        <div class="tile-base tile-with-icon box-shadow">
                              <div class="tile-icon hidden-md hidden-sm"><i class="ion-ios-list-outline"></i></div>
                              <div class="tile-small-header">
                                  <?=$this->lang->line('application_open_tasks');?>
                              </div>
                              <div class="tile-body">
                                  <div class="number" id="number1">
                                  <?=$opentasks?><small> / <?=$alltasks?></small>
                                  </div>
                              </div>
                              <div class="tile-bottom">
                                  <div class="progress tile-progress tile-progress--purple" >
                                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$opentaskspercent?>%"></div>
                                  </div>
                              </div>
                        </div>
                        <br>
                  </div>


                </div>
<!--
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-head"><?=$this->lang->line('application_milestone_progress');?> </div>
                         <div class="tile-base no-padding">
                          <div class="tile-extended-header">
                            <div class="grid tile-extended-header">
                                <div class="grid__col-6">
                                    <h5>Task Statistics for</h5>
                                    <h1>This Week</h1>
                                </div>
                                <div class="grid__col-6">
                                      <div class="grid grid--bleed grid--justify-end">

                                          <div class="grid__col-md-8 tile-text-right tile-positive">
                                              <h5>Profit</h5>
                                              <h1> 4,167.25</h1>
                                          </div>
                                    </div>
                                </div>
                                <div class="grid__col-12 grid__col--bleed grid--align-self-end">
                                    <div class="tile-body">
                                        <canvas id="projectChart" width="auto" height="70" style="margin-bottom:-11px"></canvas>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
              </div>
                -->

          </div>


               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

            <div class="stdpad box-shadow" >
            <div class="table-head"><?=$this->lang->line('application_activities');?></div>
            <div id="main-nano-wrapper" class="nano">
              <div class="nano-content">
                <ul class="activity__list">
                                <?php foreach ($project->project_has_activities as $activity) {
        ?>
                                    <li>
                                        <h3 class="activity__list--header">
                                            <?php echo time_ago($activity->datetime); ?>
                                        </h3>
                                        <p class="activity__list--sub truncate">
                                            <?php if (is_object($activity->user)) {
            echo $activity->user->firstname." ".$activity->user->lastname.' <a href="'.base_url().'projects/view/'.$activity->project->id.'">'.$activity->project->name."</a>";
        } ?>
                                        </p>
                                        <div class="activity__list--body">
                                            <?=character_limiter(str_replace(array("\r\n", "\r", "\n",), "", strip_tags($activity->message)), 260); ?>
                                        </div>
                                    </li>
                                <?php $activities = true;
    } ?>
                                <?php if (!isset($activities)) {
        ?>
                                          <div class="empty">
                                              <i class="ion-ios-people"></i><br>
                                              <?=$this->lang->line('application_no_recent_activities'); ?>
                                          </div>
                                <?php
    } ?>
                            </ul>
                          </div>
                        </div>

</div>
</div>


               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

            <div class="stdpad box-shadow" >
            <div class="table-head"><?=$this->lang->line('application_assigned_agents');?>
             <span class="pull-right">
                  <a href="<?=base_url()?>projects/assign/<?=$project->id;?>" class="btn btn-primary tt" style="padding: 4px 7px 3px;" data-toggle="mainmodal" title="<?=$this->lang->line('application_change_agents');?>"><i class="icon dripicons-gear"></i>
                  </a>
            </span>

            </div>
            <div id="main-nano-wrapper" class="nano">
              <div class="nano-content">
                          <ul class="user-list">
                              <?php foreach ($project->project_has_workers as $workers): ?>
                                  <li>
                                    <img src="<?=$workers->user->userpic?>" class="img-circle list-profile-img " height="21px">
                                    <span class="user-list-name"><?=$workers->user->firstname;?> <?=$workers->user->lastname;?></span>
                                    <ul class="details">
                                      <li>
                                          <span><?=$this->lang->line('application_time_spent_on_project');?></span>
                                          <?=$workers->getAllTasksTime($project->id, $workers->user->id);?>
                                      </li>
                                      <li>
                                          <span><?=$this->lang->line('application_tasks_completed');?></span>
                                          <?=$workers->getDoneTasks($project->id, $workers->user->id);?>
                                      </li>
                                      <li>
                                          <span><?=$this->lang->line('application_tasks_in_progress');?></span>
                                          <?=$workers->getTasksInProgress($project->id, $workers->user->id);?>
                                      </li>
                                    </ul>

                                   </li>
                              <?php  endforeach;
                              ?>
                          </ul>


                          </div>
                        </div>

                </div>
                </div>



            </div>


<div class="row tab-pane fade" role="tabpanel" id="milestones-tab">

    <!--<div class="col-xs-12 col-sm-12 col-lg-12">
        <div class="pull-right" style="padding-top: 20px;">
            <a href="<?/*=base_url()*/?>projects/areas/<?/*=$project->id;*/?>/add" class="btn btn-danger" data-toggle="mainmodal">
                <?/*=$this->lang->line('application_add_area');*/?>
            </a>
        </div>
    </div>-->

    <div id="department-areas">

    <?php foreach ($departments as $department) {?>

    <?php foreach ($department->department_has_areas as $area) {?>
     <div class="col-xs-12 col-sm-12 col-lg-6 department_<?=$department->id?>">
         <div id="areas-list" class="box-shadow">
            <div class="table-head"><?=$area->name;?>
                 <span class=" pull-right">
                      <a href="<?=base_url()?>projects/milestones/<?=$project->id;?>/add/area_id/<?=$area->id?>" class="btn btn-success" data-toggle="mainmodal">
                          <?=$this->lang->line('application_more_milestone');?>
                      </a>
                     <i style="font-size: 17px; vertical-align: middle; padding-right: 4px; padding-left: 4px;" class="icon dripicons-chevron-up collapse-expand" id="department_<?=$department->id?>_area_<?=$area->id?>"></i>
                 </span>
            </div>


<div class="subcont no-padding collapse" id="collapsible_department_<?=$department->id?>_area_<?=$area->id?>">
<ul id="milestones-list" class="todo sortlist sortable-list2">

    <?php  $count = 0;
    foreach ($area->project_has_milestones as $milestone):

        if ($milestone->project_id != $project->id){
            continue;
        }

            $count2 = 0; $count = $count+1;

              $tasksInMilestone = count($milestone->project_has_tasks);
              $taskSize = 100/$tasksInMilestone;
              $completion = 0;
              $multiplier = 0;

              foreach ($milestone->project_has_tasks as $task){

                if ($task->status == "done") {
                  $multiplier ++;
                }

              }

              $completion = round($multiplier * $taskSize, 1);

              $completion = is_nan($completion) ? 0 : $completion;

              $completion = round($completion);
    ?>

        <li id="milestoneLI_<?=$milestone->id;?>" class="hasItems">
            <h1 class="milestones__header ui-state-disabled">
               <i class="ion-android-list milestone__header__icon"></i>
                <?=$milestone->name?>
                <span class="pull-right">
                    <span id="milestone_completion_<?=$milestone->id;?>" style="margin-top: -2px; float: left!important;">
                        <a class="milestone-new-task-btn" href="<?=base_url()?>projects/tasks/<?=$project->id;?>/add/milestone_id/<?=$milestone->id?>" data-toggle="mainmodal"><?=$this->lang->line('application_more_task')?></a>
                        <?=$completion?>%
                    </span>
                    <a href="<?=base_url()?>projects/milestones/<?=$project->id;?>/update/<?=$milestone->id;?>" data-toggle="mainmodal"><i class="icon dripicons-gear milestone__header__right__icon"></i></a>
                </span>
            </h1>

            <ul id="milestonelist_<?=$milestone->id;?>" class="sortable-list">
                <?php  foreach ($milestone->project_has_tasks as $task):   $count2 =  $count2+1;  ?>
                <li id="milestonetask_<?=$task->id;?>" class="<?=$task->status;?> priority<?=$task->priority;?> task-row list-item <?php

                $start = strtotime($task->start_date);
                $end = strtotime($task->due_date);
                $current =  strtotime(date('Y-m-d H:i'));
//
                $completed = (($current - $start) / ($end - $start)) * 100;

                $barSize = $completed >= 100 ? 100 : $completed;

//                $barSize = $barSize * 100;

                if (is_infinite($completed) == false) { if ($completed >= 100) { echo "danger-task"; }else if($completed >= 60){ echo "warning-task"; }}else{ echo "";}

                ?>">
                    <a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/check/<?=$task->id;?>" class="ajax-silent task-check"></a>
                    <input name="form-field-checkbox" class="checkbox-nolabel task-check dynamic-reload" data-reload="tile-pie" data-reload2="milestone_completion_<?=$milestone->id;?>" type="checkbox" data-link="<?=base_url()?>projects/tasks/<?=$project->id;?>/check/<?=$task->id;?>" <?php if ($task->status == "done") {echo "checked";}?>/>
                    <span class="lbl">
                        <p class="truncate name"><?=$task->name;?></p>
                    </span>
                    <?php if ($barSize < 100 && $end != null) { ?>
                    <span style="width: 100px; background: lightgrey; height: 4px; position: absolute; margin-top: 17px;">
                        <span style="width: <?=$barSize?>px; background: #f37474; height: 4px; position: absolute;">
                        </span>
                    </span>
                    <?php } ?>
                    <span class="pull-right">
                        <span class="task-cell-start-date-end-date"><?php if ($task->start_date != null){ ?><?=date("d/m/Y H:i", strtotime($task->start_date));?><?php } ?> <?php if ($task->start_date != null || $task->due_date != null){  ?>➔<?php } ?> <?php if ($task->due_date != null){ ?><?=date("d/m/Y H:i", strtotime($task->due_date));?><?php }else{ ?> <span style="visibility: hidden;"> <?=date("d/m/Y H:i", time());?> </span> <?php } ?></span>
                    <?php if ($task->user_id != 0) {
                ?><img class="img-circle list-profile-img tt" title="<?=$task->user->firstname; ?> <?=$task->user->lastname; ?>"  src="<?=$task->user->userpic; ?>"><?php
            } ?>
                    <?php if ($task->public != 0) {
                ?><span class="list-button"><i class="icon dripicons-preview tt" title="" data-original-title="<?=$this->lang->line('application_task_public'); ?>"></i></span><?php
            } ?>
                    <a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/update/<?=$task->id;?>" class="edit-button" id="a_milestonetask_<?=$task->id;?>" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                    </span>

                </li>
                <?php endforeach;?>
                    <?php if ($count2 == 0) {
                ?>
                      <li class="notask list-item ui-state-disabled"><?=$this->lang->line('application_no_tasks_yet'); ?></li>
                    <?php
            }?>
                </ul>
          </li>
          <?php endforeach;?>



            <?php if ($count == 0) {
                ?>
            <li class="notask list-item ui-state-disabled"><?=$this->lang->line('application_no_milestones_yet'); ?></li>
            <?php
            } ?>
</ul>
                </div>

        </div>
               </div>
    <?php } ?>
    <?php } ?>
    </div>

</div>

<div class="row tab-pane fade" role="tabpanel" id="gantt-tab">
<div class="col-xs-12 col-sm-12">
<div class="box-shadow">
 <div class="table-head">
      <?=$this->lang->line('application_gantt');?>
      <span class="pull-right">
            <div class="btn-group pull-right-responsive margin-right-3">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <?=$this->lang->line('application_show_gantt_by');?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                       <li><a href="#" class="resize-gantt"><?=$this->lang->line('application_gantt_by_milestones');?></a></li>
                       <li><a href="#" class="users-gantt"><?=$this->lang->line('application_gantt_by_agents');?></a></li>
                 </ul>
            </div>
      </span>
 </div>
 <div class="table-div min-height-410 gantt-width">
   <?php
            //get gantt data for Milestones
            $gantt_data = '
                                {
                                  name: "'.htmlspecialchars($project->name).'", desc: "", values: [{
                                label: "", from: "'.$project->start.'", to: "'.$project->end.'", customClass: "gantt-headerline"
                                }]},  ';
            foreach ($project->project_has_milestones as $milestone):
              $counter = 0;
                   foreach ($milestone->project_has_tasks as $task):
                         $milestone_Name = "";
                          if ($counter == 0) {
                              $milestone_Name = $milestone->name;
                              $gantt_data .= '
                                {
                                  name: "'.htmlspecialchars($milestone_Name).'", desc: "", values: [';

                              $gantt_data .= '{
                                label: "", from: "'.$milestone->start_date.'", to: "'.$milestone->due_date.'", customClass: "gantt-timeline"
                                }';
                              $gantt_data .= ']
                                },  ';
                          }

                         $counter++;
                         $start = ($task->start_date) ? $task->start_date : $milestone->start_date;
                         $end = ($task->due_date) ? $task->due_date : $milestone->due_date;
                         $class = ($task->status == "done") ? "ganttGrey" : "";
                         $gantt_data .= '
                          {
                            name: "", desc: "'.htmlspecialchars($task->name).'", values: [';

                          $gantt_data .= '{
                          label: "'.htmlspecialchars($task->name).'", from: "'.$start.'", to: "'.$end.'", customClass: "'.$class.'"
                          }';
                          $gantt_data .= ']
                          },  ';
                   endforeach;
            endforeach;

            //get gantt data for Users
            $gantt_data2 = '
                                { name: "'.htmlspecialchars($project->name).'", desc: "", values: [{
                                label: "", from: "'.$project->start.'", to: "'.$project->end.'", customClass: "gantt-headerline"
                                }]}, ';
            foreach ($project->project_has_workers as $worker):
              $counter = 0;
                   foreach ($worker->getAllTasksInProject($project->id, $worker->user->id) as $task):
                         $user_name = "";
                        if ($counter == 0) {
                            $user_name = $worker->user->firstname." ".$worker->user->lastname;
                            $gantt_data2 .= '
                                {
                                  name: "'.htmlspecialchars($user_name).'", desc: "", values: [';

                            $gantt_data2 .= '{
                                label: "", from: "'.$project->start.'", to: "'.$project->end.'", customClass: "gantt-timeline"
                                }';
                            $gantt_data2 .= ']
                                },  ';
                        }
                         $counter++;
                         $start = ($task->start_date) ? $task->start_date : $project->start;
                         $end = ($task->due_date) ? $task->due_date : $project->end;
                         $class = ($task->status == "done") ? "ganttGrey" : "";
                         $gantt_data2 .= '
                          {
                            name: "", desc: "'.htmlspecialchars($task->name).'", values: [';

                          $gantt_data2 .= '{
                          label: "'.htmlspecialchars($task->name).'", from: "'.$start.'", to: "'.$end.'", customClass: "'.$class.'", dataObj: {"id": '.$task->id.'}
                          }';
                          $gantt_data2 .= ']
                          },  ';
                   endforeach;
            endforeach;

      ?>

        <div class="gantt"></div>
        <div id="gantData">
         <script type="text/javascript">
           $(document).on("click", '.resize-gantt', function (e) {
                    ganttData = [<?=$gantt_data;?>];
                    ganttChart(ganttData);
             });
           $(document).on("click", '.users-gantt', function (e) {
                    ganttData2 = [<?=$gantt_data2;?>];
                    ganttChart(ganttData2);
             });
         </script>
         </div>
</div>
</div>
</div>
</div>

<div class="row tab-pane fade" role="tabpanel" id="media-tab">
<div class="col-xs-12 col-sm-3">
<div class="box-shadow">
<div class="table-head"><?=$this->lang->line('application_files');?>
<span class=" pull-right">
    <a class="btn btn-default toggle-media-view tt" data-original-title="<?=$this->lang->line('application_media_view');?>"><i class="ion-image"></i></a>
    <a class="btn btn-default toggle-media-view hidden tt" data-original-title="<?=$this->lang->line('application_list_view');?>"><i class="ion-android-list"></i></a>
    <a href="<?=base_url()?>projects/media/<?=$project->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_media');?></a>
</span></div>

    <div class="media-uploader">
    <?php $attributes = array('class' => 'dropzone', 'id' => 'dropzoneForm');
        echo form_open_multipart(base_url()."projects/dropzone/".$project->id, $attributes); ?>
    <?php echo form_close();?>
    </div>
 </div>
</div>
<div class="col-xs-12 col-sm-9">


    <div class=" min-height-410 media-view-container">
    <div class="mediaPreviews dropzone"></div>
    <?php
          foreach ($project->project_has_files as $file):
          $type = explode("/", $file->type);
          $thumb = "./files/media/thumb_".$file->savename;

            if (file_exists($thumb)) {
                $filename = base_url()."files/media/thumb_".$file->savename;
            } else {
                $filename = base_url()."files/media/".$file->savename;
            }
    ?>
      <div class="media-galery box-shadow">
           <a href="<?=base_url()?>projects/media/<?=$project->id;?>/view/<?=$file->id;?>">
              <div class="overlay">

                <?=$file->name;?><br><br>
                <i class="ion-android-download"></i> <?=$file->download_counter;?>

              </div>
            </a>
            <div class="file-container">

                  <?php switch ($type[0]) {
                   case "image": ?>
                        <img class="b-lazy"
                           src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
                           data-src="<?=$filename?>"
                           alt="<?=$file->name;?>"
                        />
                  <?php break; ?>

                  <?php default: ?>
                  <div class="icon-box">
                        <i class="ion-ios-copy-outline"></i><br>
                        <?=$type[1]?>
                  </div>
                  <?php break; ?>

                  <?php } ?>
            </div>
            <div class="media-galery--footer"><?=$file->name;?></div>
      </div>

  <?php endforeach; ?>
</div>

<div class="media-list-view-container hidden">
    <div class="box-shadow">
 <div class="table-head"><?=$this->lang->line('application_media');?> <span class=" pull-right"><a href="<?=base_url()?>projects/media/<?=$project->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_media');?></a></span></div>
<div class="table-div min-height-410">
 <table id="media" class="table data-media" rel="<?=base_url()?>projects/media/<?=$project->id;?>" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
          <th class="hidden"></th>
          <th><?=$this->lang->line('application_name');?></th>
          <th class="hidden-xs"><?=$this->lang->line('application_filename');?></th>
          <th class="hidden-xs"><?=$this->lang->line('application_phase');?></th>
          <th class="hidden-xs"><i class="icon dripicons-download"></i></th>
          <th><?=$this->lang->line('application_action');?></th>
          </tr></thead>

        <tbody>
        <?php foreach ($project->project_has_files as $file):?>

        <tr id="<?=$file->id;?>">
          <td class="hidden"><?=human_to_unix($file->date);?></td>
          <td onclick=""><?=$file->name;?></td>
          <td class="hidden-xs"><?=$file->filename;?></td>
          <td class="hidden-xs"><?=$file->phase;?></td>
          <td class="hidden-xs"><span class="label label-info tt" title="<?=$this->lang->line('application_download_counter');?>" ><?=$file->download_counter;?></span></td>
          <td class="option " width="10%">
                <button type="button" class="btn-option btn-xs po tt" title="<?=$this->lang->line('application_delete'); ?>" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>projects/media/<?=$project->id;?>/delete/<?=$file->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a>
                  <button class='btn po-close'><?=$this->lang->line('application_no');?></button>
                  <input type='hidden' name='td-id' class='id' value='<?=$file->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                  <i class="icon dripicons-cross"></i></button>
                <a href="<?=base_url()?>projects/media/<?=$project->id;?>/update/<?=$file->id;?>" title="<?=$this->lang->line('application_edit'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
             </td>

        </tr>

        <?php endforeach;?>



        </tbody></table>
        <?php if (!$project->project_has_files) {
                       ?>
        <div class="no-files">
            <i class="icon dripicons-cloud-upload"></i><br>
            Nenhum arquivo enviado ainda
        </div>
         <?php
                   } ?>
        </div>
    </div>
    </div>
</div>
</div>
<div class="row tab-pane fade" role="tabpanel" id="notes-tab">
<div class="col-xs-12 col-sm-12">
<div class="box-shadow">
<?php $attributes = array('class' => 'note-form', 'id' => '_notes');
    echo form_open(base_url()."projects/notes/".$project->id, $attributes); ?>
 <div class="table-head"><?=$this->lang->line('application_notes');?> <span class=" pull-right"><a id="send" name="send" class="btn btn-primary button-loader"><?=$this->lang->line('application_save');?></a></span><span id="changed" class="pull-right label label-warning"><?=$this->lang->line('application_unsaved');?></span></div>

  <textarea class="input-block-level summernote-note" name="note" id="textfield" ><?=$project->note;?></textarea>
<?php echo form_close();?>
</div>
</div>

</div>

<div class="row tab-pane fade" role="tabpanel" id="activities-tab">
<div class="col-xs-12 col-sm-12">
        <div class="box-shadow">
            <div class="table-head"><?=$this->lang->line('application_activities');?>
            <span class=" pull-right"><a class="btn btn-primary open-comment-box"><?=$this->lang->line('application_new_comment');?></a></span>
            </div>
            <div class="subcont" >

<ul id="comments-ul" class="comments">
                      <li class="comment-item add-comment">
                      <?php
                                $attributes = array('class' => 'ajaxform', 'id' => 'replyform', 'data-reload' => 'comments-ul');
                                echo form_open('projects/activity/'.$project->id.'/add', $attributes);
                                ?>
                      <div class="comment-pic">
                        <img class="img-circle tt" title="<?=$this->user->firstname?> <?=$this->user->lastname?>"  src="<?=$this->user->userpic;?>">

                      </div>
                      <div class="comment-content">
                          <h5><input type="text" name="subject" class="form-control" id="subject" placeholder="<?=$this->lang->line('application_subject');?>..." required/></h5>
                            <p><small class="text-muted"><span class="comment-writer"><?=$this->user->firstname?> <?=$this->user->lastname?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, time()); ?></span></small></p>
                            <p><textarea class="input-block-level summernote" id="reply" name="message" placeholder="<?=$this->lang->line('application_write_message');?>..." required/></textarea></p>
                            <button id="send" name="send" class="btn btn-primary button-loader"><?=$this->lang->line('application_send');?></button>
                            <button id="cancel" name="cancel" class="btn btn-danger open-comment-box"><?=$this->lang->line('application_close');?></button>

                      </div>
                       </form>
                      </li>
<?php foreach ($project->project_has_activities as $activity):?>
                      <?php
                      $writer = false;

                      if ($activity->user_id != 0) {
                          $writer = $activity->user->firstname." ".$activity->user->lastname;
                          $image = $activity->user->userpic;
                      } else {
                          $writer = $activity->client->firstname." ".$activity->client->lastname;
                          $image = $activity->client->userpic;
                      }?>
                      <li class="comment-item">
                      <div class="comment-pic">
                        <?php if ($writer != false) {
                          ?>
                        <img class="img-circle tt" title="<?=$writer?>"  src="<?=$image?>">
                        <?php
                      } else {
                          ?> <i class="icon dripicons-rocket"></i> <?php
                      } ?>
                      </div>
                      <div class="comment-content">
                          <h5><?=$activity->subject;?></h5>
                            <p><small class="text-muted"><span class="comment-writer"><?=$writer?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $activity->datetime); ?></span></small>
                            <?php if ($activity->user_id == $this->user->id) {
                          ?>
                            <a class="pull-right li-delete ajax-silent" href="<?=base_url(); ?>projects/activity/<?=$activity->project_id; ?>/delete/<?=$activity->id; ?>"><i class="icon dripicons-trash"></i></a>
                            <?php
                      } ?>
                            </p>
                            <p><?=$activity->message;?></p>
                      </div>
                      </li>
  <?php endforeach;?>
                      <li class="comment-item">
                        <div class="comment-pic"><i class="icon dripicons-rocket"></i></div>
                          <div class="comment-content">
                          <h5><?=$this->lang->line('application_project_created');?></h5>
                            <p><small class="text-muted"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $project->datetime); ?></small></p>
                            <p><?=$this->lang->line('application_project_has_been_created');?></p>
                          </div>
                      </li>
         </ul>




</div>
</div>
</div>
</div>

 <script type="text/javascript">



  $(document).ready(function(){
    $(document).on("click", '.li-delete', function (e) {
      $(this).parents('li').slideUp();
    });

    // var notCollapsed = localStorage.getItem('not-colapsed');
    // $('#'+notCollapsed).removeClass('collapse');


    $("body").on('DOMSubtreeModified', "#milestones-tab", function() {
        var departmentlink = window.localStorage.getItem('departmentlink');
        var $el = $('.' + departmentlink).fadeIn(450);
        $('#department-areas > div').not($el).hide();
    });


    $(document).on("click", '.toggle-closed-tasks', function (e) {
      $("li.done").toggleClass("hidden");
      if(localStorage.hide_tasks == "1"){
          localStorage.removeItem("hide_tasks");
           $(".toggle-closed-tasks").css("opacity", "1");
      }else{
          localStorage.setItem("hide_tasks", "1");
           $(".toggle-closed-tasks").css("opacity", "0.6");
      }
  });
  hideClosedTasks();
  blazyloader();
dropzoneloader("<?php echo base_url()."projects/dropzone/".$project->id; ?>", "<?=addslashes($this->lang->line('application_drop_files_here_to_upload'));?>");

 //chartjs
  var ctx = document.getElementById("projectChart");
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?=$labels?>],
      datasets: [{
        label: "<?=$this->lang->line("application_task_due");?>",
        backgroundColor: "rgba(215,112,173,0.3)",
        borderColor: "rgba(215,112,173,1)",
        pointBorderColor: "rgba(0,0,0,0)",
        pointBackgroundColor: "#ffffff",
        pointHoverBackgroundColor: "rgba(237, 85, 101, 0.5)",
        pointHitRadius: 25,
        pointRadius: 1,
        borderWidth:2,
        data: [<?=$line1?>],
      },{
        label: "<?=$this->lang->line("application_task_start");?>",
        backgroundColor: "rgba(79,193,233,0.6)",
        borderColor: "rgba(79, 193, 233, 1)",
        pointBorderColor: "rgba(79, 193, 233, 0)",
        pointBackgroundColor: "#ffffff",
        pointHoverBackgroundColor: "rgba(79, 193, 233, 1)",
        pointHitRadius: 25,
        pointRadius: 1,
        borderWidth:2,
        data: [<?=$line2?>],
      }
      ]
    },
    options: {
      title: {
            display: true,
            text: ' '
        },
      legend:{
        display: false
      },
      scales: {

        yAxes: [{
          display: false,
          ticks: {
                      beginAtZero:true,
                      maxTicksLimit:6,
                      padding:20
                  }
        }],
        xAxes: [{
          display: false,
          ticks: {
                      beginAtZero:true,
                  }
        }]
      }
    }
  });


        $(".toggle-media-view").on("click", function(){
            $(".media-view-container").toggleClass('hidden');
            $(".toggle-media-view").toggleClass('hidden');
            $(".media-list-view-container").toggleClass('hidden');

        });

      $(".department-link").on("click", function(){

          var $el = $('.' + this.id).fadeIn(450);
          $('#department-areas > div').not($el).hide();
          $('#departments-drop-menu').html($(this).data('name'));

          window.localStorage.setItem("departmentlink", this.id);

      });

      $(".project-overview-menu").on("click", function(){

          $('#project-overview-dropdown-menu').html($(this).data('name'));

      });

      $("body").on('click', '.collapse-expand', function() {
          $('#collapsible_'+this.id).toggleClass('collapse');
          $(this).toggleClass('dripicons-chevron-up dripicons-chevron-down');

          // if ($('#collapsible_'+this.id).hasClass('collapse')){
          //     window.localStorage.removeItem("not-collapsed", this.id);
          // }else{
          //     window.localStorage.setItem("not-collapsed", "collapsible_"+this.id);
          // }

      });

      $(".task-row").dblclick(function() {
          $('#a_'+this.id).click();
      });


        <?php if ($go_to_taskID) {
                          ?>
            $("#task_menu_link").click();
            $("#task_<?=$go_to_taskID; ?> p.name").click();
        <?php
        } ?>

 });

</script>
  <div id="tkKey" class="hidden"><?=$this->security->get_csrf_hash();?></div>
  <div id="baseURL" class="hidden"><?=base_url();?>projects/</div>
  <div id="projectId" class="hidden"><?=$project->id;?></div>
