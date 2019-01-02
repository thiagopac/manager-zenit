<link href="<?=base_url()?>assets/blueline/css/plugins/video-js.css" rel="stylesheet">
 <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/pdfobject.js"></script>


       <div class="row">
       <div class="col-xs-12 col-sm-3">
	 	<div class="table-head"><?=$this->lang->line('application_media_details');?></div>
		<div class="subcont">
			<ul class="details">
				<li><span><?=$this->lang->line('application_name');?>:</span> <?=$media->name;?></li>
				<li><span><?=$this->lang->line('application_filename');?>:</span> <?=$media->filename;?></li>
				<!-- <li><span><?=$this->lang->line('application_phase');?>:</span> <?=$media->phase;?></li> -->
				<li><span><?=$this->lang->line('application_uploaded_by');?>:</span> <a class="label label-info"><?php if (is_object($media->user)) {
    ?><?=$media->user->firstname; ?> <?=$media->user->lastname; ?><?php
} else {
        ?> <?=$media->client->firstname; ?> <?=$media->client->lastname; ?><?php
    } ?></a></li>
				<li><span><?=$this->lang->line('application_uploaded_on');?>:</span> <?php $unix = human_to_unix($media->date); echo date($core_settings->date_format, $unix); ?></li>
				<li><span><?=$this->lang->line('application_download');?>:</span> <a href="<?=base_url()?>cprojects/download/<?=$media->id;?>" class="btn btn-xs btn-success"><i class="icon-download icon-white"></i> <?=$this->lang->line('application_download');?></a></li>
				<?php if (!empty($media->description)) {
        ?><li><span><?=$this->lang->line('application_description'); ?></span><br><p class="margintop5"> <?=$media->description; ?></p></li><?php
    } ?>
			</ul>
			<br clear="both">
    	 </div>
    	 <br>
    	 <a class="btn btn-primary" href="<?=base_url()?><?=$backlink;?>"><i class="icon dripicons-arrow-thin-left"></i> <?=$this->lang->line('application_back_to_project');?></a>
    	 </div>

	 <div class="col-sm-9">

	 		<?php
                $type = explode('/', $media->type);
                switch ($type[0]) {
                case "image": ?>
					<div class="table-head"><?=$this->lang->line('application_media_preview');?></div>
					<div class="subcont preview">
					<div align="center">
						<img src="<?=base_url()?>files/media/<?=$media->savename;?>">
					</div>
					</div>
				<?php
                break;
                case "application":
                    if ($type[1] == "ogg" || $type[1] == "mp4" || $type[1]  == "webm") {
                        ?>
					<div class="table-head"><?=$this->lang->line('application_media_preview'); ?></div>
					<div class="subcont preview">
					<video id="video" class="video-js vjs-default-skin" controls
				  		preload="auto" width="100%" height="350" data-setup="{}">
				  		<source src="<?=base_url()?>files/media/<?=$media->savename; ?>" type='video/<?=$type[1]; ?>'>
					</video>
					</div>
					<?php
                    }

                    if ($type[1] == "pdf") {
                        ?>
			        <div class="table-head"><h6><i class="icon-picture"></i><?=$this->lang->line('application_media_preview'); ?></h6></div>
			        <div class="subcont preview">
			        <script type='text/javascript'>

					  function embedPDF(){

					    var myPDF = new PDFObject({

					      url: '<?=base_url()?>/files/media/<?=$media->savename; ?>'

					    }).embed('pdf-viewer');

					  }

					  window.onload = embedPDF;

					</script>
					<div id="pdf-viewer" style="height:600px; width:100%"></div>
			        </div>
					<?php
                    }

            break;
            case "video":
                    ?>
					<div class="table-head"><?=$this->lang->line('application_media_preview');?></div>
					<div class="subcont preview">
					<video id="video" class="video-js vjs-default-skin" controls
				  		preload="auto" width="100%" height="350" data-setup="{}">
				  		<source src="<?=base_url()?>files/media/<?=$media->savename;?>" type='video/<?=$type[1];?>'>
					</video>
					</div>
					<?php

            break;
            case "audio":
                    ?>
					<div class="table-head"><?=$this->lang->line('application_media_preview');?></div>
					<div class="subcont preview">
					<audio controls>
					  <source src="<?=base_url()?>files/media/<?=$media->savename;?>" type="audio/mpeg">
					</audio>
					</div>

					<?php

            break;

            } ?>
			<br>


<!--
			  <h2><?=$this->lang->line('application_comments');?></h2>
			  <hr>
			  <div id="timelinediv">
                  <ul class="timeline">
			   <li class="timeline-inverted add-comment">
                        <div class="timeline-badge gray open-comment-box"><i class="icon dripicons-plus"></i></div>
                        <div id="timeline-comment" class="timeline-panel">
                          <div class="timeline-heading">
                            <h4 class="timeline-title"><?=$this->lang->line('application_post_message');?></h4>
                          </div>
                          <div class="timeline-body">
                               <?php
                                $attributes = array('class' => 'ajaxform', 'id' => 'replyform', 'data-reload' => 'timelinediv');
                                echo form_open($form_action, $attributes);
                                ?>

                                    <div class="form-group">
                                        <input id="timestamp" type="hidden" name="datetime" value="<?php echo $datetime; ?>" />
                                        <textarea class="input-block-level summernote" id="reply" name="message"/></textarea>
                                     </div>
                                <button id="send" name="send" class="btn btn-primary button-loader"><?=$this->lang->line('application_send');?></button>
                                </form>

                          </div>
                        </div>
                      </li>



				<?php
                $i = 0;
                foreach ($media->messages as $value):
                  $i = $i+1;
              if ($i == 1) {
                  ?>

			  <?php
              }
              ?>


                      <li class="timeline-inverted">
                        <div class="timeline-badge" style="background: rgb(96, 187, 248);">
                        <?=$i;?>
                        </div>
                        <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h5 class="timeline-title">
                            <p><small class="text-muted"><span class="writer"><?=$value->from;?></span> <span class="datetime"><?php  $unix = human_to_unix($value->datetime); echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix); ?></span></small>
                            		<?php if ($value->from == $this->client->firstname." ".$this->client->lastname) {
                  ?>
							         <a href="<?=base_url()?>cprojects/deletemessage/<?=$media->project_id; ?>/<?=$media->id; ?>/<?=$value->id; ?>" rel="" class="btn btn-xs btn-danger pull-right"><i class="icon dripicons-cross"></i></a>
							 		 <?php
              } ?>
                            </p></h5>
                          </div>

                          <div class="timeline-body">
                            <p><?=$value->text;?></p>
                          </div>
                        </div>
                      </li>


			  <?php endforeach;?>

			  		<li class="timeline-inverted timeline-firstentry">
                        <div class="timeline-badge gray"><i class="icon dripicons-rocket"></i></div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h5 class="timeline-title"><?=$this->lang->line('application_media_uploaded');?></h5>
                            <p><small class="text-muted"><?php $unix = human_to_unix($media->date); echo date($core_settings->date_format, $unix); ?></small></p>
                          </div>
                          <div class="timeline-body">
                            <p><?=$this->lang->line('application_media_uploaded');?></p>
                          </div>
                        </div>
                      </li>
-->

 <div class="table-head"><?=$this->lang->line('application_comments');?>
            <span class=" pull-right"><a class="btn btn-primary open-comment-box"><?=$this->lang->line('application_new_comment');?></a></span>
            </div>
            <div class="subcont" >

<ul id="comments-ul" class="comments">
                      <li class="comment-item add-comment">
                      <?php
                                $attributes = array('class' => 'ajaxform', 'id' => 'replyform', 'data-reload' => 'comments-ul');
                                echo form_open($form_action, $attributes);
                                ?>
                      <div class="comment-pic">
                        <img class="img-circle tt" title="<?=$this->client->firstname?> <?=$this->client->lastname?>"  src="<?=$this->client->userpic;?>">

                      </div>
                      <div class="comment-content">

                            <p><small class="text-muted"><span class="comment-writer"><?=$this->client->firstname?> <?=$this->client->lastname?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, time()); ?></span></small></p>
                            <input id="timestamp" type="hidden" name="datetime" value="<?php echo $datetime; ?>" />
                            <p><textarea class="input-block-level summernote" id="reply" name="message" placeholder="<?=$this->lang->line('application_write_message');?>..." required/></textarea></p>
                            <button id="send" name="send" class="btn btn-primary button-loader"><?=$this->lang->line('application_send');?></button>
                            <button id="cancel" name="cancel" class="btn btn-danger open-comment-box"><?=$this->lang->line('application_close');?></button>

                      </div>
                       </form>
                      </li>

                                            <li class="comment-item">

                          <div class="comment-content">
                          <h5><?=$media->name;?> </h5>
                            <p><small class="text-muted"><?=$this->lang->line('application_uploaded_by');?> <?php if (is_object($media->user)) {
                                    ?><?=$media->user->firstname; ?> <?=$media->user->lastname; ?><?php
                                } else {
                                    ?> <?=$media->client->firstname; ?> <?=$media->client->lastname; ?><?php
                                } ?> <?php $unix = human_to_unix($media->date); echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix); ?></small></p>
                            <p><?=$media->description;?></p>
                          </div>
                      </li>
<?php
                $i = 0;
                foreach ($media->messages as $value):
                  $i = $i+1;
              if ($i == 1) {
                  ?>

			  <?php
              }
              ?>
                      <li class="comment-item">

                      <div class="comment-content">
                            <p><small class="text-muted"><span class="comment-writer"><?=$value->from;?></span> <span class="datetime"><?php $unix = human_to_unix($value->datetime); echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix); ?></span></small></p>
                            <p><?=$value->text;?></p>
                      </div>
                      </li>
  <?php endforeach;?>

         </ul>




</div>
			 </div>
			 </div>
