<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.sms_api_user');
        $this->migrator->add('site.sms_api_password');
        $this->migrator->add('site.sms_api_sid');
    }
};
