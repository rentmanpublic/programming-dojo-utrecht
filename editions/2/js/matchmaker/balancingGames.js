// Story 2 (and 3 & 4) - Balancing Games

/*
 Implement a function that creates games with min 2 and max 6 players.
 The games should be as balanced as possible, meaning that the deviation of the
 skill levels per group should be as low as possible.
 When the number of total players is < 2, no Games can be created. (duhh)

 A Game is simply an array of Players, so this function returns an array of arrays of Players.

 Some tips:

 You can use array destructuring to get the head and tail of an array,
 the JS equivalent of Haskell's `(x:xs)` pattern:
   const [head, ...tail] = players;
 This is especially powerful in combination with recursive functions.

 You should look into `slice` (the JS take/drop). You might also want to use the `%` (modulo) operator.

 You might want to create additional functions. For example, for sorting by
 skill level and for chunking arrays.

 Remember: stay functional. Do not mutate the input array
 (use `toSorted` instead of `sort`, `slice` instead of `splice`, ...).
*/


/**
 * @param {ReadonlyArray} players
 * @returns {Array<Array>} the list of games
 */
export const balancedGames = (players) => {

	const minimumSize = 2;

	const sortBySkill = (a, b) => a.skill - b.skill;

	const basePlayers = (players) => {
		return players.filter((player) => player.playerId != player.inPartOfPlayer);
	}

	const chunk = (players) => {
		let numberOfGames = players.length / minimumSize
		for (let i = 0; i < numberOfGames; i++) {
			return [
				players.slice(0, minimumSize),
			]
		}
	}


	return (players < 2)
		? []
		: [
			chunk(players)
		];

	// return [[...players]];
};
