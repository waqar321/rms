@push('styles')

    <!-- <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet"> -->
    <style>
            /* waqar css added */
        /* .select2-container{
            display: block!important;
            width: 100%!important;
        } */

        .side-menu > li > a {
            color: #343a40; /* Main menu item color */
        }

        .child_menu {
            background-color: #f8f9fa; /* Background color for submenu */
        }

        .child_menu > li > a {
            color: #495057; /* Submenu item color */
            padding-left: 20px; /* Indentation for submenu items */
        }

        .child_menu > li > a:hover {
            color: #007bff; /* Hover color for submenu items */
        }
        /* .profile_img
        {
            width: 100%;
            height: 100%;
        } */
    </style>
@endpush

<div>
    <div class="col-md-3 left_col menu_fixed mCustomScrollbar _mCS_1 mCS-autoHide">
        <div class="left_col scroll-view">
                    <!-- <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ url_secure('') }}" class="site_title">   <img src="<?php echo url_secure('build/images/logo/LCS-logo1.png'); ?>" alt="..." class="profile_img" width="65%"></a>
                    </div> -->
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ url_secure('') }}" class="site_title">
                            <!-- <h1 style="font-weight: bold;color: #343a40;"> -->
                                <!-- </h1> -->

                            <img src="{{ url_secure('storage/'.$Setting->image_path) }}" alt="..."
                                style="width: 100%; height: 100%"
                                class="profile_img" >
                        </a>
                    </div>
                    <div class="clearfix"></div>
                <br/>
            <?php
            $segments = request()->segments();

            $uri_segment_1 = isset($segments[0]) ? $segments[0] : null;
            $uri_segment_2 = isset($segments[1]) ? $segments[1] : null;

            ?>

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <h3>General</h3>


                    <ul class="nav side-menu">

                        @foreach ($menus as $key => $menu)
                                <?php

                                    // echo "<pre>";
                                    // print_r($menu->permission);
                                    // echo "</pre>";
                                    // die();

                                ?>
                            @isset($menu->permission)                    <!--  if permission exists -->
                                @can($menu->permission->title ?? '')     <!--  check for permission -->

                                    <li id="{{ !empty($menu->IdNames) ? implode(' ', $menu->IdNames) : '' }}"  class="{{ !empty($menu->ClassNames) ? implode(' ', $menu->ClassNames) : '' }}">

                                        @if ($menu->subMenus->count() > 0)
                                            <a >
                                        @else
                                            <a href="{{ $menu->url ? url_secure($menu->url) : '#' }}">
                                        @endif
                                                <i class="{{ $menu->icon }}" ></i> {{ $menu->title }}
                                                @if ($menu->subMenus->count() > 0)
                                                    <span class="fa fa-chevron-down"></span>
                                                @endif
                                            </a>


                                        @if ($menu->subMenus->count() > 0)
                                            <ul class="nav child_menu">
                                                @foreach ($menu->subMenus as $subMenu)
                                                    @can($subMenu->permission->title ?? '')
                                                        <li id="{{ implode(' ', $subMenu->IdNames ?? []) }}" class="{{ implode(' ', $subMenu->ClassNames ?? []) }}">
                                                            <a href="{{ $subMenu->url ? url_secure($subMenu->url) : '#' }}" {{ $subMenu->title == 'Video Tutorials' ? 'target=_blank' : '' }}>
                                                                {{ $subMenu->title }}
                                                            </a>
                                                        </li>
                                                    @endcan
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>

                                    @endcan
                                @else
                                    <!--  open for everyone like video tutorial -->
                                    <li id="{{ !empty($menu->IdNames) ? implode(' ', $menu->IdNames) : '' }}" class="{{ !empty($menu->ClassNames) ? implode(' ', $menu->ClassNames) : '' }}">

                                        @if ($menu->subMenus->count() > 0)
                                            <a >
                                        @else
                                            <a href="{{ $menu->url ? url_secure($menu->url) : '#' }}">
                                        @endif
                                                <i class="{{ $menu->icon }}" ></i> {{ $menu->title }}
                                                @if ($menu->subMenus->count() > 0)
                                                    <span class="fa fa-chevron-down"></span>
                                                @endif
                                            </a>
                                        @if ($menu->subMenus->count() > 0)
                                            <ul class="nav child_menu">
                                                @foreach ($menu->subMenus as $subMenu)
                                                    <li id="{{ implode(' ', $subMenu->IdNames ?? []) }}" class="{{ implode(' ', $subMenu->ClassNames ?? []) }}">
                                                    <a href="{{ $subMenu->url ? url_secure($subMenu->url) : '#' }}" {{ $subMenu->title == 'Video Tutorials' ? 'target=_blank' : '' }}>
                                                        {{ $subMenu->title }}
                                                    </a>

                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endisset

                                @if($key == 1)

                                @endif
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <!-- <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v2.x.x/dist/livewire-sortable.js"></script> -->

    <!-- <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script> -->
        <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>
        <script>
        </script>

@endpush


