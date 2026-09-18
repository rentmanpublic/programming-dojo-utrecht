import ElectHosts
import Players
import BalancingGames
import Tests
import Test.Hspec
import Text.Pretty.Simple 
import Control.Monad.IO.Class

createDeathMatch :: IO ()
createDeathMatch = do 
  putStrLn "Creating a balanced deathmatch\n"
  mapM_ printGameInformation indexedGames
  where
    indexedGames = withIndex $ balancedGames $ defaultPlayers

withIndex :: [a] -> [(Int, a)]
withIndex a = zip [1..length a] a

printGameInformation :: (Int, Game) -> IO ()
printGameInformation (index, game) = do
    putStr $ "Game " ++ show index ++ ": " 
    prettyPrint game
    putStr "With host: "
    prettyPrint $ electHost game


main :: IO ()
main = createDeathMatch

prettyPrint  :: (MonadIO m, Show a) => a -> m ()
prettyPrint = pPrintOpt CheckColorTty defaultOutputOptionsLightBg {outputOptionsCompact = True, outputOptionsCompactParens = True}
