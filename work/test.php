<?php
//connection details
define("DB_SERVER", "127.0.0.1:3306");
define("DB_USER", "root");
define("DB_PASS", "password");
define("DB_NAME", "product_collection");
//connection
$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
mysql_select_db("product_collection",$connection) or die(mysql_error());
$query = mysql_query("SHOW TABLES");
$field = mysql_fetch_assoc($query);
?>
<form action="" method="post">
<div>
Category: <select type="text" name="category">
<?php
while ($field = mysql_fetch_assoc($query)) {
	foreach ($field as $fl) {
?>	<option value="{$fl}"><?php echo $fl;?></option>
<?php
	}
}
?>
</select>
Name:<select type="text" name="sku">
			<?php

			if (!$connection) {
				echo "</br>You can't connect to this Database"; die;
			}
			$db_select = mysql_select_db("product_collection",$connection);
			if (!$db_select) {
				die("Database selection failed !!! ");
			}
			// query
			$sql = 'SELECT * FROM edpa_product_collection LIMIT 25';
			$a = 1;
			mysql_select_db('product_collection');
			$retval = mysql_query( $sql, $connection );
			if(! $retval )
			{
				die('Could not get data: ' . mysql_error());
			}
			// results
			while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
				?>
				<option value="{row['name']}"><?php echo $a,$row['name'];?></option>
				<div><?=$row[1]?></div>
				<?php $a = $a + 1;
			}
			mysql_close($connection);?>
		</select>
		<input type="submit" name="Submit">

	</form>
</div>