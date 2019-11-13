<?php 
	$host = 'localhost';
	$db   = 'my_activities';
	$user = 'root';
	$pass = 'root';
	$charset = 'utf8';
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	
	if (isset($_POST['lettre'])) {
		$lettre = htmlspecialchars($_POST['lettre'])."%";
	} else {
		$lettre='%';
	}
	if (isset($_POST['type'])) {
		$status =htmlspecialchars($_POST['type']);
	} else {
		$status='%';
	}
?>
<html>
	<head>
	
	</head>
	<body>
		<div class="formulaire">
			<form action='all_users.php' method='post'>
				premiere lettre : <input type="text" name="lettre"/>
				status du compte : <select name="type">
					 <option value="Active Account">Active Account</option>
					<option value="Waiting for account validation">Waiting for account validation</option>
				</select>
				<input type="submit" value="Chercher !"/>
			</form>
		</div>
	</body>


<?php
	
	try {
		$pdo = new PDO($dsn, $user, $pass, $options);
	} catch (PDOException $e) {
	   throw new PDOException($e->getMessage(), (int)$e->getCode());
	}
	echo "<table border=\"1px\" width=\"100%\">";
	echo "<tr><td>Id</td><td>Username</td><td>Email</td><td>Status</td>";
	$stmt = $pdo->query("SELECT users.id, username, email, name 
						FROM users 
						JOIN status ON users.status_id = status.id 
						WHERE name LIKE '".$status."'
						AND username LIKE '".$lettre."'
						ORDER BY username 
						");
	$stmt->execute();
	while ($row = $stmt->fetch())
	{
		echo "<tr>";
		echo "<td>".$row['id']."</td>";
		echo "<td>".$row['username']."</td>";
		echo "<td>".$row['email']."</td>";
		echo "<td>".$row['name']."</td>";
		echo "</tr>";
	}
	echo "</table>";
  
?>
</html>