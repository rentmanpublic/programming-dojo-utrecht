module Players where

  data Player = Player {playerId :: Int, latency :: Int, skill :: Int, inPartOfPlayer :: Int, canHost :: Bool }
    deriving(Show, Eq, Ord)

  type ElectedPlayer = Maybe Player

  type Game = [Player]

  defaultPlayers :: [Player]
  defaultPlayers = [ Player i (latencies !! i) (skills !! i) (inParts !! i) (canHosts !! i) | i <- [0..29] ]
    where
      latencies = cycle [50, 100, 150, 200, 75, 125]
      skills = cycle [20, 40, 60, 80, 100, 10]
      inParts = cycle [0, 1, 2, 3, 4, 5]
      canHosts = cycle [True, False]

