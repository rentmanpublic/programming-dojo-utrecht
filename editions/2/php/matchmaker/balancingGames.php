<?php

declare(strict_types=1);

namespace MatchMaker;

// Story 2 (and 3 & 4) - Balancing Games

/*
 Implement a function that creates games with min 2 and max 6 players.
 The games should be as balanced as possible, meaning that the deviation of the
 skill levels per group should be as low as possible.
 When the number of total players is < 2, no Games can be created. (duhh)

 A Game is simply a list of Players, so this function returns a list of lists of Players.

 Some tips:

 You can get the head and tail of a list, the PHP equivalent of Haskell's `(x:xs)` pattern, with:
   [$head] = $players;                 // or: $head = $players[0];
   $tail = array_slice($players, 1);
 This is especially powerful in combination with recursive functions.

 You should look into `array_slice` (the PHP take/drop) and `array_chunk`.
 You might also want to use the `%` (modulo) operator and `intdiv`.

 You might want to create additional functions. For example, for sorting by
 skill level (see `sortedBy` in electHosts.php) and for chunking lists.

 Remember: stay functional. Do not mutate the input array
 (use `sortedBy` instead of `usort`, `array_slice` instead of `array_splice`, ...).
*/

/**
 * @param list<Player> $players
 * @return list<list<Player>> the list of games
 */
function balancedGames(array $players): array
{
    return [$players]; // todo replace this mock implementation with a real one.
}
