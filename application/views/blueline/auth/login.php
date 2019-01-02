<?php $attributes = ['class' => 'form-signin box-shadow', 'role' => 'form', 'id' => 'login']; ?>
<?=form_open('login', $attributes)?>
        <div class="logo"><img src="<?=base_url()?><?php if ($core_settings->login_logo == '') {
    echo $core_settings->logo;
} else {
    echo $core_settings->login_logo;
}?>" alt="<?=$core_settings->company;?>"></div>
        <?php if ($error == 'true') {
    $message = explode(':', $message)?>
            <div id="error">
              <?=$message[1]?>
            </div>
        <?php
} ?>

          <div class="form-group">
            <label for="username"><?=$this->lang->line('application_username');?></label>
            <input type="username" class="form-control" id="username" name="username" placeholder="<?=$this->lang->line('application_enter_your_username');?>" />
          </div>
          <div class="form-group">
            <label for="password"><?=$this->lang->line('application_password');?></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="<?=$this->lang->line('application_enter_your_password');?>" />
          </div>

          <?php if ($this->config->item('recaptcha_web_key') != '') {
        ?>
              <div class="g-recaptcha" data-sitekey="<?=$this->config->item('recaptcha_web_key'); ?>" data-bind="recaptcha-submit" data-callback="submitForm"></div>
          <?php
    } ?>

          <input
              type="submit"
              id="recaptcha-submit"
              value="<?=$this->lang->line('application_login');?>"
              class="btn btn-primary fadeoutOnClick"
          />
          <div class="forgotpassword"><a href="<?=site_url('forgotpass');?>"><?=$this->lang->line('application_forgot_password');?></a></div>

          <div class="sub">
           <?php if ($core_settings->registration == 1) {
        ?><div class="small"><small><?=$this->lang->line('application_you_dont_have_an_account'); ?></small></div><hr/><a href="<?=site_url('register'); ?>" class="btn btn-success"><?=$this->lang->line('application_create_account'); ?></a> <?php
    } ?>
          </div>
          <?php if ($this->config->item('recaptcha_web_key') != '') {
        ?>
                <script>
                  function submitForm() {
                      document.getElementById("login").submit();
                  }
                </script>
                <script src='https://www.google.com/recaptcha/api.js'></script>
          <?php
    } ?>

<?=form_close()?>
