<?php


namespace Observatby\TelecastTransfer\Repository\Persistence;


use Observatby\TelecastTransfer\TelecastTransferException;
use PDO;
use PDOException;


trait PrepareStatementTrait
{
    /**
     * @param $query
     * @throws TelecastTransferException
     */
    private function prepareStatement($query)
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
            $this->sth = $dbh->prepare($query);
        } catch (PDOException $e) {
            throw new TelecastTransferException(TelecastTransferException::NOT_CONNECTED_TO_DB);
        }
    }
}
