    <?php 
        $user = getUserFromId($_GET['id'], $conn);
        if(isset($_POST['submit'])){
            Coinmate::submit_coinmate_message($conn, $_POST);
        }
    ?>
    <!-- Header  -->
    <div class="d-flex align-items-center gap-5">
        <div class="flex-1 d-flex justify-content-center">
            <img style="height: 250px; width:250px; object-fit: cover;" src="<?php echo ROOT_URL; ?>dynamic/pfp/<?php echo $user['pfp']; ?>" class="img-fluid rounded-circle" alt="">
        </div>
        <div class="flex-2">
            <h3><?php echo !empty($user['name']) ? $user['name'] : $user['username']; ?></h3>
        </div>
    </div>


    <!-- Messages -->
    <div class="personal-information p-4">
        <h5>Bio</h5>
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
                    <td><?php echo $user['name'] ? $user['name'] : 'empty'; ?></td>
                    <td><?php echo $user['gender'] ? $user['gender'] : 'empty'; ?></td>
                    <td><?php echo $user['country'] ? $user['country'] : 'empty'; ?></td>
                    <td><?php echo $user['city'] ? $user['city'] : 'empty'; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

        <!-- Messages -->
    <div class="messages p-4">
        <form class="form-inline">
            <input type="hidden" name="receiver" value="<?php echo $user['id']; ?>">
            <input type="hidden" name="sender" value="<?php echo $userDetails['id']; ?>">
            <div class="form-group">
                <div class="mb-3">
                    <label for="" class="form-label">Message</label>
                    <textarea class="form-control" name="" id="" rows="3"></textarea>
                    <input name="submit" id="submit" class="btn btn-primary mt-3" type="button" value="Send">
                </div>
            </div>
        </form>
    </div>