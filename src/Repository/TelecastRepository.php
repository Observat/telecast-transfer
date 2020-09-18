<?php


namespace Observatby\TelecastTransfer\Repository;


class TelecastRepository
{
    private ReadPersistenceInterface $readPersistence;
    private WritePersistenceInterface $writePersistence;

    public function __construct(ReadPersistenceInterface $readPersistence, WritePersistenceInterface $writePersistence)
    {
        $this->readPersistence = $readPersistence;
        $this->writePersistence = $writePersistence;
    }

    # TODO
}
