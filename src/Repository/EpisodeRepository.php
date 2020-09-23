<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\Ids\EpisodeIdInMirtvru;
use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastVault\Models\Episode;
use Observatby\TelecastVault\Models\TagList;
use Observatby\TelecastVault\Models\Video;


class EpisodeRepository
{
    private ReadPersistenceInterface $readPersistence;
    private WritePersistenceInterface $writePersistence;

    public function __construct(ReadPersistenceInterface $readPersistence, WritePersistenceInterface $writePersistence)
    {
        $this->readPersistence = $readPersistence;
        $this->writePersistence = $writePersistence;
    }

    public function findById(EpisodeIdInMirtvru $id): Episode
    {
        $row = $this->readPersistence->retrieve($id->toScalar());

        return new Episode(
            $row['title'],
            $row['description'] ?? '',
            $row['text'],
            $row['ageRestriction'],
            null,
            null,
        );
    }

    /**
     * @param TelecastIdInMirtvru $id
     * @return Episode[]
     */
    public function findAllByTelecastId(TelecastIdInMirtvru $id): array
    {
        $res = $this->readPersistence->retrieveList($id->toScalar());

        $episodes = [];
        foreach ($res as $row) {
            $episodes[] = new Episode(
                $row['title'],
                $row['description'] ?? '',
                $row['text'],
                $row['ageRestriction'],
                new Video("TODO"),
                new TagList([]), # TODO
            );
        }

        return $episodes;
    }
}
