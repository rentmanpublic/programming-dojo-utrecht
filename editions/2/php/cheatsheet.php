<?php

declare(strict_types=1);

// This is just documentation and not part of the kata.
// It mirrors cheatsheet.hs from the Haskell version, translated to
// idiomatic *functional* PHP: pure functions, no mutation.

// aFunction :: Int -> String -> String
$aFunction = fn (int $number, string $word): string => "Hello {$word} {$number}";

// Haskell pattern matching on lists → PHP: check with `match` or a ternary
$patternMatching = fn (array $list): string => $list === [] ? 'empty' : 'non empty list';

// Haskell guards → PHP: a `match (true)` expression
$alsoPatternMatching = fn (int $number): string => match (true) {
    $number === 0 => 'null',
    $number > 0 => 'Positive',
    default => 'Negative',
};

// Haskell `where` bindings → PHP: local variables in a regular function
function usingLocalBindings(array $list): string
{
    $listLen = count($list);

    return $listLen === 0 ? 'empty' : 'Not empty';
}

// Haskell `(x:xs)` head/tail pattern → PHP: destructure the head, array_slice for the tail
function listPatternMatching(array $list): string
{
    if ($list === []) {
        return 'empty';
    }
    [$x] = $list;
    $xs = array_slice($list, 1);

    return "List head: {$x}. There are " . count($xs) . ' other items';
}

// filter with an anonymous (arrow) function.
// Beware: array_filter keeps the keys → wrap in array_values to get a clean list again.
$filterWithLambda = fn (array $list): array => array_values(array_filter($list, fn (int $i): bool => $i % 2 === 0));

// Haskell records → PHP: readonly classes (immutability!)
final readonly class SomeData
{
    public function __construct(public int $value1, public int $value2)
    {
    }

    // "Updating" a record → return a copy with the change, never mutate
    public function withValue1(int $value1): self
    {
        return new self($value1, $this->value2);
    }
}

$functionWithRecord = fn (SomeData $record): int => $record->value2;

// Function composition (Haskell's `.` operator)
$compose = fn (callable $f, callable $g): callable => fn (mixed $x): mixed => $f($g($x));
$shownLength = $compose(strval(...), count(...)); // `strval(...)` is the first-class callable syntax (PHP 8.1+)

// Useful array functions for this kata (PHP arrays are *values*: passing one to a
// function gives that function a copy, so these all leave the original untouched):
//   array_slice($list, 0, $n)        Haskell's `take n`
//   array_slice($list, $n)           Haskell's `drop n`
//   array_filter($list, $f)          Haskell's `filter`  (wrap in array_values!)
//   array_map($f, $list)             Haskell's `map`
//   array_merge(...$lists)           Haskell's `concat`
//   array_reduce($list, $f, $init)   Haskell's `foldl`
//   array_chunk($list, $n)           split into chunks of n
//   array_sum($list)                 Haskell's `sum`
//   sortedBy($list, $cmp)            sort a *copy* (defined in electHosts.php — `usort` sorts in place!)
//   array_all / array_any            Haskell's `all` / `any` (PHP 8.4+; on older PHP use array_reduce)
//   $a <=> $b                        the "spaceship" comparison operator: -1, 0 or 1 — handy in comparators
