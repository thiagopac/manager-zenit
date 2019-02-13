<?php
/**
 * @file        Fullpage View
 * @author      Thiago Pires
 * @copyright   Ownergy Solar
 * @version     1.x.x
 */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <META Http-Equiv="Cache-Control" Content="no-cache">
    <META Http-Equiv="Pragma" Content="no-cache">
    <META Http-Equiv="Expires" Content="0">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">

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
    <style type="text/css">
      html{
        height: 100%;
      }
      body {
        padding-bottom: 40px;
        height: 100%;
      }
    </style>

 </head>
  <body>
  <div class="container small-container">

  		<img class="fullpage-logo" src="<?=base_url()?><?=$core_settings->invoice_logo;?>" alt="<?=$core_settings->company;?>" />


    <div>
     <?php if ($this->session->flashdata('message')) {
        $exp = explode(':', $this->session->flashdata('message'))?>
	    <?php
    } ?>
<?=$yield?>
<br clear="all"/>
	</div>

</div>
  <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/app.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/locales/flatpickr_<?=$current_language?>.js"></script>


      <script type="text/javascript" charset="utf-8">

//Validation
  $("form").validator();

        $(document).ready(function(){

              $(".removehttp").change(function(e){
                $(this).val($(this).val().replace("http://",""));
              });

        });
    </script>

 </body>
</html>
