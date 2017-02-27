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
        <legend><font size = "4"><b>Mile per gallon search</b></font></legend>
        <form method = "post" action = "search_mpg_range.php">
            <span class = "prompt">MPG range:</span>
            <select name="mpg_range">
				<option value="mpg < 20">Under 20mpg</option>
				<option value="mpg BETWEEN 20 AND 30">20-30mpg</option>
				<option value="mpg >= 30">Over 30mpg</option>
			</select>
            <input type = "submit" value = "Search" />
        </form>
        <br/>
        
        <?php
            $isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');
            if ($isPost) {
                extract( $_POST );
                $query = "SELECT mpg, name as make_name, model_name, year, vin FROM make NATURAL JOIN (SELECT vin, make_id as id, name as model_name, year, mpg FROM model NATURAL JOIN (SELECT vin, model_id as id, year, mpg FROM car NATURAL JOIN performance_spec WHERE " . $mpg_range . ") AS car_model_mpg)AS car_model_make_mpg";
// USERNAME/PASSWORD needs to be made standard
                if ( !( $database = mysql_connect( "localhost", "root", "" ) ) )
                    die( "Could not connect to database");
                if ( !mysql_select_db( "car_dealer", $database ) )
                    die( "Could not open car_dealers database");
                if ( !( $result = mysql_query( $query, $database ) ) ) {
                    print( "Could not execute query! " );
                    die( mysql_error());
                }                
                mysql_close( $database );
                
                // Check if no results were found:
                if (mysql_num_rows($result) === 0) {
                    print("<span class = 'error'>Sorry, no cars of that range are currently in the database.");
                } else {
					print('<table id="datatable" border="1"><tr><th>MPG</th><th>Make</th><th>Model</th><th>Year</th><th>VIN</th></tr>');
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
    <p><font size = "2" ><i>Searches for any specific cars within a mpg range. If found, also determines the make and model.</i></p>
</body>
</html>
