<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\Ids\LeaderIdInMirtvru;
use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
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

    /**
     * @param TelecastIdInMirtvru $id
     * @return Leader[]
     */
    public function findAllByTelecastId(TelecastIdInMirtvru $id): array
    {
        $res = $this->readPersistence->retrieveList($id->toScalar());

        $leaders = [];
        foreach ($res as $row) {
            $leaders[] = new Leader(
                $row['title'],
                $row['quote'],
                $row['shortDescription'],
                $row['description'],
            );
        }

        return $leaders;
    }
}
