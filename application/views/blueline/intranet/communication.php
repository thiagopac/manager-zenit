<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-9 col-lg-9" style="margin-bottom: 20px;">

        <div class="col-md-10 col-lg-10">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_contacts');?>
                    <span class="pull-right">
<!--					<a href="--><?//=base_url()?><!--intranet/contact_create" class="btn btn-primary" data-toggle="mainmodal">-->
<!--						--><?//=$this->lang->line('application_add_contact');?>
<!--					</a>-->
				</span>
                </div>
                <div class="table-div responsive">
                    <table id="contacts" class="data-no-search table" cellspacing="0" cellpadding="0">
                        <thead>
                        <th style="width:80px">
                            <?=$this->lang->line('application_name');?>
                        </th>
                        <th>
                            <?=$this->lang->line('application_department');?>
                        </th>
                        <th>
                            <?=$this->lang->line('application_email');?>
                        </th>
                        <th>
                            <?=$this->lang->line('application_phone');?>
                        </th>
                        <?php if ($this->user->department_has_user("RH", $this->user) == true) : ?>
                            <th>
                                <?=$this->lang->line('application_actions');?>
                            </th>
                        <?php endif; ?>
                        </thead>
                        <?php foreach ($intranet_contacts as $contact):?>

                            <tr id="<?=$contact->id;?>">
                                <td>
                                    <?=$contact->name;?>
                                </td>
                                <td>
                                    <?=$contact->department;?>
                                </td>
                                <td>
                                    <?=$contact->email;?>
                                </td>
                                <td>
                                    <?=$contact->phone;?>
                                </td>
                                <?php if ($this->user->department_has_user("RH", $this->user) == true) : ?>
                                    <td class="option" width="8%">
                                        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left"
                                                data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>intranet/contact_delete/<?=$contact->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$contact->id;?>'>"
                                                data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                            <i class="icon dripicons-cross"></i>
                                        </button>
                                        <a href="<?=base_url()?>intranet/contact_update/<?=$contact->id;?>" class="btn-option" data-toggle="mainmodal">
                                            <i class="icon dripicons-gear"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>

                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>