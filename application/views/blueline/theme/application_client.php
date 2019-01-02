<?php
/**
 * @file        Application View
 * @author      Thiago Pires
 * @copyright   Ownergy Solar
 * @version     1.x.x
 */

$act_uri = $this->uri->segment(1, 0);
$lastsec = $this->uri->total_segments();
$act_uri_submenu = $this->uri->segment($lastsec);
if (!$act_uri) {
    $act_uri = 'cdashboard';
}
if (is_numeric($act_uri_submenu)) {
    $lastsec = $lastsec - 1;
    $act_uri_submenu = $this->uri->segment($lastsec);
}
$message_icon = false;
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="robots" content="none" />

    <link rel="SHORTCUT ICON" href="<?=base_url()?>assets/blueline/img/favicon.ico"/>

    <title><?=$core_settings->company;?></title>

    <script src="<?=base_url()?>assets/blueline/js/plugins/jquery-2.2.4.min.js"></script>


    <?php
    require_once '_partials/fonts.php';
    require_once '_partials/js_vars.php';
    ?>

    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/app.css"/>
    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/user.css"/>
    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/important.css"/>
    <?=get_theme_colors($core_settings);?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

<body>
<div id="mainwrapper">

    <div class="side">
    <div class="sidebar-bg"></div>
        <div class="sidebar">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><img src="<?=base_url()?><?=$core_settings->logo;?>" alt="<?=$core_settings->company;?>"></a>
        </div>

          <ul class="nav nav-sidebar">
              <?php foreach ($menu as $key => $value) {
        ?>
               <?php
               if (strtolower($value->link) == 'cmessages') {
                   $message_icon = true;
               } ?>
               <li id="<?=strtolower($value->name); ?>" class="<?php if ($act_uri == strtolower($value->link)) {
                   echo 'active';
               } ?>"><a href="<?=site_url($value->link); ?>"><span class="menu-icon"><i class="fa <?=$value->icon; ?>"></i></span><span class="nav-text"><?php echo $this->lang->line('application_' . $value->link); ?></span>
                <?php if (strtolower($value->link) == 'cmessages' && $messages_new[0]->amount != '0') {
                   ?><span class="notification-badge"><?=$messages_new[0]->amount; ?></span><?php
               } ?>
                <?php if (strtolower($value->link) == 'quotations' && $quotations_new[0]->amount != '0') {
                   ?><span class="notification-badge"><?=$quotations_new[0]->amount; ?></span><?php
               } ?>
                <?php if (strtolower($value->link) == 'cestimates' && $estimates_new[0]->amount != '0') {
                   ?><span class="notification-badge"><?=$estimates_new[0]->amount; ?></span><?php
               } ?>

               </a> </li>
              <?php
    } ?>
          </ul>



        </div>
    </div>

    <div class="content-area">
      <div class="row mainnavbar">
<div class="topbar__left noselect">
<a href="#" class="menu-trigger"><i class="ion-navicon visible-xs"></i></a>
            <?php if ($message_icon) {
        ?>
              <span class="hidden-xs">
                  <a href="<?=site_url('cmessages'); ?>" title="<?=$this->lang->line('application_messages'); ?>">
                     <i class="ion-archive topbar__icon"></i>
                  </a>
              </span>
            <?php
    } ?>
      </div>
      <div class="topbar noselect">
      <img class="img-circle topbar-userpic" src="<?=$this->client->userpic;?>" height="21px">
      <span class="topbar__name fc-dropdown--trigger">
          <?php echo character_limiter($this->client->firstname . ' ' . $this->client->lastname, 25);?> <i class="ion-chevron-down" style="padding-left: 2px;"></i>
      </span>
      <div class="fc-dropdown profile-dropdown">
        <ul>
          <li>
              <a href="<?=site_url('agent');?>" data-toggle="mainmodal">
                <span class="icon-wrapper"><i class="ion-gear-a"></i></span> <?=$this->lang->line('application_profile');?>
              </a>
          </li>

<!-- MENU DE IDIOMAS / ESCONDIDO -->
          <!-- <li class="fc-dropdown__submenu--trigger">
              <span class="icon-wrapper"><i class="ion-ios-arrow-back"></i></span> <?=$current_language;?>
                <ul class="fc-dropdown__submenu">
                    <span class="fc-dropdown__title"><?=$this->lang->line('application_languages');?></span>
                    <?php foreach ($installed_languages as $entry) {
        ?>
                                   <li>
                                       <a href="<?=base_url()?>agent/language/<?=$entry; ?>">
                                          <img src="<?=base_url()?>assets/blueline/img/<?=$entry; ?>.png" class="language-img"> <?=ucwords($entry); ?>
                                        </a>
                                   </li>

                       <?php
    } ?>
                </ul>

          </li> -->
            <li class="profile-dropdown__logout">
                    <a href="<?=site_url('logout');?>" title="<?=$this->lang->line('application_logout');?>">
                         <?=$this->lang->line('application_logout');?> <i class="ion-power pull-right"></i>
                    </a>
            </li>
          </ul>
      </div>

  </div>
</div>




        <?=$yield?>






    </div>
    <!-- Notify -->
    <?php if ($this->session->flashdata('message')) {
        $exp = explode(':', $this->session->flashdata('message'))?>
        <div class="notify <?=$exp[0]?>"><?=$exp[1]?></div>
    <?php
    } ?>


    <!-- Modal -->
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mainModalLabel" aria-hidden="true"></div>


    <!-- Js Files -->

    <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/app.js"></script>
    <script>
        flatdatepicker(false, langshort);
    </script>


 </div> <!-- Mainwrapper end -->

 </body>
</html>
