function modalfunc() {
    $('[data-toggle="mainmodal"]').bind("click", function(t) {
        t.preventDefault(), NProgress.start();
        var e = $(this).attr("href");
        0 === e.indexOf("#") ? $("#mainModal").modal("open") : $.get(e, function(t) {
            $("#mainModal").modal(), $("#mainModal").html(t)
        }).done(function() {
            NProgress.done()
        })
    }), $(document).on("click", '[data-toggle="mainmodal"]', function(t) {
        t.preventDefault(), NProgress.start();
        var e = $(this).attr("href");
        0 === e.indexOf("#") ? $("#mainModal").modal("open") : $.get(e, function(t) {
            $("#mainModal").modal(), $("#mainModal").html(t)
        }).done(function() {
            NProgress.done()
        })
    }), $(document).on("click", ".silent-submit", function(t) {
        t.preventDefault(), NProgress.start(), $('input[name="files"]').val() || $('input[name="files"]').attr("disabled", !0);
        var e = $(this).closest("form").attr("action"),
            a = $(this).data("section"),
            i = new FormData($(this).closest("form")[0]);
        $.ajax({
            type: "POST",
            url: e,
            mimeType: "multipart/form-data",
            contentType: !1,
            cache: !1,
            processData: !1,
            data: i,
            success: function(t) {},
            complete: function() {
                switch (NProgress.done(), $("#mainModal").modal("hide"), a) {
                    case "reminder":
                        window.kanbanVue.loadReminders(window.kanbanVue.openBlock);
                        break;
                    case "lead":
                        window.kanbanVue.loadBlocks()
                }
                $('input[name="files"]').attr("disabled", !1)
            }
        })
    })
}

function easyPie() {
    $(".easyPieChart").easyPieChart({
        barColor: function(t) {
            return t < 100 ? "#11A7DB" : t = "#5cb85c"
        },
        trackColor: "#E5E9EC",
        scaleColor: !1,
        size: 55
    })
}

function buttonLoader() {
    $(document).on("click", ".button-loader", function(t) {
        var e = $(this).text();
        $(this).html('<i class="icon dripicons-loading spin-it"></i> ' + e)
    })
}

function autogrowLoader() {
    $(".autogrow").autogrow()
}

function chatActionLoader() {
    function c(t) {
        var e = $("#" + t).prev().children(".chat-attachment");
        e.replaceWith(e = e.clone(!0)), $("#" + t).children().remove()
    }
    $(document).on("click", ".chat-submit", function(t) {
        if ("" == $(this).closest("form").children(".message").val() && "" == $(this).closest("form").children(".options").children(".chat-attachment").val()) return !1;
        $('input[name="files"]').val() || $('input[name="files"]').attr("disabled", !0);
        var e = new FormData($(this).closest("form")[0]);
        $('input[name="files"]').attr("disabled", !1);
        var a = $(this).closest("form").attr("action"),
            i = ($(this).closest("form").data("baseurl"), $(this)),
            o = $(this).closest(".comment-list-li").children(".task-comments"),
            n = $(this).closest("form").children(".message").val(),
            s = i.closest("form").children(".options").children("input").data("image-holder"),
            l = (l = $(".chat-message-add-template").html()).replace("[[message]]", n);
        $(".chat-dettach").remove();
        var r = $("#" + s).html();
        o.prepend('<li class="chat-message-add">' + l + r + "</li>"), $(this).closest("form").children(".message").val(""), c(s), $.ajax({
            type: "POST",
            url: a,
            mimeType: "multipart/form-data",
            contentType: !1,
            cache: !1,
            processData: !1,
            data: e,
            success: function(t) {
                $(".chat-message-add").children(".task-comments-footer").addClass("green"), $(".chat-message-add").removeClass("chat-message-add")
            },
            error: function() {
                $(".chat-message-add").children(".task-comments-footer").children("i").removeClass("ion-android-done").addClass("ion-android-close"), $(".chat-message-add").children(".task-comments-footer").addClass("red")
            },
            complete: function() {}
        })
    }), $(document).on("click", ".chat-attach", function(t) {
        var e = $(this).closest(".options").children(".chat-attachment");
        $(this).closest(".options").children(".image_holder");
        e.click()
    }), $(document).on("click", ".chat-dettach", function(t) {
        c($(this).data("image-holder"))
    }), $(document).on("change", ".chat-attachment", function(t) {
        imageholder = $(this).data("image-holder"),
            function(t, e) {
                var a = e,
                    i = t.target.files,
                    o = i[0];
                if (i && o) {
                    var n = new FileReader;
                    n.onload = function(t) {
                        if (o.type.match("image.*")) {
                            var e = t.target.result;
                            $("#" + a).html('<img class="image_holder" width="80px" src="data:' + o.type + ";base64," + btoa(e) + '" /><i class="ion-close-circled chat-dettach" data-image-holder="' + a + '"></i>')
                        } else $("#" + a).html('<div class="image_holder chat-file"><i class="ion-android-attach"></i> ' + o.name + ' <i class="ion-close-circled chat-dettach" data-image-holder="' + a + '"></i></div>')
                    }, n.readAsBinaryString(o)
                }
            }(t, imageholder)
    })
}

function show_alert(t, e) {
    $(".ajax-notify").html(e).addClass("active").addClass(t), setTimeout(function() {
        $(".ajax-notify").removeClass("active").removeClass(t)
    }, 3500)
}

function checkForUdates(t) {
    NProgress.start();
    var e = t;
    $.get(e, function(t) {}).done(function() {
        NProgress.done()
    })
}

function summernote() {
    $(".summernote").summernote({
        height: "200px",
        shortcuts: !1,
        disableDragAndDrop: !0,
        toolbar: [
            ["style", ["style"]],
            ["style", ["bold", "italic", "underline", "clear"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["insert", ["video", "picture", "link"]]
        ]
    })
}
$.ajaxSetup({
    cache: !1
}), lightbox.option({
    resizeDuration: 180,
    fadeDuration: 180,
    imageFadeDuration: 180,
    wrapAround: !0
}), String.prototype.replaceAll = function(t, e) {
    return this.replace(new RegExp(t, "g"), e)
}, Array.prototype.move = function(t, e) {
    if (e >= this.length)
        for (var a = e - this.length; 1 + a--;) this.push(void 0);
    return this.splice(e, 0, this.splice(t, 1)[0]), this
}, $(".checkbox").labelauty(), $(".checkbox-nolabel").labelauty({
    label: !1
}), modalfunc(), easyPie(), $(document).on("click", ".ajax", function(t) {
    t.preventDefault(), NProgress.start(), $(".message-list ul.list-striped li").removeClass("active"), $(this).parent().addClass("active");
    var e = $(this).attr("href");
    0 === e.indexOf("#") || $.get(e, function(t) {
        $("#ajax_content").html(t), $(".message_content:gt(1)").hide(), $("#ajax_content").velocity("transition.fadeIn")
    }).done(function() {
        $(".message_content:gt(1)").velocity("transition.fadeIn"), NProgress.done()
    })
}), $(document).on("click", ".ajax-silent", function(t) {
    t.preventDefault(), t.stopPropagation(), NProgress.start();
    var e = $(this).attr("href"),
        a = $(this);
    a.hasClass("label-changer") && (a.parents(".dropdown").removeClass("open"), a.parents(".dropdown").children(".dropdown-toggle").children("span").html('<i class="icon dripicons-loading spin-it"></i>')), $.get(e, function(t) {}).done(function() {
        a.hasClass("label-changer") && (val = a.html(), newClass = a.data("status"), a.parents(".dropdown").children(".dropdown-toggle").children("span").html(val), a.parents("td").removeClass("Paid").removeClass("Open").removeClass("Sent").removeClass("PartiallyPaid").removeClass("Canceled").addClass(newClass), a.parents(".dropdown").children(".dropdown-toggle").removeClass("label-success").removeClass("label-warning"), "Open" == newClass && a.parents(".dropdown").children(".dropdown-toggle").addClass("label-success"), "Sent" == newClass && a.parents(".dropdown").children(".dropdown-toggle").addClass("label-warning")), $(".message-list ul li a").first().click(), NProgress.done()
    })
}), Number.prototype.secondsToHoursAndMinutes = function() {
    var t = parseInt(this, 10),
        e = Math.floor(t / 3600),
        a = Math.floor((t - 3600 * e) / 60),
        i = t - 3600 * e - 60 * a;
    return e < 10 && (e = "0" + e), a < 10 && (a = "0" + a), i < 10 && (i = "0" + i), $result = [e, a], $result
}, buttonLoader(), autogrowLoader(), chatActionLoader(), $(document).on("change", ".description-setter", function(t) {
    var e = $(this).val(),
        a = $("#item" + e).html();
    $("#description").val(a)
}), $(document).on("change", ".task-check", function(t) {
    t.preventDefault();
    var e = $(this).parents("li"),
        a = $(this).data("link"),
        i = $(this);
    $.get(a, function(t) {
        "success" == t.status ? e.toggleClass("done").toggleClass("open") : (i.attr("checked", !1), show_alert(t.status, t.message))
    }).done(function() {})
}), $(document).on("click", ".ajax-click-request", function(t) {
    url = $(this).data("url"), hide = $(this).data("hide"), element = $(this), NProgress.start(), $.get(url, function(t) {
        response = $.parseJSON(t), "success" == response.status ? (show_alert(response.status, response.message), "undefined" != typeof hide && element.closest("." + hide).hide()) : show_alert(response.status, response.message)
    }).done(function() {
        NProgress.done()
    })
}), $(document).on("click", ".message-list-delete", function(t) {
    $(this).parent().fadeTo("slow", .01, function() {
        $(this).slideUp("fast", function() {
            $(this).remove()
        })
    })
}), $(document).on("click", ".add-row-ajax", function() {
    $('input[name="files"]').val() || $('input[name="files"]').attr("disabled", !0);
    var t = new FormData($(this).closest("form")[0]),
        e = $(this).closest("form").attr("action");
    $(this);
    return $("#dummyTR").clone().insertBefore("#dummyTR").removeClass("hidden").attr("id", "addedfield"), $("#addedfield .user_id").html($(".input-fields .user_id option:selected").text()), $("#addedfield .hours").html($(".input-fields .hours").val()), $(".input-fields .hours").val("00"), $("#addedfield .minutes").html($(".input-fields .minutes").val()), $(".input-fields .minutes").val("00"), $("#addedfield .start_time").html($(".input-fields .start_time").next("input").val()), $(".input-fields .start_time").next("input").val(""), $("#addedfield .end_time").html($(".input-fields .end_time").next("input").val()), $(".input-fields .end_time").next("input").val(""), taskname = $("#quick-add-task-name").val(), $("#quick-add-task-name").val(""), $.ajax({
        type: "POST",
        url: e,
        mimeType: "multipart/form-data",
        contentType: !1,
        cache: !1,
        processData: !1,
        data: t,
        success: function(t) {
            console.log(t), $("#addedfield .option_button").attr("href", $(".input-fields .delete_link").html() + t), $("#addedfield").attr("id", "")
        }
    }), $('input[name="files"]').attr("disabled", !1), !1
}), $(document).on("click", "#reply", function(t) {
    $("#reply").velocity({
        height: "240px"
    }, {
        queue: !1,
        complete: function() {
            $("#reply").wysihtml5({
                size: "small"
            }), $(".reply #send").fadeIn("slow")
        }
    })
}), $(".nano").nanoScroller(), $(document).on("submit", "form.quick-add-task", function() {
    $('input[name="files"]').val() || $('input[name="files"]').attr("disabled", !0);
    var t = new FormData($(this).closest("form")[0]),
        e = $(this).closest("form").attr("action"),
        i = $(this).closest("form").data("baseurl"),
        o = $(this);
    return $("#task_dummy").clone().prependTo("#task-list"), taskname = $("#quick-add-task-name").val(), $("#quick-add-task-name").val(""), prio = $(".priority-input").val(), $("ul li#task_dummy").addClass("priority" + prio), $("ul li#task_dummy p.name").html(taskname), $("ul li#task_dummy").removeClass("hidden"), $.ajax({
        type: "POST",
        url: e,
        mimeType: "multipart/form-data",
        contentType: !1,
        cache: !1,
        processData: !1,
        data: t,
        success: function(t) {
            console.log(t), $("ul li#task_dummy #dummy-href").attr("href", i + "check/" + t), $("ul li#task_dummy #dummy-href2").data("link", i + "check/" + t), $("ul li#task_dummy #dummy-href3").attr("href", i + "update/" + t), $("ul li#task_dummy p.name").data("taskid", "task-details-" + t), $("ul li#task_dummy").attr("id", "task_" + t), modalfunc();
            var e = o.closest("form").data("reload2"),
                a = o.closest("form").data("reload3");
            $.get(document.URL, function(t) {
                $("#" + e).parent("div").html($(t).find("#" + e)), $("#" + a).parent("div").html($(t).find("#" + a)), $("#" + e + " .checkbox-nolabel").labelauty({
                    label: !1
                }), $(".timer__span").each(function() {
                    timertime = $(this).data("timertime"), timerid = "#" + $(this).attr("id"), timerstate = $(this).data("timerstate"), startTimer(timerstate, timertime, timerid)
                }), $(".todo__close").click(), sorting_list(i), modalfunc()
            }), hideClosedTasks()
        }
    }), $('input[name="files"]').attr("disabled", !1), !1
}), $(document).on("click", ".ajaxform #send", function(t) {
    $('textarea[name="message"]').html($("#reply").summernote("code"));
    var e = $(this).closest("form").attr("action"),
        a = $(this);
    $('input[name="files"]').val() || $('input[name="files"]').attr("disabled", !0);
    var i = new FormData($(this).closest("form")[0]);
    if ($('input[name="files"]').attr("disabled", !1), "" === $('textarea[name="message"]').val()) {
        $(".comment-content .note-editable").css("border-top", "2px solid #D43F3A");
        var o = $(".button-loader").html().replace('<i class="icon dripicons-loading spin-it"></i> ', "");
        $(".button-loader").html(o)
    } else $.ajax({
        type: "POST",
        url: e,
        mimeType: "multipart/form-data",
        contentType: !1,
        cache: !1,
        processData: !1,
        data: i,
        success: function(t) {
            $("#message-list li.active").click().click(), $(".ajaxform #send").html('<i class="ion-ios-checkmark-outline"></i>'), $(".message-content-reply, #timeline-comment").slideUp("slow").velocity({
                opacity: 0
            }, {
                queue: !1,
                duration: "slow"
            }), $(".note-editable").html("");
            var e = a.closest("form").data("reload");
            e && $("#" + e).load(document.URL + " #" + e, function() {
                $("#" + e + " ul li:nth-child(2) .timeline-panel").addClass("highlight"), $("#" + e + " ul li:nth-child(2) .timeline-panel").delay("5000").removeClass("highlight"), summernote()
            })
        },
        error: function(t) {
            $("#message-list li.active").click().click(), $(".ajaxform #send").html('<i class="ion-ios-circle-outline"></i>'), $(".message-content-reply, #timeline-comment").slideUp("slow").velocity({
                opacity: 0
            }, {
                queue: !1,
                duration: "slow"
            }), $(".note-editable").html("");
            var e = a.closest("form").data("reload");
            e && $("#" + e).load(document.URL + " #" + e, function() {
                $("#" + e + " ul li:nth-child(2) .timeline-panel").addClass("highlight"), $("#" + e + " ul li:nth-child(2) .timeline-panel").delay("5000").removeClass("highlight"), summernote()
            })
        }
    });
    return !1
}), $(document).on("click", ".section-reload #send", function(t) {
    t.preventDefault(), NProgress.start(), $("#tasks-tab").load(document.URL + " #tasks-tab"), NProgress.done()
}), $(document).on("click", ".dynamic-reload", function(t) {
    var e = $(this).data("reload"),
        a = $(this).data("reload2");
    e && $("#" + e).load(document.URL + " #" + e, function(t) {
        easyPie()
    }), a && $("#" + a).load(document.URL + " #" + a, function(t) {
        easyPie()
    })
}), $(document).on("click", ".dynamic-form .send", function(t) {
    $(this).closest("form").validator(), t.stopPropagation(), t.preventDefault(), valid = !0;
    var a = $(this);
    if ($("input").filter("[required]:visible").each(function(t, e) {
        "" == $(e).val() && (valid = !1, $(".modal").animate({
            scrollTop: $(e).offset().top
        }, 500), $(e).parent().addClass("has-error"), a.text().replace('<i class="icon dripicons-loading spin-it"></i> ', ""))
    }), valid) {
        $("textarea.summernote-modal").summernote("code");
        var e = $(this).closest("form").attr("action"),
            s = $(this).closest("form").data("baseurl"),
            l = $(this);
        $('input[name="files"]').val() || $('input[name="files"]').attr("disabled", !0);
        var i = new FormData($(this).closest("form")[0]);
        return $('input[name="files"]').attr("disabled", !1), $.ajax({
            type: "POST",
            url: e,
            mimeType: "multipart/form-data",
            contentType: !1,
            cache: !1,
            processData: !1,
            data: i,
            success: function(t, e, a) {
                void 0 === t.error || console.log("ERRORS: " + t.error);
                var i = l.closest("form").data("reload"),
                    o = l.closest("form").data("reload2"),
                    n = l.closest("form").data("reload3");
                i && $.get(document.URL, function(t) {
                    $("#" + i).parent("div").html($(t).find("#" + i)), $("#" + o).parent("div").html($(t).find("#" + o)), $("#" + n).parent("div").html($(t).find("#" + n)), $("#gantData").html($(t).find("#gantData")), $("#" + i).velocity("transition.slideDownOut", {
                        duration: 300
                    }), $("#" + o).velocity("transition.slideDownOut", {
                        duration: 300
                    }), $("#" + i + " .checkbox-nolabel").labelauty({
                        label: !1
                    }), $("#" + o + " .checkbox-nolabel").labelauty({
                        label: !1
                    }), $("#" + i).velocity("transition.slideUpIn", {
                        duration: 300
                    }), $("#" + o).velocity("transition.slideUpIn", {
                        duration: 300
                    }), modalfunc(), keepmodal = l.data("keepmodal"), void 0 === keepmodal ? $("#mainModal").modal("hide") : (l.closest("form")[0].reset(), $("#mainModal .note-editable").html(""));
                    var e = l.text().replace('<i class="icon dripicons-loading spin-it"></i> ', "");
                    l.html(e), $(".timer__span").each(function() {
                        timertime = $(this).data("timertime"), timerid = "#" + $(this).attr("id"), timerstate = $(this).data("timerstate"), startTimer(timerstate, timertime, timerid)
                    }), $(".todo__close").click(), sorting_list(s), hideClosedTasks()
                })
            },
            error: function(t) {
                var a = l.closest("form").data("reload"),
                    i = l.closest("form").data("reload2"),
                    o = l.closest("form").data("reload3");
                a && $.get(document.URL, function(t) {
                    $("#" + a).parent("div").html($(t).find("#" + a)), $("#" + i).parent("div").html($(t).find("#" + i)), $("#" + o).parent("div").html($(t).find("#" + o)), $("#gantData").html($(t).find("#gantData")), $("#" + a).velocity("transition.slideDownOut", {
                        duration: 300
                    }), $("#" + i).velocity("transition.slideDownOut", {
                        duration: 300
                    }), $("#" + a + " .checkbox-nolabel").labelauty({
                        label: !1
                    }), $("#" + i + " .checkbox-nolabel").labelauty({
                        label: !1
                    }), $("#" + a).velocity("transition.slideUpIn", {
                        duration: 300
                    }), $("#" + i).velocity("transition.slideUpIn", {
                        duration: 300
                    }), modalfunc(), keepmodal = l.data("keepmodal"), void 0 === keepmodal ? $("#mainModal").modal("hide") : (l.closest("form")[0].reset(), $("#mainModal .note-editable").html(""));
                    var e = l.text().replace('<i class="icon dripicons-loading spin-it"></i> ', "");
                    l.html(e), $(".timer__span").each(function() {
                        timertime = $(this).data("timertime"), timerid = "#" + $(this).attr("id"), timerstate = $(this).data("timerstate"), startTimer(timerstate, timertime, timerid)
                    }), $(".todo__close").click(), sorting_list(s), hideClosedTasks()
                })
            }
        }), !1
    }
}), $(document).on("click", ".excel-export", function(t) {
    t.preventDefault();
    var e = document.getElementById("table_wrapper").outerHTML.replace(/ /g, "%20"),
        a = document.createElement("a");
    a.href = "data:application/vnd.ms-excel, " + e, a.download = "Report_" + Math.floor(9999999 * Math.random() + 1e6) + ".xls", a.click()
}), $(document).on("click", ".fc-dropdown--trigger", function(t) {
    t.preventDefault(), $(this).hasClass("fc-dropdown--active") ? ($(".fc-dropdown--trigger").removeClass("fc-dropdown--active"), $(this).next(".fc-dropdown").removeClass("fc-dropdown--open animated fadeIn")) : ($(this).addClass("fc-dropdown--active"), $(this).next(".fc-dropdown").addClass("fc-dropdown--open animated fadeIn"))
}), $(".content-area, .fc-dropdown a").click(function() {
    $(".fc-dropdown").removeClass("fc-dropdown--open animated fadeIn"), $(".side").removeClass("menu-action"), $(".sidebar-bg").removeClass("show")
}), $(".fc-dropdown").click(function(t) {
    t.stopPropagation()
}), $(document).on("click", ".note-form #send", function(t) {
    var a = this;
    $('textarea[name="note"]').html($("#textfield").summernote("code"));
    $('input[name="files"]').val() || $('input[name="files"]').attr("disabled", !0);
    var e = $(this).closest("form").attr("action"),
        i = $(this).closest("form").serialize();
    return $('input[name="files"]').attr("disabled", !1), $.ajax({
        type: "POST",
        url: e,
        data: i,
        success: function(t) {
            var e = $(a).text().replace('<i class="icon dripicons-loading spin-it"></i> ', "");
            $(a).html(e), $("#changed").velocity("transition.fadeOut")
        },
        error: function(t) {
            var e = $(a).text().replace('<i class="icon dripicons-loading spin-it"></i> ', "");
            $(a).html(e), $("#changed").velocity("transition.fadeOut")
        }
    }), !1
}), $(document).on("focus", "#_notes .note-editable", function(t) {
    $("#changed").velocity("transition.fadeIn")
}), $(document).on("click", "#_notes .addtemplate", function(t) {
    $("#changed").velocity("transition.fadeIn")
}), $(document).on("click", ".expand", function(t) {
    $(".sec").velocity("transition.fadeIn")
}), $(".to_modal").click(function(t) {
    t.preventDefault();
    var e = $(t.target).attr("href");
    0 == e.indexOf("#") ? $(e).modal("open") : $.get(e, function(t) {
        $('<div class="modal fade" >' + t + "</div>").modal()
    })
}), $(document).on("click", "table#projects td, table#clients td, table#invoices td, table#cprojects td, table#cinvoices td, table#estimates td, table#cestimates td, table#quotations td, table#messages td, table#cmessages td, table#subscriptions td, table#csubscriptions td, table#tickets td, table#ctickets td", function(t) {
    var e = $(this).parent().attr("id");
    if (e && !$(this).hasClass("noclick")) {
        var a = $(this).closest("table").attr("rel") + $(this).closest("table").attr("id");
        $(this).hasClass("option") || (window.location = a + "/view/" + e)
    }
}), $(document).on("click", "table#media td", function(t) {
    var e = $(this).parent().attr("id");
    if (e) {
        var a = $(this).closest("table").attr("rel");
        $(this).hasClass("option") || (window.location = a + "/view/" + e)
    }
}), $(document).on("click", "table#custom_quotations_requests td", function(t) {
    var e = $(this).parent().attr("id");
    if (e) {
        $(this).closest("table").attr("rel");
        $(this).hasClass("option") || (window.location = "quotations/cview/" + e)
    }
}), $(document).on("click", "table#quotation_form td", function(t) {
    var e = $(this).parent().attr("id");
    if (e) {
        $(this).closest("table").attr("rel");
        $(this).hasClass("option") || (window.location = "formbuilder/" + e)
    }
}), summernote(), $(".summernote-note").summernote({
    height: "360px",
    shortcuts: !1,
    disableDragAndDrop: !0,
    toolbar: [
        ["insert", ["link"]],
        ["style", ["style"]],
        ["style", ["bold", "italic", "underline", "clear"]],
        ["fontsize", ["fontsize"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["height", ["height"]]
    ]
});
var postForm = function() {
    $('textarea[name="note"]').html($("#textfield").summernote("code"))
};

function uploaderButtons(a) {
    $(document).on("change", a + " #uploadBtn", function(t) {
        var e = $(this).val().replace(/\\/g, "/").replace(/.*\//, "");
        $(a + " #uploadFile").val(e)
    }), $(document).on("change", a + " #uploadBtn2", function(t) {
        var e = $(this).val().replace(/\\/g, "/").replace(/.*\//, "");
        $(a + " #uploadFile2").val(e)
    })
}

function itemSelector() {
    $(".additem").click(function(t) {
        $("#item-selector").slideUp("fast"), $("#item-editor").delay(300).slideDown("fast"), $("#item-editor input").attr("required", !0), $("form").validator()
    })
}

function colorSelector() {
    $('.color-selector input[type="radio"]').click(function(t) {
        $(".color-selector").removeClass("selected"), $(this).parent().addClass("selected")
    })
}

function customInputMask() {
    $(".decimal").inputmask("decimal", {
        radixPoint: ".",
        groupSeparator: ",",
        digits: 2,
        digitsOptional: !1,
        autoGroup: !0,
        placeholder: "00.00",
        rightAlign: !1,
        removeMaskOnSubmit: !0
    })
}

function sortList() {
    var a = $("ul.sortlist"),
        t = a.children("li").get();
    t.sort(function(t, e) {
        var a = $(t).attr("class").split(" ").toString().toUpperCase(),
            i = $(e).attr("class").split(" ").toString().toUpperCase();
        return i < a ? -1 : a < i ? 1 : 0
    }), $.each(t, function(t, e) {
        a.append(e)
    })
}

function startTimer(t, e, a) {
    $(a).timer({
        seconds: e
    }), $(a).timer(t)
}

function fancyforms() {
    $(".form-control").each(function(t) {
        0 < $(this).val().length && $(this).closest(".form-group").addClass("filled")
    }), $("select.chosen-select").each(function(t) {
        null != $(this).val() && 0 < $(this).val().length && $(this).closest(".form-group").addClass("filled")
    }), $(".form-control").on("focusin", function() {
        $(this).closest(".form-group").addClass("focus")
    }), $(".chosen-select").on("chosen:showing_dropdown", function() {
        $(this).closest(".form-group").addClass("focus")
    }), $(".chosen-select").on("chosen:hiding_dropdown", function() {
        $(this).closest(".form-group").removeClass("focus")
    }), $(".form-control").on("focusout", function() {
        $(this).closest(".form-group").removeClass("focus"), 0 < $(this).val().length ? $(this).closest(".form-group").addClass("filled") : $(this).closest(".form-group").removeClass("filled")
    })
}

function sorting_list(a) {
    $(".sortable-list").sortable({
        items: "li:not(.ui-state-disabled)",
        cancel: "p.truncate",
        placeholder: "ui-state-highlight",
        forcePlaceholderSize: !0,
        forceHelperSize: !0,
        connectWith: "ul.sortable-list",
        dropOnEmpty: !0,
        receive: function(t, e) {
            taskId = e.item.context.id, taskId = taskId.replaceAll("milestonetask_", ""), milestoneId = t.target.id, milestoneId = milestoneId.replaceAll("milestonelist_", ""), href2 = a + "projects/move_task_to_milestone/" + taskId + "/" + milestoneId, $.get(href2, function(t) {
                console.log(" task added to milestone ")
            }), $("#" + t.target.id + " .notask").remove(), 0 == e.sender.context.childElementCount && ($("#" + e.sender.context.id).html('<li class="notask list-item ui-state-disabled">No tasks yet</li>'), $("#" + t.target.id + " .notask").fadeIn())
        },
        update: function(t, e) {
            formData = $(this).sortable("serialize", {
                key: "x"
            }), formData = formData.replaceAll("&", "-"), formData = formData.replaceAll("x=", ""), list = $(this).attr("id"), href = a + "projects/sortlist/" + formData + "/" + list, $.get(href, function(t) {
                console.log("sorting updated")
            })
        }
    }), $(".sortable-list").disableSelection(), $(".sortable-list2").sortable({
        items: "li.hasItems",
        cancel: "p.truncate",
        connectWith: "ul.sortable-list2",
        placeholder: "ui-state-highlight-milestone",
        forcePlaceholderSize: !0,
        forceHelperSize: !0,
        dropOnEmpty: !0,
        update: function(t, e) {
            formData3 = $(this).sortable("serialize", {
                key: "x"
            }), formData3 = formData3.replaceAll("&", "-"), formData3 = formData3.replaceAll("x=", ""), list3 = $(this).attr("id"), href3 = a + "projects/sort_milestone_list/" + formData3 + "/" + list3, $.get(href3, function(t) {
                console.log(" Milestone list sorting updated")
            })
        },
        beforeStop: function(t, e) {
            $(e.item).hasClass("hasItems") && $(e.placeholder).parent()[0] != this && $(this).sortable("cancel")
        }
    })
}

function taskviewer() {
    $(window).scroll(function() {
        216 < $(this).scrollTop() ? ($(".pin-to-top").addClass("fixed-div"), height = $(window).height(), height -= 50, $(".taskviewer-content").css("height", height)) : (height = $(window).height(), height = height - 270 + $(this).scrollTop(), $(".taskviewer-content").css("height", height), $(".pin-to-top").removeClass("fixed-div"))
    }), $(document).on("click", "#task-list li p.name", function(t) {
        taskId = $(this).data("taskid"), $(".todo-details").hide(), $("#" + taskId).show(), $(".highlight__task").removeClass("highlight__task"), $(this).parents("li").addClass("highlight__task"), itemdetails = $(this).parents("li").find(".todo-details").html(), $(".taskviewer-content").html(itemdetails), $(".taskviewer-content").show(), $(".task-container-left").removeClass("col-sm-12").addClass("col-sm-8"), tkKey = $("#tkKey").html(), baseURL = $("#baseURL").html(), projectId = $("#projectId").html(), inlineEdit(tkKey, baseURL, projectId)
    }), $(document).on("click", ".task__options__button", function(t) {
        timerId = $(this).data("timerid"), $(".task__options__timer." + timerId).toggleClass("hidden"), $(this).hasClass("task__options__button--red") ? ($("#" + timerId).timer("pause"), $("#notification_" + timerId).timer("pause")) : ($("#" + timerId).timer("resume"), $("#notification_" + timerId).timer("resume")), $("#" + timerId).toggleClass("pause"), $("#notification_" + timerId).toggleClass("pause")
    }), $(document).on("click", ".todo__close", function(t) {
        $(".taskviewer-content, .todo-details").fadeOut(), $(".task-container-left").removeClass("col-sm-8").addClass("col-sm-12"), $(".highlight__task").removeClass("highlight__task")
    }), height = $(window).height(), height -= 270, $(".taskviewer-content").css("height", height), $(".pin-to-top").removeClass("fixed-div")
}

function inlineEdit(t, e, a) {
    $(".synced-edit").on("save", function(t, e) {
        syncid = $(this).data("syncto"), $("#" + syncid + " .name").html(e.newValue), $("#milestone" + syncid + " .name").html(e.newValue)
    }), $(".synced-process-edit").on("save", function(t, e) {
        syncid = $(this).data("syncto"), $("#" + syncid).css("width", e.newValue + "%")
    }), $(".editable").editable({
        params: {
            fcs_csrf_token: t
        },
        success: function(t, e) {
            console.log("attribute saved" + t)
        },
        error: function(t, e) {
            console.log(t)
        }
    }), $(".editable-select").editable({
        params: {
            fcs_csrf_token: t
        },
        escape: !1,
        sourceCache: !1,
        source: e + "get_milestone_list/" + a
    })
}

function ganttChart(t) {
    $(function() {
        "use strict";
        $(".gantt").gantt({
            source: t,
            minScale: "years",
            maxScale: "years",
            navigate: "scroll",
            itemsPerPage: 30,
            onItemClick: function(t) {
                console.log(t.id)
            },
            onAddClick: function(t, e) {},
            onRender: function() {
                console.log("chart rendered")
            }
        })
    })
}

function blazyloader() {
    new Blazy({
        loadInvisible: !0
    })
}

function hideClosedTasks() {
    "1" == localStorage.hide_tasks && ($("li.done").addClass("hidden"), $(".toggle-closed-tasks").css("opacity", "0.6"))
}

function deleteRow() {
    $(".deleteThisRow").on("click", function(t, e) {
        $(this).parents("tr").slideUp("fast")
    })
}

function dropzoneloader(t, e) {
    Dropzone.autoDiscover = !1, Dropzone.options.dropzoneForm = {
        previewsContainer: ".mediaPreviews",
        dictDefaultMessage: e,
        maxFilesize: 9e3,
        thumbnailWidth: 200,
        thumbnailHeight: 200,
        init: function() {
            this.on("success", function(t) {
                console.log(t), $(".data-media tbody").prepend('<tr id="' + t.xhr.responseText + '" role="row" class="odd"><td class="hidden sorting_1"></td><td onclick="">' + t.name + '</td><td class="hidden-xs">' + t.name + '</td><td class="hidden-xs"></td><td class="hidden-xs"><span class="label label-info tt" title="" data-original-title="Download Counter">0</span></td><td class="option " width="10%"><button type="button" class="btn-option btn-xs" ><i class="icon dripicons-cross"></i></button><a href="/projects/media/12/update/' + t.xhr.responseText + '" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a></td></tr>')
            }), this.on("error", function(t, e) {
                alert(e)
            })
        }
    }, $("#dropzoneForm").dropzone({
        url: t
    })
}

function flatdatepicker(t, e) {
    flatpickr.localize(flatpickr.l10ns[e]), $(".datepickr-unix").flatpickr({
        dateformat: "U",
        timeFormat: timeFormat,
        enableTime: !0,
        altInput: !0,
        altInputClass: "form-control ",
        static: !0,
        altFormat: altDateTimeFormat,
        time_24hr: time24hours
    });
    $(".datepicker").hasClass("not-required");
    var i = flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        timeFormat: timeFormat,
        time_24hr: time24hours,
        altInput: !0,
        static: !0,
        altFormat: altDateFormat,
        altInputClass: "form-control ",
        onChange: function(t, e, a) {
            "-1" == $.inArray("datepicker-linked", a.element.classList) && 1 == $(".datepicker-linked").length && o.set("minDate", e)
        }
    });
    $(".datepicker-time").hasClass("not-required");
    i = flatpickr(".datepicker-time", {
        timeFormat: timeFormat,
        time_24hr: time24hours,
        altInput: !0,
        altInputClass: "form-control ",
        static: !0,
        altFormat: altDateTimeFormat,
        onChange: function(t, e, a) {
            "-1" == $.inArray("datepicker-time-linked", a.element.classList) && 1 == $(".datepicker-time-linked").length && i[1].set("minDate", e)
        }
    });
    $(".datepicker-time-unix").hasClass("not-required");
    i = flatpickr(".datepicker-time-unix", {
        dateFormat: "U",
        time_24hr: time24hours,
        altInput: !0,
        altInputClass: "form-control ",
        altFormat: altDateTimeFormat,
        onChange: function(t, e, a) {},
        onValueUpdate: function(t, e, a) {
            timediff = $(".datepicker-time-unix.end_time").val() - $(".datepicker-time-unix.start_time").val(), 0 < timediff && (timediff = timediff.secondsToHoursAndMinutes(), $(".hours").val(timediff[0]), $(".minutes").val(timediff[1]))
        }
    });
    if ($(".datepicker-linked").hasClass("not-required"));
    else;
    var o = flatpickr(".datepicker-linked", {
        dateFormat: "Y-m-d",
        timeFormat: timeFormat,
        time_24hr: time24hours,
        altInput: !0,
        altFormat: altDateFormat,
        static: !0,
        altInputClass: "form-control ",
        onChange: function(t) {}
    });
    $(".required").attr("required", "required")
}

function htmlDecode(t) {
    var e = document.createElement("div");
    return e.innerHTML = t, 0 === e.childNodes.length ? "" : e.childNodes[0].nodeValue
}
$(".summernote-big").summernote({
    height: "450px",
    shortcuts: !1,
    disableDragAndDrop: !0,
    toolbar: [
        ["insert", ["link"]],
        ["style", ["style"]],
        ["style", ["bold", "italic", "underline", "clear"]],
        ["fontsize", ["fontsize"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["height", ["height"]]
    ]
}), $(".chosen-select").chosen({
    scroll_to_highlighted: !1,
    disable_search_threshold: 4,
    width: "100%"
}), $(".notify").velocity({
    opacity: 1,
    right: "10px"
}, 800, function() {
    $(".notify").delay(3e3).fadeOut()
}), $("ul.striped li:even").addClass("listevenitem"), $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(), $(".use-tooltip").tooltip(), $(".tt").tooltip(), $(".po").popover({
    html: !0
}), $(document).on("change", ".comma-to-point", function(t) {
    var e = $(this).val().replace(",", ".");
    $(this).val(e)
}), $(document).on("click", ".po-close", function(t) {
    $(".po").popover("hide")
}), $(document).on("click", ".po-delete", function(t) {
    $(this).closest("tr").velocity("transition.slideRightOut")
}), $(".lbl").click(function() {
    $("#slider-range").slider("option", "disabled") ? $("#slider-range").slider("option", "disabled", !1) : $("#slider-range").slider("option", "disabled", !0)
}), $("body").on("click", "#toggle_class_checkboxes", function() {
    tglclass = $(this).data("toggle-class"), $(".checkboxlist ." + tglclass + " .checkbox").each(function() {
        chk = $(this).is(":checked"), $(this).prop("checked", !chk)
    })
}), $("body").on("click", "#toggle_all_checkboxes", function() {
    alltoggled = $(this).data("all-toggled"), toggleValue = "true" != $(this).data("all-toggled"), $(".checkboxlist .checkbox").each(function() {
        $(this).prop("checked", toggleValue)
    }), toggleValue ? $(this).data("all-toggled", "true") : $(this).data("all-toggled", "false")
}), $("body").on("click", ".clear-date", function() {
    input = $(this).next(), input.flatpickr().clear()
}), $("#slider-range").slider({
    range: "min",
    min: 0,
    max: 100,
    value: 1,
    slide: function(t, e) {
        $("#progress-amount").html(e.value), $("#progress").val(e.value)
    }
}), uploaderButtons(""), customInputMask(), $(document).on("change", ".switcher", function(t) {
    var e = $(this).data("switcher");
    "" == $(this).val() || "0" == $(this).val() ? ($("#" + e).attr("disabled", !0), $("#" + e).val("0")) : $("#" + e).removeAttr("disabled"), $("#" + e).trigger("chosen:updated")
}), $(document).on("change", ".getProjects", function(t) {
    var e = $(this).data("destination"),
        a = $(this).val();
    "" == a || "0" == a ? ($("#" + e + " optgroup").attr("disabled", !0), $("#" + e).val("0")) : ($("#" + e + " optgroup").attr("disabled", !0), $("#" + e).val("0"), $("#optID_" + a).removeAttr("disabled")), $("#" + e).trigger("chosen:updated")
}), $(document).on("click", ".message-reply-button", function(t) {
    $(".summernote-ajax").summernote({
        height: "200px",
        shortcuts: !1,
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["insert", []]
        ]
    }), $(".message-content-reply").slideDown("slow").velocity({
        opacity: 1
    }, {
        queue: !1,
        duration: "slow"
    })
}), $(document).on("click", ".open-comment-box", function(t) {
    $(".add-comment").slideToggle("slow").velocity({
        opacity: 1
    }, {
        queue: !1,
        duration: "slow"
    })
}), $(document).on("click", ".menu-trigger", function(t) {
    $(".side").addClass("menu-action"), $(".sidebar-bg").addClass("show")
}), $("#checkAll").click(function() {
    $("input:checkbox").not(this).prop("checked", this.checked)
}), $("#checkAll, .bulk-box").click(function() {
    $(".bulk-box:checked").length ? $("#bulk-button").addClass("btn-success") : $("#bulk-button").removeClass("btn-success")
}), $(".bulk-dropdown li").click(function() {
    NProgress.start();
    var t = $("input:checkbox:checked.bulk-box").map(function() {
        return this.value
    }).get();
    $("#list-data").val(t);
    var e = $("#bulk-form").attr("action");
    $("#bulk-form").attr("action", e + $(this).data("action")), $("#bulk-form").submit()
}), $(document).on("click", ".bulk-dropdown ul li a", function(t) {
    var e = $("#bulk-form").attr("action");
    $("#bulk-form").attr("action", e + $(this).data("action"))
}), $(document).on("click", "#fadein", function(t) {
    $(".fadein").toggleClass("slide")
}), $(document).on("click", ".sortListTrigger", function(t) {
    sortList()
}), fancyforms(), taskviewer(), $.fn.editable.defaults.mode = "inline", $(".priority-selector--group span").on("click", function(t, e) {
    valueOfSelector = $(this).data("priority"), $(".priority-selector--group span").css("z-index", "1"), $(this).css("z-index", "2"), $(".priority-input").val(valueOfSelector), $(".priority-selector--group span:nth-child(1)").velocity({
        right: "0px"
    }, {
        queue: !1,
        easing: "easeOutCubic",
        duration: 200
    }), $(".priority-selector--group span:nth-child(2)").velocity({
        right: "0px"
    }, {
        queue: !1,
        easing: "easeOutCubic",
        duration: 200
    })
}), $(".priority-selector--group").on({
    mouseenter: function() {
        $(".priority-selector--group span:nth-child(2)").velocity({
            right: "15px"
        }, {
            easing: "easeOutCubic",
            duration: 200
        }), $(".priority-selector--group span:nth-child(1)").velocity({
            right: "30px"
        }, {
            easing: "easeOutCubic",
            duration: 200
        })
    },
    mouseleave: function() {
        $(".priority-selector--group span:nth-child(1)").velocity({
            right: "0px"
        }, {
            queue: !1,
            easing: "easeOutCubic",
            duration: 200
        }), $(".priority-selector--group span:nth-child(2)").velocity({
            right: "0px"
        }, {
            queue: !1,
            easing: "easeOutCubic",
            duration: 200
        })
    }
}), $(document).ready(function() {
    "undefined" != typeof langshort && "" != langshort && moment.locale(langshort), sorting_list(baseUrl), $("form").validator(), $("#menu li a, .submenu li a").removeClass("active"), "" == actUriSubmenu && $("#sidebar li a").first().addClass("active"), "undefined" != typeof actUriSubmenu && "0" != actUriSubmenu && "" != actUriSubmenu && $(".submenu li a#" + actUriSubmenu).parent().addClass("active"), "undefined" != typeof actUri && "" != actUri && $("#menu li#" + actUri).addClass("active");
    var t = [];
    $(".data-sorting thead th").each(function() {
        $(this).hasClass("no_sort") ? t.push({
            bSortable: !1
        }) : t.push(null)
    }), $("table.data").dataTable({
        initComplete: function() {
            var t = this.api();
            t.$("td.add-to-search").click(function() {
                t.search($(this).data("tdvalue")).draw()
            })
        },
        iDisplayLength: 25,
        stateSave: !0,
        bLengthChange: !1,
        aaSorting: [
            [0, "desc"]
        ],
        oLanguage: {
            sSearch: "",
            sInfo: showingFromToLang,
            sInfoEmpty: showingFromToEmptyLang,
            sEmptyTable: noDataYetLang,
            oPaginate: {
                sNext: showingNextArrow,
                sPrevious: showingPreviousArrow
            }
        }
    }), $("table.data-media").dataTable({
        iDisplayLength: 15,
        stateSave: !0,
        bLengthChange: !1,
        bFilter: !1,
        bInfo: !1,
        aaSorting: [
            [0, "desc"]
        ],
        oLanguage: {
            sSearch: "",
            sInfo: showingFromToLang,
            sInfoEmpty: showingFromToEmptyLang,
            sEmptyTable: " ",
            oPaginate: {
                sNext: showingNextArrow,
                sPrevious: showingPreviousArrow
            }
        }
    }), $("table.data-no-search").dataTable({
        iDisplayLength: 8,
        stateSave: !0,
        bLengthChange: !1,
        bFilter: !1,
        bInfo: !1,
        aaSorting: [
            [1, "desc"]
        ],
        oLanguage: {
            sSearch: "",
            sInfo: showingFromToLang,
            sInfoEmpty: showingFromToEmptyLang,
            sEmptyTable: " ",
            oPaginate: {
                sNext: showingNextArrow,
                sPrevious: showingPreviousArrow
            }
        },
        fnDrawCallback: function(t) {
            $(this).parent().toggle(0 < t.fnRecordsDisplay()), t._iDisplayLength > t.fnRecordsDisplay() && $(t.nTableWrapper).find(".dataTables_paginate").hide()
        }
    }), $("table.data-sorting").dataTable({
        iDisplayLength: 25,
        bLengthChange: !1,
        aoColumns: t,
        aaSorting: [
            [1, "desc"]
        ],
        oLanguage: {
            sSearch: "",
            sInfo: showingFromToLang,
            sInfoEmpty: showingFromToEmptyLang,
            sEmptyTable: noDataYetLang,
            oPaginate: {
                sNext: showingNextArrow,
                sPrevious: showingPreviousArrow
            }
        }
    }), $("table.data-small").dataTable({
        iDisplayLength: 5,
        bLengthChange: !1,
        aaSorting: [
            [2, "desc"]
        ],
        oLanguage: {
            sSearch: "",
            sInfo: showingFromToLang,
            sInfoEmpty: showingFromToEmptyLang,
            sEmptyTable: noDataYetLang,
            oPaginate: {
                sNext: showingNextArrow,
                sPrevious: showingPreviousArrow
            }
        }
    }), $("table.data-reports").dataTable({
        iDisplayLength: 30,
        colReorder: !0,
        buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
        bLengthChange: !1,
        order: [
            [1, "desc"]
        ],
        columnDefs: [{
            orderable: !1,
            targets: 0
        }],
        oLanguage: {
            sSearch: "",
            sInfo: showingFromToLang,
            sInfoEmpty: showingFromToEmptyLang,
            sEmptyTable: noDataYetLang,
            oPaginate: {
                sNext: showingNextArrow,
                sPrevious: showingPreviousArrow
            }
        }
    })
}), $(".set-lead-id").on("click", function(t, e) {
    var a = $(this).data("lead-id");
    sessionStorage.setItem("lead", a)
}), Array.prototype.setMax = function(a) {
    return this.filter(function(t, e) {
        return e < a
    })
}, Array.prototype.setOffset = function(a) {
    return this.filter(function(t, e) {
        return a - 1 < e
    })
};