<?php 
/**
 * Coinmate Class 
 *
 * @author Omar Faruque (ronymaha@gmail.com) 
 */

 if(!class_exists('Coinmate')){
    class Coinmate{

        /**
         * Process message from one user to another user 
         * 
         * @param string $conn
         * @param array $data
         */
        public static function submit_coinmate_message($conn, $data = array()){
            
                                $query = "CREATE TABLE IF NO EXIST (
                                        ID int(11) AUTO_INCREMENT,
                                        EMAIL varchar(255) NOT NULL,
                                        PASSWORD varchar(255) NOT NULL,
                                        PERMISSION_LEVEL int,
                                        APPLICATION_COMPLETED int,
                                        APPLICATION_IN_PROGRESS int,
                                        PRIMARY KEY  (ID)
                                        )";
                                $result = mysqli_query($dbConnection, $query);
        }
    }
 }
