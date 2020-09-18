<?php declare(strict_types=1);

use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\Repository\DummyPersistence;
use Observatby\TelecastTransfer\Repository\TelecastFromMirtvruPersistence;
use Observatby\TelecastTransfer\Repository\TelecastRepository;
use PHPUnit\Framework\TestCase;

class TelecastRepositoryTest extends TestCase
{
    public function testHasCreatedTelecastRepository()
    {
        $repository1 = new TelecastRepository(new DummyPersistence(), new DummyPersistence());
        $this->assertInstanceOf(TelecastRepository::class, $repository1);

        $repository2 = new TelecastRepository(new TelecastFromMirtvruPersistence(), new DummyPersistence());
        $this->assertInstanceOf(TelecastRepository::class, $repository2);
    }

    public function testReadTelecastFromMirtvru()
    {
        $mockReadPersistence = $this->getMockBuilder(TelecastFromMirtvruPersistence::class)
            ->onlyMethods(['retrieve'])
            ->getMock();
        $mockReadPersistence->expects($this->once())->method('retrieve');

        /** @var TelecastFromMirtvruPersistence $mockReadPersistence */
        $repository = new TelecastRepository($mockReadPersistence, new DummyPersistence());

        $repository->findById(TelecastIdInMirtvru::fromScalar(68));
    }
}
