<?php
include("header.php");
if(!isset($_POST['submit'])){
$host = "spring-2018.cs.utexas.edu";
$user = "weiyi";
$pwd = "A2LQHs~cPZ";
$dbs = "cs329e_weiyi";
$port = "3306";

$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

if (empty($connect))
{
  die("mysqli_connect failed: " . mysqli_connect_error());
}

//print "Connected to ". mysqli_get_host_info($connect) . "<br /><br />\n";

// Get data from a table in the database and print it out

$result = mysqli_query($connect,"SELECT * from items ORDER BY orig_location,category;");

// Display the results table

print <<<TABLE_START
  <table border="1">
    <tr>
      <th>ID</th><th>ITEM</th><th>CATEGORY</th><th>QUANTITY</th><th>CURRENT LOCATION</th><th>CURRENT POSSESSOR</th><th>ORIGINAL LOCATION</th><th>ORIGINAL POSSESSOR</th>
    <tr>
TABLE_START;
while($row = $result->fetch_row())
{
  
  print <<<TABLE_CONTENT
    <tr>
      <td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td>$row[7]</td>
    </tr>
TABLE_CONTENT;
}
print <<<TABLE_END
  </table>
TABLE_END;

$result->free();
//unset($_POST['viewall']);
}
// When a move is made
if(isset($_POST['submit'])){

extract($_POST);
$id = $_POST["id"];
$quantity = $_POST["quantity"];
$location = $_POST["orig_location"];
$possessor = $_POST["orig_possessor"];

// Connect to the MySQL database
$host = "spring-2018.cs.utexas.edu";
$user = "weiyi";
$pwd = "A2LQHs~cPZ";
$dbs = "cs329e_weiyi";
$port = "3306";

$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

if (empty($connect))
{
  die("mysqli_connect failed: " . mysqli_connect_error());
}

//print "Connected to ". mysqli_get_host_info($connect) . "<br /><br />\n";

// Get data from a table in the database and print it out

$table = "items";

mysqli_query($connect, "UPDATE $table SET quantity=$quantity,orig_location='$location',orig_possessor='$possessor' WHERE item_id='$id';");



// Need to delete rows where the item quantity is 0 and the current location and possessor do not match the original location and possessor
// This indicates that the borrowed item has been returned
// Keeps the db from getting cluttered
mysqli_query($connect, "DELETE FROM $table WHERE (quantity=0 AND (current_location != orig_location OR current_possessor != orig_possessor))");


$result = mysqli_query($connect,"SELECT * from items ORDER BY orig_location,category;");

// Display the results table

print <<<TABLE_START
  <table border="1">
    <tr>
      <th>ID</th><th>ITEM</th><th>CATEGORY</th><th>QUANTITY</th><th>CURRENT LOCATION</th><th>CURRENT POSSESSOR</th><th>ORIGINAL LOCATION</th><th>ORIGINAL POSSESSOR</th>
    <tr>
TABLE_START;
while($row = $result->fetch_row())
{
  
  print <<<TABLE_CONTENT
    <tr>
      <td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td>$row[7]</td>
    </tr>
TABLE_CONTENT;
}
print <<<TABLE_END
  </table>
TABLE_END;


$result->free();
//unset($_POST['viewall']);


mysqli_close($connect);

$item_query->free();

}
?>

<!DOCTYPE html>
<html>
<head>
  <title> Modify Item</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<style>body {padding:70px;}</style>
</head>
<body>

<h2>Update Item</h2>

<form id="insert"  method="post"  action="">
  Item ID:<br>
  <input type="text" name="id">
  <br>
  Quantity:<br>
  <input type="number" name="quantity">
  <br>
  Original Location:<br>
  <input type="text" name="orig_location">
  <br>
  Original Possessor:<br>
  <select name="orig_possessor">
<?php

// Connect to the MySQL database
$host = "spring-2018.cs.utexas.edu";
$user = "weiyi";
$pwd = "A2LQHs~cPZ";
$dbs = "cs329e_weiyi";
$port = "3306";

$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

if (empty($connect))
{
  die("mysqli_connect failed: " . mysqli_connect_error());
}

//print "Connected to ". mysqli_get_host_info($connect) . "<br /><br />\n";

// Get data from a table in the database and print it out
/*
$stmt = mysqli_prepare ($connect, "INSERT INTO $table VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param ($stmt, 'ssssd',$id, $last, $first, $major, $gpa);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
*/
$sql = mysqli_query($connect, "SELECT user_id, first_name, last_name FROM users");
while ($row = $sql->fetch_assoc()){
$userid=$row['user_id'];
echo "<option value=\"$userid\">" . $row['last_name'] . ", " . $row['first_name'] . "</option>";
}
mysqli_close($connect);
?>
  </select>
  <br><br>
  <input type="submit" name="submit"  value="Update">
</form> 
</body>
</html>

