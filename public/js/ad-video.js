let $videoModal = document.getElementById('modal--video'),
    videoBsModal = new bootstrap.Modal($videoModal),
    videoIframe = document.getElementById('iframe--video');

Livewire.on('play-video', url => {
    videoBsModal.show();
    videoIframe.setAttribute('src', url);
});

$videoModal.addEventListener('hidden.bs.modal', _ => {
    videoIframe.setAttribute('src', '');
    Livewire.emit('video-stopped');
});

Livewire.on('no-payment', _ => {
    Toast.error('No Payment.<br>Watch the video longer than 1 minute.');
});

Livewire.on('bid-placed', amount => {
    Toast.success('Paid ' + amount + ' <span class="aether-font">9p</span>');
});
