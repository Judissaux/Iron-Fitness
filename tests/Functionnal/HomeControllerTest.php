<?php

namespace App\Tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testControllerWorks()
    {
        $client = static::createClient();
        $client->request('GET','/');
        
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    public function testRedirectToLogin()
    {
        $client = static::createClient();
        $client->request(
            method: 'GET',
            uri: '/profil'
        );
        $this->assertResponseRedirects('/connexion');
    
    }

    public function testDisplayLogin()
    {
        $client = static::createClient();
        $client->request(
            method: 'GET',
            uri: '/connexion'
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Se connecter');
    }

    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request(
            method: 'GET',
            uri: '/connexion'
        );
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'jean@laposte.net',
            'password' => 'aze'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
        
    }

    
}