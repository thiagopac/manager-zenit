<div id="row">

	<div class="col-md-12 col-lg-12">

        <div class="row">
            <div class="col-md-1">
                <a href="<?=base_url()?>leads" class="btn btn-primary">
                    <?=$this->lang->line('application_back');?>
                </a>
            </div>
        </div>

		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_lost_leads');?>
		</div>
		<div class="table-div responsive">
			<table id="lostleads" class="table" cellspacing="0" cellpadding="0">
				<thead>
                <th class="hidden-xs hidden-lg hidden-md hidden-sm hidden-print hidden"></th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_id');?>
                    </th>
					<th style="width:200px" class="hidden-xs">
						<?=$this->lang->line('application_name');?>
					</th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_company');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_lead_owner');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_registration_responsible');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_private');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_tags');?>
                    </th>
                    </thead>
				<?php foreach ($leads as $lead):?>

				<tr id="<?=$lead->id;?>">
					<td class="hidden-xs">
						<?=$lead->id;?>
					</td>
					<td>
                        <?=$lead->name;?>
					</td>
                    <td>
                        <?=$lead->company;?>
                    </td>
                    <td>
                        <?=$lead->owner;?>
                    </td>
                    <td>
                        <?=User::find($lead->user_id)->firstname?>
                    </td>
                    <td>
                        <?=$lead->private == 1 ? $this->lang->line('application_yes') : $this->lang->line('application_no') ;?>
                    </td>
                    <td>
                        <?=$lead->tags;?>
                    </td>

					<td class="option" width="8%">
						<a href="<?=base_url()?>leads/edit/<?=$lead->id;?>" class="btn-option" data-toggle="mainmodal">
							<i class="icon dripicons-gear"></i>
						</a>
					</td>
				</tr>

				<?php endforeach;?>
			</table>
		</div>
	</div>
	</div>
</div>