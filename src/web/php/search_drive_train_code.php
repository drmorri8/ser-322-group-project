<?xml version = "1.0" encoding = "utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 


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
    <h1>CarDB Query Application</h1>
    <a href="../CarDB.html">home</a>
    <br/><br/>
    
    <fieldset>    
        <legend><font size = "4"><b>Drive-train search</b></font></legend>

        <form method = "post" action = "search_drive_train_code.php">
            <span class = "prompt">Transmission Code:</span>
            <input type = "text" name = "transCode" />
            <input type = "submit" value = "Search" />
        </form>
        <br/>
        
        <?php
            $isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');
            if ($isPost) {                                      
                extract( $_POST );
                // entry was empty				
				if (!$transCode) {
					print("<span class = 'distinct'>No Search value, returning all entries.</span>");
					$query = "SELECT * FROM drive_train";
				} else { 
					$query = "SELECT * FROM drive_train WHERE trans_code = '" . $transCode . "'";
				}
// USERNAME/PASSWORD need to be made standard
				if ( !( $database = mysql_connect( "localhost", "root", "" ) ) )
					die( "Could not connect to database");
				if ( !mysql_select_db( "car_dealer", $database ) )
					die( "Could not open car_dealers database");
				if ( !( $result = mysql_query( $query, $database ) ) ) {
					print( "Could not execute query!" );
					die( mysql_error());
				}                
				mysql_close( $database );
				
				// Check if no results were found:
				if (mysql_num_rows($result) === 0) {
					print("<span class = 'error'>Transmission code, " . $transCode . ", was not found in the database.</span>");
				} else {
					print('<table id="datatable" border="1"><tr>
						<th>Trans. Code</th>
						<th>Trans. Type</th>
						<th>Torque Rating</th>
						<th># Gears</th>
						<th>Manufacturer</th>
					</tr>');
					for ( $counter = 0; $row = mysql_fetch_row( $result ); $counter++ ) {
						print( "<tr>" );
							foreach ( $row as $key => $value )
								print( "<td>$value</td>" );
						print( "</tr>" );
					}
					print('</table>');
                }
                
            }
        ?>
    </fieldset>
    <p><font size = "2" ><i>Searches for a transmission code and returns any entries. Leave search blank to return ALL drive-trains.</i></p>
</body>
</html>
