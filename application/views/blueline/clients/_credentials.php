
<ul class="details">
<li><span><?=$this->lang->line('application_username');?>:</span> <?=$client->email;?></li>
 <li><span><?=$this->lang->line('application_password');?>:</span> <?=$this->lang->line('application_link_to_set_password_will_be_sent');?></li>
 </ul>

    <div class="modal-footer">
    <a href="<?=base_url()?>clients/credentials/<?=$client->id;?>/email" id="submit" class="btn btn-primary"><?=$this->lang->line('application_email_login_details');?></a>
	<a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>