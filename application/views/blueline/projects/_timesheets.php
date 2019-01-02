
<style>
@media (min-width: 768px){
        .modal-dialog {
            width: 800px;
        }
}
</style>
<div id="printtimesheet">
<style>
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
    .print{
        display: block;
    }
}
table thead tr th {
    text-align:left;
}
</style>
<div class="hidden print" style="text-align:center; border-bottom:2px solid #000; padding:5px; margin-bottom:20px;">[<?=$task->project->name?>] <?=$task->name?></div>
<?php 
                        $attributes = array('class' => '', 'id' => '_time');
                        echo form_open($form_action, $attributes);
                    ?>
        <table class="table data-table table-striped" width="100%">
             <thead>
                        <tr>
                            <th><?=$this->lang->line('application_name');?></th>
                            <th class="hidden-xs"><?=$this->lang->line('application_time_spent');?></th>
                            <th class="hidden-xs"><?=$this->lang->line('application_start');?></th>
                            <th class="hidden-xs"><?=$this->lang->line('application_end');?></th>
                            <th class="hidden-xs" width="20px"></th>

                        </tr>
              </thead>
        
        <tbody id="newRows">
                <?php foreach ($timesheets as $value):  ?>
                        <?php
                        $tracking           = floor($value->time/60);
                        $tracking_hours     = floor($tracking/60);
                        $tracking_minutes   = $tracking-($tracking_hours*60);
                        $time_spent         = $tracking_hours." ".$this->lang->line('application_hours')." ".$tracking_minutes." ".$this->lang->line('application_minutes'); ?>
                        <tr>
                            <td>
                                <img src="<?=$value->user->userpic;?>" class="img-circle list-profile-img no-print " height="21px">
                                <label><?=$value->user->firstname;?> <?=$value->user->lastname;?></label>
                            </td>
                            <td>
                                <?=$time_spent?>
                            </td>
                            <td>
                                <?php   if ($value->start != "") {
                            echo date($core_settings->date_format.' '.$core_settings->date_time_format, $value->start);
                        } else {
                            echo "-";
                        }?>
                        
                            </td>
                            <td>
                                <?php   if ($value->end != "") {
                            echo date($core_settings->date_format.' '.$core_settings->date_time_format, $value->end);
                        } else {
                            echo "-";
                        } ?>    
                            </td>
                            
                            <td>
                                <?php if (($this->user->id == $value->user_id || $this->user->admin == 1) && $task->invoice_id == 0) {
                            ?>
                                    <a href="<?=base_url()?>projects/timesheet_delete/<?=$value->id; ?>" class="deleteThisRow ajax-silent" title="<?=$this->lang->line('application_delete'); ?>"><i class="ion-close-circled red"></i></a>    
                                <?php
                        } ?>
                                <?php if ($task->invoice_id != 0) {
                            ?>
                                        <i class="ion-locked tt" title="<?=$this->lang->line('application_task_has_been_invoiced'); ?>"></i>            
                                <?php
                        } ?>
                            </td>
                            
                        </tr>
                <?php endforeach; ?>
              
                    <tr id="dummyTR" class="hidden no-print">
                            <td class="user_id">
                                <img src="<?=$value->user->userpic;?>" class="img-circle list-profile-img no-print " height="21px">
                                <label><?=$value->user->firstname;?> <?=$value->user->lastname;?></label>
                            </td>
                            <td class="time_spent">
                                <span class="hours"></span> <?=$this->lang->line('application_hours');?> <span class="minutes"></span> <?=$this->lang->line('application_minutes');?>
                            </td>
                            <td class="start_time">
                                <?php  if ($value->start != "") {
                            echo date($core_settings->date_format.' '.$core_settings->date_time_format, $value->start);
                        } else {
                            echo "-";
                        }?>
                        
                            </td>
                            <td class="end_time">
                                <?php  if ($value->end != "") {
                            echo date($core_settings->date_format.' '.$core_settings->date_time_format, $value->end);
                        } else {
                            echo "-";
                        }?>    
                            </td>
                            
                            <td class="option_button">
                                <?php if ($task->invoice_id == 0) {
                            ?>
                                    <a href="" 
                                        class="deleteThisRow ajax-silent" title="<?=$this->lang->line('application_delete'); ?>">
                                        <i class="ion-close-circled red"></i>
                                    </a>  
                                <?php
                        } else {
                            ?>
                                    <a href="" 
                                        title="<?=$this->lang->line('application_task_has_been_invoiced'); ?>">
                                        <i class="ion-locked"></i>
                                    </a>   
                                <?php
                        } ?>
                            </td>
                            
                        </tr>
                    <?php if ($task->invoice_id == 0) {
                            ?>
                    <tr class="no-print input-fields">
                    
                    <input type="hidden" name="task_id" value="<?=$task->id; ?>">
                    <input type="hidden" name="project_id" value="<?=$task->project_id; ?>">

                            <td>        
                                        <?php if ($this->user->admin == 0) {
                                ?> 
                                        <select name="user_id" class="inline-textfield user_id">
                                            <option value="<?=$this->user->id?>"><?=$this->user->firstname?> <?=$this->user->lastname?></option>
                                       </select>
                                        <?php
                            } else {
                                $users = array();
                                $users['0'] = '-';
                                foreach ($task->project->project_has_workers as $workers):
                                                             $users[$workers->user_id] = $workers->user->firstname.' '.$workers->user->lastname;
                                endforeach;
                                if (isset($task)) {
                                    $user = $task->user_id;
                                } else {
                                    $user = $this->user->id;
                                }
                                echo form_dropdown('user_id', $users, $user, '" class="inline-textfield user_id"');
                            } ?>
                     
                            </td>
                            <td>
                                <input class="inline-textfield hours" type="number" min="0" max="1000" size="3" name="hours" value="00"> <?=$this->lang->line('application_hours'); ?> 
                                <input class="inline-textfield minutes" type="number" min="0" max="60" size="2" name="minutes" value="00"> <?=$this->lang->line('application_minutes'); ?>
                            </td>
                            <td>
                                <input class="inline-textfield datepicker-time-unix start_time" type="text" value="" data-enable-time=true  name="start">
                            </td>
                            <td>
                                <input class="inline-textfield datepicker-time-unix end_time" type="text" value="" name="end" data-enable-time=true data-altInputClass="inline-textfield">   
                            </td>
                            
                            <td>
                                    <a href="#" class="add-row-ajax" title="<?=$this->lang->line('application_save'); ?>"><i class="ion-plus-circled"></i></a> <span class="delete_link hidden"><?=base_url()?>projects/timesheet_delete/</span>
                           
                            </td>
                    
                </tr>
                 <?php
                        } ?>
        </tbody>
        </table><?php echo form_close(); ?>
</div>
         
<div class="modal-footer">
<!--  BOTÃO DE IMPRIMIR A TIMESHEET DA TAREFA / ESCONDIDO  -->
<!--        <a class="btn btn-success" href="javascript:printDiv('printtimesheet')">--><?//=$this->lang->line('application_print');?><!--</a>-->
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
</div>
<script>
            printDivCSS =  new String ('<link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/bootstrap.min.css" />')
            function printDiv(divId) {
                window.frames["print_frame"].document.body.innerHTML=printDivCSS + document.getElementById(divId).innerHTML;
                window.frames["print_frame"].window.focus();
                window.frames["print_frame"].window.print();
            }
</script>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
   