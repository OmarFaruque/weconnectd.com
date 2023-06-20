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
         * Return available club coin
         * 
         * @return array
         */

        public function availableCoin(){
            return array(
                'pepe' => 'PEPE and MemeVader',
                'bitcoin' => 'Bitcoin',
                'ethereum' => 'Ethereum',
                'solana' => 'Solana',
                'dogecoin' => 'Dogecoin',
                'goldencoin' => 'Goldencoin',
                'coinconnect' => 'Coinconnect',
                'vadermoon' => 'Vadermoon'
            );
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
                gallary text NOT NULL DEFAULT '',
                pool_status boolean NOT NULL DEFAULT false,
                club_token varchar(200) NOT NULL DEFAULT '',
                update_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP, 
                submit_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            )";
            $result = mysqli_query($this->conn, $query);
        }


        /**
         * Get all images by user id
         * 
         * @return string
         */
        public function get_gallary_images($_userid){
            $existingImages = $this->conn->prepare("SELECT `gallary` FROM {$this->usermeta_table} WHERE `user_id` = ?");
            $existingImages->bind_param('d', $_userid);

            $existingImages->execute();
            $results = $existingImages->get_result();
            $existingImages->close();

            $result = $results->fetch_assoc();
            // $allfiles = json_encode($files); 
            return $result['gallary'] ? json_decode($result['gallary']) : false;
        }

        /**
         * Upload Single file 
         * 
         * @param $filename {string}
         * @param $temp {string}
         */
        function uploadEachFiles($filename, $temp,   $user_id){
            $target_dir = $_SESSION['ROOT_PATH']  . "/uploads/gallary/" . $user_id . '/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($filename);
            $needUpload = true;
            $imgSize = getimagesize($temp);  //Image size

            if(!$imgSize)
                $needUpload = false;

            if (file_exists($target_file))
                $needUpload = false;

            if(!$needUpload)
                return false;
            
            if($needUpload){
                if(move_uploaded_file($temp, $target_file))
                    return true;
            }
        }


        /**
         * Store upload image to database for future use 
         * 
         * @param #files {array}
         */
        protected function storeImgToDb($files, $user_id){
            $existingImages = $this->conn->prepare("SELECT `gallary` FROM {$this->usermeta_table} WHERE `user_id` = ?");
            $existingImages->bind_param('d', $user_id);

            $existingImages->execute();
            $results = $existingImages->get_result();
            $existingImages->close();

            $result = $results->fetch_all();
            $allfiles = json_encode($files);
            if(count($result) > 0 && $result[0][0]){
                $allfiles = array_merge(json_decode($result[0][0]), $files);
                $allfiles = json_encode($allfiles);
            }

            
            $insertGallary = $this->conn->prepare("UPDATE {$this->usermeta_table} SET `gallary` = ? WHERE `user_id` = ?");
            $insertGallary->bind_param('sd', $allfiles, $user_id);
            $insertGallary->execute();
            $insertGallary->close();

        }



        /**
         * Upload Gallary files
         * 
         * @param $files {Array}
         */
        function upload_gallary($files = array(), $user_id = 0){

            if(isset($files['gallarys']['name']) && count($files['gallarys']['name']) > 0){
                $dbArray = array();
                foreach($files['gallarys']['name'] as $k => $singleFile){
                    $uploadStatus = $this->uploadEachFiles($singleFile, $files['gallarys']['tmp_name'][$k], $user_id);
                    if($uploadStatus)
                        array_push($dbArray, $singleFile);
                }

                if(count($dbArray) > 0){
                    $this->storeImgToDb($dbArray, $user_id);
                }
            }
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

        function get_messages($room, $receiver_id = 0){
             $qry = $this->conn->prepare("SELECT * FROM {$this->table} WHERE `room` = ?");
             $qry->bind_param('s', $room);
             
             $qry->execute();
             $results = $qry->get_result();
             $qry->close();

             //Make message as read 
             $makeRead = $this->conn->prepare("UPDATE {$this->table} SET `v_status`='read' WHERE `receiver` = ? AND `room` = ?");
             $makeRead->bind_param('ds', $receiver_id, $room); 
             $makeRead->execute();

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
            $stmt = $this->conn->prepare("UPDATE `{$this->users_table}` SET gender = ?, zipcode = ?, age = ?  WHERE id = ?");
            $stmt->bind_param("sdsd", $data['sex'], $data['zipcode'], $data['age'], $this->user_id);
            $ex = $stmt->execute();
            if($ex){
                $qryMeta = $this->conn->prepare("SELECT `id` FROM `{$this->usermeta_table}` WHERE `user_id` = ?");
                $qryMeta->bind_param('d', $this->user_id);
                $qryMeta->execute();
                $results = $qryMeta->get_result();
                
                if($results->num_rows > 0){
                    // update meta data
                    $stmt = $this->conn->prepare("UPDATE `{$this->usermeta_table}` SET `name` = ?, `city` = ?, `country` = ?, `club_token` = ? WHERE `user_id` = ?");    
                    $stmt->bind_param("ssssd", $data['name'], $data['city'], $data['country'], $data['club_token'], $this->user_id);
                    $ex = $stmt->execute();
                    $qryMeta->close();
                }else{
                    // Insert meta data
                    $stmt = $this->conn->prepare("INSERT INTO `{$this->usermeta_table}` (`user_id`, `name`, `city`, `country`, `club_token`) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("dssss", $this->user_id, $data['name'], $data['city'], $data['country'], $data['club_token']);
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
