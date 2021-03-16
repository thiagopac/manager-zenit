<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <div class="col-md-10 col-lg-10">
            <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> Aqui você encontrará os menus de iframes da intranet.</div>
        </div>

        <div class="col-md-10 col-lg-10">
            <div class="box-shadow">
                <div class="table-head">
                    Iframes
                </div>
                <div class="table-div responsive">
                    <table id="iframes" class="data-sorting table noclick" data-page-length="<?=count($intranet_iframes) ?>" cellspacing="0" cellpadding="0">
                        <thead>
                        <th>
                            Nome
                        </th>
                        <th>
                            Link da página
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
                        <?php foreach ($intranet_iframes as $iframe):?>

                            <tr id="<?=$iframe->id;?>">
                                <td>
                                    <?=$iframe->name;?>
                                </td>
                                <td>
                                    <?=ellipsize($iframe->link, 30);?>
                                </td>
                                <td>
                                    <?=$iframe->description;?>
                                </td>
                                <td>
                                    <?=$iframe->ordered;?>
                                </td>
                                <td>
                                    <?=$iframe->active == 1 ? 'Sim' : 'Não';?>
                                </td>
                                <td class="option" width="8%">
                                    <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left"
                                            data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>intranet/iframe_delete/<?=$form->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$iframe->id;?>'>"
                                            data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                        <i class="icon dripicons-cross"></i>
                                    </button>
                                    <a href="<?=base_url()?>intranet/iframe_update/<?=$iframe->id;?>" class="btn-option" data-toggle="mainmodal">
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
            <a href="<?=base_url()?>intranet/iframe_create" class="btn btn-primary" data-toggle="mainmodal" style="margin-right: 80px;">
                Adicionar iframe
            </a>
        </div>
    </div>

</div>