<?php


namespace Observatby\TelecastTransfer\Repository;


use Observatby\TelecastTransfer\ConnectionDTO;
use Observatby\TelecastTransfer\TelecastTransferException;
use PDO;
use PDOException;
use PDOStatement;

class TelecastFromMirtvruPersistence implements ReadPersistenceInterface
{
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
     * @throws TelecastTransferException
     */
    private function prepareStatement()
    {
        try {
            $dbh = (new PDO(
                $this->connectionConfig->connection,
                $this->connectionConfig->user,
                $this->connectionConfig->password,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                    PDO::ATTR_PERSISTENT => true,
                ]
            ));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->sth = $dbh->prepare(self::QUERY);
        } catch (PDOException $e) {
            throw new TelecastTransferException(TelecastTransferException::NOT_CONNECTED_TO_DB);
        }
    }

    /**
     * @param $id
     * @return array
     * @throws TelecastTransferException
     */
    public function retrieve($id): array
    {
        $this->prepareStatement();

        $this->sth->execute([$id]);
        $res = $this->sth->fetch(PDO::FETCH_ASSOC);
        $this->sth->closeCursor();

        return $res;
    }
}
