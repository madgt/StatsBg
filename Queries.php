<?php
include 'connection.php';


//Monta array com a tabela Players
function playerInfo($conn)
{
	$players = Array();

	$sqlPlayer = "select * from players";
	$result = $conn->query($sqlPlayer);

	if($result->num_rows >0)
	{
		while($row= $result->fetch_assoc())
		{
			$playerName = $row['name'];
			$playerId = $row['id'];
			$players[$playerId] = $playerName;
			
		}
	}

	return $players;
}

//Jogos que cada pessoa já jogou
function wichGame($conn, $id)
{
	$players = playerInfo($conn);
	// for ($i=1; $i <= count($players) ; $i++) 
	// { 
		echo "<br><br>Jogos que ".$players[$id]." jogou: <br>";
		$sqlWichGame = "select distinct c.bggId bg from points pts JOIN players plr ON pts.playerId = plr.id 
						JOIN plays p ON p.playId = pts.playId JOIN collection c ON c.bggId = p.gameId where plr.id = ".$id. " order by bggId";
		$resulWichGame = $conn->query($sqlWichGame);

		if($resulWichGame->num_rows > 0)
		{
			while($row = $resulWichGame->fetch_assoc())
			{
				echo "<br>".$row['bg'];
			}
		}
		else
		{
			echo "Nenhum jogo";
		}
		
	// }	
}

function playerStatsPerGame($conn, $id)
{
	$players = playerInfo($conn);
	$ratio  = 0;
	$totalPlays = 0;
	$totalWins = 0;
	$totalRatio = 0;
	echo "<br><br>Info Jogatinas de ".$players[$id]." em cada jogo: <br>";
	$sqlWinGame = "select distinct c.bggId bg, c.gameName, count(p.playId) Play,
					SUM(IF(pts.winner=1,1,0)) Win
					from points pts JOIN players plr ON pts.playerId = plr.id 
					JOIN plays p ON p.playId = pts.playId 
					JOIN collection c ON c.bggId = p.gameId where plr.id = ".$id."
					group by p.gameId order by bg asc , c.bggId"; 

	$resultWinsPerGame = $conn->query($sqlWinGame);

	if($resultWinsPerGame->num_rows > 0)
	{
		while($row = $resultWinsPerGame->fetch_assoc())
		{
			$totalPlays = $totalPlays + $row['Play'];
			$totalWins = $totalWins + $row['Win'];
			$ratio = $row['Win']/$row['Play'];
			echo "<br>".$row['gameName'].":  # de partidas: ".$row['Play']." - # de vitórias: ".$row['Win']." Ratio Wins/Play: ".round($ratio,2);
		}

		$totalRatio = $totalWins / $totalPlays;
	}

	else
	{
		echo "Nenhuma vitória ou nenhuma partida para esse jogador";
	}
	
	echo "<br> # total de partidas: ".$totalPlays." - # total de vitórias: ".$totalWins." Ratio Wins/Play: ".round($totalRatio,2);
}

function InfoUser($conn, $id)
{
	$players = playerInfo($conn);
	echo "<br><br>Partidas,  de ".$players[$id]." em cada jogo: <br>";
	$sqlPlayerPerGame = "select distinct c.bggId bg, count(p.playId) numberOfPlays from points pts JOIN players plr ON pts.playerId = plr.id 
				   JOIN plays p ON p.playId = pts.playId JOIN collection c ON c.bggId = p.gameId where plr.id = ".$id." group by p.gameId order by bg asc, c.bggId";
	$resultPlaysPerGame = $conn->query($sqlPlayerPerGame);

	if($resultPlaysPerGame->num_rows > 0)
	{
		while($row = $resultPlaysPerGame->fetch_assoc())
		{
			echo "<br>".$row['bg']." - # de jogos: ".$row['numberOfPlays'];
		}
	}
	else
	{
		echo "nenhuma partida para esse jogador";
	}
	
}

function ratioPerGame($conn, $id)
{


}
//var_dump(playerInfo($conn));
playsAndWinsPerGame($conn,2);
// playsPerGame($conn,4);
// winsPerGame($conn,4);

?>
