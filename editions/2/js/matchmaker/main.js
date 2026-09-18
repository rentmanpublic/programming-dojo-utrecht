import { inspect } from 'node:util';
import { electHost } from './electHosts.js';
import { balancedGames } from './balancingGames.js';
import { defaultPlayers } from './players.js';

const withIndex = (list) => list.map((item, i) => [i + 1, item]);

const prettyPrint = (value) =>
  console.log(inspect(value, { depth: null, colors: true, compact: 3 }));

const printGameInformation = ([index, game]) => {
  process.stdout.write(`Game ${index}: `);
  prettyPrint(game);
  process.stdout.write('With host: ');
  prettyPrint(electHost(game));
};

export const createDeathMatch = () => {
  console.log('Creating a balanced deathmatch\n');
  withIndex(balancedGames(defaultPlayers)).forEach(printGameInformation);
};

createDeathMatch();
