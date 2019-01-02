<div id="options">
			<div class="btn-group margintop5 nav-tabs normal-white-space" data-toggle="buttons-radio">
				<?php foreach ($submenu as $name=>$value):?>
	                <a class="btn btn-mini" id="<?php $val_id = explode("/", $value); if(!is_numeric(end($val_id))){echo end($val_id);}else{$num = count($val_id)-2; echo $val_id[$num];} ?>" href="<?=site_url($value);?>"><?=$name?></a>
	            <?php endforeach;?>
	            
			</div>
		</div>
		<hr/>
		<div class="btn-group margintop5 nav-tabs" data-toggle="buttons-radio">
         <a href="<?=base_url()?>settings/templates" class="btn btn-mini"><?=$this->lang->line('application_invoice_email_template');?></a>
         <a href="<?=base_url()?>settings/templates/credentials" class="btn btn-mini active"><?=$this->lang->line('application_credentials_email_template');?></a>
        </div> 
        <script type="text/javascript">$(document).ready(function() { 
	            	$('.nav-tabs #templates').button('toggle'); });
	     </script> 
<div class="table_head"><h6><i class="icon-list-alt"></i><?=$this->lang->line('application_credentials_email_template');?></h6></div>
<?php   
$attributes = array('class' => '', 'id' => 'settings_form');
echo form_open_multipart($form_action, $attributes); 
?>
<table id="settings" cellspacing="0" cellpadding="0">
	<tr>
		<td><?=$this->lang->line('application_credentials_mail_subject');?></td>
		<td><input type="text" name="credentials_mail_subject" class="required no-margin span6" value="<?=$settings->credentials_mail_subject;?>"></td>
	</tr>
	<tr>
		<td style="vertical-align:top"><?=$this->lang->line('application_credentials_mail_body');?> <br/>
			<a href="<?=base_url()?>settings/settings_reset/email_credentials" class="btn btn-mini tt" title="<?=$this->lang->line('application_reset_default');?>"><i class="icon-refresh"></i><?=$this->lang->line('application_reset_default');?></a>
			<br>
			<div class="margin5">
				<small style="font-weight: bold;"> 
					<?=$this->lang->line('application_short_tags');?>:<br/>
					{logo}<br/> 
					{invoice_logo}<br/> 
					{client_link}<br/> 
					{client_contact}<br/> 
					{due_date}<br/> 
					{invoice_id}<br/> 
					{company}<br/>
				</small>
			</div>
			</td>
			
			<td id="autowidth"><textarea class="required span12 ckeditor" name="credentials_mail_body"><?=$email_credentials;?></textarea></td>
		</tr>		
		<tr>
			<td class="bottom" colspan="2">
			 <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
			</td>
		</tr>

	</table>
	
	<?php echo form_close(); ?>
