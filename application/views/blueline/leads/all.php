<div class="col-sm-13 col-md-12 main">
	<div class="row">

        <?php

        $condition = $this->user->department_has_user("Comercial", $this->user);

        ?>

		<div id="kanban-page">

                <a v-if="stages.length > 1" href="<?=base_url()?>leads/create" class="btn btn-primary" data-toggle="mainmodal" v-cloak>
                    <?=$this->lang->line('application_create_lead');?>
                </a>

            <?php if($condition == 1) { ?>

                <a href="<?=base_url()?>leads/status/create" class="btn btn-primary" data-toggle="mainmodal" v-cloak>
                    <?=$this->lang->line('application_create_status');?>
                </a>

            <?php } ?>

            <div class="pull-right">
                <input class="kanban-search" :class="(search != '') ? 'active' : ''" type="text" name="search" v-model="search" placeholder="<?=$this->lang->line('application_search');?>" />

                <?php if($condition == 1) { ?>
                    <button class="tv-screen btn btn-warning" id="tv-screen2">Modo WEB</button>
                <?php } ?>
            </div>



			<div class="col-md-4 select-wrapper pull-right" v-cloak>

                <?php if($condition == 1) { ?>


                <a href="<?=base_url()?>leads/tags" class="btn btn-success">
                    <?=$this->lang->line('application_edit_tags');?>
                </a>

                <a href="<?=base_url()?>leads/lost" class="btn btn-danger">
                    <?=$this->lang->line('application_show_lost_leads');?>
                </a>

                <?php } ?>
				<select class="kanban-tags" type="text" name="tagsearch" v-model="tagSearch" placeholder="<?=$this->lang->line('application_tags');?>">
					<option value="" selected>
						<?=$this->lang->line('application_all_tags');?>
					</option>
					<option v-for="tag in getAllTags" :value="tag" v-cloak>{{ tag }}</option>
				</select>
			</div>

            <div  id="block-all-leads" style="background: #f1f4fa">

                <kanban-board :stages="stages" :blocks="getLeads" @update-block="updateBlock" @delete-block="deleteBlock">
                    <div v-for="(stage, index) in stages" :slot="stage.name" v-cloak>

                        <?php if($condition == 1) { ?>

                            <div class="btn-group pull-right-responsive">
                                <i class="options icon dripicons-dots-3 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a data-toggle="mainmodal" :href="'<?=base_url()?>leads/status/edit/'+stage.id">
                                            <?=$this->lang->line('application_edit');?>
                                        </a>
                                    </li>

                                    <?php if ($this->user->admin == 1)  { //apenas administradores apagam estágios ?>

                                        <li>
                                            <a @click="deleteStatus(stage.id, index)" href="#">
                                                <?=$this->lang->line('application_delete');?>
                                            </a>
                                        </li>

                                    <?php } ?>

                                    <li v-if="index > 0">
                                        <a @click="moveStatus(stage.id, index, 'left')" href="#">
                                            <i class="icon dripicons-arrow-thin-left"></i>
                                            <?=$this->lang->line('application_move_left');?>
                                        </a>
                                    </li>
                                    <li v-if="index < maxStages-1">
                                        <a @click="moveStatus(stage.id, index, 'right')" href="#">
                                            <i class="icon dripicons-arrow-thin-right"></i>
                                            <?=$this->lang->line('application_move_right');?>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        <?php } ?>
                    </div>

                    <div v-for="(block, index) in getLeads" :slot="block.id" v-cloak>

                        <div>
                            <!--						<i class="icon dripicons-lock" style="font-size: 20px; color: orangered;" title="--><?//=htmlspecialchars($this->lang->line('application_private_lead'));?><!--"-->
                            <!--						 v-if="block.private != 0"></i>-->
                            <span class="block-title">{{ block.name }}</span>
                            <div v-if="inDueReminders(block.id)" @click="openThisBlock(block.id); loadReminders(block.id);" class="pull-right switcher-button-container">
                                <i class="bell-icon icon dripicons-bell bell"></i>
                            </div>
                            <div class="pull-right switcher-button-container">

                                <!--<i class="status-icon switcher-button ionicons" :class="(block.icon != null && block.icon != '') ? block.icon : 'ion-ios-pricetag'"
							 @click="openThisSwitch(block.id)"></i>
							<transition name="fade-slide-down">
								<div v-if="openSwitch == block.id" class="switcher-group">
									<i v-if="block.icon != null && block.icon != ''" class="status-icon ionicons ion-ios-pricetag" data-position="left"
									 title="" @click="setIcon(block.id, '')"></i>
									<i v-if="block.icon != 'cold'" class="status-icon ionicons cold" data-position="left" title="<?/*=htmlspecialchars(addslashes($this->lang->line('application_cold')));*/?>"
									 @click="setIcon(block.id, 'cold')"></i>
									<i v-if="block.icon != 'hot'" class="status-icon ionicons hot" data-position="left" title="<?/*=htmlspecialchars(addslashes($this->lang->line('application_hot')));*/?>"
									 @click="setIcon(block.id, 'hot')"></i>
									<i v-if="block.icon != 'won'" class="status-icon ionicons won" data-position="left" title="<?/*=htmlspecialchars(addslashes($this->lang->line('application_won')));*/?>"
									 @click="setIcon(block.id, 'won')"></i>
								</div>
							</transition>-->
                            </div>
                        </div>



                        <div id="block-subtitle" class="block-subtitle">
                            {{ block.company }}
                        </div>

                        <div class="block-proposal-value || block.rated_power_mod != ``">
                            <span v-if="block.rated_power_mod != ``" class="label label-info">{{ block.rated_power_mod }} <?=$core_settings->rated_power_measurement?></span>
                            <span v-if="block.proposal_value != `` && block.proposal_value != null" class="label label-info" id="block-price"><?=$core_settings->money_symbol?> {{ block.proposal_value }}</span>
                        </div>

                        <div class="">
                            <span v-if="(block.city != `` && block.state != ``) && (block.city != null && block.state != null)" class="label label-important">{{ block.city }}/{{ block.state }}</span>
                        </div>

                        <div>
                            <span v-if="block.owner != ``" class="label label-success">{{ block.owner }}</span>
                        </div>


                        <div class="block-details" v-if="block.id == openBlock" :class="(block.id == openBlock) ? 'block-details-open' : ''">
                            <ul class="nav nav-tabs nav-tabs-lead">

                                <li :class="(openDetails == block.id) ? 'active' : '' ">
                                    <a @click="loadDetails(block.id)" href="#details">
                                        <i class="icon dripicons-information" title="<?=$this->lang->line('application_details');?>"></i>
                                    </a>
                                </li>

                                <li :class="(openActivities == block.id) ? 'active' : '' ">
                                    <a @click="loadActivities(block.id)" href="#activities">
                                        <i class="icon dripicons-message" title="<?=$this->lang->line('application_activities');?>"></i>
                                    </a>
                                </li>

                                <li :class="(openReminders == block.id) ? 'active' : '' ">
                                    <a id="remindertab" @click="loadReminders(block.id)" href="#reminders">
                                        <i class="icon dripicons-bell" title="<?=$this->lang->line('application_reminder');?>"></i>
                                    </a>
                                </li>

                                <li :class="(openHistory == block.id) ? 'active' : '' ">
                                    <a @click="loadHistory(block.id)" href="#history">
                                        <i class="icon dripicons-hourglass" title="<?=$this->lang->line('application_history');?>"></i>
                                    </a>
                                </li>

                                <!--                            --><?php //if($condition == 1) { ?>
                                <li>
                                    <a data-toggle="mainmodal" :href="'<?=base_url()?>leads/edit/'+block.id">
                                        <i class="icon dripicons-gear" title="<?=$this->lang->line('application_edit');?>"></i>
                                    </a>
                                </li>
                                <!--							--><?//}?>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane tab1" v-if="openDetails == block.id" :class="(openDetails == block.id) ? 'in active animated slideInLeft' : '' ">
                                    <ul class="details">
                                        <li v-if="block.position != ''">
										<span>
											<?=$this->lang->line('application_position');?>
										</span>
                                            {{ block.position }}
                                        </li>
                                        <li v-if="block.address != '' || block.city != '' || block.zipcode != '' || block.country != ''">
										<span>
											<?=$this->lang->line('application_address');?>
										</span>
                                            {{ block.address}} {{ block.city }} {{ block.zipcode}} {{ block.country }}
                                        </li>
                                        <li v-if="block.email != ''">
										<span>
											<?=$this->lang->line('application_email');?>
										</span>
                                            {{ block.email }}
                                        </li>
                                        <li v-if="block.phone != ''">
										<span>
											<?=$this->lang->line('application_phone');?>
										</span>
                                            {{ block.phone }}
                                        </li>
                                        <li v-if="block.mobile != ''">
										<span>
											<?=$this->lang->line('application_mobile');?>
										</span>
                                            {{ block.mobile }}
                                        </li>
                                        <!--<li v-if="block.language  != ''">
										<span>
											<?/*=$this->lang->line('application_language');*/?>
										</span>
										{{ block.language }}
									</li>-->
                                        <!--<li v-if="block.source != ''">
										<span>
											<?/*=$this->lang->line('application_source');*/?>
										</span>
										{{ block.source }}
									</li>-->
                                        <li v-if="block.tags" class="tags">
										<span>
											<?=$this->lang->line('application_tags');?>
										</span>
                                            <span v-for="tag in blockTags(block.tags)" class="label label-success">{{ tag }}</span>
                                        </li>
                                        <li v-if="block.description.trim().length > 0">
										<span>
											<?=$this->lang->line('application_description');?>
										</span>
                                            <p v-html="block.description"></p>
                                        </li>
                                        <li v-if="block.proposal_value != null && block.proposal_value != ``">
										<span>
											<?=$this->lang->line('application_proposal_value');?>
										</span>
                                            <?=$core_settings->money_symbol; ?> {{ block.proposal_value }}
                                        </li>
                                        <li v-if="block.rated_power_mod != null && block.rated_power_mod != ``">
										<span>
											<?=$this->lang->line('application_rated_power');?>
										</span>
                                            {{ block.rated_power_mod }} <?=$core_settings->rated_power_measurement?>
                                        </li>

                                        <li v-if="block.owner != ''">
										<span>
											<?=$this->lang->line('application_lead_owner');?>
										</span>
                                            {{ block.owner }}
                                        </li>
                                        <li v-if="block.user_id != 0">
										<span>
											<?=$this->lang->line('application_registration_responsible');?>
										</span>
                                            {{ block.user.firstname }} {{ block.user.lastname }}
                                        </li>
                                        <li v-if="block.created != ''">
										<span>
											<?=$this->lang->line('application_created');?>
										</span>
                                            {{ datetime(block.created) }}
                                        </li>
                                        <li v-if="block.modified != ''">
										<span>
											<?=$this->lang->line('application_modified');?>
										</span>
                                            {{ datetime(block.modified) }}
                                        </li>
                                        <li v-if="block.last_landing != ''">
										<span>
											<?=$this->lang->line('application_last_landing');?>
										</span>
                                            {{ datetime(block.last_landing) }}
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-pane tab2" v-if="openActivities == block.id" :class="(openActivities == block.id) ? 'in active animated slideInRight' : '' ">

                                    <div class="form-group filled chat_message_input">

                                        <textarea name="message" v-model.trim.lazy="commentForm.message" class="form-control autogrow message" placeholder="<?=$this->lang->line('application_write_message');?>"></textarea>
                                        <span class="options">

										<i class="ion-ios-paperplane-outline" v-if="!formLoading" @click="submitComment(block.id)" title="<?=$this->lang->line('application_send');?>"></i>
										<img class="loading" src="<?=base_url()?>assets/blueline/images/loading_mini_ripple.gif" v-show="formLoading" />
										<i class="ion-android-attach chat-attach" v-if="!formLoading" title="<?=$this->lang->line('application_attachment');?>"></i>
										<input type="file" name="userfile" @change="uploadAttachment" :data-image-holder="'image_holder_'+block.id" class="chat-attachment lead-attachment hidden">

									</span>
                                        <div class="lead-image-preview" v-if="attachment.file">
                                            <div class="lead-upload-progress" v-if="uploadProcess">
                                                {{ uploadProcess }}%
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" :aria-valuenow="uploadProcess" aria-valuemin="0" aria-valuemax="100" :style="'width:'+ uploadProcess+'%'"></div>
                                                </div>
                                            </div>
                                            <span v-if="!uploadProcess" class="progress-bar" @click="removeAttachment" title="<?=$this->lang->line('application_delete');?>">
											<i class="ionicons ion-close-round"></i>
										</span>
                                            <img v-if="attachment.image" :src="attachment.image" />
                                            <div v-if="!attachment.image" class="file-icon file-icon-lg" :data-type="getFileType"></div>
                                            <p class="file-name">{{ attachment.name }}</p>
                                        </div>
                                    </div>

                                    <div class="center" v-show="activitiesLoading">
                                        <div class="pulse"></div>
                                        <div class="pulse-inner"></div>
                                    </div>

                                    <div class="center" v-if="comments == '' && !activitiesLoading">
                                        <p class="shadow-icon">
                                            <i class="ionicons ion-ios-chatbubble-outline"></i>
                                        </p>
                                        <span class="shadow-text">
										<?=$this->lang->line('application_no_activities_yet');?>
									</span>
                                    </div>

                                    <div v-if="!activitiesLoading">
                                        <transition-group name="list" tag="ul" class="lead-comments" appear>
                                            <li v-for="comment in comments" v-bind:key="comment.id">
                                                <img class="userpic img-circle" :src="comment.user.userpic">
                                                <span class="username">{{ comment.user.firstname }} {{ comment.user.lastname }}</span>
                                                <span class="time">{{ getTime(comment.datetime, "MMM Do YY") }}</span>
                                                <div class="comment-wrapper arrow-box arrow-top-left">
                                                    <p>{{ comment.message }}</p>
                                                </div>
                                                <div class="lead-attachment" v-if="comment.attachment">
                                                    <a v-if="isImage(comment.attachment_link)" :href="'<?=base_url()?>files/media/'+comment.attachment_link" :data-lightbox="'lead'+comment.lead_id"
                                                       :data-title="comment.attachment">
                                                        <img :src="'<?=base_url()?>files/media/thumb_'+comment.attachment_link" />
                                                    </a>
                                                    <a v-if="!isImage(comment.attachment_link)" :href="'<?=base_url()?>leads/attachment/'+comment.id">
                                                        <div v-if="!isImage(comment.attachment_link)" class="file-icon file-icon-lg" :data-type="getExt(comment.attachment_link)"></div>
                                                    </a>
                                                    <p class="file-name">{{ comment.attachment }}</p>
                                                </div>
                                            </li>
                                        </transition-group>
                                    </div>

                                </div>

                                <div class="tab-pane tab3" v-if="openReminders == block.id" :class="(openReminders == block.id) ? 'in active animated slideInRight' : '' ">

                                    <a :href="'<?=base_url()?>leads/reminder/create/'+block.id" class="btn btn-primary btn-block lead-reminder-button" data-toggle="mainmodal">
                                        <?=$this->lang->line('application_create_reminder');?>
                                    </a>

                                    <div class="center" v-show="reminders == '' && !remindersLoading">
                                        <p class="shadow-'icon">
                                            <i class="ionicons ion-ios-bell-outline"></i>
                                        </p>
                                        <span class="shadow-text">
										<?=$this->lang->line('application_no_reminders_yet');?>
									</span>
                                    </div>

                                    <div class="center" v-show="remindersLoading">
                                        <div class="pulse"></div>
                                        <div class="pulse-inner"></div>
                                    </div>

                                    <transition-group name="list" tag="ul" class="lead-reminders" appear>
                                        <li v-for="(reminder, index) in reminders" v-bind:key="reminder.id">
                                            <div class="reminder-wrapper has-hover-options" :class="[(isDue(reminder.datetime) && reminder.done == 0) ? 'red' : 'green', (reminder.done == 1) ? 'gray' : '']">
                                                <i class="icon dripicons-bell" :class="[(isDue(reminder.datetime) && reminder.done == 0) ? 'bell' : '']"></i>
                                                <span class="reminder-datetime" :title="overDue(reminder.datetime)" :class="(reminder.done == 0) ? 'tippy' : ''">
												{{ datetime(reminder.datetime) }}
											</span>
                                                <div class="pull-right hover-options">
                                                    <i class="icon dripicons-trash" @click="deleteReminder(reminder.id, index)"></i>
                                                    <a :href="'<?=base_url()?>leads/reminder/edit/'+reminder.id" data-toggle="mainmodal">
                                                        <i class="icon dripicons-pencil"></i>
                                                    </a>
                                                </div>

                                                <p>
                                                    <i @click="toggleReminder(reminder.id)" class="ionicons reminder-check" :class="(reminder.done == 1) ? 'ion-android-checkbox-outline' : 'ion-android-checkbox-outline-blank'"
                                                       title="<?=$this->lang->line('application_done');?>"></i> {{ reminder.title }}</p>
                                            </div>
                                        </li>
                                    </transition-group>
                                </div>

                                <div class="tab-pane tab4" v-if="openHistory == block.id" :class="(openHistory == block.id) ? 'in active animated slideInRight' : '' ">


                                    <div class="center" v-show="historyLoading">
                                        <div class="pulse"></div>
                                        <div class="pulse-inner"></div>
                                    </div>

                                    <div class="center" v-if="history == '' && !historyLoading">
                                        <p class="shadow-icon">
                                            <i class="ionicons ion-ios-people-outline"></i>
                                        </p>
                                        <span class="shadow-text">
										<?=$this->lang->line('application_no_history');?>
									</span>
                                    </div>

                                    <div v-if="!historyLoading">
                                        <transition-group name="list" tag="ul" class="lead-comments" appear>
                                            <li v-for="comment in history" v-bind:key="comment.id">
                                                <span style="font-weight: bold" class="username"> {{ comment.created_at }}</span>
                                                <div class="username">
                                                    <p>{{ comment.message }}</p>
                                                </div>
                                            </li>
                                        </transition-group>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="row block-actions" :class="block.completed">

                            <a class="col-xs-2 center" :class="(block.address != '' || block.city != '' || block.zipcode != '' || block.country != '') ? 'white' : 'transparent'"
                               :href="(block.address != '' || block.city != '' || block.zipcode != '' || block.country != '') ? 'https://maps.google.com?q='+block.address+'+'+block.city+'+'+block.zipcode+'+'+block.country : ''" target="_blank"
                               :title="(block.address != '' || block.city != '' || block.zipcode != '' || block.country != '') ? block.address+' '+block.city+' '+block.zipcode+' '+block.country : ''">
                                <i class="icon dripicons-direction"></i>
                            </a>
                            <a class="col-xs-2 center" :class="(block.email != '') ? 'white' : 'transparent'" :href="(block.email != '') ? 'https://mail.google.com/mail/u/1/?view=cm&fs=1&to='+block.email+'&tf=1' : ''"

                               :title="block.email" target="_blank">
                                <i class="icon dripicons-mail"></i>
                            </a>
                            <a class="col-xs-2 center" :class="(block.phone != '') ? 'white' : 'transparent'" :href="(block.phone != '') ? 'tel:'+normalizePhoneNumber(block.phone) : ''"
                               :title="block.phone">
                                <i class="icon dripicons-phone"></i>
                            </a>
                            <a class="col-xs-2 center" :class="(block.mobile != '') ? 'white' : 'transparent'" :href="(block.mobile != '') ? 'tel:'+normalizePhoneNumber(block.mobile) : ''"
                               :title="block.mobile">
                                <i class="icon dripicons-device-mobile"></i>
                            </a>
                            <a class="col-xs-2 center" :class="(block.payment != 'bank financing') ? '' : ''" :title="block.payment == 'bank financing' ? 'Financiamento bancário' : 'Recursos próprios'">
                                <i :class="block.payment == 'bank financing' ? 'icon dripicons-jewel white' : ''"></i>
                            </a>
                            <!--<a class="col-xs-2 center" :class="(block.private != '1') ? '' : ''" title="Histórico do Lead">
                                <i class="icon dripicons-hourglass"></i>
                            </a>-->
                            <a class="col-xs-2 center white" href="#" @click="openThisBlock(block.id)" title="<?=$this->lang->line('application_details');?>">
                                <i class="icon dripicons-expand-2"></i>
                            </a>
                        </div>

                    </div>

                </kanban-board>
            </di>

				<div class="kanban-empty-state" v-if="maxStages == 1 && kanbanReady" v-cloak>
					<svg width="64px" height="64px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" opacity="0.312330163">
							<g id="share" transform="translate(32.000000, 32.000000) rotate(-90.000000) translate(-32.000000, -32.000000) " fill="#1D1D1B" fill-rule="nonzero">
								<path d="M63.386,16.193 L63.388,16.191 C63.39,16.188 63.392,16.185 63.394,16.181 C63.566,15.986 63.692,15.751 63.793,15.503 C63.825,15.427 63.846,15.355 63.869,15.278 C63.927,15.087 63.963,14.889 63.975,14.682 C63.981,14.606 63.993,14.534 63.991,14.456 C63.991,14.416 64.001,14.38 63.999,14.341 C63.985,14.102 63.937,13.871 63.863,13.654 C63.857,13.631 63.841,13.613 63.833,13.59 C63.745,13.351 63.619,13.139 63.47,12.945 C63.449,12.918 63.442,12.882 63.42,12.855 L53.109,0.709 C52.32,-0.221 51.025,-0.239 50.215,0.672 C49.407,1.582 49.392,3.074 50.183,4.006 L55.741,10.555 C47.62,9.479 39.637,11.188 39.26,11.272 C14.614,15.739 -2.827,38.499 0.38,62.008 C0.539,63.172 1.408,64 2.399,64 C2.505,64 2.611,63.991 2.719,63.973 C3.835,63.77 4.597,62.564 4.423,61.277 C1.566,40.337 17.479,19.995 39.96,15.919 C40.063,15.895 48.311,14.125 56.077,15.345 L47.5,20.438 C46.495,21.036 46.102,22.458 46.619,23.615 C47.135,24.774 48.367,25.223 49.375,24.632 L62.895,16.604 C63.078,16.493 63.242,16.354 63.386,16.193 Z" id="Shape"></path>
							</g>
						</g>
					</svg>
					<?=$this->lang->line('application_no_status_yet');?>
				</div>
			<notifications group="kanban" position="bottom right" />
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function($) {

    const el = $('section[class="drag-column-13"]');
    // $(el).animate({scrollTop: $(el).scrollHeight}, 500);

    console.log($(el).html());

    // $(el).html(null);


    $(document).bind("fullscreenchange", function() {
        if (!$(document).fullScreen()){
            $(".drag-column").removeClass("lead-screen-tv-size");
            $(".block-title").removeClass("lead-title-tv-size");
            $(".tippy").removeClass("lead-status-tv-title")
            $("#block-price, #block-subtitle").toggle();
            $("#block-price").is(":hidden") ? $(".drag-list").css("height", "1400px") : $(".drag-list").css("height", "auto");
        }
    });

    $(".tv-screen").on('click', function () {
        if ($("#block-all-leads").fullScreen() != null) {
            $(".drag-column").addClass("lead-screen-tv-size");
            $(".block-title").addClass("lead-title-tv-size");
            $(".tippy").addClass("lead-status-tv-title");
            $("#block-price, #block-subtitle").toggle();
            $("#block-all-leads").toggleFullScreen();
            $("#block-price").is(":hidden") ? $(".drag-list").css("height", "1400px") : $(".drag-list").css("height", "auto");
        }
    });
});
</script>
<?php if (isset($search)) :?>
	<script>
        sessionStorage . setItem('lead', '<?=$search?>');

	</script>
<?php endif; ?>