module BalancingGames where
  import Players
  import Data.List

  {-
   Implement a function that creates games with min 2 and max 6 players.
   The games should be as balanced as possible, meaning that the deviation of the skill levels per group should be as low as possible.
   When number of total players is < 2, no Games can be created.

   Game is a type alias for [Player]

   Some Tips:

   You can use function patterns to get the head and tail of an array. For example the functions head an tail:
    head (x:xs) = x
    tail (x:xs) = xs
   This is especially powerful in combination with recursive functions 

   You should look into the functions take and drop. You might also want to use mod.
   
   You might want to create additional functions. For example for sorting by skill level and for chunking lists.
   -}
  balancedGames :: [Player] -> [Game]
  balancedGames players = [players] -- todo replace this mock implementation with a real one.
