# Functional Programming Videogame matchmaking kata (PHP variant)

Partly taken from https://github.com/davidwhitney/CodeDojos

The challenge is exactly the same — but you solve it in PHP, in a *functional* style:
pure functions, no mutation, no loops with reassignment (prefer `array_map`/`array_filter`/`array_reduce`/recursion).

## Useful sources
- [cheatsheet.php](cheatsheet.php)
- https://www.php.net/manual/en/ref.array.php — the array functions (`array_map`, `array_filter`, `array_reduce`, `array_slice`, `array_chunk`, `array_merge`, ...)
- https://www.php.net/manual/en/functions.arrow.php — arrow functions (`fn (...) => ...`)
- https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.readonly — readonly classes, the PHP way to get immutable records
- https://github.com/hemanth/functional-programming-jargon — FP concepts explained

## How to run

You'll need PHP 8.2 or newer and [Composer](https://getcomposer.org/). Check with `php --version` and `composer --version`.

1. Clone/open this project and go to the root dir, then install the single dev dependency (PHPUnit, for the tests):
```
git clone https://github.com/rentmanpublic/programming-dojo-utrecht
cd editions/2/php
composer install
```

2. Run the program:
```
composer start
```

3. Run the tests (they will fail):
```
composer test
```

You can also run individual functions in the interactive PHP shell.
For example to run `electHost` (defined in matchmaker/electHosts.php) with `defaultPlayers` (defined in matchmaker/Player.php):
```
$ php -a
php > require 'vendor/autoload.php';
php > print_r(MatchMaker\electHost(MatchMaker\defaultPlayers()));
```

The shell can also be used to try out PHP code and functions. For example:
```
php > $letters = ['a', 'b', 'c', 'x'];
php > print_r(array_slice($letters, 0, 2));
php > print_r(array_reverse($letters));
php > print_r(array_reverse(array_slice($letters, 0, 2)));
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

The main code is in [main.php](matchmaker/main.php). [Player.php](matchmaker/Player.php) contains the readonly Player class, the Game concept (a Game is simply an array of Players) and an example list of players to test the application with.

For the matchmaking process, [electHosts.php](matchmaker/electHosts.php) and [balancingGames.php](matchmaker/balancingGames.php) is used.
The goal for this kata is to implement the `electHost` and `balancedGames` functions. You might need to implement some supporting functions too.

You can already run `composer start` to run the code.
However, as `electHost` and `balancedGames` are currently just mock implementations, the generated games will not make much sense.
All players are in the same game and everybody is selected to be host!

**House rule:** keep it functional. No mutation (`Player` is a readonly class for a reason), no `usort`/`array_push`/`array_splice`/`array_pop` on existing arrays — use `sortedBy` (see electHosts.php), `array_slice`, `array_merge`, `array_map`, `array_filter`, `array_reduce` and recursion instead. PHP arrays are values, so passing an array to a function gives it a copy: as long as a function only returns new arrays, the caller's data stays untouched.

#### Tests
[tests/MatchMakerTest.php](tests/MatchMakerTest.php) contains [PHPUnit](https://phpunit.de) property-based tests for each of the acceptance criteria per story — the PHP equivalent of QuickCheck. Every property is checked against 100 randomly generated lists of players, and the first counterexample is reported.

Run `composer test` to run these tests.
The tests are just meant as some extra tooling, understanding the generators is not in scope for this kata (unless you really want to..)

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
