<div class="lobster-font border-bottom py-3">
    <div class="container d-flex align-items-center">
        <x-logo></x-logo>

        <div class="ms-auto">
            @if(auth()->guest())
                <h4
                    role="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modal--login"
                >Login</h4>
            @else
                <a
                    id="p-username"
                    class="text-decoration-none h4 text-dark"
                    tabindex="0"
                    role="button"
                    data-href="{{ route('logout') }}"
                    data-toggle="popover"
                    data-trigger="focus"
                    data-placement="bottom"
                    data-content="Click again to logout"
                >{{ \Illuminate\Support\Str::limit(auth()->user()->name, 15) }}</a>
            @endif
        </div>
    </div>
</div>

@if(auth()->guest())
    <x-modal id="modal--login">
        <x-slot name="title">Login</x-slot>

        <div class="d-flex justify-content-evenly">
            <a href="{{ route('login', ['driver' => 'facebook']) }}">
                <x-icon :name="'facebook'" :class="'text-primary'" :width="64" :height="64"></x-icon>
            </a>

            <a href="{{ route('login', ['driver' => 'google']) }}">
                <x-icon :name="'google'" :class="'text-danger'" :width="64" :height="64"></x-icon>
            </a>
        </div>
    </x-modal>
@endif

@unless(auth()->guest())
    @push('body-scripts')
        <script>
            let $username = document.getElementById('p-username');

            $username.addEventListener('shown.bs.popover', function () {
                this.href = this.dataset.href;
            });

            $username.addEventListener('hide.bs.popover', function () {
                this.href = '#';
            });
        </script>
    @endpush
@endunless

@push('styles')
    <style>
        #p-username:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
@endpush
