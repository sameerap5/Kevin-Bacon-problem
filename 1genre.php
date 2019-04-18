<html>
<body>
<title>My Movie Database (MyMDb)</title>
<style><?php include 'bacon.css';?></style>
<?php

include 'commonpage.php';



$sql2 = "SELECT genre, COUNT(genre) movie_count FROM movies_genres GROUP BY genre HAVING movie_count = (
    SELECT COUNT(genre) c FROM movies_genres GROUP BY genre ORDER BY c DESC LIMIT 1
    )";
	
	$result2 = $conn->query($sql2);
	
	?>
	
 <div id="container2">
            <h2>Movies genres with maximum count</h2>
            <table class="result">
              
                    <tr class="result">
					<th>Index</th>
                        <th>Movie Genre</th>
                        <th>Count</th>
                    </tr>
              
	
	<?php 
	$i=0;
	foreach($conn->query($sql2) as $row) 
	{
		?>
		<tr class="result">
							<td><?php echo (++$i); ?></td>
                            <td><?php echo htmlspecialchars($row['genre']); ?></td>
                            <td><?php echo htmlspecialchars($row['movie_count']); 

	}?></td>
		</tr>
            </table></div>
			</body>
			</html>