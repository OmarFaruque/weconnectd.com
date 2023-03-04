<?php
/**
 * Create new table for store favorite data
 * 
 * @author ronymaha <ronymaha@gmail.com>
 */

$show = "SHOW TABLES LIKE 'my_favorite'";
$show = $conn->query($show);

if($show) return;

if ($show->num_rows < 0) {
    $sql = "CREATE TABLE my_favorite (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id int(6) NOT NULL,
        favorit_id int(6) NOT NULL,
        update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

    if ($conn->query($sql) === true) {
    }
}