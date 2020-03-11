<div class="col-sm-12  col-md-12 main">
		<div class="row">
			<a href="<?=base_url()?>suppliers/supplier/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_new_supplier');?></a>
            <a href="<?=base_url()?>suppliers/category/create" class="btn btn-success" data-toggle="mainmodal"><?=$this->lang->line('application_new_segment');?></a>

            <div class="btn-group pull-right margin-right-3">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <?php if (isset($active_task_filter)) {
                        echo $this->lang->line('application_' . $active_state_filter);
                    } else {
                        echo $this->lang->line('application_state');
                    } ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">

                    <li>
                        <a id="" href="<?=base_url()?>suppliers">
                            <?=$this->lang->line('application_none');?>
                        </a>
                    </li>
                    <?php
                        $settings = Setting::first();
                        $statesList = $settings->list_states();
                    ?>
                    <? foreach($statesList as $key => $value) : ?>
                        <?php if ($key != null) : ?>
                            <li>
                                <a id="<?=$key?>" href="<?=base_url()?>suppliers?state=<?=$key?>">
                                    <?=$value?>
                                </a>
                            </li>
                        <? endif; ?>
                    <? endforeach; ?>
                </ul>
            </div>
		</div>
		<div class="row">
		<div class="box-shadow">
		<div class="table-head"> <?=$this->lang->line('application_suppliers');?></div>
		<div class="table-div">
		<table class="data table" id="suppliers" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>

            <th><?=$this->lang->line('application_id');?></th>
			<th><?=$this->lang->line('application_name');?></th>
            <th><?=$this->lang->line('application_registered_number');?></th>
            <th><?=$this->lang->line('application_state_registration');?></th>
            <th><?=$this->lang->line('application_municipal_registration');?></th>
<!--            <th>--><?//=$this->lang->line('application_address');?><!--</th>-->
<!--            <th>--><?//=$this->lang->line('application_neighborhood');?><!--</th>-->
            <th><?=$this->lang->line('application_city');?></th>
            <th><?=$this->lang->line('application_state');?></th>
            <th><?=$this->lang->line('application_zipcode');?></th>
            <th><?=$this->lang->line('application_website');?></th>
			<th><?=$this->lang->line('application_contact');?></th>
<!--            <th>--><?//=$this->lang->line('application_phone');?><!--</th>-->
<!--			<th>--><?//=$this->lang->line('application_email');?><!--</th>-->
            <th><?=$this->lang->line('application_segments');?></th>
            <th><?=$this->lang->line('application_payment_condition');?></th>
            <th><?=$this->lang->line('application_supplier_deadline');?></th>
<!--            <th>--><?//=$this->lang->line('application_bank');?><!--</th>-->
<!--            <th>--><?//=$this->lang->line('application_branch');?><!--</th>-->
<!--            <th>--><?//=$this->lang->line('application_account');?><!--</th>-->

			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($suppliers as $value):?>

		<tr id="<?=$value->id;?>" >
            <td><?=$value->id; ?></td>
			<td><?=$value->name; ?></td>
            <td><?=$value->registered_number; ?></td>
            <td><?=$value->state_registration; ?></td>
            <td><?=$value->municipal_registration; ?></td>
			<td><?=$value->city ?></td>
            <td><?=$value->state ?></td>
            <td><?=$value->zipcode; ?></td>
<!--            <td>--><?//="<a href='http://$value->website' target='_blank'>".$value->website."</a>"?><!--</td>-->

            <td>

                <?php $websites = explode(' ',$value->website);?>
                <?php foreach ($websites as $website) : ?>
                    <p><button class="label label-info"  onclick=" window.open('<?="http://".$website?>', '_blank'); return false;"><?=$website?></button></p>
                <?php endforeach; ?>
            </td>




            <td><?=$value->contact; ?></td>
<!--            <td>--><?//=$value->phone; ?><!--</td>-->
<!--            <td>--><?//=$value->email; ?><!--</td>-->
            <td><?=$value->supplier_category_ids!=null ? Supplier::supplierCategoriesStr($value->supplier_category_ids): ''; ?></td>
            <td><?=$value->payment_condition; ?></td>
            <td><?=$value->supplier_deadline; ?></td>

			<td class="option" width="8%">
                <button type="button" title="<?=$this->lang->line('application_delete'); ?>"
                        class="btn-option delete po tt" data-toggle="popover" data-placement="left"
                        data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>suppliers/supplier/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>"
                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i>
                </button>
                <a href="<?=base_url()?>suppliers/supplier/update/<?=$value->id;?>"  title="<?=$this->lang->line('application_edit'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			</td>
		</tr>
		<?php endforeach;?>
	 	</table>
	 	<br clear="all">

	</div>
</div>

<!--
id
name
registered_number
state_registration
address
neighborhood
city
state
zipcode
website
contact
phone
email
supplier_category_ids
payment_condition
supplier_deadline
bank_id
branch
account
created_at
updated_at
 -->