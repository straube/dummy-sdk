<?php

use PHPUnit\Framework\TestCase;
use Straube\Dummy\Client;

class ClientTest extends TestCase
{

    private $client;

    public function setUp()
    {
        $user = getenv('DUMMY_USER');
        $password = getenv('DUMMY_PASSWORD');
        $this->client = new Client($user, $password);
    }

    public function testGetUser()
    {
        $user = $this->client->getUser();
        $this->assertInternalType('object', $user);
    }
}
