-- This is just documentation and not part of the Kata

aFunction :: Int -> String -> String
aFunction number word = "Hello " ++ word ++ " " ++ show number 

patternMatching :: [Int] -> String
patternMatching [] = "empty"
patternMatching list = "non empty list"

alsoPatternMatching :: Int -> String
alsoPatternMatching number | number == 0 = "null"
                           | number > 0 = "Positive"
                           | otherwise = "Negative" 

usingAWhere :: [Int] -> String
usingAWhere list | listLen == 0 = "empty"
                 | otherwise = "Not empty"
  where listLen = length list

listPatternMatching :: [Int] -> String
listPatternMatching [] = "empty"
listPatternMatching (x:xs) = "List head: " ++ show x ++ ". There are " ++ lengthString xs ++ "other items"
  where lengthString list = (show . length) list -- The '.' is the function composition operator https://wiki.haskell.org/Function_composition

filterWithLambda :: [Int] -> [Int]
filterWithLambda list = filter (\i -> i `mod` 2 == 0) list

data SomeData = SomeData {value1 :: Int, value2 :: String} deriving (Show, Eq, Ord)

functionWithRecord :: SomeData -> String
functionWithRecord record = value2 record

functionCreatingRecord :: Int -> String -> SomeData
functionCreatingRecord value1 value2 = (SomeData value1 value2)
