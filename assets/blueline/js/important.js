function flatdatepicker(t, e) {

    $(".datepicker-time").hasClass("not-required");
    i = flatpickr(".datepicker-time", {
        locale: 'pt',
        timeFormat: timeFormat,
        time_24hr: time24hours,
        altInput: !0,
        disable: [
            function(date) {
                // return true to disable
                return (date.getDay() === 6 || date.getDay() === 0);

            }
        ],
        altInputClass: "form-control ",
        static: !0,
        altFormat: altDateTimeFormat,
        onChange: function(t, e, a) {
            "-1" == $.inArray("datepicker-time-linked", a.element.classList) && 1 == $(".datepicker-time-linked").length && i[1].set("minDate", e)
        }
    });

}