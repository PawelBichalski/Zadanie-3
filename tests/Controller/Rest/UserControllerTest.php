<?php

namespace App\Tests\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\SetUpDatabase;

class UserControllerTest extends WebTestCase
{
    use SetUpDatabase;

    /**
     * @dataProvider validUserProvider
     */
    public function testCreateAction($fistname, $surname, $identificationNumber)
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/users',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            json_encode(array(
                'firstname' => $fistname,
                'surname' => $surname,
                'identificationNumber' => $identificationNumber
            ))
        );
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertGreaterThan(0, $data['id']);
    }

    /**
     * @dataProvider invalidUserProvider
     */
    public function testCreateActionFail($fistname, $surname, $identificationNumber, $invalidField)
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/users',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            json_encode(array(
                'firstname' => $fistname,
                'surname' => $surname,
                'identificationNumber' => $identificationNumber
            ))
        );
        $this->assertEquals(422, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(422, $data['code']);
        $this->assertArrayHasKey($invalidField, $data['errors']);
    }

    public function testListAction()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/users',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            json_encode(array(
                'firstname' => 'Imie unikalne',
                'surname' => 'Nazwisko unikalne',
                'identificationNumber' => '58091478556'
            ))
        );
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $userId = $data['id'];

        $client->request(
            'GET',
            '/users',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            null
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function validUserProvider()
    {
        return [
            ['Imie 1', 'Nazwisko 1', '99042622464'],
            ['Imie 2', 'Nazwisko 2', '62090198443'],
            ['Imie 3', 'Nazwisko 3', '80042977463']
        ];
    }

    public function invalidUserProvider()
    {
        return [
            ['', 'Nazwisko 1', '68033181316', 'firstname'],
            ['Imie', '', '68033181316', 'surname'],
            ['Imie', 'Nazwisko', '', 'identificationNumber'],
            ['Imie', 'Nazwisko', '123', 'identificationNumber'],
            ['Imie', 'Nazwisko', '12345678901', 'identificationNumber'],
        ];
    }
}
