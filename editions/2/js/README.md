# Functional Programming Videogame matchmaking kata (JavaScript variant)

Partly taken from https://github.com/davidwhitney/CodeDojos

The challenge is exactly the same — but you solve it in JavaScript, in a *functional* style:
pure functions, no mutation, no loops with reassignment (prefer `map`/`filter`/`reduce`/recursion).

## Useful sources
- [cheatsheet.js](cheatsheet.js)
- https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array — the non-mutating array methods (`toSorted`, `slice`, `filter`, `map`, `flat`, `reduce`, ...)
- https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring — the JS equivalent of Haskell's `(x:xs)` pattern matching
- https://github.com/hemanth/functional-programming-jargon — FP concepts explained

## How to run

You'll need Node.js 20 or newer (22 recommended, for `node --test --watch`). Check with `node --version`.

1. Clone/open this project and go to the root dir, then install the single dependency (fast-check, for the property-based tests):
```
git clone https://github.com/rentmanpublic/programming-dojo-utrecht
cd editions/2/js
```

2. Run the program:
```
npm start
```

3. Run the tests (they will fail):
```
npm test
```

4. Re-run the tests automatically on every file change (the JS stand-in for `ghci> :r`):
```
npm run test:watch
```

You can also run individual functions in the Node REPL.
For example to run `electHost` (defined in matchmaker/electHosts.js) with `defaultPlayers` (defined in matchmaker/players.js):
```
$ node
> const { electHost } = await import('./matchmaker/electHosts.js')
> const { defaultPlayers } = await import('./matchmaker/players.js')
> electHost(defaultPlayers)
```

The REPL can also be used to try out JavaScript code and functions. For example:
```
> const letters = ['a', 'b', 'c', 'x']
> letters.slice(0, 2)
> letters.toReversed()
> letters.slice(0, 2).toReversed()
```

## The Kata

Matchmaking is a common part of online video games. While reading the changelog for the latest revision of "Halo: The Master Chief Collection" (http://www.polygon.com/2014/12/8/7352941/another-major-update-hits-halo-the-master-chief-collection-for), it became apparent that it's something that can easily go wrong, and has lots of interesting subtleties - and is ripe for the slaying with some traditional TDD.

#### Matchmaking for games

Given a pool of players searching for a game, there are a number of factors to consider:

* The **skill** of the player
* The **latency / ping** of the player

For this Game we will organize free-for-all deathmatches. Meaning there will be one or more games with maximum 6 players each. There are no teams, every player is on its own.

From these factors, emerge *the following requirements*:

* Each game needs a host
* Each game should be balanced
* Players who are partied, should be in the same Game
* The game should be balanced
* The lower the latency of the host, the better
* Matchmaking should be as quick as possible

---

## Lets build a matchmaker!

We have a pool of players all looking to play a balanced, 6 player, free-for-all deathmatch.

### Project setup
The source code can be found in the matchmaker dir.

The main code is in [main.js](matchmaker/main.js). [players.js](matchmaker/players.js) contains the Player factory, the Game concept (a Game is simply an array of Players) and an example list of players to test the application with.

For the matchmaking process, [electHosts.js](matchmaker/electHosts.js) and [balancingGames.js](matchmaker/balancingGames.js) is used.
The goal for this kata is to implement the `electHost` and `balancedGames` functions. You might need to implement some supporting functions too.

You can already run `npm start` to run the code.
However, as `electHost` and `balancedGames` are currently just mock implementations, the generated games will not make much sense.
All players are in the same game and everybody is selected to be host!

**House rule:** keep it functional. No mutation (players are `Object.freeze`d for a reason), no `sort`/`push`/`splice` on existing arrays — use `toSorted`, `slice`, spread, `map`, `filter`, `reduce` and recursion instead.

#### Tests
[matchmaker.test.js](matchmaker/matchmaker.test.js) contains [fast-check](https://fast-check.dev) property-based tests for each of the acceptance criteria per story — the JavaScript equivalent of QuickCheck. fast-check automatically generates arbitrary (randomized) lists of players for the tests.

Run `npm test` to run these tests (or `npm run test:watch` to keep them running).
The tests are just meant as some extra tooling, understanding or using fast-check is not in scope for this kata (unless you really want to..)

### Story 1 - Electing Hosts

    As a server
    When I have a queue of players waiting for a free for all deathmatch
    Then I should elect the most appropriate hosts for those matches

    Accept:
      Hosts should be as low-latency as possible.
      Only hosts with canHost = true should be selected.

### Story 2 - Game sizes

    As a server
    When I form free for all deathmatches
    Then the games should have the proper number of players.

    Accept:
      Games should be between 2 and 6 players.
      When the total amount of players <2, no games should be created

### Additional requirements
#### Story 3 - Friends play together

    As a server
    When I form free for all deathmatches
    Then players who are partied together should be in the same game

    Accept:
       Players with inPartOfPlayer set with the ID of another player, should be in the game with that player

#### Story 4 - Balanced Games

    As a server
    When I form free for all deathmatches
    The games should contain players of similar skill levels

    Accept:
       Games should have the lowest variation possible in player skill levels.
