<nav class="header-panel-btm">
    <div class="row">
        <div class="hewader-panel-main">
            <div
                    class="header-logo container d-flex   justify-content-between   align-items-start align-items-lg-center"
            >
                <div class="header-menu container d-flex px-0">
                    <a href="{{route('site.index')}}" class="navigation-header">
                        <picture>
                            <x-curator-glider
                                    :media="app(\App\Settings\Site::class)->translate('logo')"
                            />
                        </picture>
                    </a>
                    <nav id="cssmenu" class="head_btm_menu">
                        <ul>
                            @foreach($menu->links as $link)
                                <li class="@if($link->children()->count()) has-sub @endif">
                                    <a class="{{\App\Helpers\Utilities::getActiveLink($link->link)}}" href="{{$link->link}}">{{$link->title}}</a>
                                    @if ($link->children()->count())
                                        <ul>
                                            @foreach($link->children as $child)
                                                <li @if($child->children()->count()) has-sub @endif>
                                                    <a class="{{\App\Helpers\Utilities::getActiveLink($child->link)}}" href="{{$child->link}}">{{$child->title}}</a>
                                                    @if ($child->children()->count())
                                                        <ul>
                                                            @foreach($child->children as $grandson)
                                                                <li>
                                                                    <a class="{{\App\Helpers\Utilities::getActiveLink($grandson->link)}}" href="{{$grandson->link}}">{{$grandson->title}}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="nav-btns-box">
                    @foreach($menu->buttons as $button)
                        @if (!isset($button['status']) || !$button['status'])
                            <a href="#" class="secondary-btn" disabled="disabled">{{$button['title'][app()->getLocale()]}}</a>
                        @else
                            @if (isset($button['login']) && $button['login'])
                                <a href="@if(auth()->guard('profile')->check()){{route('profile.view')}}@else{{$button['link'][app()->getLocale()]}}@endif" class="main-btn">
                                    <svg
                                            width="22"
                                            height="22"
                                            viewBox="0 0 22 22"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g clip-path="url(#clip0_254_7910)">
                                            <path
                                                    d="M18.7782 14.2218C17.5801 13.0237 16.1541 12.1368 14.5982 11.5999C16.2646 10.4522 17.3594 8.53136 17.3594 6.35938C17.3594 2.85282 14.5066 0 11 0C7.49345 0 4.64062 2.85282 4.64062 6.35938C4.64062 8.53136 5.73543 10.4522 7.40188 11.5999C5.84598 12.1368 4.41994 13.0237 3.22184 14.2218C1.14421 16.2995 0 19.0618 0 22H1.71875C1.71875 16.8823 5.88229 12.7188 11 12.7188C16.1177 12.7188 20.2812 16.8823 20.2812 22H22C22 19.0618 20.8558 16.2995 18.7782 14.2218ZM11 11C8.44117 11 6.35938 8.91825 6.35938 6.35938C6.35938 3.8005 8.44117 1.71875 11 1.71875C13.5588 1.71875 15.6406 3.8005 15.6406 6.35938C15.6406 8.91825 13.5588 11 11 11Z"
                                                    fill="black"
                                            />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_254_7910">
                                                <rect width="22" height="22" fill="black" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    @if(auth()->guard('profile')->check())
                                        <span>@lang('site.Profile')</span>
                                    @else
                                        <span> {{$button['title'][app()->getLocale()]}} </span>
                                    @endif
                                </a>
                            @else
                                <a href="{{$button['link'][app()->getLocale()]}}" class="main-btn">
                                    <svg
                                            width="22"
                                            height="22"
                                            viewBox="0 0 22 22"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g clip-path="url(#clip0_254_7910)">
                                            <path
                                                    d="M18.7782 14.2218C17.5801 13.0237 16.1541 12.1368 14.5982 11.5999C16.2646 10.4522 17.3594 8.53136 17.3594 6.35938C17.3594 2.85282 14.5066 0 11 0C7.49345 0 4.64062 2.85282 4.64062 6.35938C4.64062 8.53136 5.73543 10.4522 7.40188 11.5999C5.84598 12.1368 4.41994 13.0237 3.22184 14.2218C1.14421 16.2995 0 19.0618 0 22H1.71875C1.71875 16.8823 5.88229 12.7188 11 12.7188C16.1177 12.7188 20.2812 16.8823 20.2812 22H22C22 19.0618 20.8558 16.2995 18.7782 14.2218ZM11 11C8.44117 11 6.35938 8.91825 6.35938 6.35938C6.35938 3.8005 8.44117 1.71875 11 1.71875C13.5588 1.71875 15.6406 3.8005 15.6406 6.35938C15.6406 8.91825 13.5588 11 11 11Z"
                                                    fill="black"
                                            />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_254_7910">
                                                <rect width="22" height="22" fill="black" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span> {{$button['title'][app()->getLocale()]}} </span>
                                </a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>