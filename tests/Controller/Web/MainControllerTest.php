<?php

namespace App\Tests\Controller\Web;

use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MainControllerTest extends WebTestCase
{
    public function testSuccessful(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_web_homepage_path_ca);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::es, RoutesEnum::app_web_homepage_path_es));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::en, RoutesEnum::app_web_homepage_path_en));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::de, RoutesEnum::app_web_homepage_path_de));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_web_services_path_ca);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::es, RoutesEnum::app_web_services_path_es));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::en, RoutesEnum::app_web_services_path_en));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::de, RoutesEnum::app_web_services_path_de));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, str_replace('{slug}', 'service-six', sprintf('%s', RoutesEnum::app_web_service_detail_path_ca)));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, str_replace('{slug}', 'service-six', sprintf('/%s%s', LocaleEnum::es, RoutesEnum::app_web_service_detail_path_es)));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, str_replace('{slug}', 'service-six', sprintf('/%s%s', LocaleEnum::en, RoutesEnum::app_web_service_detail_path_en)));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, str_replace('{slug}', 'service-six', sprintf('/%s%s', LocaleEnum::de, RoutesEnum::app_web_service_detail_path_de)));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_web_contact_us_path_ca);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::es, RoutesEnum::app_web_contact_us_path_es));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::en, RoutesEnum::app_web_contact_us_path_en));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::de, RoutesEnum::app_web_contact_us_path_de));
        self::assertResponseIsSuccessful();
    }
}
