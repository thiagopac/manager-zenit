<div style="text-align: center; margin: 60px 10px;">
    <h1>
        <i class="ion ion-ios-heart-outline" style="font-size: 80px;"></i>
    </h1>
    <h2><?= $this->lang->line('application_thanks_for_chosing_FC'); ?></h2>
    <p><?= $this->lang->line('application_the_first_steps_to_setup'); ?></p>
</div>
<div class="modal-footer">
    <a class="btn pull-left" data-dismiss="modal"><?= $this->lang->line('application_later'); ?></a>
    <a href="<?=base_url()?>agent/welcome/1" class="btn btn-primary pull-right" data-toggle="mainmodal"><?= $this->lang->line('application_next'); ?></a>
</div>