<html>
<body>
<title>My Movie Database (MyMDb)</title>
<style><?php include 'bacon.css';?></style>
<?php

include 'commonpage.php';

$firstname= $_POST["input_firstname"];
$lastname= $_POST["input_lastname"]; 

$op = $conn->query("Select * from actors where last_name = 'Bacon' AND first_name LIKE 'Kevin%' Order By film_count DESC, id ASC Limit 1;");
$actor1 = $op->fetch_assoc();
unset($op);
$op = $conn->query("Select * from actors where last_name = '$lastname' AND first_name LIKE '$firstname%' Order By film_count DESC, id ASC Limit 1;");
$actor2 = $op->fetch_assoc();

//A check for the existence of the actor in the database
if($op->num_rows > 0){
	//1_degree query
	$sql_1degree = 	"SELECT id, name, year from movies WHERE id IN (
			SELECT movie_id FROM roles WHERE (roles.actor_id = '".$actor1['id']."' OR roles.actor_id = '".$actor2['id']."')
			GROUP BY movie_id
			HAVING COUNT(roles.movie_id) > 1)
			ORDER BY year DESC, name ASC";
			
	//2_degree query
$sql5 = "SELECT T1.actor_id, T2.f_name, T2.l_name
FROM
(SELECT DISTINCT r_actor12.actor_id, a_actor12.first_name, a_actor12.last_name, r_actor12.movie_id FROM roles r_actor12, actors a_actor12
WHERE
              r_actor12.movie_id IN (SELECT DISTINCT r_actor1.movie_id FROM roles r_actor1 WHERE r_actor1.actor_id = '".$actor1['id']."')
AND
    r_actor12.actor_id <> '".$actor1['id']."'
AND
             a_actor12.id = r_actor12.actor_id)
AS T1
INNER JOIN
(SELECT DISTINCT r_actor23.actor_id, a_actor23.first_name AS f_name, a_actor23.last_name AS l_name, r_actor23.movie_id FROM roles r_actor23, actors a_actor23
WHERE   
    r_actor23.movie_id IN (SELECT DISTINCT r_actor3.movie_id FROM roles r_actor3 WHERE r_actor3.actor_id = '".$actor2['id']."')  
              AND
    r_actor23.actor_id <> '".$actor2['id']."'
AND
a_actor23.id = r_actor23.actor_id)
AS T2
ON (T1.actor_id = T2.actor_id)";

$check_1deg = $conn->query($sql_1degree);	
if($check_1deg->num_rows >0){
	echo "<br/><b>".$actor2['first_name']." ".$actor2['last_name']."</b> is already related to <b>".$actor1['first_name']." ".$actor1['last_name']."</b> with 1 degree";
}
else{
	$result5 = $conn->query($sql5);
	if($result5->num_rows < 1){
		echo"<br/><b>".$actor2['first_name']." ".$actor2['last_name']."</b> is not related to <b>".$actor1['first_name']." ".$actor1['last_name']."</b> with 2 degree";
	}
	else{
	?>
	
 <div id="container2">
            <h2>Actors serving as common link between <?php echo $actor1['first_name']." ".$actor1['last_name']." and ".$actor2['first_name']." ".$actor2['last_name']?>: </h2>
            <table class="result">
                    <tr class="result">
					<th>Index</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                    </tr>
			
	<?php 
$i=0; 
	foreach($result5 as $row)
	
	{
	
		?>
		<tr class ="result">
			<td><?php echo (++$i); ?></td>
                        <td><?php echo htmlspecialchars($row['f_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['l_name']);

	}
}
}
}	
else{
	echo "<br/> ${firstname} ${lastname} does not exist";
}
?>
</td>
		</tr>
            </table></div>
			</body>
			</html>