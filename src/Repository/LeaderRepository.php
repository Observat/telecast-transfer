<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\Ids\LeaderIdInMirtvru;
use Observatby\TelecastVault\Models\Leader;


class LeaderRepository
{
    private ReadPersistenceInterface $readPersistence;
    private WritePersistenceInterface $writePersistence;

    public function __construct(ReadPersistenceInterface $readPersistence, WritePersistenceInterface $writePersistence)
    {
        $this->readPersistence = $readPersistence;
        $this->writePersistence = $writePersistence;
    }

    public function findById(LeaderIdInMirtvru $id): Leader
    {
        $res = $this->readPersistence->retrieve($id->toScalar());

        return new Leader(
            $res['title'],
            $res['quote'],
            $res['shortDescription'],
            $res['description'],
        );
    }
}
