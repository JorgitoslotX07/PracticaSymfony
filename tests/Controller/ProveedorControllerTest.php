<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Proveedor;

class ProveedorControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $client->request('GET', '/proveedor/list');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('table'); // Asumiendo que lista en una tabla
    }

    public function testNewPage()
    {
        $client = static::createClient();
        $client->request('GET', '/proveedor/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form'); // Esperamos un formulario
    }

    public function testCreateInvalid()
    {
        $client = static::createClient();
        $client->request('POST', '/proveedor/create', [
            'nombre' => '',
            'email' => '',
            'tipo' => '',
        ]);

        $this->assertResponseRedirects('/proveedor/new');
        $client->followRedirect();
        $this->assertSelectorTextContains('.flash-error', 'Los campos nombre, email y tipo son obligatorios.');
    }

    public function testCreateValid()
    {
        $client = static::createClient();
        $data = [
            'nombre' => 'Proveedor Test',
            'email' => 'test@example.com',
            'tipo' => 'tipo1',
            'activo' => '1',
        ];
        $client->request('POST', '/proveedor/create', $data);

        $this->assertResponseRedirects('/proveedor/list');
        $client->followRedirect();
        $this->assertSelectorTextContains('.flash-success', 'Proveedor creado exitosamente.');
    }

    public function testShowNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/proveedor/show/999999'); // id que no existe

        $this->assertResponseStatusCodeSame(404);
    }
}
