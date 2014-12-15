<?php 
$result = get_persons_from_contest();
//var_dump($result);
function get_persons_from_contest(){
  $dbh=getdbh();
  $stmt = "SELECT * FROM  `t_contest` LIMIT 0 , 10";  
  $sql=$dbh->prepare($stmt);
  $sql->execute();  
  $result=$sql->fetchAll(PDO::FETCH_ASSOC); 
  return $result;
}

function getdbh(){
  $dbh = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
  return $dbh;
}
 ?>

<link rel="stylesheet" href="http://localhost/blog/web/bootstrap.min.css">
<table class="table table-bordered">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
	</tr>
	<?php foreach ($result as $row) { ?>
		<tr>
			<td><?= $row['Submission_ID']?></td>
			<td><?= $row['Name']?></td>
			<td><?= $row['Email']?></td>
		</tr>
	<?php } ?>
	
</table>
