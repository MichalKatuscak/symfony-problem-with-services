<?php

namespace App\Controller;

use App\Entity\Test;
use App\Service\SyncJobFulltext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/test-repo")
     * @return Response
     */
    public function testRepo()
    {
        $testRepo = $this->entityManager->getRepository(Test::class);
        $testEntity = $testRepo->find(1);
        $testEntity->setName('hello world');

        $this->entityManager->persist($testEntity);

        // funguje dobře
        $this->entityManager->flush();

        return new Response('test repo');
    }

    /**
     * @Route("/test-repo-inside-service")
     * @param SyncJobFulltext $service
     * @return Response
     */
    public function testRepoInsideService(SyncJobFulltext $service)
    {
        // nefunguje, místo aby upravil položku, tak vytvoří novou (a přitom je v metodě stejný kód)
        $service->sync();

        return new Response('test repo inside service');
    }
}