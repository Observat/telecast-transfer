<?php

namespace Observatby\TelecastTransfer\Repository;

interface ReadPersistenceInterface
{
    public function retrieve($id): array;
}
