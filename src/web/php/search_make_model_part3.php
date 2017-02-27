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
        <legend><font size = "4"><b>Make and Model search</b></font></legend>
        
        <?php
            $isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');
            if (!$isPost) {
                die( '<span class = "error">ERROR: Please first <a href="search_make_model_part1.php">select</a> a make and model.</error>');
            } else {
                extract( $_POST );
                // get all car which match given model
                $query = "SELECT vin, year, drive_train_id,  trans_serial_number, engine_id, engine_serial_number FROM car WHERE model_id = " . $model_choice;
                $querymodel = "SELECT name FROM model WHERE id = " . $model_choice;
                $querymake = "SELECT name FROM make WHERE id IN (SELECT make_id AS id FROM model WHERE id = " . $model_choice . ")";
                if ( !( $database = mysql_connect( "localhost", "root", "" ) ) )
                    die( "Could not connect to database");
                if ( !mysql_select_db( "car_dealer", $database ) )
                    die( "Could not open car_dealers database");
                if ( !( $result = mysql_query( $query, $database ) ) ) {
                    print( "Could not execute query! " );
                    die( mysql_error());
                }
                if ( !( $makename = mysql_query( $querymodel, $database ) ) ) {
                    print( "Could not execute query! " );
                    die( mysql_error());
                }
                if ( !( $modelname = mysql_query( $querymake, $database ) ) ) {
                    print( "Could not execute query! " );
                    die( mysql_error());
                }
                mysql_close( $database );
                if ((mysql_num_rows($makename) === 0)||(mysql_num_rows($modelname) === 0)) {
                    print("<span class = 'error'>ERROR: the manufacturer or model you searched for is no longer in the database.(<a href='search_make_model_part1.php'>try another?</a>)</span>");
                } else if (mysql_num_rows($result) === 0) {
                    print("<span class = 'error'>Sorry, the database does not have a car of that model. (<a href='search_make_model_part1.php'>start again?</a>)</span>");
                } else {
                    $row = mysql_fetch_row( $modelname );        
                    print("<i>Results for: " . $row[0]);
                    $row = mysql_fetch_row( $makename );
                    print(" " . $row[0] ."</i><br/>");
                    
                    print('<table id="datatable" border="1"><tr>
						<th>VIN</th>
						<th>Year</th>
						<th>Drive Train ID</th>
						<th>Transm. Serial#</th>
						<th>Engine ID</th>						
						<th>Engine Serial#</th>
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
    <p><font size = "2" ><i>Searches for any car of a particular make, then model.</i></p>
</body>
</html>
