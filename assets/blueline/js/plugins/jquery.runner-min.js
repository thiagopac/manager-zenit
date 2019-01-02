$(document).ready(function () {
    var timer = {
            showTime: function (cDisplay, timestamp) {
            	timestamp = parseInt(timestamp);
                var now = new Date(),
					time = new Date(now - Math.floor(timestamp * 1000));
                cDisplay.html(time.getUTCHours() + ' hours ' + time.getUTCMinutes() + ' mins ' + time.getUTCSeconds() + ' secs');
                setTimeout(function () {timer.showTime(cDisplay, timestamp);}, 1000);
            }
        };
        console.log($('.timer').html());
    timer.showTime($('.timer'), $('.timer').html());
});