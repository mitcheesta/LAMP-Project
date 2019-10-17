<!--Name: dbOperations.php from Project1 for INFO3106
	Author: Michelle Estanol
	Purpose: Provides functions for connecting to and disconnecting from DB.
-->
<?php
/*  Purpose: To create a database connection.
    Pre-condition: Takes in 4 string parameters: the host name, the database name, the user name, and the database password  
    Post-condition: Returns a database connection object.
*/
function connectToDB($host, $user, $pw, $db){ //DBHOST, DBUSER, DBPW, DBDB);
    //new mysqli connection
    $db_conn = new mysqli($host, $user, $pw, $db);

    //check that connection was successful
    if($db_conn->connect_errno){
        die("Could not connect to database server." .$host ."\n Error:"
            .$db_conn->connect_errno
            ."\n Details: ".$db_conn->connect_error."\n");
    }
    return $db_conn;
}

/*  Purpose: To close a database connection.
    Pre-condition: Takes in a database connection object.
*/
function disconnectFromDB($db_conn){
    $db_conn->close();
}

?>