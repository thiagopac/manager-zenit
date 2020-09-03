<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <div class="col-md-10 col-lg-10">
            <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> Aqui vocês encontrará os menus de formulários da intranet.</div>
        </div>

        <div class="col-md-10 col-lg-10">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_projects_events');?>
                </div>
                <div class="table-div responsive">
                    <table id="forms" class="data-sorting table noclick" data-page-length="<?=count($intranet_forms) ?>" cellspacing="0" cellpadding="0">
                        <thead>
                        <th>
                            Nome
                        </th>
                        <th>
                            ID do Formulário no Auditor
                        </th>
                        <th>
                            Descrição
                        </th>
                        <th>
                            Ordenação
                        </th>
                        <th>
                            Ativo
                        </th>
                        <th>
                            Ações
                        </th>
                        </thead>
                        <?php foreach ($intranet_forms as $form):?>

                            <tr id="<?=$form->id;?>">
                                <td>
                                    <?=$form->name;?>
                                </td>
                                <td>
                                    <?=$form->auditor_form_id;?>
                                </td>
                                <td>
                                    <?=$form->description;?>
                                </td>
                                <td>
                                    <?=$form->ordered;?>
                                </td>
                                <td>
                                    <?=$form->active == 1 ? 'Sim' : 'Não';?>
                                </td>
                                <td class="option" width="8%">
                                    <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left"
                                            data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>intranet/form_delete/<?=$form->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$form->id;?>'>"
                                            data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                        <i class="icon dripicons-cross"></i>
                                    </button>
                                    <a href="<?=base_url()?>intranet/form_update/<?=$form->id;?>" class="btn-option" data-toggle="mainmodal">
                                        <i class="icon dripicons-gear"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-2">
            <a href="<?=base_url()?>intranet/form_create" class="btn btn-primary" data-toggle="mainmodal" style="margin-right: 80px;">
                Adicionar formulário
            </a>
        </div>
    </div>

</div>