'use strict';

/**
 * @param $display - the DOM element that displays time
 * @param end - the timer's scheduled end time
 * @param extendedEnd - the timer's extended end time
 * @constructor
 */
function Timer($display, end, extendedEnd) {
    this.$display = $display;
    this.end = end;
    this.extendedEnd = extendedEnd;

    this.duration = extendedEnd - this.now();
    if (this.expired()) this.duration = end - extendedEnd;
}

Timer.prototype.start = function () {
    let countdown = setInterval(_ => {
        this.duration--;

        if (this.expired()) {
            this.$display.classList.replace('text-success', 'text-danger');
            clearInterval(countdown);
        }

        this.update();
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
