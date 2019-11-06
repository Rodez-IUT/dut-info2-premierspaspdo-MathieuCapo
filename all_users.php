<?php 
	$host = 'localhost';
	$db   = 'my_activities';
	$user = 'root';
	$pass = 'root';
	$charset = 'utf8';
	$port =8080;
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	try {
		$pdo = new PDO($dsn, $user, $pass, $options);
	} catch (PDOException $e) {
	   throw new PDOException($e->getMessage(), (int)$e->getCode());
	}
	echo "<table border=\"1px\" width=\"100%\">";
	echo "<tr><td>Id</td><td>Username</td><td>Email</td><td>status</td>";
	$stmt = $pdo->query('SELECT * FROM users ORDER BY username');
	$stmt->execute();
	while ($row = $stmt->fetch())
	{
		echo "<tr>";
		echo "<td>".$row['id']."</td>";
		echo "<td>".$row['username']."</td>";
		echo "<td>".$row['email']."</td>";
		echo "<td>".$row['status_id']."</td>"; // faut que ça corresponde au status dans l'autre table ( pas au nombre)
		echo "</tr>";
	}
	echo "</table>";
  
?>