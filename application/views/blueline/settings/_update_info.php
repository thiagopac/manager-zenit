<div class="update-changelog">
        <?=$update[0]->changelog;?>
</div>
<?php if ($update[0]->beta == 1) : ?>
        <div class="alert alert-warning">Beta Update!</div>
<?php endif; ?>
<div class="modal-footer">
<a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
</div>


