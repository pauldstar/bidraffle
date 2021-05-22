'use strict';

function timer() {
    return {
        timer: '--:--:--',
        duration: 0,
        scheduledEnd: '',
        actualEnd: '',

        init() {
            this.scheduledEnd = this.$refs.timer.dataset.originalClosesAt;
            this.actualEnd = this.$refs.timer.dataset.closesAt;
            this.getDuration();
            this.start();
        },

        get endZone() {
            return this.scheduledEnd < this.actualEnd;
        },

        get expired() {
            return this.duration <= 0;
        },

        get timerClass() {
            return {
                'text-danger': this.expired,
                'text-warning': this.endZone,
                'text-success': !(this.expired || this.endZone)
            };
        },

        getDuration() {
            let now = Math.floor(Date.now() / 1000);
            this.duration = this.actualEnd - now;
        },

        start() {
            let countdown = setInterval(_ => {
                this.update();

                if (this.expired) clearInterval(countdown);
                else this.duration--;
            }, 1000);
        },

        update() {
            let abs = Math.abs(this.duration),
                hrs = Math.floor(abs / 3600),
                mins = Math.floor((abs - (hrs * 3600)) / 60),
                secs = abs - (hrs * 3600) - (mins * 60),
                out = this.pad(hrs) + ':' + this.pad(mins) + ':' + this.pad(secs);

            this.timer = this.expired ? '-' + out : out;
        },

        pad(val) {
            return val < 10 ? '0' + val : val;
        }
    }
}
