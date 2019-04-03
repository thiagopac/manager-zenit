<?php 
$attributes = ['class' => '', 'id' => '_lead'];
echo form_open($form_action, $attributes);
if (isset($lead)) {
    ?>
<input id="id" type="hidden" name="id" value="<?php echo $lead->id; ?>" />
<?php
} ?>
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
			<?=$this->lang->line('application_name');?> *
		</label>
		<input id="name" type="text" name="name" class="required form-control" value="<?php if (isset($lead)) {
            echo $lead->name;
        } ?>" required/>
	</div>
	<!--<div class="form-group">
		<label for="source">
			<?/*=$this->lang->line('application_source');*/?>
		</label>
		<input id="source" type="text" list="sourcelist" name="source" class="form-control" value="<?php /*if (isset($lead)) {
            echo $lead->source;
        } */?>"/>
		<datalist id="sourcelist">
			<?php /*foreach ($sources as $value):  */?>
			<option value="<?/*=$value->source*/?>">
				<?php /*endforeach; */?>
				<option value="Facebook">
                <option value="Google">
		</datalist>

	</div>-->
	
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
		<input id="state" type="text" name="state" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->state;
        }?>" />
	</div>
	<div class="form-group">
		<label for="country">
			<?=$this->lang->line('application_country');?>
		</label>
		<input id="country" type="text" name="country" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->country;
        }?>" />
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
        <label for="company">
            <?=$this->lang->line('application_proposal_value');?>
        </label>
    <?php if(!empty($core_settings->money_symbol)){ ?>
    <div class="input-group">
        <div class="input-group-addon"><?=$core_settings->money_symbol;?></div> <?php } ?>
        <input id="proposal_value" type="text" name="proposal_value" class="form-control" value="<?php if (isset($lead)) {
            echo $lead->proposal_value;
        } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="company">
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
                        $user_id = '';
                    }
        echo form_dropdown('user_id', $options, $user_id, 'style="width:100%" class="chosen-select"'); ?>
	</div>
	<ul class="accesslist">


        <?php

        //se for um colaborador com e-mail @ownergy.com.br ele poderá ver essa opção para marcar ou desmarcar
        list($this->user->email, $domain) = explode('@', $this->user->email);
        if ($domain == 'ownergy.com.br') { ?>

            <!--<li>
                <input type="checkbox" class="checkbox" id="private" name="private" value="1" data-labelauty="<?/*=$this->lang->line('application_private_lead');*/?>"
                    <?php /*if (isset($lead) && $lead->private != 0) { echo 'checked'; } */?>>
            </li>-->


        <?php } ?>


    </ul>

    <div class="modal-footer">
        <?php if (isset($lead)) : ?>
        <a href="<?=base_url()?>clients/company/createfromlead/<?=$lead->id?>" data-toggle="mainmodal" class="btn btn-success pull-left">
            <?=$this->lang->line('application_convert_to_client');?>
        </a>
        <?php endif; ?>
        <input type="submit" name="send" class="btn btn-primary silent-submit" data-section="lead" value="<?=$this->lang->line('application_save');?>"
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

    });


</script>
