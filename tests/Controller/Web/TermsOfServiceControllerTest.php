<?php

namespace App\Tests\Controller\Web;

use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TermsOfServiceControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_web_privacy_policy_path_ca);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::es, RoutesEnum::app_web_privacy_policy_path_es));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::en, RoutesEnum::app_web_privacy_policy_path_en));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/%s%s', LocaleEnum::de, RoutesEnum::app_web_privacy_policy_path_de));
        self::assertResponseIsSuccessful();
    }
}
