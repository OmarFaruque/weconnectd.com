<?php 
/**
 * Coinmate Class 
 *
 * @author Omar Faruque (ronymaha@gmail.com) 
 */

 if(!class_exists('Coinmate')){
    class Coinmate{

        var $conn;
        var $table = 'coinmate_messages';
        var $users_table = 'users';
        var $usermeta_table = 'user_meta';
        var $user_id;

        public function __construct($conn){
            $this->conn = $conn;
            $this->_init();
        }


        /**
         * Get login user information 
         */
        public function get_user(){
            $qry = $this->conn->prepare("SELECT *, u.`id` as id FROM {$this->users_table} u LEFT JOIN {$this->usermeta_table} m ON m.`user_id`=u.`id` WHERE u.`id`=?");
            $qry->bind_param("d", $this->user_id);
            $qry->execute();
            $items = $qry->get_result();
            $items = $items->fetch_assoc();
            
            return $items;
        }


        /**
         * Initial callback functin for careate database
         */
        public function _init(){
            $this->_create_coinmate_table();
            $this->_create_usermeta_table();
        }


        /**
         * Create user meta table for store user additional data from coinmate features 
         */
        protected function _create_usermeta_table(){
            $query = "CREATE TABLE IF NOT EXISTS `{$this->usermeta_table}` (
                id int(11) NOT NULL AUTO_INCREMENT,
                user_id int(11) NOT NULL,
                name varchar(150) NOT NULL DEFAULT '',
                city varchar(150) NOT NULL DEFAULT '',
                country varchar(200) NOT NULL DEFAULT '',
                pool_status boolean NOT NULL DEFAULT false,
                update_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP, 
                submit_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            )";
            $result = mysqli_query($this->conn, $query);
        }


      

        /**
         * Create Coinmate Table with necessary data
         */
        protected function _create_coinmate_table(){
            $query = "CREATE TABLE IF NOT EXISTS {$this->table} (
                id int(11) AUTO_INCREMENT,
                sender int(11) NOT NULL,
                receiver int(11) NOT NULL,
                msg text NOT NULL,
                room int(11),
                v_status VARCHAR(100) DEFAULT 'unread',
                update_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP, 
                submit_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            )";
            $result = mysqli_query($this->conn, $query);
        }

        function get_messages($room){
             $qry = $this->conn->prepare("SELECT * FROM {$this->table} WHERE `room` = ?");
             $qry->bind_param('s', $room);
             
             $qry->execute();
             $results = $qry->get_result();
             $qry->close();
             return $results;
        }
        /**
         * Process message from one user to another user 
         * 
         * @param array $data
         */
        public function save($data = array()){
             $room = array((int)$data['sender'], (int)$data['receiver']);
             sort($room);
             $room = join($room);
             $qry = $this->conn->prepare("INSERT INTO {$this->table} (`sender`, `receiver`, `msg`, `room`) VALUES (?, ?, ?, ?)");
             $qry->bind_param("ssss", $data['sender'], $data['receiver'], $data['msg'], $room);
             $qry->execute();
             $qry->close();
        }


        /**
         * Get count of all rooms and get messages users lists
         * 
         */
        public function list_of_my_messages($user_id){
            $qry = $this->conn->prepare("SELECT m.*, SUM(m.`v_status`='unread') as total, u.`pfp`, um.`name` FROM {$this->table} m LEFT JOIN {$this->users_table} u ON m.`sender` = u.`id` LEFT JOIN {$this->usermeta_table} um ON u.`id`=um.`user_id` WHERE m.`receiver` = ? GROUP BY m.`sender`");
            $qry->bind_param('d', $user_id);
            
            $qry->execute();
            $results = $qry->get_result();
            // $results = $results->fetch_all();
            $qry->close();
            return $results;
        }

        /**
         * Update coinbase data from conmate-edit.php 
         * 
         * @param array from form data
         */
        function update_coinbase_profile($data = array()){
            $stmt = $this->conn->prepare("UPDATE `{$this->users_table}` SET gender = ?  WHERE 	id = ?");
            $stmt->bind_param("sd", $data['sex'], $this->user_id);
            $ex = $stmt->execute();
            if($ex){
                $qryMeta = $this->conn->prepare("SELECT `id` FROM `{$this->usermeta_table}` WHERE `user_id` = ?");
                $qryMeta->bind_param('d', $this->user_id);
                $qryMeta->execute();
                $results = $qryMeta->get_result();
                
                if($results->num_rows > 0){
                    // update meta data
                    $stmt = $this->conn->prepare("UPDATE `{$this->usermeta_table}` SET `name` = ?, `city` = ?, `country` = ? WHERE `user_id` = ?");    
                    $stmt->bind_param("sssd", $data['name'], $data['city'], $data['country'], $this->user_id);
                    $ex = $stmt->execute();
                    $qryMeta->close();
                }else{
                    // Insert meta data
                    $stmt = $this->conn->prepare("INSERT INTO `{$this->usermeta_table}` (`user_id`, `name`, `city`, `country`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("dsss", $this->user_id, $data['name'], $data['city'], $data['country']);
                    $stmt->execute();
                }
            }
            $stmt->close();
            return $ex;
        }


        /**
         * Update Status 
         */
        public function update_pool_status(){
            $qry = $this->conn->prepare("SELECT `pool_status` FROM `{$this->usermeta_table}` WHERE `user_id` = ?");
            $qry->bind_param('d', $this->user_id);
            $ex = $qry->execute();
            $result = $qry->get_result();
            $result = $result->fetch_assoc();
            $status = true;
            if(!$result){
                $qry = $this->conn->prepare("INSERT INTO `{$this->usermeta_table}` (`user_id`, `pool_status`) VALUES (?, ?)");
                $qry->bind_param('dd', $this->user_id, $status);
                $ex = $qry->execute();
            }else{
                $status = $result['pool_status'] ? false : true;
                $qry = $this->conn->prepare("UPDATE `{$this->usermeta_table}` SET `pool_status`=? WHERE `user_id`=?");
                $qry->bind_param('dd', $status, $this->user_id);
                $qry->execute();
            }
        }
        
    }
 }
