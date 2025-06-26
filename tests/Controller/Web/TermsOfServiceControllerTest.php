<?php

namespace App\Tests\Controller\Web;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TermsOfServiceControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_web_privacy_policy_ca);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/es%s', RoutesEnum::app_web_privacy_policy_es));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/en%s', RoutesEnum::app_web_privacy_policy_en));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/de%s', RoutesEnum::app_web_privacy_policy_de));
        self::assertResponseIsSuccessful();
    }
}
