<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/users/list');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('table');
    }

    public function testNewUserFormDisplay()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/users/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testCreateUserWithoutPassword()
    {
        $client = static::createClient();
        $client->request('POST', '/admin/users/new', [
            'email' => 'test@example.com',
            'plainPassword' => '',
        ]);

        $this->assertSelectorTextContains('.flash-error', 'La contraseña es requerida.');
    }

    public function testCreateUserSuccess()
    {
        $client = static::createClient();
        $client->request('POST', '/admin/users/new', [
            'email' => 'test@example.com',
            'plainPassword' => 'password123',
            'roles' => ['ROLE_USER'],
        ]);

        $this->assertResponseRedirects('/admin/users/list');
        $client->followRedirect();
        $this->assertSelectorTextContains('.flash-success', 'Usuario creado correctamente.');
    }

    public function testEditUserNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/users/edit/999999');

        $this->assertResponseStatusCodeSame(404);
    }
}
