<?php 

//SQL 
include 'connection.php';

$url = 'https://www.boardgamegeek.com/xmlapi2/collection?username=marcelodgt';

$xml = simplexml_load_file($url);
$njogos = $xml['totalitems'];


for ($i=0; $i < $njogos ; $i++) 
{ 
	

	$bggId = $xml->item[$i]["objectid"];
	$gameName = $xml->item[$i]->name;
	$priority = $xml->item[$i]->status['wishlistpriority'];
	$numOfPlays = $xml->item[$i]->numplays;
	if ($xml->item[$i]->status['own'] == 1) {
 		//colecao
 		//oldGame?
		$sql = "select * from Collection where bggId = ".$bggId;
		$OldGame = $conn->query($sql);
		if($OldGame->num_rows > 0)
			{
				while($row = $OldGame->fetch_assoc())
				{
					$sqlUpdateCollection = "Update Collection set gameName='".mysql_real_escape_string($gameName)."', bggId=".$bggId.",numOfPlays=".$numOfPlays." where bggId=".$bggId;
					if (mysqli_query($conn, $sqlUpdateCollection)) {
					    echo "Record <strong>collection</strong> updated successfully<BR>";
					} else {
					    echo "Error updating record: " . mysqli_error($conn)."<BR>";
					}
				}
			}
			
	 		else
	 		{
	 			$sqlColecao = "Insert into Collection (gameName, bggId, numOfPlays) values ('".mysql_real_escape_string($gameName)."','".$bggId."',".$numOfPlays.")";
				if (mysqli_query($conn, $sqlColecao)) {
		    		echo "New record <strong>Collection</strong> created successfully<br />";
				}
				else {
		    		echo "Error: " . $sqlColecao . "<br>" . mysqli_error($conn) ."<BR>";
				}
	 		}
	}
	
	else
	{
		//wishlist

		//oldWish
		$sql = "select * from Wishlist where bggId = ".$bggId;
		$oldWish = $conn->query($sql);

		if($oldWish->num_rows > 0)
		{
			while($row = $oldWish->fetch_assoc())
			{
				$sqlUpdateWishlist = "Update Wishlist set gameName='".mysql_real_escape_string($gameName)."', bggId=".$bggId.", priority=".$priority." where bggId=".$row['bggId'];
				if (mysqli_query($conn, $sqlUpdateWishlist)) {
				    echo "Record updated  <strong>Wishlist</strong> successfully<BR>";
				} else {
				    echo "Error updating record: " . mysqli_error($conn)."<BR>";
				}
			}
		}
		
 		else
 		{
 			$sqlWishlist = "Insert into Wishlist (gameName, bggId,priority) values ('".mysql_real_escape_string($gameName)."','".$bggId."',".$priority.")";
			if (mysqli_query($conn, $sqlWishlist)) {
	    		echo "New record <strong>Wishlist</strong> created successfully<br />";
			}
			else {
	    		echo "Error: " . $sqlWishlist . "<br>" . mysqli_error($conn) ."<BR>";
			}
 		}
	}
}

mysqli_close($conn);

?>