<?php declare(strict_types=1);

use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\Repository\DummyPersistence;
use Observatby\TelecastTransfer\Repository\TelecastFromMirtvruPersistence;
use Observatby\TelecastTransfer\Repository\TelecastRepository;
use PHPUnit\Framework\TestCase;

class ReadFromMirtvruTest extends TestCase
{
    public function testReadTelecastFromMirtvru()
    {
        $repository = new TelecastRepository(new TelecastFromMirtvruPersistence(), new DummyPersistence());

        $telecast = $repository->findById(TelecastIdInMirtvru::fromScalar(68));

        $this->assertEquals("Вместе", $telecast->getTitle());
        $this->assertEquals("Екатерина Абрамова", $telecast->getLeader()->getTitle());
    }
}
