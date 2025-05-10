<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Block\Block;
use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\District\District;
use App\Models\Dropdown\Dropdown;
use App\Models\Faq\Faq;
use App\Models\Menu\Menu;
use App\Models\News\News;
use App\Models\Page\Page;
use App\Models\Party\Party;
use App\Models\Seo\Seo;
use App\Models\Seo\SeoLink;
use App\Models\Slider\Slider;
use App\Models\Translation\Translation;
use App\Models\Translation\TranslationCategory;
use App\Policies\Block\BlockPolicy;
use App\Policies\Candidate\CandidatePolicy;
use App\Policies\City\CityPolicy;
use App\Policies\Cluster\ClusterPolicy;
use App\Policies\District\DistrictPolicy;
use App\Policies\Dropdown\DropdownPolicy;
use App\Policies\Faq\FaqPolicy;
use App\Policies\HeaderImage\HeaderImagePolicy;
use App\Policies\Menu\MenuPolicy;
use App\Policies\News\NewsPolicy;
use App\Policies\Page\PagePolicy;
use App\Policies\Party\PartyPolicy;
use App\Policies\Seo\SeoLinkPolicy;
use App\Policies\Slider\SliderPolicy;
use App\Policies\Translation\TranslationCategoryPolicy;
use App\Policies\Translation\TranslationPolicy;
use App\View\Components\Layout\HeaderImage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Block::class => BlockPolicy::class,
        Candidate::class => CandidatePolicy::class,
        City::class => CityPolicy::class,
        Cluster::class => ClusterPolicy::class,
        District::class => DistrictPolicy::class,
        Dropdown::class => DropdownPolicy::class,
        Faq::class => FaqPolicy::class,
        \App\Models\HeaderImage\HeaderImage::class => HeaderImagePolicy::class,
        Menu::class => MenuPolicy::class,
        News::class => NewsPolicy::class,
        Page::class => PagePolicy::class,
        Party::class => PartyPolicy::class,
        SeoLink::class  => SeoLinkPolicy::class,
        Slider::class => SliderPolicy::class,
        Translation::class => TranslationPolicy::class,
        TranslationCategory::class => TranslationCategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
