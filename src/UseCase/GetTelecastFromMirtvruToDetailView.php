<?php

namespace Observatby\TelecastTransfer\UseCase;


use Observatby\TelecastTransfer\ConnectionDTO;
use Observatby\TelecastTransfer\Ids\TelecastIdInMirtvru;
use Observatby\TelecastTransfer\ModelListProxy\EpisodeListProxy;
use Observatby\TelecastTransfer\ModelListProxy\LeaderListProxy;
use Observatby\TelecastTransfer\Repository\EpisodeRepository;
use Observatby\TelecastTransfer\Repository\LeaderRepository;
use Observatby\TelecastTransfer\Repository\Persistence\DummyPersistence;
use Observatby\TelecastTransfer\Repository\Persistence\EpisodeFromMirtvruPersistence;
use Observatby\TelecastTransfer\Repository\Persistence\LeaderFromMirtvruPersistence;
use Observatby\TelecastTransfer\Repository\Persistence\TelecastFromMirtvruPersistence;
use Observatby\TelecastTransfer\Repository\TelecastRepository;
use Observatby\TelecastVault\Dto\ViewTelecastWithEpisodesDTO;
use Observatby\TelecastVault\TransformToDto\TransformTelecastWithEpisodesToViewDto;

class GetTelecastFromMirtvruToDetailView
{
    public static function handle(ConnectionDTO $connectionDto, TelecastIdInMirtvru $idInMirtvru): ViewTelecastWithEpisodesDTO
    {
        $repository = new TelecastRepository(new TelecastFromMirtvruPersistence($connectionDto), new DummyPersistence());

        $telecast = $repository->findById($idInMirtvru);

        /** @var LeaderListProxy $leaders */
        $leaders = $telecast->getLeaders();
        $leaders->setRepository(new LeaderRepository(new LeaderFromMirtvruPersistence($connectionDto), new DummyPersistence()));

        /** @var EpisodeListProxy $episodes */
        $episodes = $telecast->getEpisodes();
        $episodes->setRepository(new EpisodeRepository(new EpisodeFromMirtvruPersistence($connectionDto), new DummyPersistence()));

        return TransformTelecastWithEpisodesToViewDto::transform($telecast);
    }
}
