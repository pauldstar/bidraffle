'use strict';

/**
 * @param timer Timer object
 * @constructor
 */
function Raffle(timer) {
    this.timer = timer;
}

Raffle.prototype.run = function () {
    this.timer.start();
};
