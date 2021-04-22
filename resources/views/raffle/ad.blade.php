<x-modal id="modal--video">
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <!-- 16:9 aspect ratio -->
    <div class="embed-responsive embed-responsive-16by9">
        <iframe
            id="iframe--video"
            class="embed-responsive-item"
            allowscriptaccess="always"
            allowfullscreen="allowfullscreen"
            allow="autoplay"
        ></iframe>
    </div>
</x-modal>

@push('body-scripts')
    <script src="{{ asset('js/ad.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ad.css') }}">
@endpush()
