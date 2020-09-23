<?php declare(strict_types=1);

use Observatby\TelecastTransfer\ConnectionDTO;
use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\UseCase\GetTelecastFromMirtvruToDetailView;
use PHPUnit\Framework\TestCase;


class GetTelecastFromMirtvruToDetailViewTest extends TestCase
{
    public function testHandle()
    {
        $connection = new ConnectionDTO(
            getenv("DB_CONNECTION"),
            getenv("DB_USER"),
            getenv("DB_PASSWORD")
        );
        $id = getenv("DB_MIRTVRU_TELECAST_ID");

        $telecastDto = GetTelecastFromMirtvruToDetailView::handle($connection, TelecastIdInMirtvru::fromScalar($id));

        $this->assertEquals("Вместе", $telecastDto->title);
        $this->assertEquals("Екатерина Абрамова", ($telecastDto->leaders)[0]->title);
        $this->assertEquals("Хобби — большой теннис, кулинария.", ($telecastDto->leaders)[0]->quote);
    }
}
