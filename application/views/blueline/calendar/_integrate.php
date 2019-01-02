<?php
$attributes = array('class' => '', 'id' => '_event');
echo form_open($form_action, $attributes);
?>


<div>
  <p><?=$this->lang->line('application_in_order_to_integrate_with_calendar');?></p>

  <!-- LINKS DE INTEGRAÇÃO DE CALENDÁRIOS / ESCONDIDO -->
  <!-- <a href="https://support.apple.com/en-us/HT202361" target="_blank">Add calendar subscriptions on your Mac</a><br>
  <a href="https://www.calendarwiz.com/knowledgebase/entry/71/" target="_blank">Use Outlook calendar subscriptions</a><br>
  <a href="https://www.imore.com/how-subscribe-calendars-your-iphone-or-ipad" target="_blank">Add calendar subscription on iOS</a><br> -->
<br>
  <p><b><?=$this->lang->line('application_integrate_with_projects');?></b></p>
  <h6><?=base_url()?>api/ical/true/<?=$this->user->token;?></h6>
  <p><b><?=$this->lang->line('application_integrate_without_projects');?></b></p>
  <h6><?=base_url()?>api/ical/false/<?=$this->user->token;?></h6>
</div>





        <div class="modal-footer">
        <?php if(isset($event)){ ?>
        <a class="btn btn-danger pull-left" href="<?=base_url()?>calendar/delete/<?=$event->id?>"><?=$this->lang->line('application_delete');?></a>
        <?php } ?>
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>



<?php echo form_close(); ?>
