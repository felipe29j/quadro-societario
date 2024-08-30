<?php

namespace App\Repository;

use App\Entity\Socio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Socio>
 */
class SocioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Socio::class);
    }

    public function findBySearchTerm(string $searchTerm)
    {
        return $this->createQueryBuilder('s')
            ->where('s.nome LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }
}
