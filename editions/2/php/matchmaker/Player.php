<?php

declare(strict_types=1);

namespace MatchMaker;

/**
 * The Player "data type" (the PHP equivalent of the Haskell `data Player = Player {...}`).
 *
 * The class is readonly: this kata is about *functional* programming, so a
 * Player can never be mutated — create a new one instead.
 */
final readonly class Player
{
    public function __construct(
        public int $playerId,
        public int $latency,
        public int $skill,
        /** The ID of another player this player is partied with (0 = no party). */
        public int $inPartOfPlayer,
        public bool $canHost,
    ) {
    }
}

// A Game is simply a list of Players (like Haskell's `type Game = [Player]`),
// so in PHP that is an `array<Player>`.

/**
 * 30 example players, identical to the Haskell version's `defaultPlayers`.
 *
 * @return list<Player>
 */
function defaultPlayers(): array
{
    $cycle = fn (array $list): callable => fn (int $i): mixed => $list[$i % count($list)];

    $latencies = $cycle([50, 100, 150, 200, 75, 125]);
    $skills = $cycle([20, 40, 60, 80, 100, 10]);
    $inParts = $cycle([0, 1, 2, 3, 4, 5]);
    $canHosts = $cycle([true, false]);

    return array_map(
        fn (int $i): Player => new Player($i, $latencies($i), $skills($i), $inParts($i), $canHosts($i)),
        range(0, 29),
    );
}
