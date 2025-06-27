<?php

namespace App\Enum;

final readonly class RoutesEnum
{
    // routes
    public const string app_web_homepage_route = 'app_web_homepage';
    public const string app_web_privacy_policy_route = 'app_web_privacy_policy';
    // paths
    public const string app_web_homepage_path_ca = '/';
    public const string app_web_homepage_path_es = '/';
    public const string app_web_homepage_path_en = '/';
    public const string app_web_homepage_path_de = '/';
    public const string app_web_privacy_policy_path_ca = '/politica-de-privacitat';
    public const string app_web_privacy_policy_path_es = '/politica-de-privacidad';
    public const string app_web_privacy_policy_path_en = '/privacy-policy/';
    public const string app_web_privacy_policy_path_de = '/datenschutzrichtlinie';
    // admin
    public const string app_admin_service_path = 'service';
    public const string app_admin_contact_message_path = 'contact-message';
}
