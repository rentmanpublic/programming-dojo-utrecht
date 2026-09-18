// This is just documentation and not part of the kata.
// It mirrors cheatsheet.hs from the Haskell version, translated to
// idiomatic *functional* JavaScript: pure functions, no mutation.

// aFunction :: Int -> String -> String
const aFunction = (number, word) => `Hello ${word} ${number}`;

// Haskell pattern matching on lists → JS: check length / destructure
const patternMatching = (list) => (list.length === 0 ? 'empty' : 'non empty list');

// Haskell guards → JS: a chain of ternaries (or if/else)
const alsoPatternMatching = (number) =>
  number === 0 ? 'null'
  : number > 0 ? 'Positive'
  : 'Negative';

// Haskell `where` bindings → JS: local consts
const usingLocalBindings = (list) => {
  const listLen = list.length;
  return listLen === 0 ? 'empty' : 'Not empty';
};

// Haskell `(x:xs)` head/tail pattern → JS: array destructuring with rest
const listPatternMatching = (list) => {
  if (list.length === 0) return 'empty';
  const [x, ...xs] = list;
  return `List head: ${x}. There are ${xs.length} other items`;
};

// filter with an anonymous (arrow) function
const filterWithLambda = (list) => list.filter((i) => i % 2 === 0);

// Haskell records → JS: frozen plain objects (immutability!)
const someData = (value1, value2) => Object.freeze({ value1, value2 });

const functionWithRecord = (record) => record.value2;

// "Updating" a record → create a copy with spread, never mutate
const withValue1 = (record, value1) => Object.freeze({ ...record, value1 });

// Function composition (Haskell's `.` operator)
const compose = (f, g) => (x) => f(g(x));
const shownLength = compose(String, (list) => list.length);

// Useful non-mutating array methods for this kata:
//   list.toSorted(cmp)      sort a *copy* (never use .sort() — it mutates!)
//   list.slice(0, n)        Haskell's `take n`
//   list.slice(n)           Haskell's `drop n`
//   list.filter(f)          Haskell's `filter`
//   list.map(f)             Haskell's `map`
//   list.flat()             Haskell's `concat`
//   list.reduce(f, init)    Haskell's `foldl`
//   list.every(f) / list.some(f)   Haskell's `all` / `any`
