<?php
include 'connection.php';


// $testArray = array( array( array()));

// $emptyArray = array(array());  // Creates a 2D array with one empty element in $emptyArray[0]
//     //array_pop($emptyArray);


// // var_dump($testArray);

// var_dump($emptyArray);


$coopGames = array('Escape: The Curse of the Temple', 'Hanabi', 'A Ilha Proibida', 'Masmorra de DADOS', 'Pandemic', 'Samurai Spirit');
$gameName = 'Masmorra de DADOS';

for ($i=0; $i < count($coopGames); $i++) { 
	if(strcmp($coopGames[$i], $gameName)==0)
	{
		if(strcmp($gameName, 'Masmorra de DADOS')==0)
			echo 'Masmorra de Dados tem modo Cooperativo e Competitivo';
		else
			echo 'Jogo Cooperativo';
	}


}
// $teste2 = strcmp($test, $bla);

// var_dump($teste2);


// if($i!=2)
// 		echo 'jogo é cooperativo'
// 	else