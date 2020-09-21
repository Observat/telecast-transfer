<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\ConnectionDTO;
use Observatby\TelecastTransfer\TelecastTransferException;
use PDO;
use PDOStatement;

class TelecastFromMirtvruPersistence implements ReadPersistenceInterface
{
    use PrepareStatementTrait;

    private const QUERY = "SELECT
                               title,
                               description as shortDescription,
                               text as description,
                               age_restriction
                           FROM article_broadcast
                           WHERE article_id = ?";

    private ConnectionDTO $connectionConfig;
    private PDOStatement $sth;

    /**
     * TelecastFromMirtvruPersistence constructor.
     * @param ConnectionDTO $connectionConfig
     */
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

    public function retrieveList($parentId): array
    {
        return [];// TODO: Implement retrieveList() method.
    }
}
