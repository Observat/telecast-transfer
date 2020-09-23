<?php declare(strict_types=1);

use Observatby\TelecastTransfer\ConnectionDTO;
use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\Repository\Persistence\DummyPersistence;
use Observatby\TelecastTransfer\Repository\Persistence\TelecastFromMirtvruPersistence;
use Observatby\TelecastTransfer\Repository\TelecastRepository;
use PHPUnit\Framework\TestCase;

class TelecastRepositoryTest extends TestCase
{
    public function testHasCreatedTelecastRepository()
    {
        $repository1 = new TelecastRepository(
            new DummyPersistence(),
            new DummyPersistence()
        );
        $this->assertInstanceOf(TelecastRepository::class, $repository1);

        $repository2 = new TelecastRepository(
            new TelecastFromMirtvruPersistence(new ConnectionDTO('', '', '')),
            new DummyPersistence()
        );
        $this->assertInstanceOf(TelecastRepository::class, $repository2);
    }

    public function testReadTelecastFromMirtvru()
    {
        $id = 1;
        $mockReadPersistence = $this->createMock(TelecastFromMirtvruPersistence::class);
        $mockReadPersistence
            ->expects($this->once())
            ->method('retrieve')
            ->willReturn(['title' => 'titleMock', 'shortDescription' => '', 'description' => '']);

        /** @var TelecastFromMirtvruPersistence $mockReadPersistence */
        $repository = new TelecastRepository($mockReadPersistence, new DummyPersistence());

        $telecast = $repository->findById(TelecastIdInMirtvru::fromScalar($id));

        $this->assertEquals('titleMock', $telecast->getTitle());
    }
}
