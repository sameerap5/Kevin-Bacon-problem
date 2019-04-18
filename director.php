<html>
<body>
<title>My Movie Database (MyMDb)</title>
<style><?php include 'bacon.css';?></style>
<?php

include 'commonpage.php';



$sql4 = "SELECT actors.first_name, actors.last_name
FROM actors
INNER JOIN directors ON actors.first_name = directors.first_name AND actors.last_name = directors.last_name";
	
	//$result4 = $conn->query($sql4);
	
	?>
	
 <div id="container2">
            <h2>Actors who also directed a movie</h2>
            <table class ="result">
                
                    <tr class="result">
						<th>Index</th>
                        <th>First name</th>
                        <th>Last name</th>
                    </tr>
                
     
	<?php
	$i=0;
	foreach($conn->query($sql4) as $row) 
	{
		?>
		<tr class="result">
							<td><?php echo (++$i); ?></td>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_name']); 

	}?></td>
		</tr>
            </table></div>
			</body>
			</html>