<?php


namespace Observatby\TelecastTransfer;


class ConnectionDTO
{
    public string $connection;
    public string $user;
    public string $password;

    /**
     * ConnectionDTO constructor.
     * @param string $connection
     * @param string $user
     * @param string $password
     */
    public function __construct(string $connection, string $user, string $password)
    {
        $this->connection = $connection;
        $this->user = $user;
        $this->password = $password;
    }
}
