<?php

declare(strict_types=1);

namespace MatchMaker;

require __DIR__ . '/../vendor/autoload.php';

function describePlayer(Player $player): string
{
    return sprintf(
        'Player(id=%d, latency=%d, skill=%d, inPartOfPlayer=%d, canHost=%s)',
        $player->playerId,
        $player->latency,
        $player->skill,
        $player->inPartOfPlayer,
        $player->canHost ? 'true' : 'false',
    );
}

/** @param list<Player> $players */
function prettyPrint(array $players): void
{
    echo $players === []
        ? "[]\n"
        : "[\n" . implode('', array_map(fn (Player $p): string => '  ' . describePlayer($p) . "\n", $players)) . "]\n";
}

/** @param list<Player> $game */
function printGameInformation(int $index, array $game): void
{
    echo "Game {$index}: ";
    prettyPrint($game);
    echo 'With host: ';
    prettyPrint(electHost($game));
}

function createDeathMatch(): void
{
    echo "Creating a balanced deathmatch\n\n";

    $games = balancedGames(defaultPlayers());
    array_map(printGameInformation(...), range(1, max(count($games), 1)), $games);
}

createDeathMatch();
