<?php

namespace App\Filament\Pages;

use App\Exports\SiteSettingsExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Helpers\SettingsExport;
use FilamentTiptapEditor\TiptapEditor;
use App\Settings\Site;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Faker\Provider\Text;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Contracts\Support\Htmlable;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ManageSiteSettings extends SettingsPage
{
    use HasPageShield;
    protected static ?string $navigationGroup = "Site Settings";

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = Site::class;

    public function getTitle(): string|Htmlable
    {
        return __("Site Settings");
    }

    public static function getNavigationLabel(): string
    {
        return __("Site Settings");
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('Export')
                ->label(__("Export"))
                ->action(function(){
                    return \Maatwebsite\Excel\Facades\Excel::download(new SiteSettingsExport, 'site-settings.xlsx');
                })

        ];
    }

    public function form(Form $form): Form
    {
        $tabs = [];
        foreach (config('app.locales') as $locale => $language){
            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        FileUpload::make("fav_icon")
                            ->multiple(false)
                            ->label(__("Fav Icon")),
                        FileUpload::make("logo.{$locale}")
                            ->multiple(false)
                            ->label(__("Logo")),
                        FileUpload::make("footer_logo.{$locale}")
                            ->multiple(false)
                            ->label(__("Footer Logo")),
                    ]),
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        TiptapEditor::make("footer_description.{$locale}")
                            ->label(__("Footer Description")),
                        TextInput::make("address.{$locale}")
                            ->label(__("Address")),
                        TextInput::make("email")
                            ->label(__("Email"))
                            ->email(),
                        TextInput::make("phone")
                            ->label(__("Phone")),
                    ])
            ]);
        }
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Grid::make(1)
                        ->schema([
                            Forms\Components\Tabs::make()
                                ->tabs($tabs)
                                ->columnSpan(1),
                            Forms\Components\Section::make()
                                ->schema([
                                    TextInput::make('facebook_link')
                                        ->label(__("Facebook")),
                                    TextInput::make('instagram_link')
                                        ->label(__("Instagram")),
                                    TextInput::make('twitter_link')
                                        ->label(__("Twitter")),
                                    TextInput::make('youtube_link')
                                        ->label(__("Youtube")),
                                    TextInput::make('linkedin_link')
                                        ->label(__("Linkedin")),
                                    TextInput::make("whatsapp_link")
                                        ->label(__("Whatsapp")),
                                    TextInput::make("app_store_link")
                                        ->label(__("App Store")),
                                    TextInput::make("play_store_link")
                                        ->label(__("Play Store")),
                                    TextInput::make("app_gallery_link")
                                        ->label(__("App Gallery"))
                                ])
                                ->columnSpan(1)
                                ->columns(1),
                        ])
                        ->columnSpan(1),
                    Forms\Components\Grid::make(1)
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    TextInput::make('captcha_site_key')
                                        ->label(__("Captcha Site Key")),
                                    TextInput::make('captcha_secret_key')
                                        ->label(__("Captcha Secret Key")),
                                    Forms\Components\Checkbox::make('enable_captcha')
                                        ->label(__("Enable Captcha"))
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    TextInput::make('sms_api_user')
                                        ->label(__("SMS API User")),
                                    TextInput::make('sms_api_password')
                                        ->label(__("SMS API Password")),
                                    TextInput::make('sms_api_sid')
                                        ->label(__("SMS API SID")),
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Checkbox::make('maintenance')
                                        ->default(false)
                                        ->label(__("Coming Soon"))
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    TextInput::make("default_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    TextInput::make("news_page_size")
                                        ->integer()
                                        ->minValue(1),
                                    TextInput::make('faqs_page_size')
                                        ->integer()
                                        ->minValue(1),
                                    TextInput::make('parties_page_size')
                                        ->integer()
                                        ->minValue(1),
                                    TextInput::make('clusters_page_size')
                                        ->integer()
                                        ->minValue(1),
                                    TextInput::make('candidates_page_size')
                                        ->integer()
                                        ->minValue(1)
                                ]),

                            Forms\Components\Section::make()
                                ->schema([
                                    TextInput::make('contact_us_mailing_list')
                                        ->label(__("Contact Us Mailing List"))
                                        ->helperText(__("Separate Using ,"))
                                ])
                        ])
                        ->columnSpan(1)
                ])
            ]);
    }
}
