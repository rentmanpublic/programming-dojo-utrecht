<?php

declare(strict_types=1);

namespace MatchMaker;

// Story 1 - Electing Hosts

/**
 * This is an example of a comparator function (the PHP equivalent of the
 * Haskell `lowestLatency :: Player -> Player -> Ordering` function).
 * Use it with `sortedBy` (below), never with `usort` directly: `usort` mutates!
 */
function lowestLatency(Player $player1, Player $player2): int
{
    return $player1->latency <=> $player2->latency;
}

/**
 * Return a *sorted copy* of a list (the PHP equivalent of JavaScript's `toSorted`).
 *
 * PHP arrays are values, not references: `$list` inside this function is a copy,
 * so sorting it leaves the caller's array untouched.
 *
 * @template T
 * @param list<T> $list
 * @param callable(T, T): int $comparator
 * @return list<T>
 */
function sortedBy(array $list, callable $comparator): array
{
    usort($list, $comparator);

    return $list;
}

/*
 Implement a function that returns a player who can host.
 Start with selecting the player with the lowest latency.

 note: This function should return a list of either 1 or 0 players.
 This is because I want to spare you the extra complexity of null handling / Maybe types...

 Tip: use the lowestLatency comparator with `sortedBy`, and `array_slice`.

 Then add logic to filter out players who have canHost = false.
 Tip: use `array_filter` with an arrow function: array_filter($players, fn (Player $p) => ...)
 Beware: `array_filter` keeps the original keys. Wrap it in `array_values` to get a proper list again.

 Remember: stay functional. Do not mutate the input array
 (use `sortedBy` instead of `usort`, `array_slice` instead of `array_splice`, ...).
*/

/**
 * @param list<Player> $players
 * @return list<Player> a list with 1 elected host, or an empty list
 */
function electHost(array $players): array
{
    if ($players === []) {
        return []; // the "empty list" case
    }

    return $players; // todo replace this mock implementation with a real one.
}
