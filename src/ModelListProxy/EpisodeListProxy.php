<?php

namespace Observatby\TelecastTransfer\ModelListProxy;


use ArrayIterator;
use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\Repository\EpisodeRepository;
use Observatby\TelecastVault\Models\Episode;
use Observatby\TelecastVault\Models\EpisodeListInterface;

class EpisodeListProxy implements EpisodeListInterface
{
    private bool $loaded = false;
    private TelecastIdInMirtvru $parentId;
    private ?EpisodeRepository $repository;
    /** @var Episode[] */
    private array $episodes;

    /**
     * EpisodeListProxy constructor.
     * @param TelecastIdInMirtvru $parentId
     * @param EpisodeRepository|null $repository
     */
    public function __construct(TelecastIdInMirtvru $parentId, ?EpisodeRepository $repository = null)
    {
        $this->parentId = $parentId;
        $this->repository = $repository;
    }

    public function setRepository(?EpisodeRepository $repository): EpisodeListProxy
    {
        $this->repository = $repository;
        return $this;
    }

    public function getIterator()
    {
        if (!$this->loaded) {
            $this->loadList();
        }

        return new ArrayIterator($this->episodes);
    }

    private function loadList(): self
    {
        $this->episodes = $this->repository->findAllByTelecastId($this->parentId);
        $this->loaded = true;

        return $this;
    }
}
