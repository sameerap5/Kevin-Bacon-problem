<html>
<body>
<title>My Movie Database (MyMDb)</title>
<style><?php include 'bacon.css';?></style>
<?php

include 'commonpage.php';

$inputgenre= $_POST["input_genre"];

$moviecheck= $conn->query("SELECT * FROM movies_genres WHERE (genre='$inputgenre')");


if($moviecheck->num_rows > 0){
	
$sql3 = "SELECT a1.first_name, a1.last_name, a1.film_count, r1.actor_id, COUNT(r1.actor_id) count_genre
FROM actors a1, roles r1, movies_genres mg1
WHERE a1.id = r1.actor_id AND r1.movie_id = mg1.movie_id AND mg1.genre = '$inputgenre'
GROUP BY r1.actor_id
HAVING count_genre =
(SELECT COUNT(r2.actor_id) c2
FROM roles r2, movies_genres mg2
WHERE r2.movie_id = mg2.movie_id AND mg2.genre = '$inputgenre'
GROUP BY r2.actor_id
ORDER BY c2 DESC LIMIT 1)";
	
	//$result3 = $conn->query($sql3);
	
	?>
	
 <div id="container2">
            <h2>Actors with maximum number of movies in <?php echo $_POST["input_genre"] ?> genre: </h2>
            <table class="result">
               
                    <tr class= "result">
					<th>Index</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                </thead>
	<?php 
	$i=0;
	foreach($conn->query($sql3) as $row)
	{
		?>
		<tr class="result">
							<td><?php echo (++$i); ?></td>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_name']); 

	}
}	
else{
	echo "<br/> Genre does not exist";
}
?></td>
		</tr>
            </table></div>
			</body>
			</html>