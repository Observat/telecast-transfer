<?php declare(strict_types=1);

use Observatby\TelecastTransfer\Repository\DummyPersistence;
use Observatby\TelecastTransfer\Repository\TelecastFromMirtvruPersistence;
use Observatby\TelecastTransfer\Repository\TelecastRepository;
use PHPUnit\Framework\TestCase;

class TelecastRepositoryTest extends TestCase
{
    public function testHasCreatedTelecastRepository()
    {
        $repository = new TelecastRepository(new TelecastFromMirtvruPersistence(), new DummyPersistence());

        $this->assertInstanceOf(TelecastRepository::class, $repository);
    }
}
