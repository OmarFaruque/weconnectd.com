<?php
    $message_lists = $coinmate->list_of_my_messages($userDetails['id']);
 
?>



<!-- Message lists -->
<div class="personal-information p-4">
    <div class="row">
        <?php while($row = $message_lists->fetch_assoc()): 
            // echo 'row array <br/><pre>';
            // print_r($row);
            // echo '</pre>';
            ?>
        <div class="col-sm-3 col-md-3">
            <div class="card text-center shadow-sm position-relative">
            <!-- '+global.root_url+'coinmate.php?action=user_details&id='+v.user_id+' -->
                <a href="<?php echo ROOT_URL; ?>coinmate.php?action=user_details&id=<?php echo $row['sender']; ?>" class="text-decoration-none">
                    <picture>
                        <img style="height: 150px; width: 100%; object-fit: cover;" src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo $row['pfp']; ?>" class="img-fluid" alt="image desc">
                    </picture>
                    <div class="card-body">
                        <h4 class="card-title"><?php 
                        if(!empty($row['name'])):
                            echo $row['name']; 
                        else:
                            echo isset($userDetails['username']) && !empty($userDetails['username']) ? $userDetails['username'] : $row['name'];
                        endif;
                        ?></h4>
                    </div>
                    <?php if($row['total'] > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                            <?php echo $row['total']; ?>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
            

        </div>
        <?php endwhile; ?>
    </div>
</div>