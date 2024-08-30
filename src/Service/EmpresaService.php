<?php

namespace App\Service;

use App\Entity\Empresa;
use Doctrine\ORM\EntityManagerInterface;

class EmpresaService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createEmpresa(Empresa $empresa): void
    {
        $this->entityManager->persist($empresa);
        $this->entityManager->flush();
    }

    public function updateEmpresa(Empresa $empresa): void
    {
        $this->entityManager->flush();
    }

    public function deleteEmpresa(Empresa $empresa): void
    {
        foreach ($empresa->getSocios() as $socio) {
            $this->entityManager->remove($socio);
        }

        $this->entityManager->remove($empresa);
        $this->entityManager->flush();
    }
}
