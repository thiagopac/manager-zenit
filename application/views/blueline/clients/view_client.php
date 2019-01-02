
<div id="main">
<div id="options">
			<a href="<?=base_url()?>clients/update/<?=$client->id;?>/view" class="btn" data-toggle="modal"><i class="icon-edit"></i> <?=$this->lang->line('application_edit');?></a>
			<a href="<?=base_url()?>clients/credentials/<?=$client->id;?>" class="btn" data-toggle="modal"><i class="icon-info-sign"></i> <?=$this->lang->line('application_show_login_details');?></a>
		</div>
		<hr>
		<div class="row">
		<div class="span12 marginbottom20">
		<div class="table_head"><img class="minipic" src="
               <?php 
                if($client->userpic != 'no-pic.png'){
                  echo base_url()."files/media/".$client->userpic;
                }else{
                  echo get_gravatar($client->email, '20');
                }
                 ?>
                " /><h6><?=$this->lang->line('application_client_details');?></h6></div>
		<div class="subcont">
		<ul class="details span6">
			<li><span><?=$this->lang->line('application_company_name');?>:</span> <?php echo $client->company->name = empty($client->company->name) ? "-" : $client->company->name; ?></li>
			<li><span><?=$this->lang->line('application_contact');?>:</span> <?php echo $client->firstname = empty($client->firstname) ? "-" : $client->firstname.' '.$client->lastname; ?></li>
			<li><span><?=$this->lang->line('application_email');?>:</span> <?php echo $client->email = empty($client->email) ? "-" : $client->email; ?></li>
			<li><span><?=$this->lang->line('application_website');?>:</span> <?php echo $client->website = empty($client->website) ? "-" : '<a target="_blank" href="http://'.$client->website.'">'.$client->website.'</a>' ?></li>
		</ul>
		<ul class="details span6">
			<li><span><?=$this->lang->line('application_phone');?>:</span> <?php echo $client->phone = empty($client->phone) ? "-" : $client->phone; ?></li>
			<li><span><?=$this->lang->line('application_mobile');?>:</span> <?php echo $client->mobile = empty($client->mobile) ? "-" : $client->mobile; ?></li>
			<li><span><?=$this->lang->line('application_address');?>:</span> <?php echo $client->address = empty($client->address) ? "-" : $client->address; ?></li>
			<li><span><?=$this->lang->line('application_zip_code');?>:</span> <?php echo $client->zipcode = empty($client->zipcode) ? "-" : $client->zipcode; ?></li>
			<li><span><?=$this->lang->line('application_city');?>:</span> <?php echo $client->city = empty($client->city) ? "-" : $client->city; ?></li>

		</ul>
		<br clear="all">
		</div>
		</div>
		</div>
		

	</div>