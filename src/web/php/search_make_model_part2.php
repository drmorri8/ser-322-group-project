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
                die( '<span class = "error">ERROR: Please first <a href="search_make_model_part1.php">select</a> a car manufacturer.</error>');
            } else {
                extract( $_POST );
                // get all model which match given make_id
                $query = "SELECT * FROM model WHERE make_id = " . $make_choice;
                $querymake = "SELECT name FROM make WHERE id = " . $make_choice;
                if ( !( $database = mysql_connect( "localhost", "root", "" ) ) )
                    die( "Could not connect to database");
                if ( !mysql_select_db( "car_dealer", $database ) )
                    die( "Could not open car_dealers database");
                if ( !( $result = mysql_query( $query, $database ) ) ) {
                    print( "Could not execute query!" );
                    die( mysql_error());
                }
                if ( !( $makename = mysql_query( $querymake, $database ) ) ) {
                    print( "Could not execute query!" );
                    die( mysql_error());
                }
                mysql_close( $database );
                if (mysql_num_rows($makename) === 0) {
                    print("<span class = 'error'>ERROR: The manufacturer you searched is not in the database.(<a href='search_make_model_part1.php'>try another?</a>)</span>");
                } else if (mysql_num_rows($result) === 0) {
                    print("<span class = 'error'>Sorry, the database returned no model for that manufactuer. (<a href='search_make_model_part1.php'>try another?</a>)</span>");
                } else {
                    $row = mysql_fetch_row( $makename );
                    print('<i>Selected: ' . $row[0] . "</i></br>");
                    
                    print('<form method = "post" action = "search_make_model_part3.php">Select a model from the database: <select name="model_choice">');
                    for ( $counter = 0; $row = mysql_fetch_row( $result ); $counter++ ) {
                        print( "<option value = " . $row[0] . ">" . $row[2] . "</option>");
                    }
                    print('</select><input type = "submit" value = "Continue" /></form>');
                }
            }
        ?>
    </fieldset>
    <p><font size = "2" ><i>Searches for any car of a particular make, then model.</i></p>
</body>
</html>