<?php

namespace App\Tests\Controller\Web;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MainControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_web_homepage_path_ca);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/es%s', RoutesEnum::app_web_homepage_path_es));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/en%s', RoutesEnum::app_web_homepage_path_en));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/de%s', RoutesEnum::app_web_homepage_path_de));
        self::assertResponseIsSuccessful();
    }
}
