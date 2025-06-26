<?php

namespace App\Tests\Controller\Admin;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ContactMessageControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, sprintf('/admin/%s/list', RoutesEnum::app_admin_contact_message_path));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/admin/%s/1/delete', RoutesEnum::app_admin_contact_message_path));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/admin/%s/1/show', RoutesEnum::app_admin_contact_message_path));
        self::assertResponseIsSuccessful();
    }
}
