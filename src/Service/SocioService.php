<?php

namespace App\Service;

use App\Entity\Socio;
use Doctrine\ORM\EntityManagerInterface;

class SocioService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createSocio(Socio $socio): void
    {
        $this->entityManager->persist($socio);
        $this->entityManager->flush();
    }

    public function updateSocio(Socio $socio): void
    {
        $this->entityManager->flush();
    }

    public function deleteSocio(Socio $socio): void
    {
        $this->entityManager->remove($socio);
        $this->entityManager->flush();
    }
}
