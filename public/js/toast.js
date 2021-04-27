const Toast = (_ => {
    let $toast = document.getElementById('app-toast'),
        $toastText = document.getElementById('app-toast-text'),
        bsToast = new bootstrap.Toast($toast);

    function modeColor(mode) {
        return mode === 'error' ? 'danger' : mode;
    }

    function show(mode, msg) {
        let color = modeColor(mode);

        $toast.classList.add('bg-' + color);
        $toastText.innerHTML = msg;

        bsToast.show();

        let removeClass = _ => {
            $toast.classList.remove('bg-' + color);
            $toast.removeEventListener('hidden.bs.toast', removeClass);
        };

        $toast.addEventListener('hidden.bs.toast', removeClass);
    }

    return {
        success: msg => show('success', msg),
        error: msg => show('error', msg),
        warning: msg => show('warning', msg),
        info: msg => show('info', msg),
        show: (mode, msg) => show(mode, msg),
    };
})();
