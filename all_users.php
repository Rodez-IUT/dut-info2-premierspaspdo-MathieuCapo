<?php 
	$host = 'localhost';
	$db   = 'my-activities';
	$user = 'root';
	$pass = 'root';
	$charset = 'utf8';
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
	
	if(isset($_GET['status_id']) && isset($_GET['user_id']) && isset($_GET['action'])) {
		$action = $_GET['action'];
		$user_id = $_GET['user_id'];
		try {
			$pdo->beginTransaction();
			$stmt = $pdo->prepare('INSERT INTO action_log (action_date, action_name, user_id) 
								VALUES ("'.date("Y-m-d H:i:s").'",?,?)');
			$stmt->execute(["$action","$user_id"]);
			$pdo->commit();
		} catch (Exception $e){
			$pdo->rollBack();
			throw $e;
		}
		try {
			$pdo->beginTransaction();
			$stmt = $pdo->prepare('UPDATE users SET status_id = 3 WHERE id =?');
			$stmt->execute(["$user_id"]);
			$pdo->commit();
		} catch (Exception $e){
			$pdo->rollBack();
			throw $e;
		}
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
					<option value="Waiting for account deletion">Waiting for account deletion</option>
				</select>
				<input type="submit" value="Chercher !"/>
			</form>
		</div>
	</body>


<?php
	
	
	echo "<table border=\"1px\" width=\"100%\">";
	echo "<tr><td>Id</td><td>Username</td><td>Email</td><td>Status</td>";
	$stmt = $pdo->prepare('SELECT users.id, username, email, name
						FROM users 
						JOIN status ON users.status_id = status.id 
						WHERE name LIKE ?
						AND username LIKE ?
						ORDER BY username');
	$stmt->execute([$status, $lettre]);
	while ($row = $stmt->fetch())
	{
		echo "<tr>";
		echo "<td>".$row['id']."</td>";
		echo "<td>".$row['username']."</td>";
		echo "<td>".$row['email']."</td>";
		echo "<td>".$row['name']."</td>";
		if ($row['name'] != "Waiting for account deletion") {
			echo "<td> <a href=all_users.php?status_id=3&user_id=".$row['id']."&action=askDeletion>askDeletion</a> </td>";
		}
		echo "</tr>";
	}
	echo "</table>";
  
?>
</html>