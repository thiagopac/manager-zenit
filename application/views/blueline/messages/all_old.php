<div class="col-sm-13  col-md-12 messages">

          <div class="row">
            <div class="messages-left col-sm-5  col-md-4" >
              <div class="message-list-header">
              <span id="inbox-folder"><i class="fa fa-inbox"></i> <?=$this->lang->line('application_INBOX');?></span>
              <span id="sent-folder"><i class="fa fa-mail-forward"></i> <?=$this->lang->line('application_sent');?></span>
              <span id="deleted-folder"><i class="fa fa-trash-o"></i> <?=$this->lang->line('application_Deleted');?></span>
              <span id="marked-folder"><i class="fa fa-dot-circle-o"></i> <?=$this->lang->line('application_Marked');?></span>
              </div>
              <div class="message-list-menu">
                <div class="btn-group btn-group-justified">
                  <a class="btn btn-default message-list-load inbox-folder" id="message-trigger" role="button" href="<?=base_url()?>messages/messagelist" title="Inbox"><i class="fa fa-inbox"></i></a>
                  <a class="btn btn-default message-list-load sent-folder" role="button" href="<?=base_url()?>messages/filter/sent/0" title="Sent Folder"><i class="fa fa-share"></i></a>
                  <a class="btn btn-default message-list-load deleted-folder" role="button" href="<?=base_url()?>messages/filter/deleted/0" title="<?=$this->lang->line('application_messages_show_deleted');?>"><i class="fa fa-trash-o"></i></a>
                  <a class="btn btn-default message-list-load marked-folder" role="button" href="<?=base_url()?>messages/filter/marked/0" title="<?=$this->lang->line('application_Marked');?>"><i class="fa fa-dot-circle-o"></i></a>
                  <a class="btn btn-default" data-toggle="mainmodal" role="button" href="<?=base_url()?>messages/write" title="<?=$this->lang->line('application_write_message');?>"><i class="icon dripicons-mail-o"></i></a>
                </div>
                
              </div>
              <div id="message-list" class="message-list scroll-content-2">
              
              
              </div>
          </div>
          <div id="ajax_content" class="messages-right col-sm-9  col-md-10 scroll-content" >
          </div>
        </div>
