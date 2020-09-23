<?php


namespace Observatby\TelecastTransfer\Repository\Persistence;


use Observatby\TelecastTransfer\Repository\ReadPersistenceInterface;
use Observatby\TelecastTransfer\Repository\WritePersistenceInterface;

class DummyPersistence implements ReadPersistenceInterface, WritePersistenceInterface
{
    public function persist(array $data): void
    {
        # dummy
    }

    public function retrieve($id): array
    {
        return [];
    }

    public function retrieveList($parentId): array
    {
        return [];
    }
}
