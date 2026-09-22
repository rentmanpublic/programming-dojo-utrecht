# Functional Programming Videogame matchmaking kata
Partly taken from https://github.com/davidwhitney/CodeDojos

This kata is available in three languages, each with its own README and starter code:
[Haskell](haskell/README.md) (the original, described below), [JavaScript](js/README.md) and [PHP](php/README.md).


## Useful sources
- [cheatsheet.hs](cheatsheet.hs)
- https://hoogle.haskell.org/?hoogle=cons&scope=package%3Abase For finding Haskell functions 
- https://www.haskell.org/tutorial/functions.html
- https://www.haskell.org/tutorial/patterns.html
- https://hackage.haskell.org/package/CheatSheet-2.7/src/CheatSheet.pdf

## How to run
There are a couple of easy ways to start coding in Haskell

### Locally

#### Installing
It is recommended to run Haskell locally. As this will allow you to use the repl. 
For running locally, you'll need GHC (compiler) and Cabal (build tool).

1. Get ghcup https://www.haskell.org/ghcup/

*Windows Users* You should choose to install MSys2 and to install desktop shortcuts.
The install will ask if you want to install Stack and Hsl. Stack is not needed for this Kata, HSL could be useful if you use a editor that supports it.
You should use the 'MinGW haskell shell' shortcut on the desktop.

2. Use ghcup to install ghc (the Haskell Compiler) and Cabal (build tool). 
```
ghcup install ghc 9.10.1
ghcup install cabal
ghcup set ghc 9.10.1
```

#### Running
1. Clone this project and go to the root dir.
```
git clone https://github.com/rentmanpublic/programming-dojo-utrecht
cd editions/2/haskell
```
2. To open the project in the repl run:
```
cabal repl
```
3. Run the program using
```
ghci> createDeathMatch
```
or the tests using (they will fail)
```
ghci> test
```

4. Reload file changes and recompile using
```
ghci> :r
```

You can also run individual functions.  
For example to run electHosts (defined in ElectHosts/ElectHosts.hs) with defaultPlayers (defined in Players.hs)
```
ghci> electHosts defaultPlayers
```

The repl can also be used to try out Haskell code and functions. For example:
```
ghci> letters = ['a', 'b', 'c', 'x']
ghci> take 2 letters
ghci> reverse letters
ghci> reverse $ take 2 letters
```

### Web IDE

I have uploaded to project to [codeboard.io](https://codeboard.io/projects/515449). However, I really recommend to use a local development setup as this will allow you to use the repl. Pretty printing is also not available online.


## The Kata

Matchmaking is a common part of online video games.  While reading the changelog for the latest revision of "Halo: The Master Chief Collection" (http://www.polygon.com/2014/12/8/7352941/another-major-update-hits-halo-the-master-chief-collection-for), it became apparent that it's something that can easily go wrong, and has lots of interesting subtleties - and is ripe for the slaying with some traditional TDD.

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
The source code can be found in the MatchMaking dir.

The main code is in [Main.hs](MatchMaker/Main.hs). [Players.hs](MatchMaker/Players.hs) contains the Player and Game data types and a example list of players to test the application with.

For the matchmaking process, [ElectHosts.hs](MatchMaker/ElectHosts.hs) and [BalancingGames.hs](MatchMaker/BalancingGames.hs) is used. 
The goal for this kata is to implement the `electHosts` and `balancedGames` functions. You might need to implement some supporting functions too.

You can run the matchmaking process using the Cabal repl. You can already run `ghci> createDeathMatch` to run the code. 
However, as `electHosts` and `balancedGames` are currently just mock implementations, the generated games will not make much sense.
All players are in the same game and everybody is selected to be host!

#### Tests
[Tests.hs](MatchMaker/Tests.hs) contains [QuickCheck](https://hackage.haskell.org/package/QuickCheck-2.15.0.1/docs/Test-QuickCheck.html) tests for each of the acceptance criteria per story. QuickCheck automatically generates arbitrary (randomized) input of lists of players for the tests.

From the repl you can run `ghci> test` to run these tests. 
The tests are just meant as some extra tooling, understanding or using QuickCheck is not in scope for this Kata (unless you really want to..)


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

