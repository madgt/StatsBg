<!DOCTYPE html>
<?php 
include 'connection.php';?>

<html>
<head>
	<title>Jogos</title>
</head>
<body>
	<h1>Jogos de tabuleiro</h1>
	<h2>Coleção</h2>
	<ul>
		<?php 
			

			$buscaColeção = "Select * from Collection";

			$result = $conn->query($buscaColeção);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
			         echo "<li>".$row["gameName"]."</li>";
			     }
			 }
			  else {
			     echo "Sem jogos na coleçao";
			 }
			
					?>
	</ul>
	<h2>Wishlist</h2>
	<ul>
		<?php 
			$buscaWishlist = "select w.gameName, p.description from wishlist w, priority p where w.priority = p.id order by w.priority
";

			$topWishlist = $conn->query($buscaWishlist);

			if($topWishlist->num_rows > 0)
			{
				while($row = $topWishlist->fetch_assoc())
				{
					echo "<li>".$row["gameName"]." (".$row["description"].")</li>";
				}
			}
			else
				echo "<h3>Não tá querendo comprar nenhum joguinho?!</h3>"
		?>
	</ul>


	<?php mysqli_close($conn); ?>
</body>
</html>