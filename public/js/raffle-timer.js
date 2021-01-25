let $timer = document.getElementById('raffle-timer'),
    timerEnd = $timer.dataset.closesAt,
    originalTimerEnd = $timer.dataset.originalClosesAt,
    timerLeft = timerEnd - now();

let hrs, mins, secs, countdown;

startCountdown();

/**
 *  FUNCTIONS
 */

function tick() {
    if (timerLeft <= 0) return void(clearInterval(countdown));
    $timer.innerText = timerFormat();
    timerLeft--;
}

function startCountdown() {
    countdown = setInterval(tick, 1000);
}

function updateTimer(end) {
    timerEnd = end;
    timerLeft = timerEnd - now();
}

function timerFormat() {
    hrs = Math.floor(timerLeft / 3600);
    mins = Math.floor((timerLeft - (hrs * 3600)) / 60);
    secs = timerLeft - (hrs * 3600) - (mins * 60);

    hrs = padZeros(hrs);
    mins = padZeros(mins);
    secs = padZeros(secs);

    return hrs + ':' + mins + ':' + secs;
}

function padZeros(val) {
    return val < 10 ? '0' + val : val;
}

function now() {
    return Math.floor(Date.now() / 1000);
}
