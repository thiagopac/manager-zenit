<?php 
$attributes = array('class' => 'vue-modal', 'id' => '_reminder');
echo form_open($form_action, $attributes);
if (isset($reminder)) {
    ?>
<input id="id" type="hidden" name="id" value="<?php echo $reminder->id; ?>" />
<?php
} ?>

	<div class="form-group">
		<label for="datetime">
			<?=$this->lang->line('application_date_time');?> *</label>
		<input class="form-control datepickr-unix not-required" name="datetime" id="datetime" type="text" value="<?php if (isset($reminder)) {
        echo $reminder->datetime;
    } ?>" required/>
	</div>
	<div class="form-group">
		<label for="title">
			<?=$this->lang->line('application_title');?> *</label>
		<input id="title" type="text" name="title" class="form-control" value="<?php if (isset($reminder)) {
        echo $reminder->title;
    } ?>" required/>
	</div>
	<div class="form-group">
		<label for="message">
			<?=$this->lang->line('application_description');?>
		</label>
		<textarea id="message" name="message" rows="6" class="textarea summernote-modal"><?php if (isset($reminder)) {
        echo $reminder->body;
    } ?></textarea>
	</div>

	<ul class="accesslist">
		<li>
			<input type="checkbox" class="checkbox" id="email_notification" name="email_notification" value="1" data-labelauty="<?=$this->lang->line('application_send_reminder_email');?>"
			 <?=(isset($reminder) && $reminder->email_notification != 0) ? "checked" : "";?>>
		</li>
	</ul>

	<div class="modal-footer">
		<input type="submit" name="send" class="btn btn-primary silent-submit" data-section="reminder" value="<?=$this->lang->line('application_save');?>"
		/>
		<a class="btn" data-dismiss="modal">
			<?=$this->lang->line('application_close');?>
		</a>
	</div>


	<?php echo form_close(); ?>