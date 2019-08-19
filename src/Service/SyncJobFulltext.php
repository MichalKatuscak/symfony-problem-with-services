<?php

namespace App\Service;

use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;

class SyncJobFulltext
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function sync()
    {
        $testRepo = $this->entityManager->getRepository(Test::class);
        $testEntity = $testRepo->find(1);
        $testEntity->setName(rand());

        $this->entityManager->persist($testEntity);

        // nefunguje, místo aby upravil položku, tak vytvoří novou
        $this->entityManager->flush();
    }
}