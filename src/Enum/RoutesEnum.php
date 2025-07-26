<?php

namespace App\Enum;

final readonly class RoutesEnum
{
    // routes
    public const string app_web_homepage_route = 'app_web_homepage';
    public const string app_web_services_route = 'app_web_services';
    public const string app_web_service_detail_route = 'app_web_service_detail';
    public const string app_web_contact_us_route = 'app_web_contact_us';
    public const string app_web_privacy_policy_route = 'app_web_privacy_policy';
    // paths
    public const string app_web_homepage_path_ca = '/';
    public const string app_web_homepage_path_es = '/';
    public const string app_web_homepage_path_en = '/';
    public const string app_web_homepage_path_de = '/';
    public const string app_web_services_path_ca = '/serveis';
    public const string app_web_services_path_es = '/servicios';
    public const string app_web_services_path_en = '/services';
    public const string app_web_services_path_de = '/dienste';
    public const string app_web_service_detail_path_ca = '/servei/{slug}';
    public const string app_web_service_detail_path_es = '/servicio/{slug}';
    public const string app_web_service_detail_path_en = '/service/{slug}';
    public const string app_web_service_detail_path_de = '/dienste/{slug}';
    public const string app_web_contact_us_path_ca = '/contacte';
    public const string app_web_contact_us_path_es = '/contacto';
    public const string app_web_contact_us_path_en = '/contact-us';
    public const string app_web_contact_us_path_de = '/kontaktieren-sie-uns';
    public const string app_web_privacy_policy_path_ca = '/politica-de-privacitat';
    public const string app_web_privacy_policy_path_es = '/politica-de-privacidad';
    public const string app_web_privacy_policy_path_en = '/privacy-policy/';
    public const string app_web_privacy_policy_path_de = '/datenschutzrichtlinie';
    // admin
    public const string app_admin_service_path = 'service';
    public const string app_admin_contact_message_path = 'contact-message';
}
