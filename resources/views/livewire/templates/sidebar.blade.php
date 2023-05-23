<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a class="d-flex flex-row align-items-center"
            {{ isset($header['href']) && $header['href'] != null ? 'href=' . $header['href'] : '' }}>
            @if (isset($header['icon']) && $header['icon'] != null)
                <i class="{{ $iconIndex . ' ' . $iconIndex . '-' . $header['icon'] }} text-light"
                    style="font-size: 1.9rem"></i>
            @endif
            @if (isset($header['title']) && $header['title'])
                <h1 class="ms-3 mb-0 text-light">{{ $header['title'] }}</h1>
            @elseif (isset($header['logo']) && $header['logo'])
                <img alt="Logo" src="{{ asset($header['logo']) }}" class="h-25px app-sidebar-logo-default">
                @if (isset($header['small-logo']) && $header['small-logo'])
                    <img alt="Logo" src="{{ asset($header['small-logo']) }}"
                        class="h-20px app-sidebar-logo-minimize">
                @endif
            @endif
        </a>

        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor"></path>
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor"></path>
                </svg>
            </span>
        </div>
    </div>

    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true"
            style="height: 566px;">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expandfalse">
                @foreach ($items as $key => $item)
                    @if (!isset($item['show']) or $item['show'])
                        <div class="menu-item {{ $item['infos']['menu_item_class'] }}"
                            id="app-sidebar-menu-{{ $key }}">
                            <{{ $item['infos']['tag'] }}
                                {{ $item['infos']['tag'] == 'a' ? 'href=' . $item['infos']['href'] : '' }}
                                class="menu-link {{ $key == $options['old'] ? $item['infos']['active'] : '' }}"
                                id="app-sidebar-menu-link-{{ $key }}"
                                wire:click="action_sub({{ $key }})">
                                <div class="menu-icon">
                                    @if (isset($item['icon']) && $item['icon'] != null)
                                        <i class="{{ $iconIndex . ' ' . $iconIndex . '-' . $item['icon'] }}"></i>
                                    @elseif (isset($item['svg-icon']) && $item['svg-icon'] != null)
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                                viewBox="0 0 24 25" fill="none">
                                                {!! $item['svg-icon'] !!}
                                            </svg>
                                        </span>
                                    @endif
                                </div>

                                <span class="menu-title">{{ $item['title'] }}</span>

                                @if ($item['infos']['children_exist'])
                                    <span class="menu-arrow"></span>
                                @endif
                                </{{ $item['infos']['tag'] }}>

                                @if ($item['infos']['children_exist'])
                                    <div class="menu-sub menu-sub-accordion {{ $key == $options['old'] ? 'show' : '' }}"
                                        {!! $key == $options['old'] ? '' : 'style="display: none; overflow: hidden;"' !!}>
                                        @foreach ($item['children'] as $child)
                                            @if (!isset($child['show']) or $child['show'])
                                                <div class="menu-item">
                                                    <a class="menu-link {{ $child['infos']['is_current_url'] ? 'active' : '' }}"
                                                        href="{{ $child['infos']['href'] }}">
                                                        @if (isset($child['icon']) && $child['icon'] != null)
                                                            <div class="menu-icon">
                                                                <i
                                                                    class="{{ $iconIndex . ' ' . $iconIndex . '-' . $child['icon'] }}"></i>
                                                            </div>
                                                        @elseif (isset($child['svg-icon']) && $child['svg-icon'] != null)
                                                            <div class="menu-icon">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="25"
                                                                        viewBox="0 0 24 25" fill="none">
                                                                        {!! $child['svg-icon'] !!}
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        @else
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                        @endif

                                                        <span class="menu-title">{{ $child['title'] }}</span>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    @if (gettype($footer) == 'array' && count($footer) > 1)
        <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
            <a {{ isset($footer['href']) && $footer['href'] != null ? 'href=' . $footer['href'] : '' }}
                class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
                title="200+ in-house components and 3rd-party plugins">
                <span
                    class="btn-label">{{ isset($footer['title']) && $footer['title'] != null ? $footer['title'] : '' }}
                </span>
                @if (isset($footer['icon']) && $footer['icon'] != null)
                    <i class="{{ $iconIndex . ' ' . $iconIndex . '-' . $footer['icon'] }}"></i>
                @elseif (isset($footer['svg-icon']) && $footer['svg-icon'] != null)
                    <span class="svg-icon btn-icon svg-icon-2 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            {!! $footer['svg-icon'] !!}
                        </svg>
                    </span>
                @endif
            </a>
        </div>
    @endif
</div>
