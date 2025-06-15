<?php

namespace App\Repository;

use App\Entity\Proveedor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Proveedor>
 *
 * @method Proveedor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proveedor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proveedor[]    findAll()
 * @method Proveedor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProveedorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proveedor::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Proveedor $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Proveedor $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

}
