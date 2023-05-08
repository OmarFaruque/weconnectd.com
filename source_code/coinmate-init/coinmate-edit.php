
<div class="d-flex align-items-center gap-5">
                            <div class="flex-1">
                                <img src="<?php echo ROOT_URL; ?>/dynamic/pfp/<?php echo $userDetails['pfp']; ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="flex-2">
                                <h3><?php echo $userDetails['name'] ? $userDetails['name'] : $userDetails['username']; ?></h3>
                            </div>
                        </div>

<!-- personal information -->
 <div class="edit-personal-information p-4">
    <div class="container">
        <form action="" method="POST">
            <?php if($msg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <span class="ml-3" style="margin-left: 10px;">
                    Profile Update Successfully.
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <input type="hidden" value="<?php echo $_SESSION['siteusername']; ?>" name="user_name">
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">Name</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="name" value="<?php echo $userDetails['name']; ?>" id="name" placeholder="Name">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="sex" class="col-4 col-form-label">Sex</label>
                <div class="col-8">    
                    <select class="form-select" name="sex" id="sex">
                        <option <?php echo $userDetails['gender'] == 'male' ? 'selected' : ''; ?> value="male">Male</option>
                        <option <?php echo $userDetails['gender'] == 'female' ? 'selected' : ''; ?> value="female">Female</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="city" class="col-4 col-form-label">City Name</label>
                <div class="col-8">
                    <input type="text" class="form-control" value="<?php echo $userDetails['city']; ?>" name="city" id="city" placeholder="City...">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="sex" class="col-4 col-form-label">Country</label>
                <div class="col-8">    
                    <select class="form-select select2" name="country" id="country">
                        <option value="">Country</option>
                        <?php foreach($countries as $k => $country): ?>
                        <option <?php echo $userDetails['country'] == $k ? 'selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $country; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="city" class="col-4 col-form-label">Zipcode</label>
                <div class="col-8">
                    <input type="text" class="form-control" value="<?php echo $userDetails['zipcode']; ?>" name="zipcode" id="zipcode" placeholder="Zipcode...">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="city" class="col-4 col-form-label">Age</label>
                <div class="col-8">
                    <input type="number" min="10" max="150" class="form-control" value="<?php echo $userDetails['age']; ?>" name="age" id="age" placeholder="Age...">
                </div>
            </div>
            
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>          
</div>