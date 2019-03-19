

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

                <!--  ABA DE TAREFAS ESCONDIDA PARA LEVAR TAREFAS PARA PACOTES DE TRABALHO / ESCONDIDO  -->
                <li role="presentation" class="hidden-xs"><a href="#tasks-tab" id="task_menu_link" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?php if ($mytasks != 0) {
                            ?><span class="badge"><?=$mytasks?></span><?php
                        } ?><?=$this->lang->line('application_tasks');?></a></li>
                <!--  -->

                <li role="presentation" class="hidden-xs"><a href="#milestones-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_milestones');?></a></li>

                <!-- GRAFICO DE GANTT / ESCONDIDO -->
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
                        id="myTabDrop1"
                        class="dropdown-toggle"
                        data-toggle="dropdown"
                        aria-controls="myTabDrop1-contents"
                        aria-expanded="false">
                        <?=$this->lang->line('application_overview');?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                        <li role="presentation"><a href="#projectdetails-tab" aria-controls="projectdetails-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_project_details');?></a></li>
                        <li role="presentation"><a href="#tasks-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?php if ($mytasks != 0) {
                                    ?><span class="badge submenu-badge"><?=$mytasks?></span><?php
                                } ?><?=$this->lang->line('application_tasks');?></a></li>
                        <li role="presentation" ><a href="#milestones-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_milestones');?></a></li>
                        <li role="presentation" ><a href="#gantt-tab" class="resize-gantt" aria-controls="gantt-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_gantt');?></a></li>
                        <li role="presentation"><a href="#media-tab" aria-controls="media-tab"  class="media-tab-trigger" role="tab" data-toggle="tab"><?=$this->lang->line('application_files');?></a></li>
                        <li role="presentation"><a href="#notes-tab" aria-controls="notes-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_notes');?></a></li>
                        <?php if ($invoice_access) {
                            ?>
                            <li role="presentation"><a href="#invoices-tab" aria-controls="invoices-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_invoices'); ?></a></li>
                            <?php
                        } ?>
                        <li role="presentation"><a href="#activities-tab" aria-controls="activities-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_activities');?></a></li>
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
                        <a href="<?=base_url()?>projects/tracking/<?=$project->id; ?>" class="tt" title="<?=$this->lang->line('application_start_timer'); ?>"><i class="icon dripicons-clock"></i> </a>
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
                        <li><span><?=$this->lang->line('application_start_date');?></span> <?php  $unix = human_to_unix($project->start.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
                        <li><span><?=$this->lang->line('application_deadline');?></span> <?php  $unix = human_to_unix($project->end.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
                        <li><span><?=$this->lang->line('application_project');?> - <?=$this->lang->line('application_time_spent');?></span> <?=$time_spent;?> <a href="<?=base_url()?>projects/timer_reset/<?=$project->id;?>" class="tt" title="<?=$this->lang->line('application_reset_timer');?>"><i class="icon dripicons-time-reverse"></i></a> <a href="<?=base_url()?>projects/timer_set/<?=$project->id;?>" data-toggle="mainmodal" class="tt" style="    margin-left: 7px;" title="<?=$this->lang->line('application_timer_set');?>"><i class="icon dripicons-clock"></i></a></li>
                        <li><span><?=$this->lang->line('application_tasks');?> - <?=$this->lang->line('application_time_spent');?></span> <?=Project::getAllTasksTime($project->id);?> </li>

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
                            <?php foreach ($project->project_has_activities as $value) {
                                ?>
                                <li>
                                    <h3 class="activity__list--header">
                                        <?php echo time_ago($value->datetime); ?>
                                    </h3>
                                    <p class="activity__list--sub truncate">
                                        <?php if (is_object($value->user)) {
                                            echo $value->user->firstname." ".$value->user->lastname.' <a href="'.base_url().'projects/view/'.$value->project->id.'">'.$value->project->name."</a>";
                                        } ?>
                                    </p>
                                    <div class="activity__list--body">
                                        <?=character_limiter(str_replace(array("\r\n", "\r", "\n",), "", strip_tags($value->message)), 260); ?>
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


    <div class="row tab-pane fade" role="tabpanel" id="tasks-tab">
        <div class="col-xs-12 col-sm-12 task-container-left">
            <div class="box-shadow">
                <div class="table-head"><?=$this->lang->line('application_tasks');?>
                    <span class=" pull-right">
                 <a class="btn btn-success toggle-closed-tasks tt" data-original-title="<?=$this->lang->line('application_hide_completed_tasks');?>" >
                          <i class="ion-checkmark-circled"></i>
                      </a>
                      <a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/add" class="btn btn-primary" data-toggle="mainmodal">
                          <?=$this->lang->line('application_add_task');?>
                      </a>
                 </span>
                </div>


                <div class="subcont no-padding min-height-410">
                    <div class="task__quick-add">
                        <?php $attributes = array('class' => 'quick-add-task', 'data-reload' => 'task-list', 'data-reload2' => 'milestones-list', 'data-reload3' => 'areas-list', 'data-baseurl' => base_url().'projects/tasks/'.$project->id.'/', 'id' => '_task');
                        $formURL = base_url()."projects/quicktask";
                        echo form_open($formURL, $attributes); ?>
                        <input type="text" id="quick-add-task-name" autocomplete="off" name="name" placeholder="<?=$this->lang->line('application_add_new_task...');?>" />
                        <div class="priority-selector--group">
                            <span class="priority-selector priority-selector--high tt" data-priority="3" data-original-title="<?=$this->lang->line('application_high_priority');?>"></span>
                            <span class="priority-selector priority-selector--mid tt" data-priority="2" data-original-title="<?=$this->lang->line('application_med_priority');?>"></span>
                            <span class="priority-selector priority-selector--low tt" data-priority="1" data-original-title="<?=$this->lang->line('application_low_priority');?>"></span>
                        </div>
                        <input type="hidden" class="priority-input" name="priority" value="1" />
                        <input type="hidden" name="project_id" value="<?=$project->id?>" />
                        <input type="hidden" name="user_id" value="<?=$this->user->id?>" />
                        <input type="hidden" name="status" value="open" />
                        <input type="hidden" name="public" value="0" />
                        <input type="hidden" name="public" value="0" />
                        <input type="hidden" name="task_order" value="0" />
                        <input type="hidden" name="start_date" value="<?=date('Y-m-d', time())?>" />
                        <?php echo form_close();?>

                        <li id="task_dummy" class="open list-item owntask hidden">
                            <a id="dummy-href" href="" class="ajax-silent task-check"></a>

                            <input id="dummy-href2" name="form-field-checkbox" class="checkbox-nolabel task-check dynamic-reload" data-reload="tile-pie" type="checkbox" data-link="" />
                            <span class="lbl"> <p class="truncate name pointer" data-taskid="task-details-dummy"> </p></span>
                            <span class="pull-right">
                                            <img class="img-circle list-profile-img tt"  title="<?=$this->user->firstname;?> <?=$this->user->lastname;?>"  src="<?=$this->user->userpic;?>">
                                            <span class="list-button">
                                              <a id="dummy-href3" href="" data-toggle="mainmodal">
                                                    <i class="icon dripicons-gear" title="" ></i>
                                              </a>
                                            </span>
                                        </span>
                        </li>
                    </div>
                    <div>
                        <ul id="task-list" class="todo sortlist sortable-list">
                            <?php
                            $count = 0;
                            $task_list = ($project->hide_tasks == 1 && $this->user->admin == 0) ? $allmytasks : $project->project_has_tasks;
                            foreach ($task_list as $value):  $count = $count+1; ?>

                                <li id="task_<?=$value->id;?>" class="<?=$value->status;?> priority<?=$value->priority;?> list-item <?php if ($value->user_id == $this->user->id) {
                                    echo "owntask";
                                }?>">

                                    <a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/check/<?=$value->id;?>" class="ajax-silent task-check"></a>

                                    <input name="form-field-checkbox" class="checkbox-nolabel task-check dynamic-reload" data-reload="tile-pie" type="checkbox" data-link="<?=base_url()?>projects/tasks/<?=$project->id;?>/check/<?=$value->id;?>" <?php if ($value->status == "done") {
                                        echo "checked";
                                    }?>
                                        <?php if ($value->invoice_id != 0) {
                                            echo 'disabled="disabled"';
                                        }  ?>
                                    />
                                    <span class="lbl"> <p class="truncate name pointer" data-taskid="task-details-<?=$value->id;?>"><?=$value->name;?></p></span>
                                    <span class="pull-right">
                                  <?php if ($value->invoice_id != 0) {
                                      ?>
                                      <span class="list-button task-lock-<?=$value->id?>">
                                          <i class="icon dripicons-lock tt" title="" data-original-title="<?=$this->lang->line('application_task_has_been_invoiced'); ?>"></i>
                                        </span>
                                      <?php
                                  } ?>
                                        <?php if ($value->tracking != 0) {
                                            ?>
                                            <span class="list-button">
                                          <i class="icon dripicons-stopwatch tt" title="" data-original-title="<?=$this->lang->line('application_running_timer'); ?>"></i>
                                        </span>
                                            <?php
                                        } ?>
                                        <?php if ($value->public != 0) {
                                            ?>
                                            <span class="list-button">
                                          <i class="icon dripicons-preview task__icon tt" title="" data-original-title="<?=$this->lang->line('application_task_public'); ?>"></i>
                                        </span>
                                            <?php
                                        } ?>
                                        <?php if ($value->created_by_client != 0) {
                                            ?>
                                            <span class="list-button">
                                          <i class="ion-bookmark task__icon tt" title="" data-original-title="<?=$this->lang->line('application_created_by_client'); ?>"></i>
                                        </span>
                                            <?php
                                        } ?>
                                        <?php if ($value->user_id != 0) {
                                            ?>
                                            <img class="img-circle list-profile-img tt"  title="<?=$value->user->firstname; ?> <?=$value->user->lastname; ?>"  src="<?=$value->user->userpic; ?>">
                                            <?php
                                        } ?>
                                        <?php if ($value->client_id != 0) {
                                            ?>
                                            <img class="img-circle list-profile-img tt"  title="<?=$value->client->firstname; ?> <?=$value->client->lastname; ?>"  src="<?=$value->client->userpic; ?>">
                                            <?php
                                        } ?>

                                        <span class="list-button">
                                          <a href="<?=base_url();?>projects/tasks/<?=$project->id?>/update/<?=$value->id?>" data-toggle="mainmodal">
                                                <i class="icon dripicons-gear"></i>
                                          </a>
                                        </span>



                                  </span>


                                </li>
                            <?php endforeach;?>
                            <?php if ($count == 0) {
                                ?>
                                <li class="notask list-item ui-state-disabled"><?=$this->lang->line('application_no_tasks_yet'); ?></li>
                                <?php
                            } ?>



                        </ul> </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 pin-to-top">

            <div id="taskviewer-content" class="subcont taskviewer-content box-shadow">
                <?php foreach ($task_list as $value): ?>
                    <div id="task-details-<?=$value->id;?>" class="todo-details">
                        <i class="ion-close pull-right todo__close"></i>
                        <span class="x-edit-large"><h4 data-name="name" class="editable synced-edit" data-syncto="task_<?=$value->id;?>" data-inputclass="inline__edit__title" data-showbuttons="false" data-type="text" data-pk="<?=$value->id;?>" data-url="<?=base_url()?>projects/task_change_attribute">
                            <?=$value->name;?>
                        </h4> </span>
                        <div class="progress tt" style="margin-top: 10px;" data-original-title="<?=$value->progress;?>%">
                            <div id="progress-bar<?=$value->id;?>" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?=$value->progress;?>%;" ></div>
                        </div>
                        <div class="grid grid--bleed task__options">

                        </div>
                        <ul class="details">

                            <?php if ($value->invoice_id != 0) {
                                ?>
                                <li class="task-lock">
                                <span class="red">
                                    <i class="icon dripicons-lock tt unlock-task ajax-click-request" data-hide="task-lock" data-url="<?=base_url(); ?>projects/tasks/<?=$value->project_id?>/unlock/<?=$value->id?>" title="" data-original-title="<?=$this->lang->line('application_unlock_task'); ?>"></i>
                                    <?=$this->lang->line('application_task_has_been_invoiced'); ?>: <a href="<?=base_url(); ?>invoices/view/<?=$value->invoice_id?>"><?=$core_settings->invoice_prefix; ?><?=$value->invoice->reference; ?></a>
                                </span>
                                </li>
                                <?php
                            } ?>
                            <li>
                                <span><?=$this->lang->line('application_time_spent');?></span>

                                <?php if ($value->tracking != 0 && $value->tracking != "") {
                                    $timertime=(time()-$value->tracking)+$value->time_spent;
                                    $state = "resume";
                                } else {
                                    $timertime = ($value->time_spent != 0 && $value->time_spent != "") ? $value->time_spent : 0;
                                    $state = "pause";
                                } ?>

                                <span id="timer<?=$value->id;?>" class="timer__span badge timer__badge <?=$state?>" data-timerstate="<?=$state;?>" data-timertime="<?=$timertime;?>"></span>
                                <script>$( document ).ready(function() { startTimer("<?=$state;?>", "<?=$timertime;?>", "#timer<?=$value->id;?>"); });</script>
                                <?php if ($value->user_id == $this->user->id && $value->invoice_id == 0) {
                                    ?>
                                    <?php if ($value->tracking != 0 && $value->tracking != "") {
                                        $start = "hidden";
                                        $stop = "";
                                    } else {
                                        $start = "";
                                        $stop = "hidden";
                                    } ?>
                                    <a href="<?=base_url(); ?>projects/task_start_stop_timer/<?=$value->id?>" data-timerid="timer<?=$value->id; ?>" class=" ajax-silent task__options__button task__options__button--green task__options__timer timer<?=$value->id; ?> <?=$start?>">
                                        <?=$this->lang->line('application_start_timer'); ?>
                                    </a>

                                    <a href="<?=base_url(); ?>projects/task_start_stop_timer/<?=$value->id?>" data-timerid="timer<?=$value->id; ?>" class="ajax-silent task__options__button task__options__button--red task__options__timer timer<?=$value->id; ?> <?=$stop?>">
                                        <?=$this->lang->line('application_stop_timer'); ?>
                                    </a>

                                    <?php
                                } ?>
                                <a href="<?=base_url();?>projects/timesheets/<?=$value->id?>" class="timer__icon_button tt" data-original-title="<?=$this->lang->line('application_timesheet');?>" data-toggle="mainmodal">
                                    <i class="icon dripicons-list"></i>
                                </a>
                            </li>
                            <li>
                                <span><?=$this->lang->line('application_assigned_to_agent');?></span>
                                <?php if ($value->user_id != 0 && $value->user_id != "") {
                                    $pic = $value->user->userpic;
                                    echo "<img src=\"$pic\" class=\"img-circle list-profile-img \" height=\"21px\"> ";
                                    echo $value->user->firstname." ".$value->user->lastname;
                                } else {
                                    echo $this->lang->line('application_not_assigned');
                                }?>
                            </li>
                            <li>
                                <span><?=$this->lang->line('application_priority');?></span>
                                <?php switch ($value->priority) {case "0": echo $this->lang->line('application_no_priority'); break; case "1": echo $this->lang->line('application_low_priority'); break; case "2": echo $this->lang->line('application_med_priority'); break; case "3": echo $this->lang->line('application_high_priority'); break;};?>
                            </li>
                            <li>
                                <span><?=$this->lang->line('application_progress');?></span>
                                <a href="#" data-name="progress" class="editable synced-process-edit" data-syncto="progress-bar<?=$value->id;?>" data-type="range" data-pk="<?=$value->id;?>" data-url="<?=base_url()?>projects/task_change_attribute"><?=$value->progress;?></a>
                                <span class="progress-task-percent">%</span>
                            </li>
                            <?php if ($value->value != 0) {
                                ?>
                                <li>
                                    <span><?=$this->lang->line('application_value'); ?></span>
                                    <!-- <a href="#" data-name="value" class="editable" data-type="text" data-pk="<?=$value->id; ?>" data-url="<?=base_url()?>projects/task_change_attribute"> -->
                                    <?=$value->value; ?>
                                    <!-- </a> -->
                                </li>
                                <?php
                            } ?>
                            <?php if ($value->start_date != "") {
                                ?>
                                <li>
                                    <span><?=$this->lang->line('application_start_date'); ?></span>
                                    <?php  $unix = human_to_unix($value->start_date.' 00:00');
                                    echo date($core_settings->date_format, $unix); ?>
                                </li>
                                <?php
                            } ?>
                            <?php if ($value->due_date != "") {
                                ?>
                                <li> <?php $overdue = ($value->due_date < date("Y-m-d", time())) ? "label label-important" : ""; ?>
                                    <span><?=$this->lang->line('application_due_date'); ?></span>
                                    <span class="<?=$overdue?>"><?php  $unix = human_to_unix($value->due_date.' 00:00');
                                        echo date($core_settings->date_format, $unix); ?></span>
                                </li>
                                <?php
                            } ?>
                            <?php if ($value->created_by_client != 0 && $value->created_by_client != "") {
                                ?>
                                <li>
                                    <span><?=$this->lang->line('application_created_by_client'); ?></span>
                                    <?php $pic = $value->creator->userpic;
                                    echo "<img src=\"$pic\" class=\"img-circle list-profile-img \" height=\"21px\"> "; ?>
                                    <?=$value->creator->firstname; ?> <?=$value->creator->lastname; ?>
                                </li>
                                <?php
                            } ?>
                            <?php if ($value->client_id != 0  && $value->client_id != "") {
                                ?>
                                <li>
                                    <span><?=$this->lang->line('application_assigned_to_client'); ?></span>
                                    <?php $pic = $value->client->userpic;
                                    echo "<img src=\"$pic\" class=\"img-circle list-profile-img \" height=\"21px\"> "; ?>
                                    <?=$value->client->firstname; ?> <?=$value->client->lastname; ?>
                                </li>
                                <?php
                            } ?>

                            <li>
                                <span><?=$this->lang->line('application_milestone');?></span>
                                <!-- <a href="#" data-name="milestone_id" class="editable-select" data-type="select" data-pk="<?=$value->id;?>" data-url="<?=base_url()?>projects/task_change_attribute"> -->
                                <?php if ($value->milestone_id != 0 && $value->milestone_id != "") {
                                    echo $value->project_has_milestone->name;
                                } else {
                                    echo $this->lang->line('application_no_milestone_assigned');
                                }?> <!--</a> -->
                            </li>
                            <?php if ($value->description != "") {
                                ?>
                                <li>
                                    <span><?=$this->lang->line('application_description'); ?></span>
                                    <p><?=$value->description; ?></p>
                                </li>
                                <?php
                            } ?>

                            <li class="comment-list-li">
                                <span><?=$this->lang->line('application_comments');?></span>

                                <div class="form-group filled chat_message_input">
                                    <?php
                                    $attributes = array('class' => 'ajaxform', 'id' => 'write-comment');
                                    echo form_open_multipart('projects/task_comment/'.$value->id.'/create', $attributes);
                                    ?>

                                    <textarea name="message" class="form-control autogrow message" placeholder="<?=$this->lang->line('application_write_message');?>"></textarea>
                                    <span class="options">

                                          <i class="ion-ios-paperplane-outline tt chat-submit" title="<?=$this->lang->line('application_send');?>"></i>
                                          <i class="ion-android-attach tt chat-attach" title="<?=$this->lang->line('application_attachment');?>"></i>
                                          <input type="file" name="userfile" data-image-holder="image_holder_<?=$value->id?>" class="chat-attachment hidden">

                                      </span>
                                    <div class="chat-image-preview" id="image_holder_<?=$value->id?>" >

                                    </div>


                                    <?php echo form_close(); ?>
                                </div>
                                <ul class="task-comments">
                                    <?php
                                    usort($value->task_has_comments, "cmpDatetime");
                                    foreach ($value->task_has_comments as $comments) {
                                        if (!empty($comments->attachment)) {
                                            $mime = explode("/", get_mime_by_extension($comments->attachment));
                                        } ?>
                                        <li>
                                            <div class="task-comments-header">
                                                <?php echo (is_object($comments->user)) ? $comments->user->firstname." ".$comments->user->lastname : $comments->client->firstname." ".$comments->client->lastname; ?>
                                                <span class="time"><?php echo time_ago($comments->datetime); ?></span>
                                            </div>
                                            <span>
                                                <?php echo nl2br($comments->message); ?>
                                            </span>
                                            <?php if ($comments->attachment != "") {
                                                ?>
                                                <div>
                                                    <?php if ($mime[0] == "image") {
                                                        ?>
                                                        <a href="<?=base_url()?>files/media/<?=$comments->attachment_link?>" data-lightbox="image-<?=$comments->id?>" data-title="<?=$comments->attachment?>">
                                                            <img
                                                                class="image_holder b-lazy"
                                                                src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
                                                                data-src="<?=base_url()?>files/media/<?=$comments->attachment_link?>"
                                                            />
                                                        </a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="tt" href="<?=base_url()?>projects/download/false/<?=$comments->attachment_link?>"  title="<?=$comments->attachment?>">
                                                            <i class="ion-android-attach"></i> <?=$comments->attachment?>
                                                        </a>
                                                        <?php
                                                    } ?>
                                                </div>
                                                <?php
                                            } ?>
                                            <div class="task-comments-footer green">
                                                <i class="ion-android-done"></i>
                                            </div>
                                        </li>
                                        <?php
                                    } ?>
                                </ul>

                                <div class="chat-message-add-template">
                                    <div class="task-comments-header">
                                        <?php echo $this->user->firstname." ".$this->user->lastname; ?>
                                    </div>
                                    <span style="white-space: pre-line">[[message]]</span>

                                    <div class="task-comments-footer">
                                        <i class="ion-android-done"></i>
                                    </div>
                                </div>


                            </li>
                        </ul>


                    </div>
                <?php endforeach;?>


            </div>
        </div>
    </div>



    <div class="row tab-pane fade" role="tabpanel" id="milestones-tab">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="box-shadow">
                <div class="table-head"><?=$this->lang->line('application_milestones');?>
                    <span class=" pull-right">
                      <a href="<?=base_url()?>projects/milestones/<?=$project->id;?>/add" class="btn btn-primary" data-toggle="mainmodal">
                          <?=$this->lang->line('application_add_milestone');?>
                      </a>
                 </span>
                </div>


                <div class="subcont no-padding min-he   ight-410">
                    <ul id="milestones-list" class="todo sortlist sortable-list2">
                        <?php  $count = 0;
                        foreach ($project->project_has_milestones as $milestone):
                            $count2 = 0; $count = $count+1;

                            $tasksInMilestone = count($milestone->project_has_tasks);
                            $taskSize = 100/$tasksInMilestone;
                            $completion = 0;
                            $multiplier = 0;

                            foreach ($milestone->project_has_tasks as $value){

                                if ($value->status == "done") {
                                    $multiplier ++;
                                }

                            }

                            $completion = round($multiplier * $taskSize, 1);

                            $completion = is_nan($completion) ? 0 : $completion;

                            $color = $completion == 100 ? "bgColor18" : "";
                            ?>

                            <li id="milestoneLI_<?=$milestone->id;?>" class="hasItems">
                                <h1 class="milestones__header ui-state-disabled <?=$color?>">
                                    <i class="ion-android-list milestone__header__icon"></i>
                                    <?=$milestone->name?>
                                    <span class="pull-right">
                    <span id="milestone_completion_<?=$milestone->id;?>" style="margin-top: -2px; float: left!important;">
                        <a class="milestone-new-task-btn btn-primary" href="<?=base_url()?>projects/tasks/<?=$project->id;?>/add/milestone_id/<?=$milestone->id?>" data-toggle="mainmodal"><?=$this->lang->line('application_add_task')?></a>
                        <?=$completion?>% <?=$this->lang->line('application_completed'); ?>
                    </span>
                    <a href="<?=base_url()?>projects/milestones/<?=$milestone->project_id;?>/update/<?=$milestone->id;?>" data-toggle="mainmodal"><i class="icon dripicons-gear milestone__header__right__icon"></i></a>
                </span>
                                </h1>

                                <ul id="milestonelist_<?=$milestone->id;?>" class="sortable-list">
                                    <?php  foreach ($milestone->project_has_tasks as $value):   $count2 =  $count2+1;  ?>
                                        <li id="milestonetask_<?=$value->id;?>" class="<?=$value->status;?> priority<?=$value->priority;?> list-item <?php

                                        $start = strtotime($value->start_date);
                                        $end = strtotime($value->due_date);
                                        $current =  strtotime(date('Y-m-d H:i'));

                                        $completed = (($current - $start) / ($end - $start)) * 100;

                                        if ($completed >= 100) { echo "danger-task"; }else if($completed >= 60){ echo "warning-task"; }

                                        ?>">
                                            <a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/check/<?=$value->id;?>" class="ajax-silent task-check"></a>
                                            <input name="form-field-checkbox" class="checkbox-nolabel task-check dynamic-reload" data-reload="tile-pie" data-reload2="milestone_completion_<?=$milestone->id;?>" type="checkbox" data-link="<?=base_url()?>projects/tasks/<?=$project->id;?>/check/<?=$value->id;?>" <?php if ($value->status == "done") {
                                                echo "checked";
                                            }?>/>
                                            <span class="lbl">
                        <p class="truncate name"><?=$value->name;?></p>
                    </span>
                                            <span class="pull-right">
                        <span class="task-cell-start-date-end-date"><?php if ($value->start_date != null){ ?><?=date("d/m/Y H:i", strtotime($value->start_date));?><?php } ?> <?php if ($value->start_date != null || $value->due_date != null){  ?>➔<?php } ?> <?php if ($value->due_date != null){ ?><?=date("d/m/Y H:i", strtotime($value->due_date));?><?php }else{ ?> <span style="visibility: hidden;"> <?=date("d/m/Y H:i", time());?> </span> <?php } ?></span>
                    <?php if ($value->user_id != 0) {
                        ?><img class="img-circle list-profile-img tt"  title="<?=$value->user->firstname; ?> <?=$value->user->lastname; ?>"  src="<?=$value->user->userpic; ?>"><?php
                    } ?>
                                                <?php if ($value->public != 0) {
                                                    ?><span class="list-button"><i class="icon dripicons-preview tt" title="" data-original-title="<?=$this->lang->line('application_task_public'); ?>"></i></span><?php
                                                } ?>
                    <a href="<?=base_url()?>projects/tasks/<?=$project->id;?>/update/<?=$value->id;?>" class="edit-button" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
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


        <!-- GRADE DE TAREFAS SEM PACOTE DE TRABALHO ESCONDIDO / ESCONDIDO -->
        <!--<div class="col-xs-12 col-sm-12 col-lg-6">
            <div class="box-shadow">
             <div class="table-head">
                <?/*=$this->lang->line('application_tasks_without_milestone');*/?>
            </div>
            <div class="subcont no-padding min-height-410">
            <ul id="task-list2" class="todo sortable-list">
                <?php /*$count3 = 0; foreach ($tasksWithoutMilestone as $value):   $count3 =  $count3+1;  */?>
                <li id="milestonetask_<?/*=$value->id;*/?>" class="<?/*=$value->status;*/?> priority<?/*=$value->priority;*/?> list-item">
                    <a href="<?/*=base_url()*/?>projects/tasks/<?/*=$project->id;*/?>/check/<?/*=$value->id;*/?>" class="ajax-silent task-check"></a>
                    <input name="form-field-checkbox" class="checkbox-nolabel task-check dynamic-reload" data-reload="tile-pie" type="checkbox" data-link="<?/*=base_url()*/?>projects/tasks/<?/*=$project->id;*/?>/check/<?/*=$value->id;*/?>" <?php /*if ($value->status == "done") {
                echo "checked";
            }*/?>/>
                    <span class="lbl">
                        <p class="truncate name"><?/*=$value->name;*/?></p>
                    </span>
                    <span class="pull-right">
                    <?php /*if ($value->user_id != 0) {
                */?><img class="img-circle list-profile-img tt"  title="<?/*=$value->user->firstname; */?> <?/*=$value->user->lastname; */?>"  src="<?/*=$value->user->userpic; */?>"><?php
        /*            } */?>
                    <?php /*if ($value->public != 0) {
                */?><span class="list-button"><i class="icon dripicons-preview tt" title="" data-original-title="<?/*=$this->lang->line('application_task_public'); */?>"></i></span><?php
        /*            } */?>
                    <a href="<?/*=base_url()*/?>projects/tasks/<?/*=$project->id;*/?>/update/<?/*=$value->id;*/?>" class="edit-button" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                    </span>

                </li>
                <?php /*endforeach;*/?>
                    <?php /*if ($count3 == 0) {
                */?>
                      <li class="notask list-item ui-state-disabled"><?/*=$this->lang->line('application_no_tasks_without_milestone'); */?></li>
                    <?php
        /*            }*/?>
                </ul>
            </div>
            </div>
            </div>-->


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
                        foreach ($milestone->project_has_tasks as $value):
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
                            $start = ($value->start_date) ? $value->start_date : $milestone->start_date;
                            $end = ($value->due_date) ? $value->due_date : $milestone->due_date;
                            $class = ($value->status == "done") ? "ganttGrey" : "";
                            $gantt_data .= '
                          {
                            name: "", desc: "'.htmlspecialchars($value->name).'", values: [';

                            $gantt_data .= '{
                          label: "'.htmlspecialchars($value->name).'", from: "'.$start.'", to: "'.$end.'", customClass: "'.$class.'"
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
                        foreach ($worker->getAllTasksInProject($project->id, $worker->user->id) as $value):
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
                            $start = ($value->start_date) ? $value->start_date : $project->start;
                            $end = ($value->due_date) ? $value->due_date : $project->end;
                            $class = ($value->status == "done") ? "ganttGrey" : "";
                            $gantt_data2 .= '
                          {
                            name: "", desc: "'.htmlspecialchars($value->name).'", values: [';

                            $gantt_data2 .= '{
                          label: "'.htmlspecialchars($value->name).'", from: "'.$start.'", to: "'.$end.'", customClass: "'.$class.'", dataObj: {"id": '.$value->id.'}
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
                foreach ($project->project_has_files as $value):
                    $type = explode("/", $value->type);
                    $thumb = "./files/media/thumb_".$value->savename;

                    if (file_exists($thumb)) {
                        $filename = base_url()."files/media/thumb_".$value->savename;
                    } else {
                        $filename = base_url()."files/media/".$value->savename;
                    }
                    ?>
                    <div class="media-galery box-shadow">
                        <a href="<?=base_url()?>projects/media/<?=$project->id;?>/view/<?=$value->id;?>">
                            <div class="overlay">

                                <?=$value->name;?><br><br>
                                <i class="ion-android-download"></i> <?=$value->download_counter;?>

                            </div>
                        </a>
                        <div class="file-container">

                            <?php switch ($type[0]) {
                                case "image": ?>
                                    <img class="b-lazy"
                                         src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==
                                         data-src="<?=$filename?>"
                                         alt="<?=$value->name;?>"
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
                        <div class="media-galery--footer"><?=$value->name;?></div>
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
                            <?php foreach ($project->project_has_files as $value):?>

                                <tr id="<?=$value->id;?>">
                                    <td class="hidden"><?=human_to_unix($value->date);?></td>
                                    <td onclick=""><?=$value->name;?></td>
                                    <td class="hidden-xs"><?=$value->filename;?></td>
                                    <td class="hidden-xs"><?=$value->phase;?></td>
                                    <td class="hidden-xs"><span class="label label-info tt" title="<?=$this->lang->line('application_download_counter');?>" ><?=$value->download_counter;?></span></td>
                                    <td class="option " width="10%">
                                        <button type="button" class="btn-option btn-xs po tt" title="<?=$this->lang->line('application_delete'); ?>" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>projects/media/<?=$project->id;?>/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a>
                  <button class='btn po-close'><?=$this->lang->line('application_no');?></button>
                  <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                            <i class="icon dripicons-cross"></i></button>
                                        <a href="<?=base_url()?>projects/media/<?=$project->id;?>/update/<?=$value->id;?>" title="<?=$this->lang->line('application_edit'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                                    </td>

                                </tr>

                            <?php endforeach;?>



                            </tbody></table>
                        <?php if (!$project->project_has_files) {
                            ?>
                            <div class="no-files">
                                <i class="icon dripicons-cloud-upload"></i><br>
                                No files have been uploaded yet!
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

    <?php if ($invoice_access) {
        ?>
        <div class="row tab-pane fade" role="tabpanel" id="invoices-tab">
            <div class="col-xs-12 col-sm-12"><br>
                <a href="<?=base_url()?>projects/invoice/<?=$project->id; ?>" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_create_invoice'); ?></a>
                <div class="box-shadow">
                    <div class="table-head"><?=$this->lang->line('application_invoices'); ?> <span class=" pull-right"></span></div>
                    <div class="table-div">
                        <table class="data table" id="invoices" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                            <thead>
                            <th width="70px" class="hidden-xs"><?=$this->lang->line('application_invoice_id'); ?></th>
                            <th><?=$this->lang->line('application_client'); ?></th>
                            <th class="hidden-xs"><?=$this->lang->line('application_issue_date'); ?></th>
                            <th class="hidden-xs"><?=$this->lang->line('application_due_date'); ?></th>
                            <th><?=$this->lang->line('application_status'); ?></th>
                            <th class="hidden-xs"><?=$this->lang->line('application_value'); ?></th>
                            <th class="hidden-xs"><?=$this->lang->line('application_action'); ?></th>
                            </thead>
                            <?php foreach ($project_has_invoices as $value):?>

                                <tr id="<?=$value->id; ?>" >
                                    <td class="hidden-xs" onclick=""><?=$core_settings->invoice_prefix; ?><?=$value->reference; ?></td>
                                    <td onclick=""><span class="label label-info"><?php if (is_object($value->company)) {
                                                echo $value->company->name;
                                            } ?></span></td>
                                    <td class="hidden-xs"><span><?php $unix = human_to_unix($value->issue_date.' 00:00');
                                            echo '<span class="hidden">'.$unix.'</span> ';
                                            echo date($core_settings->date_format, $unix); ?></span></td>
                                    <td class="hidden-xs"><span class="label <?php if ($value->status == "Paid") {
                                            echo 'label-success';
                                        }
                                        if ($value->due_date <= date('Y-m-d') && $value->status != "Paid") {
                                            echo 'label-important tt" title="'.$this->lang->line('application_overdue');
                                        } ?>"><?php $unix = human_to_unix($value->due_date.' 00:00');
                                            echo '<span class="hidden">'.$unix.'</span> ';
                                            echo date($core_settings->date_format, $unix); ?></span> <span class="hidden"><?=$unix; ?></span></td>
                                    <td onclick=""><span class="label <?php $unix = human_to_unix($value->sent_date.' 00:00');
                                        if ($value->status == "Paid") {
                                            echo 'label-success';
                                        } elseif ($value->status == "Sent") {
                                            echo 'label-warning tt" title="'.date($core_settings->date_format, $unix);
                                        } ?>"><?=$this->lang->line('application_'.$value->status); ?></span></td>
                                    <td class="hidden-xs"><?php if (isset($value->sum)) {
                                            echo display_money($value->sum, $value->currency);
                                        } ?> </td>

                                    <td class="option hidden-xs" width="8%">
                                        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>invoices/delete/<?=$value->id; ?>'><?=$this->lang->line('application_yes_im_sure'); ?></a>
                  <button class='btn po-close'><?=$this->lang->line('application_no'); ?></button>
                  <input type='hidden' name='td-id' class='id' value='<?=$value->id; ?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete'); ?></b>"><i class="icon dripicons-cross"></i>
                                        </button>
                                        <a href="<?=base_url()?>invoices/update/<?=$value->id; ?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </table>
                        <?php if (!$project_has_invoices) {
                            ?>
                            <div class="no-files">
                                <i class="icon dripicons-document"></i><br>

                                <?=$this->lang->line('application_no_invoices_yet'); ?>
                            </div>
                            <?php
                        } ?>
                    </div>
                </div>
            </div>


        </div>
        <?php
    } ?>



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
                        <?php foreach ($project->project_has_activities as $value):?>
                            <?php
                            $writer = false;

                            if ($value->user_id != 0) {
                                $writer = $value->user->firstname." ".$value->user->lastname;
                                $image = $value->user->userpic;
                            } else {
                                $writer = $value->client->firstname." ".$value->client->lastname;
                                $image = $value->client->userpic;
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
                                    <h5><?=$value->subject;?></h5>
                                    <p><small class="text-muted"><span class="comment-writer"><?=$writer?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $value->datetime); ?></span></small>
                                        <?php if ($value->user_id == $this->user->id) {
                                            ?>
                                            <a class="pull-right li-delete ajax-silent" href="<?=base_url(); ?>projects/activity/<?=$value->project_id; ?>/delete/<?=$value->id; ?>"><i class="icon dripicons-trash"></i></a>
                                            <?php
                                        } ?>
                                    </p>
                                    <p><?=$value->message;?></p>
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
