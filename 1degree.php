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
if(($op->num_rows) > 0){
//if($conn->query("SELECT * FROM actors WHERE (first_name='$firstname' AND last_name='$lastname')")->num_rows > 0){	
	//1_degree query
/*	$sql= "SELECT id, name, year from movies WHERE id IN (
			SELECT movie_id FROM roles WHERE roles.actor_id IN (
				SELECT B.id FROM actors B WHERE ( B.first_name = 'Kevin' AND B.last_name = 'Bacon' )
				UNION
				SELECT C.id FROM actors C WHERE ( C.first_name = '$firstname' AND C.last_name = '$lastname' )
			)
			GROUP BY movie_id
			HAVING COUNT(roles.movie_id) > 1)
			ORDER BY year DESC, name ASC"; */
			
	$sql = 	"SELECT id, name, year from movies WHERE id IN (
			SELECT movie_id FROM roles WHERE (roles.actor_id = '".$actor1['id']."' OR roles.actor_id = '".$actor2['id']."')
			GROUP BY movie_id
			HAVING COUNT(roles.movie_id) > 1)
			ORDER BY year DESC, name ASC";	

	$result = $conn->query($sql);

	if ($result->num_rows >0)
	{ ?>
		<div id="container">
			<!-- <h2>Results for <?php //echo $_POST["input_firstname"]." ".$_POST["input_lastname"]?>: -->
			<h2>Results for <?php echo $actor2['first_name']." ".$actor2['last_name']?>:
			</h2>
			<table class = "result">
				<tr class ="result">
					<th>#</th>
					<th>Title</th>
					<th>Year</th>
				</tr>
				
		<!-- output data of each row -->
		<?php 
		$i=0;
		while($row = $result->fetch_assoc())		
		{ 
			
	?>
				<tr class ="result">
				<td><?php echo ($i+1); ?></td>
				<td><?php echo htmlspecialchars($row['name']); ?></td>
				<td><?php echo htmlspecialchars($row['year']) ?></td>
				</tr>
			</table>
		</div>
		<?php		
	   }
	}
	else
	{
		echo "<br>";
		//echo "${firstname} ${lastname} wasn't in any films with Kevin Bacon.";
		echo $actor2['first_name']." ".$actor2['last_name']." wasn't in any films with Kevin Bacon.";
	}
}
else{
	echo "<br/> ${firstname} ${lastname} does not exist";
}

?>

</body>
</html>