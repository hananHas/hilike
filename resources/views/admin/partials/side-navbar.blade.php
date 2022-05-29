<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src1" style="text-align: center; width:100%">
            <img style="width:3rem" src="{{ asset('logo.jpg') }}" alt="">
        </div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Analytics</li>
                <li @if(explode('/',request()->path())[0] == 'home') class="mm-active" @endif >
                    <a href="{{route('home')}}">
                        <i class="metismenu-icon pe-7s-home">
                        </i>{{ __('Dashboard') }}
                    </a>
                </li>
                @can('analytics-list')
                @php
                if(explode('/',request()->path())[0] == 'analytics'){
                    $active0 = true;
                }
                else {
                    $active0 = false;
                }
                @endphp
                <li @if($active0) class="mm-active" @endif>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-graph3"></i>
                        {{ __('Analytics') }}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('analytics.users')}}" @if(explode('/',request()->path())[0] == 'analytics_users') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Users') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('analytics.incomes')}}" @if(explode('/',request()->path())[0] == 'analytics_incomes') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Incomes') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('analytics.interactions')}}" @if(explode('/',request()->path())[0] == 'analytics_interactions') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Interactions') }}
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @php
                $user = \Auth::user();
                @endphp
                @if($user->can('filters-management') || $user->can('settings-management') || $user->can('gifts-management')
                 || $user->can('coins-management') || $user->can('notifications-create') || $user->can('app-links-edit'))
                <li class="app-sidebar__heading">App Management</li>
                @endif
                @php
                if(explode('/',request()->path())[0] == 'religions' || explode('/',request()->path())[0] == 'social_types'
                || explode('/',request()->path())[0] == 'marriage_types' || explode('/',request()->path())[0] == 'education'
                || explode('/',request()->path())[0] == 'skin_colors' || explode('/',request()->path())[0] == 'body_shapes'
                || explode('/',request()->path())[0] == 'jobs'){
                    $active = true;
                }
                else {
                    $active = false;
                }
                @endphp
                @can('filters-management')
                
                <li @if($active) class="mm-active" @endif>
                    <a href="#">
                        <i class="metismenu-icon lnr-database"></i>
                        {{ __('Filters management') }}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('religions.index')}}" @if(explode('/',request()->path())[0] == 'religions') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Religions') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('social_types.index')}}" @if(explode('/',request()->path())[0] == 'social_types') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Social Types') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('marriage_types.index')}}" @if(explode('/',request()->path())[0] == 'marriage_types') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Marriage Types') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('education.index')}}" @if(explode('/',request()->path())[0] == 'education') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Education') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('skin_colors.index')}}" @if(explode('/',request()->path())[0] == 'skin_colors') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Skin Colors') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('body_shapes.index')}}" @if(explode('/',request()->path())[0] == 'body_shapes') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Body Shapes') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('jobs.index')}}" @if(explode('/',request()->path())[0] == 'jobs') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Jobs') }}
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @php
                    if(explode('/',request()->path())[0] == 'onboarding' || explode('/',request()->path())[0] == 'about_us'
                    || explode('/',request()->path())[0] == 'usage_policy' || explode('/',request()->path())[0] == 'privacy_policy'){
                        $active1 = true;
                    }
                    else {
                        $active1 = false;
                    }
                @endphp
                @can('settings-management')
                <li @if($active1) class="mm-active" @endif>
                    <a href="#">
                        <i class="metismenu-icon lnr-cog"></i>
                        {{ __('Settings') }}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('onboarding.index')}}" @if(explode('/',request()->path())[0] == 'onboarding') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Onboarding screens') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('settings.about_us')}}" @if(explode('/',request()->path())[0] == 'about_us') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('About us') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('settings.usage_policy')}}" @if(explode('/',request()->path())[0] == 'usage_policy') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Usage policy') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('settings.privacy_policy')}}" @if(explode('/',request()->path())[0] == 'privacy_policy') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Privacy policy') }}
                            </a>
                        </li>
                       
                    </ul>
                </li>
                @endcan
                @php
                    if(explode('/',request()->path())[0] == 'gifts' || explode('/',request()->path())[0] == 'gifts_categories'){
                        $active3 = true;
                    }
                    else {
                        $active3 = false;
                    }
                @endphp
                @can('gifts-management')
                <li @if($active3) class="mm-active" @endif>
                    <a href="#">
                        <i class="metismenu-icon lnr-gift"></i>
                        {{ __('Gifts') }}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('gifts_categories.index')}}" @if(explode('/',request()->path())[0] == 'gifts_categories') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Gifts Categories') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('gifts.index')}}" @if(explode('/',request()->path())[0] == 'gifts') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Gifts') }}
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('coins-management')
                <li @if(explode('/',request()->path())[0] == 'coins') class="mm-active" @endif >
                    <a href="{{route('coins.index')}}">
                        <i class="metismenu-icon pe-7s-cash">
                        </i>{{ __('Coins') }}
                    </a>
                </li>
                @endcan
                @can('notifications-create')

                <li @if(explode('/',request()->path())[0] == 'notifications') class="mm-active" @endif >
                    <a href="{{route('notifications.index')}}">
                        <i class="metismenu-icon lnr-alarm">
                        </i>{{ __('Notifications') }}
                    </a>
                </li>
                @endcan
                @can('app-links-edit')

                <li @if(explode('/',request()->path())[0] == 'app_links') class="mm-active" @endif >
                    <a href="{{route('app_links.index')}}">
                        <i class="metismenu-icon lnr-link">
                        </i>{{ __('App Links') }}
                    </a>
                </li>
                @endcan

                @if($user->can('users-management') || $user->can('report-list') || $user->can('chats-monitoring')
                 || $user->can('preview-images') || $user->can('preview-texts'))
                <li class="app-sidebar__heading">Users Data</li>
                @endif
                @can('users-management')

                <li @if(explode('/',request()->path())[0] == 'users') class="mm-active" @endif >
                    <a href="{{route('users.index')}}">
                        <i class="metismenu-icon lnr-users">
                        </i>{{ __('Users management') }}
                    </a>
                </li>
                @endcan
                
                @can('report-list')
                <li @if(explode('/',request()->path())[0] == 'reports') class="mm-active" @endif >
                    <a href="{{route('reports.index')}}">
                        <i class="metismenu-icon lnr-file-empty">
                        </i>{{ __('Reports') }}
                    </a>
                </li>
                @endcan
                @can('chats-monitoring')

                <li @if(explode('/',request()->path())[0] == 'chats') class="mm-active" @endif >
                    <a href="{{route('chats.index')}}">
                        <i class="metismenu-icon lnr-bubble">
                        </i>{{ __('Chats') }}
                    </a>
                </li>
                @endcan
                

                @php
                if(explode('/',request()->path())[0] == 'images' || explode('/',request()->path())[0] == 'images_other'){
                    $active2 = true;
                }
                else {
                    $active2 = false;
                }
                $profile = \App\Models\UserDetail::where('profile_image','!=',null)->where('confirmed_image',null)->count();
                $other = \App\Models\UserImage::where('confirmed',null)->count();
                @endphp
                @can('preview-images')

                <li @if($active2) class="mm-active" @endif>
                    <a href="#">
                        <i class="metismenu-icon lnr-picture"></i>
                        {{ __('Preview images') }}
                        <span class="badge badge-pill badge-danger ml-0 mr-2" style="padding: 5px 7px;">{{$profile + $other}}</span>

                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('images.review_profile')}}" @if(explode('/',request()->path())[0] == 'images') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Profile images') }}
                                <span class="badge badge-pill badge-danger ml-0 mr-2" style="padding: 5px 7px;">{{$profile}}</span>

                            </a>
                        </li>
                        <li>
                            <a href="{{route('images.review_other')}}" @if(explode('/',request()->path())[0] == 'images_other') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Other images') }}
                                <span class="badge badge-pill badge-danger ml-0 mr-2" style="padding: 5px 7px;">{{$other}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @php
                if(explode('/',request()->path())[0] == 'nicknames' || explode('/',request()->path())[0] == 'looking_for' || explode('/',request()->path())[0] == 'about_user'){
                    $active8 = true;
                }
                else {
                    $active8 = false;
                }
                @endphp
                @can('preview-texts')

                <li @if($active8) class="mm-active" @endif>
                    <a href="#">
                        <i class="metismenu-icon lnr-text-align-left"></i>
                        {{ __('Preview texts') }}

                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('texts.nicknames')}}" @if(explode('/',request()->path())[0] == 'nicknames') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Nicknames') }}

                            </a>
                        </li>
                        <li>
                            <a href="{{route('texts.looking_for')}}" @if(explode('/',request()->path())[0] == 'looking_for') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('Looking for') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('texts.about_user')}}" @if(explode('/',request()->path())[0] == 'about_user') class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>{{ __('About user') }}
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @if($user->can('chat-support') || $user->can('contact-messages') )
                <li class="app-sidebar__heading">Support</li>
                @endif
                @can('chat-support')

                <li @if(explode('/',request()->path())[0] == 'chats_list') class="mm-active" @endif >
                    <a href="{{route('chats.view')}}">
                        <i class="metismenu-icon lnr-bubble">
                        </i>{{ __('Support Chats') }}
                    </a>
                </li>
                @endcan
                @can('contact-messages')

                <li @if(explode('/',request()->path())[0] == 'contact') class="mm-active" @endif >
                    <a href="{{route('contact.index')}}">
                        <i class="metismenu-icon pe-7s-mail">
                        </i>{{ __('Contact_messages') }}
                    </a>
                </li>
                @endcan
                @if($user->can('plans-management') || $user->can('subscriptions-list') )
                <li class="app-sidebar__heading">Subscriptions</li>
                @endif
                @can('plans-management')

                <li @if(explode('/',request()->path())[0] == 'plans') class="mm-active" @endif >
                    <a href="{{route('plans.index')}}">
                        <i class="metismenu-icon lnr-text-align-left">
                        </i>{{ __('Plans') }}
                    </a>
                </li>
                @endcan

                @can('subscriptions-list')

                <li @if(explode('/',request()->path())[0] == 'subscriptions') class="mm-active" @endif >
                    <a href="{{route('subscriptions.index')}}">
                        <i class="metismenu-icon pe-7s-credit">
                        </i>{{ __('Subscriptions') }}
                    </a>
                </li>
                @endcan
                @if($user->can('roles-management') || $user->can('admins-management') )
                <li class="app-sidebar__heading">Roles and Permissions</li>
                @endif
                @can('roles-management')

                <li @if(explode('/',request()->path())[0] == 'roles') class="mm-active" @endif >
                    <a href="{{route('roles.index')}}">
                        <i class="metismenu-icon lnr-text-align-left">
                        </i>{{ __('Roles') }}
                    </a>
                </li>
                @endcan
                @can('admins-management')

                <li @if(explode('/',request()->path())[0] == 'admins') class="mm-active" @endif >
                    <a href="{{route('admins.index')}}">
                        <i class="metismenu-icon lnr-users">
                        </i>{{ __('Administrators') }}
                    </a>
                </li>

                @endcan

            </ul>
        </div>
    </div>
</div>