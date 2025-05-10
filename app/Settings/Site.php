<?php

namespace App\Settings;

use App\Helpers\TranslatableSettings;
use Spatie\LaravelSettings\Settings;

class Site extends Settings
{
    private array $translatable = [
        'fav_icon', 'logo', 'mobile_logo', 'footer_logo', 'address', 'footer_description'
    ];

    private array $uploads = [
        'fav_icon', 'logo', 'mobile_logo', 'footer_logo'
    ];

    public function translatable()
    {
        return $this->translatable;
    }

    public function uploads(){
        return $this->uploads;
    }

    use TranslatableSettings;

    public ?string $fav_icon;

    public ?array $logo;
    public ?array $mobile_logo;
    public ?array $footer_logo;

    public bool $maintenance;

    public ?array $footer_description;

    public ?string $email;
    public ?string $phone;

    public ?string $facebook_link;
    public ?string $instagram_link;
    public ?string $twitter_link;
    public ?string $youtube_link;
    public ?string $linkedin_link;
    public ?string $whatsapp_link;
    public ?string $app_store_link;
    public ?string $play_store_link;
    public ?string $app_gallery_link;

    public ?int $default_page_size;
    public ?int $news_page_size;
    public ?int $faqs_page_size;

    public ?int $parties_page_size;
    public ?int $clusters_page_size;
    public ?int $candidates_page_size;

    public ?string $contact_us_mailing_list;

    public ?string $captcha_secret_key;
    public ?string $captcha_site_key;
    public bool $enable_captcha;

    public ?string $sms_api_user;
    public ?string $sms_api_password;
    public ?string $sms_api_sid;

    public static function group(): string
    {
        return 'site';
    }
}
