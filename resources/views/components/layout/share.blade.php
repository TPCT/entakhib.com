<div class="share-header">
    <div class="container shareBtnContainer">
        <span class="share--closeBtn pointer">X</span>
        <span class="share-btn">
            <picture>
            <img src="{{asset('/Assets/Icons/share 1.svg')}}" alt="" srcset="">
            </picture>
            <span>@lang('site.SHARE')</span>
          </span>
        <div class="share-header-icons-container">
            <a class="icon-container copy_text" href=""><i class="fa-solid fa-link"></i></a>
            <a class="icon-container"
               href="https://www.facebook.com/sharer.php?u={{request()->fullUrl()}}"
            ><i class="fa-brands fa-facebook-f"></i></a>
            <a class="icon-container"
               href="https://twitter.com/share?url={{request()->fullUrl()}}"
            ><i class="fa-brands fa-x-twitter"></i></a>
            <a class="icon-container"
               href="https://www.linkedin.com/shareArticle?mini=true&url={{request()->fullUrl()}}"
            ><i class="fa-brands fa-linkedin"></i></a>
        </div>
    </div>
</div>