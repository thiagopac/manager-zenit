<?php
$attributes = array('class' => '', 'id' => '_event');
$classname = "bgColor1";
echo form_open($form_action, $attributes);
if (isset($event)) {
    $classname = $event->classname; ?>
<input id="id" type="hidden" name="id" value="<?php echo $event->id; ?>" />
<?php
} ?>


<div class="form-group ">
                          <label for="title"><?=$this->lang->line('application_title');?> *</label>
                          <input type="text" name="title" class="form-control" id="title"  value="<?php if (isset($event)) {
        echo $event->title;
    } ?>" required/>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group">
                          <label for="start"><?=$this->lang->line('application_start');?> *</label>
                          <input class="form-control datepicker-time" data-enable-time=true name="start" id="start" type="text" value="<?php if (isset($event)) {
        echo $event->start;
    } ?>" required/>

</div>
</div>
<div class="col-md-6">
<div class="form-group">
                          <label for="end"><?=$this->lang->line('application_end');?> *</label>
                          <input class="form-control datepicker-time datepicker-time-linked" data-enable-time=true name="end" id="end" type="text" value="<?php if (isset($event)) {
        echo $event->end;
    } ?>" required/>
</div>
</div>
</div>
<div class="form-group">
                          <label for="description"><?=$this->lang->line('application_description');?></label>
                          <textarea class="input-block-level form-control" rows="5" id="textfield" name="description"><?php if (isset($event)) {
        echo $event->description;
    } ?></textarea>
</div>
<div class="form-group no-border">

<?php $i = 1;
      while ($i <= 19) {
          ?>
    <span class="color-selector bgColor<?=$i?> <?php if ($classname == "bgColor".$i) {
              echo "selected";
          } ?>"><input type="radio" name="classname" value="bgColor<?=$i?>" <?php if ($classname == "bgColor".$i) {
              echo "selected";
          } ?>></span>
<?php $i++;
      } ?>


</div>




        <div class="modal-footer">
        <?php if (isset($event)) {
          ?>
        <a class="btn btn-danger pull-left" href="<?=base_url()?>calendar/delete/<?=$event->id?>"><?=$this->lang->line('application_delete'); ?></a>
        <?php
      } ?>
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<script type="text/javascript">
    $(function () {

        $("#start").on("dp.change", function (e) {
            $('.linkedDateTime').data("DateTimePicker").minDate(e.date);

        });
        $(".linkedDateTime").on("dp.change", function (e) {

            $('#start').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>

<?php echo form_close(); ?>
