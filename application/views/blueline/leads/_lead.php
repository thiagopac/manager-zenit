<?php 
$attributes = ['class' => '', 'id' => '_lead'];
echo form_open($form_action, $attributes);
if (isset($lead)) {
    ?>
<input id="id" type="hidden" name="id" value="<?php echo $lead->id; ?>" />
<?php
} ?>
<div class="visible-xs visible-sm" style="padding-bottom: 40px">
        <input class="btn btn-primary col-xs-5 silent-submit" type="submit" data-previous-destiny="<?=$previous_status->id?>" data-section="lead" value="◄ <?=$this->lang->line('application_move_previous_status');?>" id="btn-move-lead-previous"/>
        <input class="btn pull-right btn-primary col-xs-5 silent-submit" type="submit" data-next-destiny="<?=$next_status->id?>" value="<?=$this->lang->line('application_move_next_status');?> ►" data-section="lead" id="btn-move-lead-next"/>
    </div>
	<div class="form-group">
		<label for="status_id">
			<?=$this->lang->line('application_status');?>
		</label>
		<?php $options = [];
                 foreach ($status as $stat):
                    $options[$stat->id] = $stat->name;
                endforeach;
        if (isset($lead) && is_object($lead)) {
            $status_id = $lead->status_id;
        } else {
            $status_id = '';
        }
        echo form_dropdown('status_id', $options, $status_id, 'style="width:100%" class="chosen-select"');?>
	</div>
	<div class="form-group">
		<label for="name">
			<?=$this->lang->line('application_lead_name');?> *
		</label>
		<input id="name" type="text" name="name" class="required form-control" value="<?php if (isset($lead)) {
            echo $lead->name;
        } ?>" required/>
	</div>
	
	<div class="form-group">
		<label for="company">
			<?=$this->lang->line('application_company');?>
		</label>
		<input id="company" type="text" name="company" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->company;
        } ?>" />
	</div>
	<div class="form-group">
		<label for="position">
			<?=$this->lang->line('application_position');?>
		</label>
		<input id="position" type="text" name="position" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->position;
        } ?>" />
	</div>

	<div class="form-group">
		<label for="email">
			<?=$this->lang->line('application_email');?>
		</label>
		<input id="email" type="email" name="email" class="email form-control" value="<?php if (isset($lead)) {
            echo $lead->email;
        } ?>" />
	</div>
	<div class="form-group">
		<label for="phone">
			<?=$this->lang->line('application_phone');?>
		</label>
		<input id="phone" type="text" name="phone" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->phone;
        }?>" />
	</div>
	<div class="form-group">
		<label for="mobile">
			<?=$this->lang->line('application_mobile');?>
		</label>
		<input id="mobile" type="text" name="mobile" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->mobile;
        }?>" />
	</div>
	<div class="form-group">
		<label for="address">
			<?=$this->lang->line('application_address');?>
		</label>
		<input id="address" type="text" name="address" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->address;
        }?>" />
	</div>
	<div class="form-group">
		<label for="zipcode">
			<?=$this->lang->line('application_zip_code');?>
		</label>
		<input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->zipcode;
        }?>" />
	</div>
	<div class="form-group">
		<label for="city">
			<?=$this->lang->line('application_city');?>
		</label>
		<input id="city" type="text" name="city" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->city;
        }?>" />
	</div>
	<div class="form-group">
		<label for="province">
			<?=$this->lang->line('application_province');?>
		</label>
        <?php
        $settings = Setting::first();
        $statesList = $settings->list_states();

        echo form_dropdown('state', $statesList, $lead->state, 'style="width:100%" class="chosen-select"');?>
	</div>
    <div class="form-group">
        <label for="country">
            <?=$this->lang->line('application_payment_method');?>
        </label>
        <?php
        $settings = Setting::first();
        $countriesList = $settings->list_countries();

        echo form_dropdown('country', $countriesList, $lead->country,'style="width:100%" class="chosen-select"');?>
    </div>
    <div class="form-group">
        <label for="tags">
            <?=$this->lang->line('application_tags');?>
        </label>
        <?php
        $options = array();
        $selected_tags = array();

        foreach ($tags as $value):
            $options[$value] = $value;
        endforeach;

        if(isset($lead)){}else{$tag = "";}

        $lead_tags = explode(',', $lead->tags);

        foreach ($lead_tags as $tag):
            $selected_tags[$tag] = $tag;
        endforeach;

        echo form_dropdown('tags_arr[]', $options, $selected_tags, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select_tags').'" multiple tabindex="3"');
        ?>
    </div>
	<div class="form-group">
		<label for="description">
			<?=$this->lang->line('application_description');?>
		</label>
		<textarea id="description" name="description" rows="6" class="textarea summernote-modal">
			<?php if (isset($lead)) {
            echo $lead->description;
        } ?>
		</textarea>
	</div>
    <div class="form-group">
        <label for="proposal_value">
            <?=$this->lang->line('application_proposal_value');?>
        </label>
    <?php if(!empty($core_settings->money_symbol)){ ?>
    <div class="input-group">
        <div class="input-group-addon"><?=$core_settings->money_symbol;?></div>
        <input id="proposal_value" type="text" name="proposal_value" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->proposal_value;
        } ?>" />
        </div>
    <?php } ?>
    </div>
    <div class="form-group">
        <label for="payment">
            <?=$this->lang->line('application_payment_method');?>
        </label>
        <?php
        $settings = Setting::first();
        $paymentMethodsList = $settings->list_payment_methods();

        echo form_dropdown('payment', $paymentMethodsList, $lead->payment,'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="rated_power_mod">
            <?=$this->lang->line('application_rated_power');?>
        </label>
        <?php if(!empty($core_settings->rated_power_measurement)){ ?>
        <div class="input-group">
            <div class="input-group-addon"><?=$core_settings->rated_power_measurement;?></div>
            <input id="rated_power_mod" type="text" name="rated_power_mod" class="form-control" value="<?php if (isset($lead)) {
                echo $lead->rated_power_mod;
            } ?>" />
        </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="owner">
            <?=$this->lang->line('application_lead_owner');?>
        </label>
        <input id="owner" type="text" name="owner" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->owner;
        } ?>" />
    </div>
	<div class="form-group">
		<label for="leads">
			<?=$this->lang->line('application_registration_responsible');?>
		</label>
		<?php $options = [];
                    $user = [];
                    foreach ($users as $value):
                    $options[$value->id] = $value->firstname . ' ' . $value->lastname;
                    endforeach;
                    if (isset($lead) && is_object($lead)) {
                        $user_id = $lead->user_id;
                    } else {
                        $user_id = $this->user->id;
                    }
        echo form_dropdown('user_id', $options, $user_id, 'style="width:100%" class="chosen-select"'); ?>
	</div>
	<ul class="accesslist">


        <?php

        $condition = $this->user->department_has_user("Comercial", $this->user);

        if ($condition == 1) { ?>

            <!--<li>
                <input type="checkbox" class="checkbox" id="private" name="private" value="1" data-labelauty="<?/*=$this->lang->line('application_private_lead');*/?>"
                    <?php /*if (isset($lead) && $lead->private != 0) { echo 'checked'; } */?>>
            </li>-->

            <li>
                <input type="checkbox" class="checkbox" id="lead_warning_user" name="lead_warning_user" value="1" data-labelauty="<?=$this->lang->line('application_lead_warning_receiver');?>"
                    <?php if (isset($lead_warning_user)) { echo 'checked'; } ?>>
            </li>


        <?php } ?>

    </ul>

    <div class="modal-footer">
        <?php if (isset($lead) && $condition == 1) : ?>
        <a href="<?=base_url()?>clients/company/createfromlead/<?=$lead->id?>" data-toggle="mainmodal" class="btn btn-success pull-left">
            <?=$this->lang->line('application_convert_to_client');?>
        </a>
        <?php endif; ?>
        <a href="<?=base_url()?>leads/notifycomercial/<?=$lead->id?>" class="btn btn-danger pull-left tt ajax-silent" title="<?=$this->lang->line('application_notify_comercial_help');?>">
            <?=$this->lang->line('application_notify_comercial_team');?>
            <i class="icon dripicons-bell"></i>
        </a>
        <input type="button" name="send" id="send" class="btn btn-primary silent-submit" data-section="lead" value="<?=$this->lang->line('application_save');?>"
        />
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>


    <?php echo form_close(); ?>

<script>
    $(document).ready(function(){

        $("#proposal_value").mask("000.000.000.000.000,00", {reverse: true});
        $("#mobile").mask("(##)#####-####", {reverse: false});
        $("#phone").mask("(##)####-####", {reverse: false});
        $("#zipcode").mask("#####-####", {reverse: false});
        $("#rated_power_mod").mask("##########.##", {reverse: true});

        $('#send').on('click', function() {

            $(this).val("<?=$this->lang->line('application_wait');?>");

            setTimeout(function(){
                $('#send').attr('disabled','disabled');
            }, 10);

        });

        if ($("#btn-move-lead-previous").data('previous-destiny') == ''){
            $("#btn-move-lead-previous").hide();
        }

        if ($("#btn-move-lead-next").data('next-destiny') == ''){
            $("#btn-move-lead-next").hide();
        }

        $("#btn-move-lead-previous").on("click", function(t) {

            $("[name='status_id']").val($("#btn-move-lead-previous").data('previous-destiny'));

        });

        $("#btn-move-lead-next").on("click", function(t) {

            $("[name='status_id']").val($("#btn-move-lead-next").data('next-destiny'));

        });

    });
</script>
