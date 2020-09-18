<?php


namespace Observatby\TelecastTransfer\Repository;


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

}
