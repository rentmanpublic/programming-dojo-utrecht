// Property-based tests for each of the acceptance criteria per story,
// mirroring the QuickCheck tests of the Haskell version.
//
// fast-check (https://fast-check.dev) automatically generates arbitrary
// (randomized) lists of players for the tests — just like QuickCheck.
// The tests are just meant as some extra tooling; understanding or using
// fast-check is not in scope for this kata (unless you really want to..).
//
// Run with: npm test

import { describe, it } from 'node:test';
import assert from 'node:assert/strict';
import fc from 'fast-check';
import { electHost } from './electHosts.js';
import { balancedGames } from './balancingGames.js';
import { player } from './players.js';

// A generator ("arbitrary") for random Players, like QuickCheck's `instance Arbitrary Player`.
const arbitraryPlayer = fc
  .record({
    playerId: fc.integer({ min: 1, max: 1_000_000 }),
    latency: fc.integer({ min: 1, max: 1_000_000 }),
    skill: fc.integer({ min: 1, max: 1_000_000 }),
    inPartOfPlayer: fc.integer({ min: 1, max: 1_000_000 }),
    canHost: fc.boolean(),
  })
  .map((p) => player(p.playerId, p.latency, p.skill, p.inPartOfPlayer, p.canHost));

// Force canHost to true, like `playersThatCanHost` in the Haskell version.
const arbitraryPlayerThatCanHost = arbitraryPlayer.map((p) =>
  player(p.playerId, p.latency, p.skill, p.inPartOfPlayer, true)
);

const arbitraryPlayers = fc.array(arbitraryPlayer);
const arbitraryPlayersThatCanHost = fc.array(arbitraryPlayerThatCanHost);

// Sort a list of players deterministically, so two lists can be compared as (multi)sets.
const byAllFields = (a, b) =>
  a.playerId - b.playerId ||
  a.latency - b.latency ||
  a.skill - b.skill ||
  a.inPartOfPlayer - b.inPartOfPlayer ||
  Number(a.canHost) - Number(b.canHost);
const sorted = (players) => players.toSorted(byAllFields);

describe('Story 1 - Electing Hosts', () => {
  it('The first selected host should have the lowest latency', () => {
    fc.assert(
      fc.property(arbitraryPlayersThatCanHost, (players) => {
        const elected = electHost(players);
        if (elected.length === 0) return true;
        const [host] = elected;
        return players.every((p) => host.latency <= p.latency);
      })
    );
  });

  it('Only players with canHost == true should be selected', () => {
    fc.assert(
      fc.property(arbitraryPlayers, (players) =>
        electHost(players).every((p) => p.canHost)
      )
    );
  });
});

describe('Story 2 - Game sizes', () => {
  it('A game should have max 6 players', () => {
    fc.assert(
      fc.property(arbitraryPlayers, (players) =>
        balancedGames(players).every((game) => game.length <= 6)
      )
    );
  });

  it('A game should have minimal 2 players', () => {
    fc.assert(
      fc.property(arbitraryPlayers, (players) =>
        balancedGames(players).every((game) => game.length >= 2)
      )
    );
  });

  it('When games are created, all players should take part', () => {
    fc.assert(
      fc.property(arbitraryPlayers, (players) => {
        const games = balancedGames(players);
        if (games.length === 0) return true;
        assert.deepEqual(sorted(games.flat()), sorted([...players]));
        return true;
      })
    );
  });
});
