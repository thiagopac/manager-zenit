import Vue from "vue";
import vueKanban from "vue-kanban";
import axios from "axios";
import Notifications from "vue-notification";
var phoneFormatter = require("phone-formatter");
import {debounce} from "lodash";

Vue.use(vueKanban);
Vue.use(Notifications);
axios.defaults.baseURL = window.baseUrl;

if (document.querySelector("#kanban-page")) {
  window.kanbanVue = new Vue({
    el: "#kanban-page",
    data: {
      errors: [],
      stages: [{id: "options", name: "Options", offset: 0, limit: 2}],
      kanbanReady: false,
      blocks: [],
      comments: [],
      reminders: [],
      dueReminders: [],
      search: sessionStorage.getItem("lead") ? sessionStorage.getItem("lead") : "",
      tagSearch: "",
      openBlock: 0,
      openSwitch: 0,
      openDetails: 0,
      openActivities: 0,
      openHistory: 0,
      openReminders: 0,
      activitiesLoading: false,
      remindersLoading: false,
      formLoading: false,
      uploadProcess: false,
      attachment: {
        name: false,
        image: false,
        file: false,
        type: false
      },
      commentForm: {
        id: 0,
        user_id: 0,
        message: "",
        datetime: "",
        attachment: "",
        lead_id: 0,
        attachment_link: ""
      }
    },
    computed: {
      maxStages: function() {
        return Number(this.stages.length);
      },
      getFileType: function() {
        return this.attachment.name ? this.attachment.name.split(".").pop() : false;
      },
      getAllTags: function() {
        var allTags = [];
        this.blocks.forEach(element => {
          var tags = element.tags != "" ? element.tags.split(",") : [];
          tags.forEach(tag => {
            if ($.inArray(tag, allTags) == -1 && tag != "") {
              allTags.push(tag);
            }
          });
        });
        return allTags;
      },
      getLeads: function() {
        sessionStorage.removeItem("lead");

        var self = this;

        return this.blocks.filter(function(block) {
          return (
            block.tags
              .trim()
              .toLowerCase()
              .search(self.tagSearch.trim().toLowerCase()) >= 0 &&
            (block.name.toLowerCase().indexOf(self.search.toLowerCase()) >= 0 ||
              block.company.toLowerCase().indexOf(self.search.toLowerCase()) >= 0 ||
              block.description.toLowerCase().indexOf(self.search.toLowerCase()) >= 0 ||
              block.source.toLowerCase().indexOf(self.search.toLowerCase()) >= 0 ||
              block.id == self.search)
          );
        });
      }
    },

    created: function() {
      this.loadBlocks();
      this.loadDueReminders();
    },
    watch: {
      reminders: function() {
        this.loadDueReminders();
      }
    },

    methods: {
      loadBlocks() {
        axios
          .get("leads/all")
          .then(response => {
            this.blocks = response.data.data.leads;
            this.stages = response.data.data.stages;
            this.stages.push({id: "options", name: "Options", offset: 0, limit: 2});
            this.kanbanReady = true;
          })
          .catch(e => {
            this.errors.push(e);
          });
      },
      getBlock(id) {
        var block_id = id;
        function findBlock(block) {
          return block.id === Number(block_id);
        }
        return this.getLeads.find(findBlock);
      },
      openThisBlock(id) {
        this.openBlock = this.openBlock == id ? 0 : id;
        this.openDetails = id;
        this.openActivities = 0;
        this.openHistory = 0;
        this.openReminders = 0;
        this.comments = [];
      },
      openThisSwitch(id) {
        this.openSwitch = this.openSwitch == id ? 0 : id;
      },
      setIcon(id, state) {
        this.blocks.find(b => b.id === Number(id)).icon = state;
        this.openSwitch = 0;
        axios.get("leads/icon/" + id + "/" + state).then(response => {});
      },
      loadDetails(id) {
        this.openHistory = 0;
        this.openActivities = 0;
        this.openHistory = 0;
        this.openReminders = 0;
        this.openDetails = id;
      },
      loadHistory(id) {
        this.openHistory = id;
        this.openActivities = 0;
        this.openReminders = 0;
        this.openDetails = 0;
        this.historyLoading = true;
        var vm = this;
        axios.get("leads/history/" + id).then(response => {
          if (response.data.status == "error" || response.headers["content-type"] != "application/json") {
            vm.$notify({
              group: "kanban",
              type: "error",
              title: "Error",
              text:
                response.headers["content-type"] != "application/json"
                  ? "You are logged out. Please login again."
                  : response.data.message
            });
          }
          this.history = response.data.data.history;
          Vue.nextTick(function() {
            vm.historyLoading = false;
          });
        });
      },
      loadActivities(id) {
        this.openActivities = id;
        this.openHistory = 0;
        this.openReminders = 0;
        this.openDetails = 0;
        this.activitiesLoading = true;
        var vm = this;
        axios.get("leads/comments/" + id).then(response => {
          if (response.data.status == "error" || response.headers["content-type"] != "application/json") {
            vm.$notify({
              group: "kanban",
              type: "error",
              title: "Error",
              text:
                response.headers["content-type"] != "application/json"
                  ? "You are logged out. Please login again."
                  : response.data.message
            });
          }
          this.comments = response.data.data.comments;
          Vue.nextTick(function() {
            vm.activitiesLoading = false;
          });
        });
      },
      loadReminders(id) {
        this.reminders = [];
        this.remindersLoading = true;
        this.openReminders = id;
        this.openHistory = 0;
        this.openActivities = 0;
        this.openDetails = 0;
        var vm = this;
        axios.get("leads/reminders/" + id).then(response => {
          if (response.data.status == "error" || response.headers["content-type"] != "application/json") {
            vm.$notify({
              group: "kanban",
              type: "error",
              title: "Error",
              text:
                response.headers["content-type"] != "application/json"
                  ? "You are logged out. Please login again."
                  : response.data.message
            });
          }
          this.reminders = response.data.data.reminders;
          Vue.nextTick(function() {
            vm.remindersLoading = false;
          });
        });
      },
      toggleReminder(id) {
        this.reminders.find(b => b.id === Number(id)).done =
          this.reminders.find(b => b.id === Number(id)).done == 1 ? 0 : 1;
        this.openSwitch = 0;
        axios.get("leads/togglereminder/" + id).then(response => {});
        this.loadDueReminders();
      },
      loadDueReminders: function() {
        axios
          .get("leads/duereminders")
          .then(response => {
            this.dueReminders = response.data.data.due_reminders;
          })
          .catch(e => {
            this.errors.push(e);
          });
      },
      inDueReminders: function(id) {
        return this.dueReminders.find(b => b.source_id === Number(id));
      },
      deleteReminder(id, index) {
        axios.get("leads/reminder/delete/" + id).then(response => {});
        this.reminders.splice(index, 1);
      },
      getExt: function(name) {
        return name.split(".").pop();
      },
      isImage: function(name) {
        var ext = name.split(".").pop();
        return ext == "jpeg" || ext == "jpg" || ext == "gif" || ext == "png" || ext == "bmp" ? true : false;
      },
      uploadAttachment(e) {
        this.formLoading = true;
        this.attachment.image = false;
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length) {
          return;
        }
        this.attachment.type = files[0].type;
        this.attachment.name = files[0].name;
        if (
          files[0].type == "image/png" ||
          files[0].type == "image/jpeg" ||
          files[0].type == "image/png" ||
          files[0].type == "image/gif"
        ) {
          this.createImage(files[0]);
        } else {
          this.formLoading = false;
        }
        this.attachment.file = files[0];
      },
      createImage(file) {
        var attachment = new Image();
        var reader = new FileReader();
        var vm = this;

        reader.onload = e => {
          vm.attachment.image = e.target.result;
        };
        reader.readAsDataURL(file);
        this.formLoading = false;
      },
      removeAttachment: function(e) {
        this.attachment = [
          {
            name: false,
            image: false,
            file: false,
            type: false
          }
        ];
      },
      submitComment(leadId) {
        $(".message").blur();
        if (this.commentForm.message == "") {
          return false;
        }

        this.formLoading = true;
        var data = {
          id: this.commentForm.id,
          user_id: this.commentForm.user_id,
          message: this.commentForm.message,
          datetime: this.commentForm.datetime,
          attachment: this.commentForm.attachmant,
          lead_id: leadId,
          attachment_link: this.commentForm.attachment_link,
          user: {
            firstname: "",
            lastname: "",
            email: ""
          }
        };

        this.commentForm.message = "";

        var params = new FormData();
        params.append("fcs_csrf_token", csfrData.fcs_csrf_token);
        params.append("message", data.message);
        params.append("lead_id", data.lead_id);
        if (this.attachment.file) {
          params.append("userfile", this.attachment.file);
        }

        var vm = this;
        var config = {
          onUploadProgress: function(progressEvent) {
            vm.uploadProcess = Math.round(progressEvent.loaded * 100 / progressEvent.total);
          }
        };
        axios
          .post("leads/addcomment/", params, config)
          .then(response => {
            data.id = response.data.data.comment.id;
            data.user_id = response.data.data.comment.user_id;
            data.user.userpic = response.data.data.comment.userpic;
            data.datetime = response.data.data.comment.datetime;
            data.user.firstname = response.data.data.comment.firstname;
            data.user.lastname = response.data.data.comment.lastname;
            data.attachment = response.data.data.comment.attachment;
            data.attachment_link = response.data.data.comment.attachment_link;
            vm.comments.unshift(data);
            vm.formLoading = false;
            vm.uploadProcess = false;
            vm.removeAttachment();
          })
          .catch(function(error) {
            vm.$notify({
              group: "kanban",
              type: "error",
              title: "Error",
              text: error.message
            });
            vm.formLoading = false;
            vm.uploadProcess = false;
            vm.removeAttachment();
          });
      },
      deleteStatus(id, index) {
        axios.get("leads/status/delete/" + id).then(response => {});
        this.stages.splice(index, 1);
      },
      moveStatus(id, index, direction) {
        if (direction == "left") {
          this.stages.move(index, index - 1);
        } else {
          this.stages.move(index, index + 1);
        }

        axios
          .get("leads/status/move/" + id + "/" + direction)
          .then(response => {
            if (response.data.status == "error" || response.headers["content-type"] != "application/json") {
              this.$notify({
                group: "kanban",
                type: "error",
                title: "Error",
                text:
                  response.headers["content-type"] != "application/json"
                    ? "You are logged out. Please login again."
                    : response.data.message
              });
            }
          })
          .catch(error => {
            this.errors.push(error.response.status);
            this.$notify({
              group: "kanban",
              type: "error",
              title: "Error",
              text: "You are logged out. Please login again."
            });
          });
      },
      updateBlock: debounce(function(id, status, order) {
        this.updateDbRecord(id, "status_id", Number(status), order);
      }, 500),
      deleteBlock(id, status) {
        this.$notify({
          group: "kanban",
          type: "success",
          title: "Deleted",
          duration: 3000,
          text: "Lead has been deleted!"
        });
        axios.get("leads/delete/" + id).then(response => {});
      },
      updateDbRecord(id, field, value, order) {
        var params = new URLSearchParams();
        params.append("fcs_csrf_token", csfrData.fcs_csrf_token);
        params.append("id", id);
        params.append("field", field);
        params.append("value", value);
        params.append("order", order);

        axios
          .post("leads/updateblock", params)
          .then(response => {
            if (response.data.status == "error" || response.headers["content-type"] != "application/json") {
              this.$notify({
                group: "kanban",
                type: "error",
                title: "Error",
                text:
                  response.headers["content-type"] != "application/json"
                    ? "You are logged out. Please login again."
                    : response.data.message
              });
            }
          })
          .catch(error => {
            this.errors.push(error.response.status);
            this.$notify({
              group: "kanban",
              type: "error",
              title: "Error",
              text: "You are logged out. Please login again."
            });
          });
      },
      normalizePhoneNumber(phone_number) {
        return phone_number;
      },
      blockTags(tags) {
        var tag_array = tags.split(",");
        return tag_array;
      },
      datetime: function(datetime) {
        return moment(datetime).format("lll");
      },
      getTime: function(timestamp, format) {
        return moment.unix(timestamp).format("lll");
      },
      getIsoTime: function(datetime) {
        return moment(datetime).calendar(); //.format('lll');
      },
      isDue: function(datetime) {
        return moment().isAfter(datetime);
      },
      overDue: function(datetime) {
        return moment(datetime).fromNow();
      }
    }
  });
}
