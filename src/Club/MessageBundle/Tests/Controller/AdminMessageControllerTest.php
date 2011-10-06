<?php
namespace Club\MessageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminMessageControllerTest extends WebTestCase
{
  protected function login($client)
  {
    $crawler = $client->request('GET', '/login');
    $form = $crawler->selectButton('Sign In')->form();
    $form['_username'] = '10';
    $form['_password'] = '1234';
    $crawler = $client->submit($form);
  }

  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/message');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/message/new');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $form['message[subject]'] = 'Test';
    $form['message[message]'] = 'Testing';
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $link = $crawler->selectLink('Add recipients')->link();
    $crawler = $client->click($link);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Send message')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
