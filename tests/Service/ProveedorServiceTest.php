<?php

namespace App\Tests\Service;

use App\Doctrine\DBAL\Types\TipoProveedorType;
use App\Entity\Proveedor;
use App\Service\ProveedorService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class ProveedorServiceTest extends TestCase
{
    private $em;
    private $repo;
    private ProveedorService $service;

    protected function setUp(): void
    {
        $this->repo = $this->createMock(ObjectRepository::class);
        $this->em = $this->createMock(EntityManagerInterface::class);

        $this->em->method('getRepository')->willReturn($this->repo);

        $this->service = new ProveedorService($this->em);
    }

    public function testGetAllProveedores()
    {
        $proveedores = [new Proveedor(), new Proveedor()];
        $this->repo->expects($this->once())
            ->method('findAll')
            ->willReturn($proveedores);

        $result = $this->service->getAllProveedores();
        $this->assertSame($proveedores, $result);
    }

    public function testGetTipos()
    {
        $tipos = TipoProveedorType::getValues();
        $this->assertEquals($tipos, $this->service->getTipos());
    }

    public function testCreateProveedorFailsIfRequiredFieldsMissing()
    {
        $result = $this->service->createProveedor([
            'nombre' => '',
            'email' => '',
            'tipo' => '',
        ]);
        $this->assertNull($result);
    }

    public function testCreateProveedorSuccess()
    {
        $data = [
            'nombre' => 'Nombre Test',
            'email' => 'test@example.com',
            'telefono' => '123456',
            'tipo' => 'tipo1',
            'activo' => '1',
        ];

        $this->em->expects($this->once())->method('persist')->with($this->isInstanceOf(Proveedor::class));
        $this->em->expects($this->once())->method('flush');

        $proveedor = $this->service->createProveedor($data);

        $this->assertInstanceOf(Proveedor::class, $proveedor);
        $this->assertEquals($data['nombre'], $proveedor->getNombre());
        $this->assertEquals($data['email'], $proveedor->getEmail());
        $this->assertEquals($data['telefono'], $proveedor->getTelefono());
        $this->assertEquals($data['tipo'], $proveedor->getTipo());
        $this->assertTrue($proveedor->getActivo());
        $this->assertInstanceOf(DateTime::class, $proveedor->getCreatedAt());
        $this->assertInstanceOf(DateTime::class, $proveedor->getUpdatedAt());
    }

    public function testGetProveedorById()
    {
        $proveedor = new Proveedor();

        $this->repo->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($proveedor);

        $result = $this->service->getProveedorById(123);
        $this->assertSame($proveedor, $result);
    }

    public function testUpdateProveedor()
    {
        $proveedor = new Proveedor();
        $data = [
            'nombre' => 'Nuevo Nombre',
            'email' => 'nuevo@example.com',
            'telefono' => '654321',
            'tipo' => 'tipo2',
            'activo' => '0',
        ];

        $this->em->expects($this->once())->method('flush');

        $this->service->updateProveedor($proveedor, $data);

        $this->assertEquals($data['nombre'], $proveedor->getNombre());
        $this->assertEquals($data['email'], $proveedor->getEmail());
        $this->assertEquals($data['telefono'], $proveedor->getTelefono());
        $this->assertEquals($data['tipo'], $proveedor->getTipo());
        $this->assertFalse($proveedor->getActivo());
        $this->assertInstanceOf(DateTime::class, $proveedor->getUpdatedAt());
    }

    public function testDeleteProveedor()
    {
        $proveedor = new Proveedor();

        $this->em->expects($this->once())->method('remove')->with($proveedor);
        $this->em->expects($this->once())->method('flush');

        $this->service->deleteProveedor($proveedor);
    }
}
