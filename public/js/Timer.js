'use strict';

/**
 * @param $display - the DOM element that displays time
 * @param scheduledEnd - the timer's initially scheduled end time in seconds
 * @param actualEnd - the timer's actual/extended end time in seconds
 * @constructor
 */
function Timer($display, scheduledEnd, actualEnd) {
    this.$display = $display;
    this.end = scheduledEnd;
    this.duration = actualEnd - this.now();

    if (this.expired()) this.duration = scheduledEnd - actualEnd;
}

Timer.prototype.start = function () {
    let countdown = setInterval(_ => {
        this.update();

        if (this.expired()) {
            this.$display.classList.replace('text-success', 'text-danger');
            clearInterval(countdown);
        } else this.duration--;
    }, 1000);
}

Timer.prototype.update = function () {
    this.$display.innerText = this.format();
}

Timer.prototype.format = function () {
    let abs = Math.abs(this.duration),
        hrs = Math.floor(abs / 3600),
        mins = Math.floor((abs - (hrs * 3600)) / 60),
        secs = abs - (hrs * 3600) - (mins * 60),
        out = this.pad(hrs) + ':' + this.pad(mins) + ':' + this.pad(secs);

    return this.expired() ? '-' + out : out;
}

Timer.prototype.expired = function () {
    return this.duration <= 0;
}

Timer.prototype.now = function () {
    return Math.floor(Date.now() / 1000);
}

Timer.prototype.pad = function (val) {
    return val < 10 ? '0' + val : val;
}
