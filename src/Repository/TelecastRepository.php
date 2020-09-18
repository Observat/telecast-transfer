<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastVault\Models\EpisodeList;
use Observatby\TelecastVault\Models\Leader;
use Observatby\TelecastVault\Models\Telecast;

class TelecastRepository
{
    private ReadPersistenceInterface $readPersistence;
    private WritePersistenceInterface $writePersistence;

    public function __construct(ReadPersistenceInterface $readPersistence, WritePersistenceInterface $writePersistence)
    {
        $this->readPersistence = $readPersistence;
        $this->writePersistence = $writePersistence;
    }

    public function findById(TelecastIdInMirtvru $id): Telecast
    {
        $res = $this->readPersistence->retrieve($id->toScalar());

        return new Telecast(
            $res['title'],
            $res['shortDescription'],
            $res['description'],
            new Leader(
                $res['leaderTitle'],
                $res['leaderBlockquote'],
                $res['leaderShortDescription'],
                $res['leaderDescription'],
            ),
            new EpisodeList([]) # TODO
        );
    }
}
