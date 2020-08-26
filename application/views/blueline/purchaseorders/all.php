<link href="<?=base_url()?>assets/blueline/css/plugins/messages.css" rel="stylesheet">
<div class="col-sm-13 col-md-12 messages" onmouseover="document.body.style.overflow='hidden';" onmouseout="document.body.style.overflow='auto';">
    <main id="main" >
        <div class="overlay"></div>
        <header class="header">
            <h1 class="page-title">
                <div class="pull-right margin-right-2" style="display: inline-flex">
                    <input class="form-control" type="text" id="search" style="height: 30px" name="search" placeholder="Buscar..."/>
                    <a class="btn btn-primary message-list-load all-folder" id="search_button" name="search_button" style="margin-left: 5px" role="button" href="<?=base_url()?>purchaseorders/filter/search/">
                        <i class="fa fa-search"></i>
                    </a>
                </div>

                <div class="message-list-header">
                    <span id="inbox-folder"><i class="icon dripicons-inbox"></i> <?=$this->lang->line('application_INBOX');?></span>
                    <span id="sent-folder"><i class="icon dripicons-user"></i> <?=$this->lang->line('application_created_by_me');?></span>
                    <span id="finished-folder"><i class="icon dripicons-thumbs-up"></i> <?=$this->lang->line('application_finished');?></span>
                    <span id="canceled-folder"><i class="icon dripicons-thumbs-down"></i> <?=$this->lang->line('application_Canceled');?></span>
                    <span id="all-folder"><i class="icon dripicons-folder"></i> <?=$this->lang->line('application_all');?></span>
                </div>
            </h1>

        </header>
        <div class="action-bar">
            <ul>
                <li><a class="btn btn-primary" data-toggle="mainmodal" role="button" href="<?=base_url()?>purchaseorders/write" title="<?=$this->lang->line('application_write_message');?>"><i class="icon dripicons-pencil space"></i> <span class="hidden-xs"><?=$this->lang->line('application_new_purchase_order');?></span></a></li>
                <li>
                    <div class="btn-group">
                        <a class="btn btn-primary message-list-load inbox-folder" id="message-trigger" role="button" href="<?=base_url()?>purchaseorders/listing" title="Inbox"><i class="icon dripicons-inbox space"></i> <span class="hidden-xs"><?=$this->lang->line('application_INBOX');?></span></a>
                        <a class="btn btn-primary message-list-load sent-folder" role="button" href="<?=base_url()?>purchaseorders/filter/sent/0" title="Sent Folder"><i class="icon dripicons-user space"></i> <span class="hidden-xs"><?=$this->lang->line('application_created_by_me');?></span></a>
                        <a class="btn btn-success message-list-load finished-folder" role="button" href="<?=base_url()?>purchaseorders/filter/finished/0" title="Finished Folder"><i class="icon dripicons-thumbs-up space"></i> <span class="hidden-xs"><?=$this->lang->line('application_finished');?></span></a>
                        <a class="btn btn-danger message-list-load canceled-folder" role="button" href="<?=base_url()?>purchaseorders/filter/canceled" title="Canceled Folder"><i class="icon dripicons-thumbs-down space"></i> <span class="hidden-xs"><?=$this->lang->line('application_Canceled');?></span></a>
                        <?php if ($is_viewer == true) : ?>
                            <a class="btn btn-warning message-list-load all-folder" role="button" href="<?=base_url()?>purchaseorders/filter/all/0" title="All Folder"><i class="icon dripicons-folder space"></i> <span class="hidden-xs"><?=$this->lang->line('application_all');?></span></a>
                        <?php endif; ?>
                    </div>
                </li>

            </ul>
        </div>
        <div id="main-nano-wrapper" class="nano">
            <div class="nano-content" id="purchaseorderslist">
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

        $("#search_button"). click(function(){
            var str = $("#search"). val();
            let url = '<?=base_url()?>'+'purchaseorders/filter/search/'
            $(this).attr("href", url+str)
        });

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                $('#search_button').click()
            }
        });

    });


</script>
