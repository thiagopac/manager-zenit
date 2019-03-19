<div class="row">
              <div class="col-xs-12 col-sm-12">
  <div class="row tile-row tile-view">
      <div class="col-md-1 col-xs-3">
      <div class="percentage easyPieChart" data-percent="<?=$project->progress;?>"><span><?=$project->progress;?>%</span></div>

      </div>
      <div class="col-md-11 col-xs-9 smallscreen">
        <h1><span class="nobold">#<?=$core_settings->project_prefix;?><?=$project->reference;?></span> - <?=$project->name;?></h1>
         <p class="truncate description"><?=$project->description;?></p>
      </div>

      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active hidden-xs"><a href="#projectdetails-tab" aria-controls="projectdetails-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_project_details');?></a></li>
        <li role="presentation" class="hidden-xs"><a href="#tasks-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_tasks');?></a></li>
        <li role="presentation"><a href="#milestones-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_milestones');?></a></li>

        <!-- ABA DE ARQUIVOS ESCONDIDO DO CLINETE / ESCONDIDO -->
        <!-- <li role="presentation" class="hidden-xs"><a href="#media-tab" aria-controls="media-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_files');?></a></li> -->

        <!-- ABA DE NOTAS APAGADA DO CLINETE / ESCONDIDO -->
        <!-- <li role="presentation" class="hidden-xs"><a href="#notes-tab" aria-controls="notes-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_notes');?></a></li> -->

       <?php if ($invoice_access) {
    ?>
        <li role="presentation" class="hidden-xs"><a href="#invoices-tab" aria-controls="invoices-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_invoices'); ?></a></li>
       <?php
} ?>
        <li role="presentation" class="hidden-xs"><a href="#activities-tab" aria-controls="activities-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_activities');?></a></li>

        <li role="presentation" class="dropdown visible-xs">
            <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><?=$this->lang->line('application_overview');?> <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">

              <li role="presentation" class="active"><a href="#projectdetails-tab" aria-controls="projectdetails-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_project_details');?></a></li>

              <li role="presentation"><a href="#tasks-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_tasks');?></a></li>

              <li role="presentation"><a href="#milestones-tab" aria-controls="tasks-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_milestones');?></a></li>

              <!-- ABA DE ARQUIVOS ESCONDIDO DO CLINETE / ESCONDIDO -->
              <!-- <li role="presentation"><a href="#media-tab" aria-controls="media-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_files');?></a></li> -->

              <!-- ABA DE NOTAS APAGADA DO CLINETE / ESCONDIDO -->
              <!-- <li role="presentation"><a href="#notes-tab" aria-controls="notes-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_notes');?></a></li> -->
             <?php if ($invoice_access) {
        ?>
              <li role="presentation"><a href="#invoices-tab" aria-controls="invoices-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_invoices'); ?></a></li>
             <?php
    } ?>
              <li role="presentation"><a href="#activities-tab" aria-controls="activities-tab" role="tab" data-toggle="tab"><?=$this->lang->line('application_activities');?></a></li>
            </ul>
        </li>





      </ul>


    </div>


              </div>
          </div>
   <div class="tab-content">

<div class="row tab-pane fade in active" role="tabpanel" id="projectdetails-tab">

              <div class="col-xs-12 col-sm-9">
             <div class="box-shadow">
            <div class="table-head"><?=$this->lang->line('application_project_details');?></div>

                <div class="subcont">
                  <ul class="details col-xs-12 col-sm-12 col-md-6">
                    <li><span><?=$this->lang->line('application_project_id');?>:</span> <?=$core_settings->project_prefix;?><?=$project->reference;?></li>

                    <li><span><?=$this->lang->line('application_client');?>:</span> <?php if (!is_object($project->company)) {
        ?> <a href="#" class="label label-default"><?php echo $this->lang->line('application_no_client_assigned');
    } else {
        ?><a class="label label-success" href="#"><?php echo $project->company->name;
    } ?></a></li>
                    <li><span><?=$this->lang->line('application_assigned_to');?>:</span> <?php foreach ($project->project_has_workers as $workers):?> <a class="label label-info" style="padding: 2px 5px 3px;"><?php echo $workers->user->firstname." ".$workers->user->lastname;?></a><?php endforeach;?> </li>

                  </ul>
                  <ul class="details col-xs-12 col-sm-12 col-md-6"><span class="visible-xs divider"></span>
                    <li><span><?=$this->lang->line('application_start_date');?>:</span> <?php  $unix = human_to_unix($project->start); echo date($core_settings->date_format, $unix);?></li>
                    <li><span><?=$this->lang->line('application_deadline');?>:</span> <?php  $unix = human_to_unix($project->end); echo date($core_settings->date_format, $unix);?></li>
                    <li><span><?=$this->lang->line('application_created_on');?>:</span> <?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $project->datetime); ?></li>

                    <!-- TEMPO GASTO NO PROJETO SENDO MOSTRADO PARA O CLIENTE / ESCONDIDO -->
                    <!-- <li><span><?=$this->lang->line('application_time_spent');?>:</span> <?=$time_spent;?> </li> -->
                  </ul>
                  <br clear="both">
                </div>
            </div>

               </div>


               <div class="col-xs-12 col-sm-3">
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



            </div>


  <div class="row tab-pane fade" role="tabpanel" id="tasks-tab">
     <div class="col-xs-12 col-sm-12  task-container-left">
         <div class="box-shadow">
            <div class="table-head"><?=$this->lang->line('application_tasks');?>
            <span class=" pull-right">
                 <a class="btn btn-success toggle-closed-tasks tt" data-original-title="<?=$this->lang->line('application_hide_completed_tasks');?>" >
                          <i class="ion-checkmark-circled"></i>
                      </a>

                <?php if ($project->enable_client_tasks == 1) {
                        ?>

                      <a href="<?=base_url()?>cprojects/tasks/<?=$project->id; ?>/add" class="btn btn-primary" data-toggle="mainmodal">
                          <?=$this->lang->line('application_add_task'); ?>
                      </a>

                 <?php
                    } ?>
                </span>
            </div>


                <div class="subcont no-padding min-height-410">

                  <ul id="task-list" class="todo sortlist ">
              <?php
              $count = 0;
              foreach ($task_list as $value):  $count = $count+1;
              $disable = 'disabled="disabled"';
              if ($value->client_id == $this->client->id) {
                  $disable = "";
              }
              if ($value->created_by_client == $this->client->id) {
                  $disable = "";
              }
                ?>
            <li id="task_<?=$value->id;?>" class="<?=$value->status;?> priority<?=$value->priority;?> list-item">

              <a href="<?=base_url()?>cprojects/tasks/<?=$project->id;?>/check/<?=$value->id;?>" class="ajax-silent task-check"></a>

              <input name="form-field-checkbox" class="checkbox-nolabel task-check dynamic-reload" data-reload="tile-pie" type="checkbox" data-link="<?=base_url()?>cprojects/tasks/<?=$project->id;?>/check/<?=$value->id;?>" <?php if ($value->status == "done") {
                    echo "checked";
                }?> <?=$disable?>/>
              <span class="lbl"> <p class="truncate name pointer" data-taskid="task-details-<?=$value->id;?>"><?=$value->name;?></p></span>
              <span class="pull-right">
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

                                  </span>


          </li>
         <?php endforeach;?>
         <?php if ($count == 0) {
                    ?>
          <li class="notask list-item ui-state-disabled"><?=$this->lang->line('application_no_tasks_yet'); ?></li>
         <?php
                } ?>



                         </ul>
                </div>
            </div>
        </div>
            <div class="col-sm-4 pin-to-top">
            <div class="subcont taskviewer-content box-shadow">
                <?php foreach ($task_list as $value):
                $disable = 'disabled';
              if ($value->client_id == $this->client->id) {
                  $disable = "";
              }
              if ($value->created_by_client == $this->client->id) {
                  $disable = "";
              } ?>
                <div id="task-details-<?=$value->id;?>" class="todo-details">
                        <i class="ion-close pull-right todo__close"></i>
                        <h4>
                            <?=$value->name;?>
                        </h4>
                        <?php if ($disable == "") {
                  ?>
                        <div class="grid grid--bleed task__options">
                        <?php if ($value->tracking != 0 && $value->tracking != "") {
                      $start = "hidden";
                      $stop = "";
                  } else {
                      $start = "";
                      $stop = "hidden";
                  } ?>

                          <!-- ACIONAR CRONÔMETRO, PARAR CRONÔMETRO E EDITAR TAREFA / ESCONDIDO -->
                          <!-- <a href="<?=base_url(); ?>cprojects/task_start_stop_timer/<?=$value->id?>" data-timerid="timer<?=$value->id; ?>" class="grid__col-6 grid__col--bleed center ajax-silent task__options__button task__options__button--green task__options__timer timer<?=$value->id; ?> <?=$start?>">
                              <?=$this->lang->line('application_start_timer'); ?>
                          </a> -->

                          <!-- <a href="<?=base_url(); ?>cprojects/task_start_stop_timer/<?=$value->id?>" data-timerid="timer<?=$value->id; ?>" class="grid__col-6 grid__col--bleed center ajax-silent task__options__button task__options__button--red task__options__timer timer<?=$value->id; ?> <?=$stop?>">
                              <?=$this->lang->line('application_stop_timer'); ?>
                          </a> -->

                          <!-- <a href="<?=base_url(); ?>cprojects/tasks/<?=$project->id?>/update/<?=$value->id?>" class="grid__col-6 grid__col--bleed task__options__button" data-toggle="mainmodal">
                              <?=$this->lang->line('application_edit'); ?>
                          </a> -->
                        </div>
                        <?php
              } ?>
                        <ul class="details">

                          <!-- TEMPO GASTO NA TAREFA ACIONADO PELO CLINETE / ESCONDIDO -->
                            <!-- <li>
                                <span><?=$this->lang->line('application_time_spent');?></span>

                                <?php if ($value->tracking != 0 && $value->tracking != "") {
                  $timertime=(time()-$value->tracking)+$value->time_spent;
                  $state = "resume";
              } else {
                  $timertime = ($value->time_spent != 0 && $value->time_spent != "") ? $value->time_spent : 0;
                  $state = "pause";
              } ?>

                                <span id="timer<?=$value->id;?>" class="badge timer__badge <?=$state?>"></span>
                                <script>$( document ).ready(function() { startTimer("<?=$state;?>", "<?=$timertime;?>", "#timer<?=$value->id;?>"); });</script>

                            </li> -->
                            <li>
                                <span><?=$this->lang->line('application_priority');?></span>
                                <?php switch ($value->priority) {case "0": echo $this->lang->line('application_no_priority'); break; case "1": echo $this->lang->line('application_low_priority'); break; case "2": echo $this->lang->line('application_med_priority'); break; case "3": echo $this->lang->line('application_high_priority'); break;};?>
                            </li>
                            <?php if ($value->value != 0) {
                  ?>
                              <li>
                                  <span><?=$this->lang->line('application_value'); ?></span>
                                  <!-- <a href="#" data-name="value" class="editable" data-type="text" data-pk="<?=$value->id; ?>" data-url="<?=base_url()?>cprojects/task_change_attribute"> -->
                                  <?=$value->value; ?>
                                 <!-- </a> -->
                              </li>
                            <?php
              } ?>
                            <?php if ($value->start_date != "") {
                  ?>
                              <li>
                                  <span><?=$this->lang->line('application_start_date'); ?></span>
                                  <?php  $unix = human_to_unix($value->start_date);
                  echo date($core_settings->date_format, $unix); ?>
                              </li>
                            <?php
              } ?>
                            <?php if ($value->due_date != "") {
                  ?>
                              <li>
                                  <span><?=$this->lang->line('application_due_date'); ?></span>
                                  <?php  $unix = human_to_unix($value->due_date);
                  echo date($core_settings->date_format, $unix); ?>
                              </li>
                            <?php
              } ?>
                            <?php if ($value->created_by_client != 0 && $value->created_by_client != "") {
                  ?>
                              <li>
                                  <span><?=$this->lang->line('application_created_by_client'); ?></span>
                                  <?=$value->creator->firstname; ?> <?=$value->creator->lastname; ?>
                              </li>
                            <?php
              } ?>
                            <?php if ($value->client_id != 0  && $value->client_id != "") {
                  ?>
                              <li>
                                  <span><?=$this->lang->line('application_assigned_to_client'); ?></span>
                                  <?=$value->client->firstname; ?> <?=$value->client->lastname; ?>
                              </li>
                            <?php
              } ?>
                              <li>
                                  <span><?=$this->lang->line('application_assigned_to_agent');?></span>
                                  <?php if ($value->user_id != 0 && $value->user_id != "") {
                  echo $value->user->firstname." ".$value->user->lastname;
              } else {
                  echo $this->lang->line('application_not_assigned');
              }?>
                              </li>
                              <li>
                                  <span><?=$this->lang->line('application_milestone');?></span>
                                 <!-- <a href="#" data-name="milestone_id" class="editable-select" data-type="select" data-pk="<?=$value->id;?>" data-url="<?=base_url()?>cprojects/task_change_attribute"> -->
                                  <?php if ($value->milestone_id != 0 && $value->milestone_id != "") {
                  echo $value->project_has_milestone->name;
              } else {
                  echo $this->lang->line('application_no_milestone_assigned');
              }?> <!--</a> -->
                              </li>
                              <li>
                                  <span><?=$this->lang->line('application_description');?></span>
                                  <p><?=$value->description;?></p>
                              </li>

                              <li class="comment-list-li">
                              <span><?=$this->lang->line('application_comments');?></span>

                              <div class="form-group filled chat_message_input">
                                      <?php
                                      $attributes = array('class' => 'ajaxform', 'id' => 'write-comment');
                                      echo form_open_multipart('cprojects/task_comment/'.$value->id.'/create', $attributes);
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
                                                <a class="tt" href="<?=base_url()?>cprojects/download/false/<?=$comments->attachment_link?>"  title="<?=$comments->attachment?>">
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
                                                <?php echo $this->client->firstname." ".$this->client->lastname; ?>
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
            </div>


<div class="subcont no-padding min-height-410">
<ul id="milestones-list" class="todo">
    <?php  $count = 0;
    foreach ($project->project_has_milestones as $milestone):
            $count2 = 0; $count = $count+1; ?>

            <?php

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

                <span class="pull-right"><span id="milestone_completion_<?=$milestone->id;?>" style="margin-top: 0px; float: left!important;"> <?=$completion?>% <?=$this->lang->line('application_completed'); ?></span>
                </span>
            </h1>
            &nbsp;
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
</div>
<div class="row tab-pane fade" role="tabpanel" id="media-tab">
<div class="col-xs-12 col-sm-3">
<div class="box-shadow">
<div class="table-head"><?=$this->lang->line('application_files');?>
<span class=" pull-right">
  <!-- BOTÃO DE ALTERAR FORMA DE VISUALIZAR MÍDAS E ARQUIVOS / ESCONDIDO -->
    <!-- <a class="btn btn-default toggle-media-view tt" data-original-title="<?=$this->lang->line('application_media_view');?>"><i class="ion-image"></i></a> -->
    <a class="btn btn-default toggle-media-view hidden tt" data-original-title="<?=$this->lang->line('application_list_view');?>"><i class="ion-android-list"></i></a>
    <a href="<?=base_url()?>cprojects/media/<?=$project->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_media');?></a>
</span></div>

    <div class="media-uploader">
    <?php $attributes = array('class' => 'dropzone', 'id' => 'dropzoneForm');
        echo form_open_multipart(base_url()."cprojects/dropzone/".$project->id, $attributes); ?>
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
           <a href="<?=base_url()?>cprojects/media/<?=$project->id;?>/view/<?=$value->id;?>">
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
 <div class="table-head"><?=$this->lang->line('application_files');?> <span class=" pull-right"><a href="<?=base_url()?>cprojects/media/<?=$project->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_media');?></a></span></div>
<div class="table-div min-height-410">
 <table id="media" class="table data-media" rel="<?=base_url()?>cprojects/media/<?=$project->id;?>" cellspacing="0" cellpadding="0">
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
                <button type="button" class="btn-option btn-xs po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>cprojects/media/<?=$project->id;?>/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
                <a href="<?=base_url()?>cprojects/media/<?=$project->id;?>/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
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
<?php $attributes = array('class' => 'note-form', 'id' => '_notes');
    echo form_open(base_url()."cprojects/notes/".$project->id, $attributes); ?>
<div class="box-shadow">
 <div class="table-head"><?=$this->lang->line('application_notes');?> <span class=" pull-right"><a id="send" name="send" class="btn btn-primary button-loader"><?=$this->lang->line('application_save');?></a></span><span id="changed" class="pull-right label label-warning"><?=$this->lang->line('application_unsaved');?></span></div>

  <textarea class="input-block-level summernote-note" name="note" id="textfield" ><?=$project->note;?></textarea>
</form>
</div>
</div>
</div>

<?php if ($invoice_access) {
        ?>
<div class="row tab-pane fade" role="tabpanel" id="invoices-tab">
 <div class="col-xs-12 col-sm-12">
<div class="box-shadow">
 <div class="table-head"><?=$this->lang->line('application_invoices'); ?> <span class=" pull-right"></span></div>
<div class="table-div">
 <table class="data table" id="cinvoices" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
    <thead>
      <th width="70px" class="hidden-xs"><?=$this->lang->line('application_invoice_id'); ?></th>
      <th><?=$this->lang->line('application_client'); ?></th>
      <th class="hidden-xs"><?=$this->lang->line('application_issue_date'); ?></th>
      <th class="hidden-xs"><?=$this->lang->line('application_due_date'); ?></th>
      <th><?=$this->lang->line('application_status'); ?></th>
    </thead>
    <?php foreach ($project_has_invoices as $value):?>

    <tr id="<?=$value->id; ?>" >
      <td class="hidden-xs" onclick=""><?=$core_settings->invoice_prefix; ?><?=$value->reference; ?></td>
      <td onclick=""><span class="label label-info"><?php if (is_object($value->company)) {
            echo $value->company->name;
        } ?></span></td>
      <td class="hidden-xs"><span><?php $unix = human_to_unix($value->issue_date);
        echo '<span class="hidden">'.$unix.'</span> ';
        echo date($core_settings->date_format, $unix); ?></span></td>
      <td class="hidden-xs"><span class="label <?php if ($value->status == "Paid") {
            echo 'label-success';
        }
        if ($value->due_date <= date('Y-m-d') && $value->status != "Paid") {
            echo 'label-important tt" title="'.$this->lang->line('application_overdue');
        } ?>"><?php $unix = human_to_unix($value->due_date);
        echo '<span class="hidden">'.$unix.'</span> ';
        echo date($core_settings->date_format, $unix); ?></span> <span class="hidden"><?=$unix; ?></span></td>
      <td onclick=""><span class="label <?php $unix = human_to_unix($value->sent_date.' 00:00');
        if ($value->status == "Paid") {
            echo 'label-success';
        } elseif ($value->status == "Sent") {
            echo 'label-warning tt" title="'.date($core_settings->date_format, $unix);
        } ?>"><?=$this->lang->line('application_'.$value->status); ?></span></td>
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

            <!-- BOTÃO DE ADICIONAR REGISTRO À ATIVIDADES PELO CLIENTE / ESCONDIDO  -->
            <!-- <span class=" pull-right"><a class="btn btn-primary open-comment-box"><?=$this->lang->line('application_new_comment');?></a></span> -->

            </div>
            <div class="subcont" >

<ul id="comments-ul" class="comments">
                      <li class="comment-item add-comment">
                      <?php
                                $attributes = array('class' => 'ajaxform', 'id' => 'replyform', 'data-reload' => 'comments-ul');
                                echo form_open('cprojects/activity/'.$project->id.'/add', $attributes);
                                ?>
                      <div class="comment-pic">
                        <img class="img-circle tt" title="<?=$this->client->firstname?> <?=$this->client->lastname?>"  src="<?=$this->client->userpic;?>">

                      </div>
                      <div class="comment-content">
                          <h5><input type="text" name="subject" class="form-control" id="subject" placeholder="<?=$this->lang->line('application_subject');?>..." required/></h5>
                            <p><small class="text-muted"><span class="comment-writer"><?=$this->client->firstname?> <?=$this->client->lastname?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, time()); ?></span></small></p>
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
                            <p><small class="text-muted"><span class="comment-writer"><?=$writer?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $value->datetime); ?></span></small></p>
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
<style type="text/css">

.circular-bar{
  text-align: center;

  margin:10px 20px;
}
  .circular-bar-content{
    margin-bottom: 70px;
    margin-top: -100px;
    text-align: center;
  }
    .circular-bar-content strong{
      display: block;
      font-weight: 400;
      @include font-size(18,24);
    }
    .circular-bar-content label, .circular-bar-content span{
      display: block;
      font-weight: 400;
      font-size: 18px;
      color: #505458;
      @include font-size(15,20);
    }


</style>
 <script type="text/javascript">
  $(document).ready(function(){

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
    dropzoneloader("<?php echo base_url()."cprojects/dropzone/".$project->id; ?>", "<?=addslashes($this->lang->line('application_drop_files_here_to_upload'));?>");

 });

</script>
    <div id="tkKey" class="hidden"><?=$this->security->get_csrf_hash();?></div>
  <div id="baseURL" class="hidden"><?=base_url();?>cprojects/</div>
  <div id="projectId" class="hidden"><?=$project->id;?></div>
