<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\ConnectionDTO;
use Observatby\TelecastTransfer\TelecastTransferException;
use PDO;
use PDOStatement;


class LeaderFromMirtvruPersistence implements ReadPersistenceInterface
{
    use PrepareStatementTrait;

    private const QUERY = "SELECT
                               title,
                               description as shortDescription,
                               text as description,
                               quote
                           FROM persona
                           WHERE persona_id = ?";
    private const QUERY_LIST = "SELECT
                               title,
                               description as shortDescription,
                               text as description,
                               quote
                           FROM persona_used inner join persona p on persona_used.persona_id = p.persona_id
                           WHERE entity=? AND entity_id = ?";

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

        $this->sth->execute(['broadcast', $parentId]);
        $res = $this->sth->fetchAll(PDO::FETCH_ASSOC);
        $this->sth->closeCursor();

        return $res;
    }
}
