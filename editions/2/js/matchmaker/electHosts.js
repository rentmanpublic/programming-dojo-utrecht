// Story 1 - Electing Hosts

/**
 * This is an example of a comparator function (the JS equivalent of the
 * Haskell `lowestLatency :: Player -> Player -> Ordering` function).
 * Use it with `Array.prototype.toSorted` (non-mutating!).
 */
export const lowestLatency = (player1, player2) => player1.latency - player2.latency;

/*
 Implement a function that returns a player who can host.
 Start with selecting the player with the lowest latency.

 note: This function should return an array of either 1 or 0 players.
 This is because I want to spare you the extra complexity of null handling / Maybe types...

 Tip: use the lowestLatency comparator with `toSorted`, and `slice`.

 Then add logic to filter out players who have canHost = false.
 Tip: use `filter` with an arrow function: players.filter((p) => ...)

 Remember: stay functional. Do not mutate the input array
 (use `toSorted` instead of `sort`, `slice` instead of `splice`, ...).
*/

/**
 * @param {ReadonlyArray<import('./players.js')>} players
 * @returns {Array} an array with 1 elected host, or an empty array
 */
export const electHost = (players) => {
  if (players.length === 0) return []; // the "empty list" case
  return [...players]; // todo replace this mock implementation with a real one.
};
