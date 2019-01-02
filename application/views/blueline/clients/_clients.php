<?php   
$attributes = array('class' => '', 'id' => '_clients', 'autocomplete' => 'off');
echo form_open_multipart($form_action, $attributes); 
?>
<?php if(isset($client)){ ?>
<input id="id" type="hidden" name="id" value="<?=$client->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
<input id="view" type="hidden" name="view" value="true" />
<?php } ?>
<div class="form-group">
        <label for="firstname"><?=$this->lang->line('application_firstname');?> *</label>
        <input id="firstname" type="text" name="firstname" class=" form-control" value="<?php if(isset($client)){echo $client->firstname;} ?>" required/>
</div>
<div class="form-group">
        <label for="lastname"><?=$this->lang->line('application_lastname');?> *</label>
        <input id="lastname" type="text" name="lastname" class="required form-control" value="<?php if(isset($client)){echo $client->lastname;} ?>" required/>
</div>
<div class="form-group">
        <label for="email"><?=$this->lang->line('application_email');?> *</label>
        <input id="email" type="email" name="email" class="required email form-control" value="<?php if(isset($client)){echo $client->email;} ?>" required/>
</div>
<div class="form-group">
        <label for="phone"><?=$this->lang->line('application_phone');?></label>
        <input id="phone" type="text" name="phone" class="form-control" value="<?php if(isset($client)){echo $client->phone;}?>" />
</div>
<div class="form-group">
        <label for="mobile"><?=$this->lang->line('application_mobile');?></label>
        <input id="mobile" type="text" name="mobile" class="form-control" value="<?php if(isset($client)){echo $client->mobile;}?>" />
</div>
<div class="form-group">
        <label for="address"><?=$this->lang->line('application_address');?></label>
        <input id="address" type="text" name="address" class="form-control" value="<?php if(isset($client)){echo $client->address;}?>" />
</div>
<div class="form-group">
        <label for="zipcode"><?=$this->lang->line('application_zip_code');?></label>
        <input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if(isset($client)){echo $client->zipcode;}?>" />
</div>
<div class="form-group">
        <label for="city"><?=$this->lang->line('application_city');?></label>
        <input id="city" type="text" name="city" class="form-control" value="<?php if(isset($client)){echo $client->city;}?>" />
</div>
<div class="form-group">
        <label for="password"><?=$this->lang->line('application_password');?> <?php if(!isset($client)){echo "*";}?></label>
        <input id="password" type="password" name="password" class="form-control" autocomplete="new-password" value="" <?php if(!isset($client)){echo "required";}?> />
</div>
<div class="form-group">
                <label for="userfile"><?=$this->lang->line('application_profile_picture');?></label><div>
                <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
                  </div>
</div>

    <!-- REDES SOCIAIS NO CADASTRO DO CONTATO DO CLIENTE / ESCONDIDO -->
<!--<div class="row">-->
<!--    <div class="col-md-6">-->
<!--        <div class="form-group">-->
<!--                <label for="twitter">Twitter</label>-->
<!--                <input id="twitter" type="text" name="twitter" class="form-control" value="--><?php //if(isset($client)){echo $client->twitter;}?><!--" />-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--                <label for="skype">Skype</label>-->
<!--                <input id="skype" type="text" name="skype" class="form-control" value="--><?php //if(isset($client)){echo $client->skype;}?><!--" />-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--                <label for="linkedin">LinkedIn</label>-->
<!--                <input id="linkedin" type="text" name="linkedin" class="form-control" value="--><?php //if(isset($client)){echo $client->linkedin;}?><!--" />-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--                <label for="facebook">Facebook</label>-->
<!--                <input id="facebook" type="text" name="facebook" class="form-control" value="--><?php //if(isset($client)){echo $client->facebook;}?><!--" />-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-md-6">-->
<!--        <div class="form-group">-->
<!--                <label for="instagram">Instagram</label>-->
<!--                <input id="instagram" type="text" name="instagram" class="form-control" value="--><?php //if(isset($client)){echo $client->instagram;}?><!--" />-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--                <label for="googleplus">Google Plus</label>-->
<!--                <input id="googleplus" type="text" name="googleplus" class="form-control" value="--><?php //if(isset($client)){echo $client->googleplus;}?><!--" />-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--                <label for="youtube">Youtube</label>-->
<!--                <input id="youtube" type="text" name="youtube" class="form-control" value="--><?php //if(isset($client)){echo $client->youtube;}?><!--" />-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--                <label for="pinterest">Pinterest</label>-->
<!--                <input id="pinterest" type="text" name="pinterest" class="form-control" value="--><?php //if(isset($client)){echo $client->pinterest;}?><!--" />-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php
$access = array();
if(isset($client)){ $access = explode(",", $client->access); }
?>

<div class="form-group">
<label><?=$this->lang->line('application_module_access');?></label>
<ul class="accesslist">

  <?php foreach ($modules as $key => $value) { ?>
<li> <input type="checkbox" class="checkbox" id="r_<?=$value->link;?>" name="access[]" value="<?=$value->id;?>" <?php if(in_array($value->id, $access)){ echo 'checked="checked"';}?> data-labelauty="<?=$this->lang->line('application_'.$value->link);?>"> </li>
<?php } ?>
</ul>
</div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>