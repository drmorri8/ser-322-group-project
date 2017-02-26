
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 

<!-- carsearchform.php -->
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
	<title>Form Validation</title>
	<style type = "text/css">
		body { font-family: arial, sans-serif }
		div { font-size: 10pt;
		text-align: center }
		table { border: 0 }
		td { padding-top: 2px;
		padding-bottom: 2px;
		padding-left: 10px;
		padding-right: 10px }
		.error { color: red }
		.distinct { color: blue }
	</style>
</head>
<body>
	<?php
		extract( $_POST );
		
	?><!-- end PHP script --> 
	
	<h1>CarDB Query Application</h1>
	<a href="/car-db.html">home</a>
	<br/><br/>
	
	<fieldset>	
		<legend><font size = "4"><b>Car search</b></font></legend>
		
		<!-- "Request" Query Code goes in this field: --> 
		<form method = "post" action = "car-search.php">
			<span class = "prompt">
				Enter car name:<br/>
			</span>
			<input type = "text" name = "carname" /><br/>
			<input type = "submit" value = "Search" />
		</form>
		<br/>
		
		<!-- TESTING. If the server is processing PHP, the second line will print: -->
		TEST FOR PHP PROCESSING:
		<?php echo "<p>THIS IS A SUCCESSFUL TEST FOR PHP PROCESSING</p>"; ?>
		
		<!-- "Return" data from DB goes in this field: -->
		<table id="datatable" border="1">
		</table>
	</fieldset>
</body>
</html>