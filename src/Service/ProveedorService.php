<?php

namespace App\Service;

use App\Entity\Proveedor;
use App\Doctrine\DBAL\Types\TipoProveedorType;
use Doctrine\ORM\EntityManagerInterface;

class ProveedorService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getAllProveedores(): array
    {
        return $this->em->getRepository(Proveedor::class)->findAll();
    }

    public function getTipos(): array
    {
        return TipoProveedorType::getValues();
    }

    public function createProveedor(array $data): ?Proveedor
    {
        if (empty($data['nombre']) || empty($data['email']) || empty($data['tipo'])) {
            return null;
        }

        $now = new \DateTime();
        $proveedor = (new Proveedor())
            ->setNombre($data['nombre'])
            ->setEmail($data['email'])
            ->setTelefono($data['telefono'] ?? null)
            ->setTipo($data['tipo'])
            ->setActivo($data['activo'] === '1')
            ->setCreatedAt($now)
            ->setUpdatedAt($now);

        $this->em->persist($proveedor);
        $this->em->flush();

        return $proveedor;
    }

    public function getProveedorById(int $id): ?Proveedor
    {
        return $this->em->getRepository(Proveedor::class)->find($id);
    }

    public function updateProveedor(Proveedor $p, array $data): void
    {
        $p->setNombre($data['nombre'])
            ->setEmail($data['email'])
            ->setTelefono($data['telefono'] ?? null)
            ->setTipo($data['tipo'])
            ->setActivo(($data['activo'] ?? '0') === '1')
            ->setUpdatedAt(new \DateTime());

        $this->em->flush();
    }

    public function deleteProveedor(Proveedor $p): void
    {
        $this->em->remove($p);
        $this->em->flush();
    }
}
