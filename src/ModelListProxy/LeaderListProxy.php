<?php

namespace Observatby\TelecastTransfer\ModelListProxy;

use ArrayIterator;
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
     * LeaderListProxy constructor.
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

    public function loadList(): self
    {
        $this->leaders = $this->repository->findAllByTelecastId($this->parentId);
        $this->loaded = true;

        return $this;
    }
}
