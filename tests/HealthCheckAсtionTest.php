<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckAсtionTestTest extends WebTestCase // test
{
    public function test_request_responded_successful_result(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/health-check');

        $this->assertResponseIsSuccessful();
        $jsonResponse = json_encode($client->getResponse()->getContent(), true);
        $this->assertEquals($jsonResponse['status'], 'ok');
    }
}
