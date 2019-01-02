<?php $attributes = ['class' => 'form-signin box-shadow', 'role' => 'form', 'id' => 'resetpass']; ?>
<?=form_open($form_action, $attributes)?>
        <div class="logo"><img src="<?=base_url()?><?php if ($core_settings->login_logo == '') {
    echo $core_settings->invoice_logo;
} else {
    echo $core_settings->login_logo;
}?>" alt="<?=$core_settings->company;?>"></div>
        <?php if ($this->session->flashdata('message')) {
    $exp = explode(':', $this->session->flashdata('message')); ?>
            <div class="forgotpass-success">
              <?=$exp[1]?>
            </div>
        <?php
} else {
        ?>
        <div class="forgotpass-info"><?=$this->lang->line('application_enter_your_new_password'); ?></div>
          
        <div class="form-group">
                <label for="password"><?=$this->lang->line('application_password'); ?> *</label>
                <input id="password" type="password" name="password" class="form-control "  minlength="6" required/>
        </div>
        <div class="form-group">
                <label for="password"><?=$this->lang->line('application_confirm_password'); ?> *</label>
                <input id="confirm_password" type="password" name="confirm_password" class="form-control" data-match="#password" />
        </div>

          <input type="submit" class="btn btn-primary" value="<?=$this->lang->line('application_reset_password'); ?>" />
          <?php
    } ?>
          <div class="forgotpassword"><a href="<?=site_url('login');?>"><?=$this->lang->line('application_go_to_login');?></a></div>
<?=form_close()?>