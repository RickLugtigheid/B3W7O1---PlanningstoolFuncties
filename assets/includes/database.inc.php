<?php
    function connect($databaseName){
        $serverName = "127.0.0.1";
        $username = "root";//This is the username for php myadmin
        $password = "mysql";//the default password for ampps/phpmyadmin is mysql
        try{
            //argument 1 is to connect to the server and find the database
            //the second and third is to verify to php myadmin that you are the admin
            $conn = new PDO("mysql:host=$serverName;dbname=$databaseName","$username", "$password");

            //the first Attribute will report it to the webpage if something goes wrong
            //the second trows the error to the catch 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //$conn = $handle->query("SELECT * FROM characters ORDER BY `name`");
            return $conn;
        }catch(PDOException $e){
            //database conection error
            die("[Database error]<br> <br>Error: $e");
        }
    }
    function manipulateDatabase($conn, $type, $args){
        try{
            switch ($type){
                case "get":
                    //we want to select a row in the table
                    if(is_array($args) && $args[0] == "where"){
                        $stmt = $conn->prepare("SELECT * FROM $args[1] WHERE $args[2]=:val");
                        $stmt->bindParam(":val", $args[3]);
                        //now we return the value
                        $stmt->execute();
                        return $stmt;
                    }elseif(is_array($args) && $args[0] == "order"){
                        return $conn->query("SELECT * FROM $args[1] ORDER BY $args[2]");
                    }else{
                        //else we want to get all rows from table
                        return $conn->query("SELECT * FROM $args");
                    }
                break;
                case "insert":
                    //we need an array of args so we check if args is an array
                        //args[0] = tablename && args[1] = columnNames[] && args[2] = valuesToInsert[]
                        //we need 2 arrays of values in args, 1 for column names and 1 for the values to set && they need to be the same length
                    
                        if(is_array($args[1]) && is_array($args[2]) && count($args[1]) == count($args[2])){
                        //to avoid an infinit loop and -1 because a array begins at 0 but count() gives 4
                        $count = count($args[2])-1;
                        
                        //create the strings I need
                        foreach($args[1] as $arg){
                            $colls .= "$arg, ";
                        }
                        for($i = 0; $i <= $count; $i++){
                            $values .= ":value$i, ";
                        }
    
                        $stmt = $conn->prepare("INSERT INTO $args[0] (".substr_replace($colls ,"",-2).") VALUES (".substr_replace($values ,"",-2).")");
    
                        //now bind all parameters
                        for($a = 0; $a <= $count; $a++){$stmt->bindParam(":value$a", $args[2][$a]);}
    
                        //insert row into table
                        $stmt->execute();
                        //echo "inserted";
                    }else{
                        echo "args in  not an array";
                    }
                break;
                case "update":
                    if(is_array($args)){
                        $stmt = $conn->prepare("UPDATE $args[0] SET $args[1]=:val WHERE $args[3]=:is");
                        //now bind the is var
                        $stmt->bindParam(":is", $args[4]);
                        $stmt->bindParam(":val", $args[2]);
                        $stmt->execute();
                        //echo "inserted";
                    }else{
                        echo "args in not an array";
                    }
                break;
                case "delete":
                    //we need an array of args so we check if args is an array
                    if(is_array($args)){
                        //args[0] = table && args[1] = the where condition && args[2] = the parameter to the where condition
                        $stmt = $conn->prepare("DELETE FROM $args[0] WHERE $args[1]=:val");
                        //$stmt->bindParam(":val", $args[2]);
                        $stmt->execute([':val' => "$args[2]"]);
                        var_dump($args);
                    }else{
                        echo "args is not an array";
                    }
                break;
            }
        }catch(Exception $e){
            header("Location: ../../editor.php?type=response&post=error => &message=".$e);
        }
    }
?>