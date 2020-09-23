<?php declare(strict_types=1);

use Observatby\TelecastTransfer\Ids\LeaderIdInMirtvru;
use Observatby\TelecastTransfer\Repository\LeaderRepository;
use Observatby\TelecastTransfer\Repository\Persistence\DummyPersistence;
use Observatby\TelecastTransfer\Repository\Persistence\LeaderFromMirtvruPersistence;
use PHPUnit\Framework\TestCase;

class LeaderRepositoryTest extends TestCase
{
    public function testReadLeaderFromMirtvru()
    {
        $id = 102;

        $mockReadPersistence = $this->createMock(LeaderFromMirtvruPersistence::class);
        $mockReadPersistence
            ->expects($this->once())
            ->method('retrieve')
            ->willReturn(['title' => 'titleMock', 'shortDescription' => '', 'description' => '', 'quote' => '']);

        $repository = new LeaderRepository($mockReadPersistence, new DummyPersistence());

        $leader = $repository->findById(LeaderIdInMirtvru::fromScalar($id));

        $this->assertEquals("titleMock", $leader->getTitle());
    }
}
