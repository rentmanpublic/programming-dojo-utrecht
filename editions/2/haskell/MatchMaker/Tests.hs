module Tests(test) where
  import Data.List
  import Test.QuickCheck
  import Test.Hspec
  import ElectHosts
  import BalancingGames
  import Players

  -- A generator for arbitrary (random) Players. To be used in QuickCheck properties (tests).
  instance Arbitrary Player where
    arbitrary = Player <$> arbitrary `suchThat` (> 0) <*> arbitrary `suchThat` (> 0) <*> arbitrary `suchThat` (> 0) <*> arbitrary `suchThat` (> 0) <*> arbitrary

  playersThatCanHost :: Gen Player -> Gen Player
  playersThatCanHost gen = do
    Player pid lat skill part _ <- gen  -- Generate a random player
    return $ Player pid lat skill part True  -- Force canHost to True

  test :: IO ()
  test = hspec $ do
    describe "Story 1 - Electing Hosts" $ do
      it "The first selected hosts should have the lowest latency" $ property $ forAll (listOf $ playersThatCanHost arbitrary) $
        \players ->
          case electHost players of
            [] -> True
            x:_ -> all (\p -> latency x <= latency p) players
      it "Only Players with canHost == true should be selected" $ property$
        \players ->
          case electHost players of
            players -> all (\p -> canHost p) players

    describe "Story 2 - Game sizes" $ do
      it "A game should have max 6 players" $ property $ 
        \players ->
          case balancedGames players of
            games -> all ((<= 6) . length) games
      it "A game should have minimal 2 players" $ property $
        \players ->
          case balancedGames players of
            games -> all ((>= 2) . length) games
      it "When games are created, all players should take part" $ property $
        \players ->
          case balancedGames players of
            [] -> True
            games -> sort (concat games) == (sort players)
      


        
        
