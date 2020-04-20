<link href="<?=base_url()?>assets/blueline/css/plugins/messages.css" rel="stylesheet">

<div class="col-sm-13 col-md-12 messages" onmouseover="document.body.style.overflow='hidden';" onmouseout="document.body.style.overflow='auto';">
    <main id="main" >
        <div class="overlay"></div>
        <header class="header">
            <h1 class="page-title">
                <div class="message-list-header">
                    <span id="inbox-folder"><i class="icon dripicons-inbox"></i> <?=$this->lang->line('application_INBOX');?></span>
                    <span id="sent-folder"><i class="icon dripicons-user"></i> <?=$this->lang->line('application_created_by_me');?></span>
                    <span id="finished-folder"><i class="icon dripicons-thumbs-up"></i> <?=$this->lang->line('application_finished');?></span>
                    <span id="canceled-folder"><i class="icon dripicons-thumbs-down"></i> <?=$this->lang->line('application_Canceled');?></span>
                </div>
            </h1>
        </header>
        <div class="action-bar">
            <ul>
                <li><a class="btn btn-primary" data-toggle="mainmodal" role="button" href="<?=base_url()?>purchaseorders/write" title="<?=$this->lang->line('application_write_message');?>"><i class="icon dripicons-pencil space"></i> <span class="hidden-xs"><?=$this->lang->line('application_new_purchase_order');?></span></a></li>
                <li>
                    <div class="btn-group">
                        <a class="btn btn-primary message-list-load inbox-folder" id="message-trigger" role="button" href="<?=base_url()?>purchaseorders/listing" title="Inbox"><i class="icon dripicons-inbox space"></i> <span class="hidden-xs"><?=$this->lang->line('application_INBOX');?></span></a>
                        <a class="btn btn-primary message-list-load sent-folder" role="button" href="<?=base_url()?>purchaseorders/filter/sent" title="Sent Folder"><i class="icon dripicons-user space"></i> <span class="hidden-xs"><?=$this->lang->line('application_created_by_me');?></span></a>
                        <a class="btn btn-success message-list-load finished-folder" role="button" href="<?=base_url()?>purchaseorders/filter/finished" title="Finished Folder"><i class="icon dripicons-thumbs-up space"></i> <span class="hidden-xs"><?=$this->lang->line('application_finished');?></span></a>
                        <a class="btn btn-danger message-list-load canceled-folder" role="button" href="<?=base_url()?>purchaseorders/filter/canceled" title="Finished Folder"><i class="icon dripicons-thumbs-down space"></i> <span class="hidden-xs"><?=$this->lang->line('application_Canceled');?></span></a>
                    </div>
                </li>

            </ul>
        </div>
        <div id="main-nano-wrapper" class="nano">
            <div class="nano-content">
                <ul id="message-list" class="message-list">

                </ul>
            </div>
        </div>
    </main>
    <div id="message">

    </div>
</div>
</div>
<script>
    jQuery(document).ready(function($) {


        $(document).on("click", '.message-list-load', function (e) {
            e.preventDefault();

            messageheader(this);

            $('.message-list-footer').fadeOut('fast');

            var url = $(this).attr('href');
            if (url.indexOf('#') === 0) {

            } else {
                $.get(url, function(data) {
                    $('#message-list').html(data);

                }).done(function() {    });
            }
        });
        $('#message-trigger').click();


        function messageheader(active) {
            var classes = $(active).attr("class").split(/\s/);
            if(classes[3]){
                $('.message-list-header span').hide();
                $('.message-list-header #'+classes[3]).fadeIn('slow');
            }


        }

        $('.search-box input').on('focus', function() {
            if($(window).width() <= 1360) {
                cols.hideMessage();
            }
        });

    });


</script>
