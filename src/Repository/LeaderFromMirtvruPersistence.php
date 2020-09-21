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
}
