<?php

include 'connection.php';
$url = "Teste.xml";
$xml = simplexml_load_file($url);

$numOfPlays = $xml['total'];


$numOfPages  = (int)($numOfPlays / 100);
if(($numOfPlays % 100) != 0)
	$numOfPages++;

for ($i=$numOfPages; $i > 0; $i--) 
{ 
	//$urlPage = "https://www.boardgamegeek.com/xmlapi2/plays?username=marcelodgt&page=".$i;
	$urlPage = "Teste.xml";
	$xmlPage = simplexml_load_file($urlPage);
	$numPlaysPerPage = count($xmlPage->play);
	
	
	for ($j=($numPlaysPerPage-1); $j >= 0; $j--) 
	{ 
		
	 	$playId = $xmlPage->play[$j]['id'];
	 	$playDate = $xmlPage->play[$j]['date'];
	 	$playDate=date("Y-m-d",strtotime($playDate));
	 	$playGame = $xmlPage->play[$j]->item["objectid"];
	 	$comments = "";

	 	//Numero de jogadores por partida
	 	$numOfPlayers = count($xmlPage->play[$j]->players->player);
	 	echo "<BR><BR><H1>numero de jogados da partida: </h1>".$numOfPlayers."<br>";
	 	// echo "<br>".$numOfPlays."<BR>";
	 	//Pegar dados de Jogador de Cada Partida
		
		for ($x=0; $x < $numOfPlayers; $x++)
		{
			$a = 0;
			$playerName = $xmlPage->play[$j]->players->player[$x]["name"];
			$playerScore = $xmlPage->play[$j]->players->player[$x]["score"];
			$playerWin = $xmlPage->play[$j]->players->player[$x]["win"];
			$playerRole = $xmlPage->play[$j]->players->player[$x]["color"];
			
			if($playerScore = " ")
			{
				$playerScore = 0;
			}

			//Corrigindo Erro de Colocar Michel ao invés de Yusuke
			if(strcasecmp($playerName, "Michel")==0)
			{
				$playerName = "Yusuke";
			}

			echo "Jogador ".$playerName." - score: ".$playerScore." - win: ".$playerWin." - role: ".$playerRole."<br>";
			// echo "<BR>Jogador: ".$playerName." - Score: ".$playerScore. " - Win: ".$playerWin." - Role: ".$playerRole;

			$playerBggUsername = $xmlPage->play[$j]->players->player[$x]["username"];

			
			//*** - CADASTRAR JOGADOR NO BD - ***

			//Procurar se já tem jogador com Mesmo nome na base de Dados
			$sqlregisterdPlayer = "select * from players where name = '".$playerName."'";
			$oldPlayer = $conn->query($sqlregisterdPlayer);


			//Se já tiver jogador com mesmo nome, fazer update
			if ($oldPlayer->num_rows > 0) 
			{
				while($row = $oldPlayer->fetch_assoc())
				{
					
					
					$sqlOldPlayer = "Update Players set name='".$playerName."', userId='".$playerBggUsername."' where name like '".$playerName."'";

					if (mysqli_query($conn, $sqlOldPlayer)) 
					{
				    		echo "Update <strong>PLAYER</strong> successfully<br />";
					}
					else 
					{
				    		echo "Error: " . $sqlOldPlayer . "<br>" . mysqli_error($conn) ."<BR>";
					}

				}
			}

			//Se não tiver jogador com mesmo nome na base de Dados, inserir novo jogador
			else
			{
				$sqlNewPlayer = "insert into players (name, userId) values ('".$playerName."', '".$playerBggUsername."')";
				if (mysqli_query($conn, $sqlNewPlayer)) 
				{
			    		echo "New <strong>PLAYER</strong> created successfully<br />";
				}
				else 
				{
			    		echo "<BR>Error: " . $sqlNewPlayer . "<br>" . mysqli_error($conn) ."<BR>";
				}

			}

			// **** - CADASTRAR PONTOS PARTIDA NO BD - ****

			//Procurar Id do jogador com o nome
			$sqlPLayerId = "select * from players where name = '".$playerName."'";
			$resultPlayerId = $conn->query($sqlPLayerId);

			if ($resultPlayerId->num_rows > 0) 
			{
				while($row = $resultPlayerId->fetch_assoc())
				{
					$playerBdId = $row['id'];
					echo $playerBdId;
				}
			}
			
			// PROCURAR SE JÁ EXISTE PARTIDA COM AQUELE PLAYID E DAQUELE JOGADOR
			$sqlRegisteredPoints = "select * from points where playerId = ".$playerBdId." and playId = ".$playId;
			$oldPoints = $conn->query($sqlRegisteredPoints);


			echo "<br>---- ERRO -----<br>";
			echo "playerID = ".$playerBdId."<br>";

			//SE TIVER, FAZER UPDATE
			if($oldPoints->num_rows > 0)
			{
				echo "teste de erro<br>";
				while($row = $oldPoints->fetch_assoc())
				{
					echo "<h2> UPDATE PONTOS <BR>";
					echo $x;
					echo "Jogador ".$playerName." - score: ".$playerScore." - win: ".$playerWin." - role: ".$playerRole."<br>";
					$sqlOldPoints = "Update points set playId =".$playId.",playerId=".$playerBdId.
							      ",score='".$playerScore."',role = '".mysql_real_escape_string($playerRole). "', winner = ".$playerWin." where playId = ".$row['playId'];
					if (mysqli_query($conn, $sqlOldPoints)) 
					{
				    		echo "Update <strong>Points</strong> successfully<br />";
					}
					else 
					{
				    		echo "Error: " . $sqlOldPoints . "<br>" . mysqli_error($conn) ."<BR>";
					}
					
				}
			}
			//SE NÃO, INSERIR DADOS DA PARTIDA
			else
			{
				echo $x."<h2> INSERT PONTOS <BR>";
				echo $x;
				echo "Jogador ".$playerName." - score: ".$playerScore." - win: ".$playerWin." - role: ".$playerRole."<br>";
				$sqlNewPoints = "Insert into Points (playId, playerId, score, role, winner ) values (".$playId.",".$playerBdId.",".$playerScore.",'".mysql_real_escape_string($playerRole) ."',".$playerWin.")";
				if (mysqli_query($conn, $sqlNewPoints)) 
				{
			    		echo "New <strong>Points</strong> created successfully<br />";
			    		echo $playId." - ".$playerBdId." - <br>";
				}
				else 
				{
			    		echo "<BR>Error: " . $sqlNewPoints . "<br>" . mysqli_error($conn) ."<BR>";
				}
			}
			
		}
			
		

		//*** - CADASTRAR PARTIDA NO BD - ***
		
		//Procurar se já tem partida com o Id cadastrada no banco
	 	$sqlRegisteredPlay = "select * from plays where playId = ".$playId;

	 	$oldPlay = $conn->query($sqlRegisteredPlay);

	 	//Se já tiver, fazer update
		if($oldPlay->num_rows > 0)
		{
			while($row = $oldPlay->fetch_assoc())
			{
				$sqlOldPlay = "Update plays set gameId =".$playGame.",numberOfPlayers=".$numOfPlayers.
						      ",comments='".$comments."',date = '".$playDate. "' where playId = ".$row['playId'];
				if (mysqli_query($conn, $sqlOldPlay)) 
				{
			    		echo "Update <strong>PLAY</strong> created successfully<br />";
				}
				else 
				{
			    		echo "Error: " . $sqlOldPlay . "<br>" . mysqli_error($conn) ."<BR>";
				}
					
			}
		}
		//Se nao, criar nova Partida
		else
		{
			
			$sqlNewPlay = "Insert into Plays (playId, gameId, numberOfPlayers, comments, date ) values (".$playId.","
						  .$playGame.",".$numOfPlayers.",'".$comments."', '".$playDate."')";
			if (mysqli_query($conn, $sqlNewPlay)) 
			{
		    		echo "New record <strong>PLAY</strong> created successfully<br />";
			}
			else 
			{
		    		echo "<BR>Error: " . $sqlNewPlay . "<br>" . mysqli_error($conn) ."<BR>";
			}
		}

		
		
	 	// echo "Jogo: ".$numOfPlays." Página".$i.": ".$j." - ".$playId." - data: ".$playDate." - jogo: ".$playGame." - n. jogadores: ".$numOfPlayers."<BR>";
	 	
	}
	
}


// for ($i=0; $i < $numOfPlays; $i++) 
// { 

// 	$playId = $xml->play[$i]['id'];
// 	echo $i." - ".$playId."<BR>";
// }
// die;

// 	//pegar Id da partida
// 	$playId = $xml->play['id'];
// 	echo $playId."<br>";
// 	//pegar data da partida
// 	$playDate = $xml->play['date'];
// 	echo $playDate."<br>";
// 	//pegar nome do jogo
// 	$playGame = $xml->play->item["objectid"];
// 	echo $playGame."<br>";
	
// 	//pegar jogadores
// 	$numOfPlayers = count($xml->play->players->player);
// 	echo $numOfPlayers."<br>";

// 	for ($i=0; $i < $numOfPlayers; $i++) { 
// 		$player = $xml->play->players->player[$i]["name"];

// 		echo $player."<br>";
// 	}

// 	//checar se esses jogadores já estão na tabela de jogadores
// 	//senao, inserir
// 	//inserir id dos jogadores, pontuaçao e id da Partida na tabela Points

// 	//$winner
// 	$countWinner = 0;
// 	for ($i=0; $i < $numOfPlayers; $i++) { 

// 		if ($xml->play->players->player[$i]["win"] == 1)
// 		{
// 			$vencedor = $xml->play->players->player[$i]["name"];
// 			$countWinner++;
// 		}
		
// 	}

// 	if ($countWinner == 1)
// 	{
// 		echo "O vencedor foi ".$vencedor;

// 	}
// 	else
// 		{
// 			if($countWinner == $numOfPlayers)
// 			{
// 				echo "Todo mundo ganhou! jogo Cooperativo";
// 			}
// 			if($countWinner == 0)
// 			{
// 				echo "Todo Mundo Perdeu! Jogo Cooperativo";
// 			}
// 		}
	
	
	
// 	// pegar cor ou personagem
// 		$char = $xml->play->players->player[$i]["color"];
// 	// pegar comentários
// 		$comments = $xml->play->$comments;

// 	//pegar username do bgg
// 		$bggUser = $xml->play->$player->player["username"];

//    // Array jogador: nome, usuario, cor, 

?>