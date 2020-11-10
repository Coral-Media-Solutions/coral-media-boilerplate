<?php


namespace CoralMedia\Component\Monogram\Database;


use Doctrine\DBAL\Connection;

class MonogramDatabaseConnection
{
    public $connection;

    public function __construct(Connection $monogramDatabaseConnection)
    {
        $this->connection = $monogramDatabaseConnection;
    }
}