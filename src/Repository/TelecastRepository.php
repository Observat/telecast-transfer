<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\ModelListProxy\LeaderListProxy;
use Observatby\TelecastTransfer\Repository\Persistence\DummyPersistence;
use Observatby\TelecastVault\Models\EpisodeList;
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
            new LeaderListProxy($id, new LeaderRepository(new DummyPersistence(), new DummyPersistence())), # TODO not DummyPersistence
            new EpisodeList([]) # TODO
        );
    }
}
