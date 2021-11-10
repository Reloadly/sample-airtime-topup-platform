<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <div class="brand-logo"></div>
                    @if((@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true) && (@OTIFSolutions\Laravel\Settings\Models\Setting::get('full_logo')))
                        <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('full_logo') }}" class="brand-text mb-0" width="120px">
                    @else
                        <img src="{{ asset('/assets/svgs/logo_text.svg') }}" class="brand-text mb-0" width="120px">
                    @endif
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @foreach(Auth::user()['user_role']->menu_items()->orderBy('order_number', 'asc')->get() as $menuItem)
                @if (Auth::user()->hasPermissionMenuItem($menuItem['id']))
                    @if ($menuItem['show_on_sidebar'])
                        @if (count($menuItem['children']) === 0)
                            @if($menuItem['parent_id'] === 0)
                                <li class="nav-item {{ Request::is(strtolower(str_replace(' ','_',$menuItem['name']))) || Request::is(strtolower(str_replace(' ','_',$menuItem['name'])).'/*')?'active':'' }}">
                                    <a href="{{ url($menuItem['route']) }}">
                                        <i class="{{ $menuItem['icon'] }}"></i>
                                        <span class="menu-title" data-i18n="{{ $menuItem['name'] }}">{{ $menuItem['name'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item has-sub {{ Request::is(strtolower(str_replace(' ','_',str_replace('/','',$menuItem['route']))).'/*')?'open':'' }}"><a href="{{ $menuItem['route'] }}"><i class="{{ $menuItem['icon'] }}"></i><span class="menu-title" data-i18n="{{ $menuItem['name'] }}">{{ $menuItem['name'] }}</span></a>
                                <ul class="menu-content">
                                    @foreach($menuItem->children()->orderBy('order_number','asc')->get() as $child)
                                        @if (Auth::user()->hasPermissionMenuItem($child['id']))
                                        <li class="nav-item {{ Request::is(strtolower(str_replace(' ','_',str_replace('/','',$menuItem['route']).'/'.$child['name'])))?'active':'' }}"><a href="{{ url($child['route']) }}"><i class="{{ $child['icon'] }}"></i><span class="menu-item" data-i18n="{{ $child['name'] }}">{{ $child['name'] }}</span></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                @endif
            @endforeach
        </ul>
    </div>
</div>
