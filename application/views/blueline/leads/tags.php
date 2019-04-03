<div id="row">

	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

        <div class="row">
            <div class="col-md-1">
                <a href="<?=base_url()?>leads" class="btn btn-primary">
                    <?=$this->lang->line('application_back');?>
                </a>
            </div>

            <div class="pull-right">
                <div class="col-md-1">
                    <a href="<?=base_url()?>leads/edittag/create" data-toggle="mainmodal" class="btn btn-secondary">
                        <?=$this->lang->line('application_add_tag');?>
                    </a>
                </div>
            </div>

        </div>

		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_edit_tags');?>
		</div>
		<div class="table-div responsive">
			<table id="alltags" class="table" cellspacing="0" cellpadding="0">
				<thead>
                <th class="hidden-xs hidden-lg hidden-md hidden-sm hidden-print hidden"></th>
                    <th style="width:60px" class="hidden-xs">
                        <?=$this->lang->line('application_id');?>
                    </th>
					<th class="hidden-xs">
						<?=$this->lang->line('application_name');?>
					</th>
                    </thead>
				<?php foreach ($tags as $tag):?>

				<tr id="<?=$tag->id;?>">
					<td class="hidden-xs">
						<?=$tag->id;?>
					</td>
					<td>
                        <?=$tag->name;?>
					</td>

					<td class="option" width="8%">
						<a href="<?=base_url()?>leads/edittag/edit/<?=$tag->id;?>" class="btn-option" data-toggle="mainmodal">
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