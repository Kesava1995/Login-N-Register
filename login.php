<?php
$mess="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if(empty($_POST['username']) or empty($_POST['password']))$mess= "User name and password are required";
else{
$p1=$_POST['password'];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bd0306";
$port = 3306;

$dbuser="";
$dbpass="";
$inputUsername = $_POST['username']; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SELECT statement with a placeholder
$sql = "SELECT username, pass FROM db0306 WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter (s = string)
$stmt->bind_param("s", $inputUsername);

// Execute
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch and output rows
    while ($row = $result->fetch_assoc()) {
        $dbuser=htmlentities($row['username']);
		$dbpass=$row['pass'];
    }
} else {
    $mess= "No user found.";
}



if(!password_verify($p1, $dbpass))$mess="Incorrect password";
else{
    header("Location: account.php?username=" . urlencode($_POST['username']));
    exit();
}
// Close statement and connection
$stmt->close();
$conn->close();
}
}
?>
<html>
<head>
<title>Login</title>
<style>
body{
	background-color:pink;
	justify-content: center;
	align-items: center;
	display: flex;
}
div{
	background-color:white;
	border:2px solid red;
	text-align:center;
	font-size:30px;
	padding: 20px;
}
</style>
</head>
<body>
<div>
<form method="POST" action="login.php">
<h1>Log In</h1>
<p style="color:red;">
<?php
if (isset($mess)) {
    echo htmlentities($mess);
}
?>
</p>
<table>
<tr>
<td>
<label for="who">Username</label></td><td>
<input type="text"  name="username" value="<?= htmlentities($_POST['username'] ?? '') ?>"></td></tr><br>
<tr><td>
<label for="#2">Password</label></td><td>
<input type="password" name="password"></td></tr><br>
<tr><td style="padding-left:50px;">
<input type="submit" value="Log In"></td><td style="padding-left:30px;">
<input type="reset" value="Cancel"></td></tr>
</form>
</div>
</body>
</html>