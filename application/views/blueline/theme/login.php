<?php
/**
 * @file        Login View
 * @author      Thiago Pires
 * @copyright   Ownergy Solar
 * @version     1.x.x
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <META Http-Equiv="Cache-Control" Content="no-cache">
    <META Http-Equiv="Pragma" Content="no-cache">
    <META Http-Equiv="Expires" Content="0">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="18000">

    <title><?=$core_settings->company;?></title>

    <link href="<?=base_url()?>assets/blueline/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/plugins/animate.css" />
    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/plugins/nprogress.css" />
    <link href="<?=base_url()?>assets/blueline/css/blueline.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/blueline/css/user.css" rel="stylesheet" />
    <?=get_theme_colors($core_settings);?>
    <?php require_once '_partials/fonts.php'; ?>

    <link rel="SHORTCUT ICON" href="<?=base_url()?>assets/blueline/img/favicon.ico"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="login" style="background-image:url('<?=base_url()?>assets/blueline/images/backgrounds/<?=$core_settings->login_background;?>')">
    <div class="container-fluid">
      <div class="row" style="margin-bottom:0px">
        <?=$yield?>
      </div>
    </div>
     <!-- Notify -->
    <?php if ($this->session->flashdata('message')) {
    $exp = explode(':', $this->session->flashdata('message'))?>
        <div class="notify <?=$exp[0]?>"><?=$exp[1]?></div>
    <?php
} ?>
    <script src="<?=base_url()?>assets/blueline/js/plugins/jquery-2.2.4.min.js"></script>

    <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/velocity.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/velocity.ui.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/validator.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
              fade = "Left";
              <?php if ($core_settings->login_style == 'center') {
        ?>
                fade = "Up";
              <?php
    }?>
              $("form").validator();

           $(".form-signin").addClass("animated fadeIn"+fade);
           $( ".fadeoutOnClick" ).on( "click", function(){
              $(".form-signin").addClass("animated fadeOut"+fade);
            });
                <?php if ($error == 'true') {
        ?>
                    $("#error").addClass("animated shake");
                <?php
    } ?>

                //notify
            $('.notify').velocity({
                  opacity: 1,
                  right: "10px",
                }, 900, function() {
                  $('.notify').delay( 4000 ).fadeOut();
                });

             /* 2.5.0 Form styling */

            $( ".form-control" ).each(function( index ) {
              if ($( this ).val().length > 0 ) {
                    $( this ).closest('.form-group').addClass('filled');
                  }
            });
            $( "select.chosen-select" ).each(function( index ) {
              if ($( this ).val().length > 0 ) {
                    $( this ).closest('.form-group').addClass('filled');
                  }
            });

            $( ".form-control" ).on( "focusin", function(){
                  $(this).closest('.form-group').addClass("focus");
              });
            $( ".chosen-select" ).on( "chosen:showing_dropdown", function(){
                  $(this).closest('.form-group').addClass("focus");
              });
            $( ".chosen-select" ).on( "chosen:hiding_dropdown", function(){
                  $(this).closest('.form-group').removeClass("focus");
              });

            $( ".form-control" ).on( "focusout", function(){
                  $(this).closest('.form-group').removeClass("focus");
                  if ($(this).val().length > 0 ) {
                      $(this).closest('.form-group').addClass('filled');
                  } else {
                      $(this).closest('.form-group').removeClass('filled');
                  }
              });

      });




        </script>

  </body>
</html>
