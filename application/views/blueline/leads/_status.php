<?php 
$attributes = ['class' => '', 'id' => '_status'];
echo form_open($form_action, $attributes);
if (isset($status)) {
    ?>
<input id="id" type="hidden" name="id" value="<?php echo $status->id; ?>" />
<?php
} ?>

	<div class="form-group">
		<label for="name">
			<?=$this->lang->line('application_name');?> *</label>
		<input id="name" type="text" name="name" class="form-control" value="<?php if (isset($status)) {
        echo $status->name;
    }?>" required/>
	</div>
    <div class="form-group">
        <label for="duration">
            <?=$this->lang->line('application_duration');?> (<?=$this->lang->line('application_in_days');?>) *</label>
        <input id="duration" type="number" min="0" max="99" size="2" name="duration" class="form-control" value="<?php if (isset($status)) {
            echo $status->duration;
        }?>" required/>
    </div>
	<div class="form-group">
		<label for="description">
			<?=$this->lang->line('application_description');?>
		</label>
		<textarea id="description" name="description" rows="6" class="textarea summernote-modal"><?php if (isset($status)) {
        echo $status->description;
    }?></textarea>
	</div>
	<div class="form-group">
		<label>
			<?=$this->lang->line('application_color');?>
		</label>
		<input id="color" name="color" type="text" class="form-control colorpickerinput" value="<?=(isset($status)) ? $status->color : '#1261cb';?>" />
		<span class="color color-previewer" style="background-color:<?=(isset($status)) ? $status->color : '#1261cb';?>"></span>
	</div>



<div class="form-group">
    <label for="users"><?=$this->lang->line('application_lead_status_user_notification');?></label>
    <?php
        $options = array();
        $user = array();

        foreach ($users as $value):
            $options[$value->id] = $value->firstname.' '.$value->lastname;
        endforeach;

        if(isset($status)){}else{$user = "";}

        foreach ($status->lead_status_receiver as $workers):
            $user[$workers->user_id] = $workers->user_id;
        endforeach;

        echo form_dropdown('user_id[]', $options, $user, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select_agents').'" multiple tabindex="3"');
    ?>
</div>

	<div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary silent-submit" data-section="lead" value="<?=$this->lang->line('application_save');?>"/>
		<a class="btn" data-dismiss="modal">
			<?=$this->lang->line('application_close');?>
		</a>
	</div>


	<?php echo form_close(); ?>

	<script>
		$(function() {
			var colors = {
				'#161b1f': '#161b1f',
				'#d8dce3': '#d8dce3',
				'#11a7db': '#11a7db',
				'#2aa96b': '#2aa96b',
				'#5bc0de': '#5bc0de',
				'#f0ad4e': '#f0ad4e',
				'#ed5564': '#ed5564'
			};
			var sliders = {
				saturation: {
					maxLeft: 200,
					maxTop: 200
				},
				hue: {
					maxTop: 200
				},
				alpha: {
					maxTop: 200
				}
			};
			/*$('.colorpickerinput').colorpicker({
				customClass: 'colorpicker-2x',
				colorSelectors: colors,
				align: 'left',
				sliders: sliders
			}).on('changeColor', function(e) {
				$('.color-previewer')
					.css('background', e.color);

			});*/
		});
	</script>