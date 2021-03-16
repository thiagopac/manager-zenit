<?php
$attributes = array('class' => '', 'id' => '_import');
echo form_open_multipart($form_action, $attributes);
?>

    <div class="alert alert-info"><?= $this->lang->line('application_csv_file_update_info'); ?></div>
    <div class="alert alert-success">Baixe o CSV de exemplo <b><a style="color: greenyellow; text-decoration: underline" href="<?=$exemple_file?>">clicando aqui</a></b></div>

    <div class="form-group">
        <label for="userfile"><?= $this->lang->line('application_file'); ?> .CSV</label>
        <div>
            <input id="uploadFile" class="form-control uploadFile"
                   placeholder="<?= $this->lang->line('application_choose_file'); ?>" disabled="disabled"/>
            <div class="fileUpload btn btn-primary">
                <span><i class="icon dripicons-upload"></i><span
                            class="hidden-xs"> <?= $this->lang->line('application_select'); ?></span></span>
                <input id="uploadBtn" type="file" name="userfile" class="upload" accept=".csv"/>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" id="send" name="send"
                class="btn btn-primary send button-loader"><?= $this->lang->line('application_csv_update_payment_date'); ?></button>
        <a class="btn" data-dismiss="modal"><?= $this->lang->line('application_close'); ?></a>
    </div>

<?php echo form_close(); ?>