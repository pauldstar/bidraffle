const Toast = (_ => {
    let $toast = document.getElementById('app-toast'),
        $toastText = document.getElementById('app-toast-text'),
        bsToast = new bootstrap.Toast($toast);

    function show(msg, mode) {
        $toast.classList.add('bg-' + mode);
        $toastText.innerHTML = msg;

        bsToast.show();

        let removeClass = _ => {
            $toast.classList.remove('bg-' + mode);
            $toast.removeEventListener('hidden.bs.toast', removeClass);
        };

        $toast.addEventListener('hidden.bs.toast', removeClass);
    }

    return {
        success: msg => show(msg, 'success'),
        error: msg => show(msg, 'danger'),
        warning: msg => show(msg, 'warning'),
        info: msg => show(msg, 'info')
    };
})();
