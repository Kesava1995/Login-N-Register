<?php
if($_GET == null)die("Name parameter missing");
else{
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bd0306";
$port = 3306;

$dbuser="";
$dbpass="";
$inputUsername = $_GET['username']; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SELECT statement with a placeholder
$sql = "SELECT * FROM db0306 WHERE username = ?";
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
		$dbem=$row['email'];
		$dbdob=$row['DOB'];
		$dbmob=$row['mob'];
		$dbaem=$row['aem'];
		$dbprefl=$row['preflan'];
		$dbmoto=$row['mot'];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
        header("Location: login.php");
        exit();
}
echo "
<html>
<head>
<title></title>
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
<table>
<caption>USER Details</caption>
<tr><th>Username</th><td>".htmlentities($dbuser)."</td></tr>
<tr><th>Email</th><td>".htmlentities($dbem)."</td></tr>
<tr><th>DOB</th><td>".htmlentities($dbdob)."</td></tr>
<tr><th>Mobile</th><td>".htmlentities($dbmob)."</td></tr>
<tr><th>Alternate Email ID</th><td>".htmlentities($dbaem)."</td></tr>
<tr><th>Preferred Language</th><td>".htmlentities($dbprefl)."</td></tr>
<tr><th>Mother Tongue</th><td>".htmlentities($dbmoto)."</td></tr>
<tr colspan='2'><td style='padding-left:150px;'>    
<form method='POST'>
        <input type='submit'  value='Logout' name='logout'>
</form></td></tr>
</table>
</div>
</body>
</html>
";
}
?>