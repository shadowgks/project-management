<!DOCTYPE html>
{{--
Product Name: {{ theme()->getOption('product', 'description') }}
Author: KeenThemes
Purchase: {{ theme()->getOption('product', 'purchase') }}
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: {{ theme()->getOption('product', 'license') }}
--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"{!! theme()->printHtmlAttributes('html') !!}
    {{ theme()->printHtmlClasses('html') }}>
{{-- begin::Head --}}

<head>
    @livewireStyles
    <meta charset="utf-8" />
    {{-- <title>{{ ucfirst(theme()->getOption('meta', 'title')) }} | Keenthemes</title> --}}
    <title>@yield('title')</title>
    <meta name="description" content="{{ ucfirst(theme()->getOption('meta', 'description')) }}" />
    <meta name="keywords" content="{{ theme()->getOption('meta', 'keywords') }}" />
    <link rel="canonical" href="{{ ucfirst(theme()->getOption('meta', 'canonical')) }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset(theme()->getDemo() . '/' . theme()->getOption('assets', 'favicon')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- begin::Fonts --}}
    {{ theme()->includeFonts() }}
    {{-- end::Fonts --}}

    @if (theme()->hasOption('page', 'assets/vendors/css'))
        {{-- begin::Page Vendor Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/vendors/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Vendor Stylesheets --}}
    @endif

    @if (theme()->hasOption('page', 'assets/custom/css'))
        {{-- begin::Page Custom Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/custom/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Custom Stylesheets --}}
    @endif

    @if (theme()->hasOption('assets', 'css'))
        {{-- begin::Global Stylesheets Bundle(used by all pages) --}}
        @foreach (array_unique(theme()->getOption('assets', 'css')) as $file)
            @if (strpos($file, 'plugins') !== false)
                {!! preloadCss(assetCustom($file)) !!}
            @else
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css" />
            @endif
        @endforeach
        {{-- end::Global Stylesheets Bundle --}}
    @endif

    @if (theme()->getViewMode() === 'preview')
        {{ theme()->getView('partials/trackers/_ga-general') }}
        {{ theme()->getView('partials/trackers/_ga-tag-manager-for-head') }}
    @endif

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css-files/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css-files/style.css') }}">
    @yield('styles')
</head>
{{-- end::Head --}}

{{-- begin::Body --}}

<body {!! theme()->printHtmlAttributes('body') !!} {!! theme()->printHtmlClasses('body') !!} {!! theme()->printCssVariables('body') !!} data-kt-name="metronic">

    <!--begin::Theme mode setup on page load-->
    <script>
        if (document.documentElement) {
            var name = document.body.getAttribute("data-kt-name");
            var themeMode = localStorage.getItem("kt_" + name + "_theme_mode_value");
            var enableSystemMode = true;

            if (themeMode) {
                if (themeMode === "dark") {
                    document.documentElement.setAttribute("data-theme", "dark");
                } else if (themeMode === "light") {
                    document.documentElement.setAttribute("data-theme", "light");
                } else if (enableSystemMode === true || themeMode === "system") {
                    document.documentElement.setAttribute("data-theme", window.matchMedia('(prefers-color-scheme: dark)') ?
                        "dark" : "light");
                }
            } else {
                document.documentElement.setAttribute("data-theme", "light");
            }
        }
    </script>
    <!--end::Theme mode setup on page load-->

    @if (theme()->getOption('layout', 'loader/display') === true)
        {{ theme()->getView('layout/_loader') }}
    @endif

    @yield('content')

    {{-- begin::Javascript --}}
    @if (theme()->hasOption('assets', 'js'))
        {{-- begin::Global Javascript Bundle(used by all pages) --}}
        @foreach (array_unique(theme()->getOption('assets', 'js')) as $file)
            <script src="{{ asset(theme()->getDemo() . '/' . $file) }}"></script>
        @endforeach
        {{-- end::Global Javascript Bundle --}}
    @endif

    @if (theme()->hasOption('page', 'assets/vendors/js'))
        {{-- begin::Page Vendors Javascript(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/vendors/js')) as $file)
            <script src="{{ asset(theme()->getDemo() . '/' . $file) }}"></script>
        @endforeach
        {{-- end::Page Vendors Javascript --}}
    @endif

    @if (theme()->hasOption('page', 'assets/custom/js'))
        {{-- begin::Page Custom Javascript(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/custom/js')) as $file)
            <script src="{{ asset(theme()->getDemo() . '/' . $file) }}"></script>
        @endforeach
        {{-- end::Page Custom Javascript --}}
    @endif
    {{-- end::Javascript --}}

    @if (theme()->getViewMode() === 'preview')
        {{ theme()->getView('partials/trackers/_ga-tag-manager-for-body') }}
    @endif


    {{-- custom call --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
    <script src="{{ asset('js-files/splide.min.js') }}"></script>
    <script src="{{ asset('js-files/apexcharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js-files/swappable.js') }}"></script>
    <script src="{{ asset('js/create.js') }}"></script>
    <script src="{{ asset('js/widget-4.js') }}"></script>
    <script src="{{ asset('js-files/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- app scripts --}}
    <script>
        // NOTE - Global Variables
        var _urls = {
                notification: "{{ route('notifications.get_unread') }}",
                setRead: "{{ route('notifications.set_read') }}",
                changeLang: "{{ route('settings.change_lang') }}",
                getMessages: "{{ route('chat.get') }}",
                saveMessage: "{{ route('chat.save') }}",
                getMessagesView: "{{ route('chat.get-view') }}",
            },
            env = {
                MIX_PUSHER_APP_KEY: "{{ env('MIX_PUSHER_APP_KEY') }}",
                MIX_PUSHER_APP_CLUSTER: "{{ env('MIX_PUSHER_APP_CLUSTER') }}",
            },
            base_data = {
                id: null,
                app_module_id: null,
                chat_conversation_id: null,
                datatables: {},
                initialized: false,
            };
    </script>

    <script type="module">
        // NOTE - Imports
        import Echo from "{{ asset('js-files/echo.js') }}";
        import {
            Pusher
        } from "{{ asset('js-files/pusher.js') }}";

        // NOTE - JS Inits
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: "pusher",
            key: env.MIX_PUSHER_APP_KEY,
            cluster: env.MIX_PUSHER_APP_CLUSTER,
            disableStats: true,
            encrypted: true,
        });

        window.Echo.channel("messanger")
            .listen("PodcastProcessed", (data) => {
                console.log(data);
            });

        window.Echo.channel("message-channel")
            .listen(".MessageEvent", (dt) => {
                if (dt.data.type != undefined) {
                    if (dt.data.type == "{{ \App\Models\ChatConversation::PRIVATE }}" && base_data.chat_conversation_id == dt.data.chat_conversation_id) {
                        liveCall('getDataAfterSave', dt.data.chat_conversation_id);
                    } else if (dt.data.type == "{{ \App\Models\ChatConversation::GROUP }}" && base_data.chat_conversation_id == dt.data.chat_conversation_id) {
                        //
                    }
                } else {
                    getMessages();
                }
            });

        window.Echo.channel("test_event")
            .listen(".TestsEvent", (data) => {
                console.log(data);
            });

        // Event pushers
    </script>
    <script src="{{ asset('js-files/inits.js') }}"></script>
    <script src="{{ asset('js-files/helpers.js') }}"></script>
    <script src="{{ asset('js-files/events.js') }}"></script>
    <script src="{{ asset('js-files/general.js') }}"></script>
    @yield('scripts')
    @yield('table-script')

    {{-- @livewireScripts --}}
</body>
{{-- end::Body --}}

</html>
