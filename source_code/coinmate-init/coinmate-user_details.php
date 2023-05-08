    <?php 
        $user = getUserFromId($_GET['id'], $conn);
        
        if(isset($_POST['submit'])){
            $coinmate = new Coinmate($conn);
            $coinmate->save($_POST);
            $_POST = array();
        }

        // room number
        $room = array((int)$userDetails['id'], (int)$_GET['id']);
        sort($room);
        $room = join($room);
        $messages = $coinmate->get_messages($room);
        // echo 'messages <br/><pre>';
        // print_r($messages);
        // echo '</pre>';
    ?>
    <!-- Header  -->
    <div class="d-flex align-items-center gap-5">
        <div class="flex-1 d-flex justify-content-center">
            <img style="height: 250px; width:250px; object-fit: cover;" src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo $user['pfp']; ?>" class="img-fluid rounded-circle shadow" alt="">
        </div>
        <div class="flex-2">
            <h3><?php echo !empty($user['name']) ? $user['name'] : $user['username']; ?></h3>
        </div>
    </div>


    <!-- Messages -->
    <div class="personal-information p-4">
        <h5>Bio</h5>
        <div class="shadow-sm p-3 rounded">
            <div class="bio-details mb-3">
                <?php echo $user['bio']; ?>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Sex</td>
                        <td>Country</td>
                        <td>City</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($user['name']) ? $user['name'] : 'empty'; ?></td>
                        <td><?php echo isset($user['gender']) ? $user['gender'] : 'empty'; ?></td>
                        <td><?php echo isset($user['country']) ? $user['country'] : 'empty'; ?></td>
                        <td><?php echo isset($user['city']) ? $user['city'] : 'empty'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Conversation History -->

    <div class="conversatin-history p-4">
        <h5>Conversation History</h5>
        <div class="messagelists">
            <?php while($row = $messages->fetch_assoc()): ?>
                <div class="card shadow-sm mb-4" style="background-color:white; border-width:0;">
                  <div class="card-body">
                    <div class="item-body d-flex item-center gap-4 <?php echo $userDetails['id'] == $row['sender'] ? 'flex-row-reverse' : ''; ?>">
                        <div class="flex-1" style="flex: 1;">
                            <img style="max-width:100%; width: 100%; height: 50px; object-fit: cover;" src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo $userDetails['id'] == $row['sender'] ? $userDetails['pfp'] : $user['pfp']; ?>" class="img-fluid rounded shadow" alt="">
                        </div>
                        <div class="flex-10" style="flex: 10;">
                            <p><?php echo $row['msg']; ?></p>
                            <p class="text-muted align-right ml-auto <?php echo $userDetails['id'] == $row['sender'] ? 'text-start' : 'text-end'; ?>"><small class="ml-auto"><i>Date: <?php echo date('jS F Y', strtotime($row['submit_at'])); ?></i></small></p>
                        </div>
                    </div>
                  </div>
                </div>


            <?php endwhile; ?>
        </div>
    </div>

    <!-- Messages -->
    <div class="messages p-4">
        <form class="form-inline" action="" method="POST">
            <input type="hidden" name="receiver" value="<?php echo $user['id']; ?>">
            <input type="hidden" name="sender" value="<?php echo $userDetails['id']; ?>">
            <div class="form-group">
                <div class="mb-3">
                    <label for="" class="form-label">Message</label>
                    <textarea class="form-control" name="msg" id="msg" rows="3"></textarea>
                    <input name="submit" id="submit" class="btn btn-primary mt-3" type="submit" value="Send">
                </div>
            </div>
        </form>
    </div>