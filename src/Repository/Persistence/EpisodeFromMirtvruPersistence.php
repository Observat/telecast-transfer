<?php


namespace Observatby\TelecastTransfer\Repository\Persistence;


use Observatby\TelecastTransfer\ConnectionDTO;
use Observatby\TelecastTransfer\Repository\ReadPersistenceInterface;
use Observatby\TelecastTransfer\TelecastTransferException;
use PDO;
use PDOStatement;


class EpisodeFromMirtvruPersistence implements ReadPersistenceInterface
{
    use PrepareStatementTrait;

    private const QUERY = "SELECT
                               title,
                               description,
                               text,
                               age_restriction as ageRestriction
                           FROM video
                           WHERE video_id = ?";
    private const QUERY_LIST = "SELECT
                               title,
                               description,
                               text,
                               age_restriction as ageRestriction
                           FROM video
                           WHERE article_broadcast_id = ?
                           ORDER BY video_id DESC";

    private ConnectionDTO $connectionConfig;
    private PDOStatement $sth;

    public function __construct(ConnectionDTO $connectionConfig)
    {
        $this->connectionConfig = $connectionConfig;
    }

    /**
     * @param $id
     * @return array
     * @throws TelecastTransferException
     */
    public function retrieve($id): array
    {
        $this->prepareStatement(self::QUERY);

        $this->sth->execute([$id]);
        $res = $this->sth->fetch(PDO::FETCH_ASSOC);
        $this->sth->closeCursor();

        return $res;
    }

    /**
     * @param $parentId
     * @return array
     * @throws TelecastTransferException
     */
    public function retrieveList($parentId): array
    {
        $this->prepareStatement(self::QUERY_LIST);

        $this->sth->execute([$parentId]);
        $res = $this->sth->fetchAll(PDO::FETCH_ASSOC);
        $this->sth->closeCursor();

        return $res;
    }
}
