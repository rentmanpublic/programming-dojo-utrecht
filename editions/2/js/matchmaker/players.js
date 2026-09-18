// The Player "data type" and an example list of players to test the application with.
//
// A Player is a plain object:
//   { playerId: number, latency: number, skill: number, inPartOfPlayer: number, canHost: boolean }

/**
 * Create a Player. The object is frozen: this kata is about *functional*
 * programming, so never mutate players — create new ones instead.
 *
 * @param {number} playerId
 * @param {number} latency
 * @param {number} skill
 * @param {number} inPartOfPlayer - the ID of another player this player is partied with (0 = no party)
 * @param {boolean} canHost
 * @returns {Readonly<{playerId: number, latency: number, skill: number, inPartOfPlayer: number, canHost: boolean}>}
 */
export const player = (playerId, latency, skill, inPartOfPlayer, canHost) =>
  Object.freeze({ playerId, latency, skill, inPartOfPlayer, canHost });

// A Game is simply an array of Players (like Haskell's `type Game = [Player]`).

const cycle = (list) => (i) => list[i % list.length];

const latencies = cycle([50, 100, 150, 200, 75, 125]);
const skills = cycle([20, 40, 60, 80, 100, 10]);
const inParts = cycle([0, 1, 2, 3, 4, 5]);
const canHosts = cycle([true, false]);

/** 30 example players, identical to the Haskell version's `defaultPlayers`. */
export const defaultPlayers = Object.freeze(
  Array.from({ length: 30 }, (_, i) =>
    player(i, latencies(i), skills(i), inParts(i), canHosts(i))
  )
);
