<?php

namespace App\Http\Controllers;

use App\Models\Candidate\Candidate;
use App\Models\City;
use App\Models\Cluster\Cluster;
use App\Models\ContactUs;
use App\Models\Dropdown\Dropdown;
use App\Models\Faq\Faq;
use App\Models\News\News;
use App\Models\Page\Page;
use App\Models\Party\Party;
use App\Models\Slider\Slider;
use App\Settings\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(Request $request){
        $banner = Slider::active()
            ->whereCategory(Slider::HOMEPAGE_SLIDER)
            ->whereSlug('homepage-banner')
            ->active()
            ->first();

        $news = News::active()
            ->wherePromoteToHomepage(1)
            ->limit(4)
            ->get();

        $news_banner = Slider::active()
            ->whereCategory(Slider::HOMEPAGE_SLIDER)
            ->whereSlug('homepage-news-slider')
            ->active()
            ->first();

        $candidates = Candidate::active()
            ->wherePromote(1)
            ->get();

        $news_image = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-news-image')
            ->first()
            ?->blocks()->first();


        $total_cities_votes = City\City::active()->withSum('clusters', 'votes')->get()->sum('clusters_sum_votes');
        $total_cities_votes += Cluster::active()->withSum('candidates', 'extra_votes')->get()->sum('candidates_sum_votes');

        $city_votes = [];

        foreach (City\City::active()->get() as $city){
            $city_votes[$city->title] = $city->clusters->sum('votes');
            $city_votes[$city->title] += $city->clusters()->withSum('candidates', 'extra_votes')->get()->sum('candidates_sum_votes');
            $city_votes[$city->title] = $total_cities_votes ? $city_votes[$city->title] / $total_cities_votes * 100: 0 . "%";
        }

        $total_parties_votes = Party::active()->sum('votes');
        $parties_votes = [];


        foreach (Party::active()->get() as $party){
            $parties_votes[$party->title] = $total_parties_votes ? $party->votes / $total_parties_votes * 100 : 0 . "%";
        }

        return $this->view('Site.homepage',
            compact('banner', 'news', 'news_banner', 'candidates', 'city_votes', 'parties_votes', 'news_image')
        );
    }

    public function aboutUs(Request $request){
        $about_us_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('about-us-section')
            ->first()
            ?->blocks()->first();

        return $this->view('Site.about-us', [
            'about_us_section' => $about_us_section,
        ]);
    }

    public function faqs(Request $request)
    {
        $faqs = Faq::paginate(app(Site::class)->faqs_page_size)->withQueryString();
        return $this->view('Site.faqs', compact('faqs'));
    }

    public function contactUs(Request $request){
        if ($request->method() == "POST") {
            $data = $request->validate([
                'name' => 'required|regex:/^[^0-9]*$/i',
                'phone' => 'required|phone:JO',
                'email' => 'required|email',
                'message' => 'required',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ]);

            unset($data['g-recaptcha-response']);
            $model = ContactUs::create($data);
            $model->save();
            return redirect()->route('site.contact-us')->with('success', __("site.Application Has Been Submitted Successfully"));
        }
        return $this->view('Site.contact-us');
    }

    public function show(): bool|\Illuminate\Http\JsonResponse|string
    {
        $segments = \request()->segments();
        $prefix = implode(
            '/',
            array_slice($segments, \request()->route()->hasParameter('section') ? 2 : 1, -1)
        );

        $prefix = $prefix ?: null;
        $slug = last($segments);


        $page = Page::active()
            ->directAccess()
            ->whereSlug($slug)
            ->wherePrefix($prefix)
            ->whereDoesntHave('sections')
            ->first();

        if (!$page){
            $prefix = implode('/', array_slice($segments, 2, -1));
            $prefix = $prefix ?: null;

            $page = Page::active()
                        ->directAccess()
                        ->whereSlug($slug)
                        ->wherePrefix($prefix)
                        ->first();
        }

        if (!$page)
            return (new SectionController())->index(app()->getLocale(), \request()->segment(2));

        $view = strtolower(explode(' ', $page->view)[0]);
        return $this->view('Pages.' . $view, compact('page'));
    }
}
