<?php
$link = mysqli_connect("localhost", "root", "");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Create database if not exists and select
$database="bouunty_g10_test";
$sql_db = "CREATE DATABASE  IF NOT EXISTS  $database ";
mysqli_query($link, $sql_db);
mysqli_select_db($link,$database);
$table_name="formdata";
$table_create="CREATE TABLE IF NOT EXISTS $table_name (
  id INT(11) NOT NULL AUTO_INCREMENT,
  subject VARCHAR(45) DEFAULT NULL,
  user VARCHAR(45) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB";

mysqli_query($link, $table_create);



if(isset($_POST['submit'])){
	$user=$_POST['user'];
	$subject=$_POST['subject'];
	$textarea=$_POST['description'];
	$description=str_replace(PHP_EOL,'<br/>', $textarea);
	
	$insert="insert into $table_name set subject='".$subject."',user='".$user."',description='".$description."' ";
	$ins=mysqli_query($link, $insert);
	if($ins)
	{
		echo '<span style="color:green">Successfully inserted!</span>';
		
		//now you can write code for send email user user the $description filed to send the right formatted text
	}
	else
	{
	  echo '<span style="color:red">Failed to insertion!</span>';
	}


}

?>
<h2>Instead of email i am saving into db and showing in list also, you can sent this in email as well</h2>
<form method="post">
	
<p>name:<input type="text" name="user" required />
<p>subject:<input  type="text"  name="subject" required />
<p>Description:<textarea rows="20" cols="50" name="description" required ></textarea>
<p><input type="submit" name="submit" />
</form>

<table style="width:100%;" border="1">
	<tr>
	<td>S/no.</td>
	<td>User</td>
	<td>Subject</td>
	<td>Description</td>
	</tr>
	<?php
	$sql = "SELECT * FROM $table_name";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	$i=1;
    while($row = mysqli_fetch_assoc($result)) 
	{
       echo "<tr><td>".$i."</td><td>".$row['user']."</td><td>".$row['subject']."</td><td>".$row['description']."</td></tr>";
	  
		
		$i++;
    }
} else {
    echo "<tr><td colspan='4'>0 results</td></tr>";
}
?>	
</table>

<?php 
	// Close connection
mysqli_close($link);
	?>
