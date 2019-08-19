<?php


namespace App\EventSubscriber;

use App\Service\SyncJobFulltext;
use Doctrine\Common\EventSubscriber;

class TestSubscriber implements EventSubscriber
{

    public function __construct(SyncJobFulltext $syncJobFulltext)
    {
    }

    public function getSubscribedEvents()
    {
        return [];
    }
}