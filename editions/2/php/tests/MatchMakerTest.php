<?php

declare(strict_types=1);

namespace MatchMaker\Tests;

// Property-based tests for each of the acceptance criteria per story,
// mirroring the QuickCheck tests of the Haskell version.
//
// PHPUnit has no QuickCheck built in, so `forAll` below does the job: it runs a
// property against 100 randomly generated lists of players and reports the first
// counterexample it finds. The tests are just meant as some extra tooling;
// understanding the generators is not in scope for this kata (unless you really want to..).
//
// Run with: composer test

use MatchMaker\Player;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Random\Randomizer;

use function MatchMaker\balancedGames;
use function MatchMaker\electHost;

final class MatchMakerTest extends TestCase
{
    private const RUNS = 100;
    private const MAX_PLAYERS = 10;

    // --- Generators ("arbitraries"), like QuickCheck's `instance Arbitrary Player` ---

    private static function arbitraryPlayer(Randomizer $random, ?bool $canHost = null): Player
    {
        return new Player(
            playerId: $random->getInt(1, 1_000_000),
            latency: $random->getInt(1, 1_000_000),
            skill: $random->getInt(1, 1_000_000),
            inPartOfPlayer: $random->getInt(1, 1_000_000),
            canHost: $canHost ?? $random->getInt(0, 1) === 1,
        );
    }

    /** @return list<Player> */
    private static function arbitraryPlayers(Randomizer $random): array
    {
        return array_map(
            fn () => self::arbitraryPlayer($random),
            array_fill(0, $random->getInt(0, self::MAX_PLAYERS), null),
        );
    }

    /**
     * Force canHost to true, like `playersThatCanHost` in the Haskell version.
     *
     * @return list<Player>
     */
    private static function arbitraryPlayersThatCanHost(Randomizer $random): array
    {
        return array_map(
            fn () => self::arbitraryPlayer($random, canHost: true),
            array_fill(0, $random->getInt(0, self::MAX_PLAYERS), null),
        );
    }

    /**
     * QuickCheck's `forAll`: the property must hold for RUNS randomly generated inputs.
     *
     * @param callable(Randomizer): list<Player> $generator
     * @param callable(list<Player>): bool $property
     */
    private function forAll(callable $generator, callable $property): void
    {
        $random = new Randomizer();
        foreach (range(1, self::RUNS) as $run) {
            $players = $generator($random);
            $this->assertTrue(
                $property($players),
                "Property failed after {$run} tests. Counterexample:\n" . self::describe($players),
            );
        }
    }

    // --- Helpers ---

    /** Haskell's `all`: does every item satisfy the predicate? */
    private static function every(array $list, callable $predicate): bool
    {
        return array_reduce($list, fn (bool $ok, mixed $item): bool => $ok && $predicate($item), true);
    }

    /** Sort a list of players deterministically, so two lists can be compared as (multi)sets. */
    private static function sorted(array $players): array
    {
        $key = fn (Player $p): array => [$p->playerId, $p->latency, $p->skill, $p->inPartOfPlayer, $p->canHost];
        usort($players, fn (Player $a, Player $b): int => $key($a) <=> $key($b));

        return $players;
    }

    /** @param list<Player> $players */
    private static function describe(array $players): string
    {
        return $players === []
            ? '[]'
            : implode("\n", array_map(
                fn (Player $p): string => sprintf(
                    '  Player(id=%d, latency=%d, skill=%d, inPartOfPlayer=%d, canHost=%s)',
                    $p->playerId,
                    $p->latency,
                    $p->skill,
                    $p->inPartOfPlayer,
                    $p->canHost ? 'true' : 'false',
                ),
                $players,
            ));
    }

    // --- Story 1 - Electing Hosts ---

    #[TestDox('Story 1 - The first selected host should have the lowest latency')]
    public function testTheFirstSelectedHostShouldHaveTheLowestLatency(): void
    {
        $this->forAll(self::arbitraryPlayersThatCanHost(...), function (array $players): bool {
            $elected = electHost($players);
            if ($elected === []) {
                return true;
            }

            $host = $elected[0];

            return self::every($players, fn (Player $p): bool => $host->latency <= $p->latency);
        });
    }

    #[TestDox('Story 1 - Only players with canHost == true should be selected')]
    public function testOnlyPlayersWithCanHostShouldBeSelected(): void
    {
        $this->forAll(
            self::arbitraryPlayers(...),
            fn (array $players): bool => self::every(electHost($players), fn (Player $p): bool => $p->canHost),
        );
    }

    // --- Story 2 - Game sizes ---

    #[TestDox('Story 2 - A game should have max 6 players')]
    public function testAGameShouldHaveMax6Players(): void
    {
        $this->forAll(
            self::arbitraryPlayers(...),
            fn (array $players): bool => self::every(balancedGames($players), fn (array $game): bool => count($game) <= 6),
        );
    }

    #[TestDox('Story 2 - A game should have minimal 2 players')]
    public function testAGameShouldHaveMinimal2Players(): void
    {
        $this->forAll(
            self::arbitraryPlayers(...),
            fn (array $players): bool => self::every(balancedGames($players), fn (array $game): bool => count($game) >= 2),
        );
    }

    #[TestDox('Story 2 - When games are created, all players should take part')]
    public function testWhenGamesAreCreatedAllPlayersShouldTakePart(): void
    {
        $this->forAll(self::arbitraryPlayers(...), function (array $players): bool {
            $games = balancedGames($players);

            return $games === [] || self::sorted($players) == self::sorted(array_merge(...$games));
        });
    }
}
