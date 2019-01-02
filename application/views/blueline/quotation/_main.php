<?php 
$attributes = ['class' => '', 'id' => '_quotation'];
echo form_open($form_action, $attributes);
?>
<style type="text/css">input.labelauty + label{width:100%;}
.dropdown-menu>li>a {
font-size: 12px;
text-transform: initial;
}
</style>
<div class="box-shadow">
<div class="table-head"><?=$this->lang->line('quotation_website_quotation');?>
<?php if (!empty($core_settings->language)) {
    $default_language = $core_settings->language;
} else {
    $default_language = 'english';
} ?>
<div class="btn-group pull-right-responsive" style="margin-top: 9px;">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <img src="<?=base_url()?>assets/blueline/img/<?php if ($this->input->cookie('fc2language') != '') {
    echo $this->input->cookie('fc2language');
} else {
    echo $default_language;
} ?>.png" style="margin-top:-1px" align="middle"> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
          <?php if ($handle = opendir('application/language/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != '.' && $entry != '..') {
            ?><li><a href="<?=base_url()?>quotation/language/<?=$entry; ?>"><img src="<?=base_url()?>assets/blueline/img/<?=$entry; ?>.png" class="language-img"><?=ucwords($entry); ?></a></li>
                                  <?php
        }
    }
    closedir($handle);
} ?>
            	                
	                      </ul>
      </div>

</div>
	<div class="table-div">


      

		<br>
<div class="form-group">
<label class="control-label"><?=$this->lang->line('quotation_question_1');?></label>
			
			<input type="radio" id="q1_aw1" name="q1" value="1" checked="checked" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_1_aw_1');?>" />
			<input type="radio" id="q1_aw2" name="q1" value="2" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_1_aw_2');?>">
			<input type="radio" id="q1_aw3" name="q1" value="3" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_1_aw_3');?>">
			<input type="radio" id="q1_aw4" name="q1" value="4" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_1_aw_4');?>">
			<input type="radio" id="q1_aw5" name="q1" value="5" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_1_aw_5');?>">
</div>
<div class="form-group">
		<label class="control-label"><?=$this->lang->line('quotation_question_2');?></label>

			<input type="radio" id="q2_aw1" name="q2" value="1" checked="checked" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_2_aw_1');?>" />
			<input type="radio" id="q2_aw2" name="q2" value="2" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_2_aw_2');?>">
			<input type="radio" id="q2_aw3" name="q2" value="3" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_2_aw_3');?>">
			<input type="radio" id="q2_aw4" name="q2" value="4" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_2_aw_4');?>">
 
</div>
<div class="form-group">

		<label class="control-label"><?=$this->lang->line('quotation_question_3');?></label>
			
			<input type="radio" id="q3_aw1" name="q3" value="1" checked="checked" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_3_aw_1');?>">
			<input type="radio" id="q3_aw2" name="q3" value="2" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_3_aw_2');?>">
</div>
<div class="form-group">

		<label class="control-label"><?=$this->lang->line('quotation_question_4');?></label>
			<input type="text" class="removehttp form-control" name="q4" maxlength="100" value="">
</div>
<div class="form-group">

		<label class="control-label"><?=$this->lang->line('quotation_question_5');?> *</label>			
			<textarea class="required form-control" rows="6" name="q5"  maxlength="400" required></textarea>

</div>
<div class="form-group">

		<label class="control-label"><?=$this->lang->line('quotation_question_6');?> (<?=$core_settings->currency;?>)</label>

			<input type="radio" id="q6_aw1" name="q6" value="1"  checked="checked" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_6_aw_1');?>"/>
			<input type="radio" id="q6_aw2" name="q6" value="2" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_6_aw_2');?>">
			<input type="radio" id="q6_aw3" name="q6" value="3" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_6_aw_3');?>">
			<input type="radio" id="q6_aw4" name="q6" value="4" class="checkbox" data-labelauty="<?=$this->lang->line('quotation_question_6_aw_4');?>">
</div>
<div class="form-group">

			<label class="control-label"><?=$this->lang->line('quotation_question_7');?></label>	
			<input class="form-control" name="company" type="text" maxlength="100" value="">
</div>
<div class="form-group">

 			<label class="control-label"><?=$this->lang->line('quotation_question_8');?> *</label>	
			<input class="required form-control" type="text" name="fullname" maxlength="100" value="" required>
</div>
<div class="form-group">

			<label class="control-label"><?=$this->lang->line('quotation_question_9');?> *</label>
			<input class="required form-control" type="email" name="email" maxlength="100" value="" required>
</div>
<div class="form-group">

			<label class="control-label"><?=$this->lang->line('quotation_question_10');?> *</label>
			<input class="required form-control" type="text" name="phone" maxlength="100" value="" required>
</div>
<div class="form-group">
 		
			<label class="control-label"><?=$this->lang->line('quotation_question_11');?> *</label>
			<input class="required form-control" type="text" name="address" maxlength="100" value="" required>
</div>
<div class="form-group">
 		
			<label class="control-label"><?=$this->lang->line('quotation_question_12');?> *</label>
			<input class="required form-control" type="text" name="city" maxlength="100" value="" required>
</div>
<div class="form-group">
 		
 			<label class="control-label"><?=$this->lang->line('quotation_question_13');?> *</label>
			<input class="required form-control" type="text" name="zip" maxlength="100" value="" required>
</div>
<div class="form-group">

			<label class="control-label"><?=$this->lang->line('quotation_question_14');?> *</label>
			<input class="required form-control" type="text" name="country" maxlength="100" value="" required>
</div>
<div class="form-group">

			<label class="control-label"><?=$this->lang->line('quotation_question_15');?></label>		
			<textarea name="comment" class="form-control" rows="6" maxlength="400"></textarea>
</div>
<div class="form-group">
<?php 
              $number1 = rand(1, 10);
              $number2 = rand(1, 10);

              $captcha = $number1 + $number2;
?>
			<input type="hidden" id="captcha" value="<?=$captcha;?>">
			<label class="control-label"><?=$number1;?> + <?=$number2;?> = ?</label>
			<input type="text" id="confirmcaptch" data-match="#captcha" class="form-control" required/>
</div>



	<div class="bottom">
		<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('quotation_save');?>"/>
	</div>
<?php echo form_close(); ?>
<br>
</div>
</div>