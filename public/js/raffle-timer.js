let $timer = document.getElementById('raffle-timer'),
    timerEnd = $timer.dataset.closesAt,
    originalTimerEnd = $timer.dataset.originalClosesAt,
    timerLeft = timerEnd - now();

let hrs, mins, secs, countdown;

if (timerExpired()) setTimer();
else startCountdown();

/**
 *  FUNCTIONS
 */

function startCountdown() {
    countdown = setInterval(tick, 1000);
}

function tick() {
    if (timerExpired()) return void (clearInterval(countdown));
    setTimer();
    timerLeft--;
}

function timerExpired() {
    return timerLeft <= 0;
}

function setTimer() {
    $timer.innerText = timerFormat();
}

function timerFormat() {
    let left = Math.abs(timerLeft);

    hrs = Math.floor(left / 3600);
    mins = Math.floor((left - (hrs * 3600)) / 60);
    secs = left - (hrs * 3600) - (mins * 60);

    let out = pad(hrs) + ':' + pad(mins) + ':' + pad(secs);

    return timerExpired() ? '-' + out : out;
}

function pad(val) {
    return val < 10 ? '0' + val : val;
}

function now() {
    return Math.floor(Date.now() / 1000);
}
