<?php

namespace Observatby\TelecastTransfer\ModelListProxy;

use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\Repository\LeaderRepository;
use Observatby\TelecastVault\Models\Leader;
use Observatby\TelecastVault\Models\LeaderListInterface;


class LeaderListProxy implements LeaderListInterface
{
    private bool $loaded = false;
    private TelecastIdInMirtvru $parentId;
    private LeaderRepository $repository;
    /** @var Leader[] */
    private array $leaders;

    /**
     * EpisodeListProxy constructor.
     * @param TelecastIdInMirtvru $parentId
     * @param LeaderRepository $repository
     */
    public function __construct(TelecastIdInMirtvru $parentId, LeaderRepository $repository)
    {
        $this->parentId = $parentId;
        $this->repository = $repository;
    }

    public function getIterator()
    {
        if (!$this->loaded) {
            $this->loadList();
        }

        return new ArrayIterator($this->leaders);
    }

    private function loadList(): void
    {
        $this->leaders = $this->repository->findAllByTelecastId($this->parentId);
    }
}
