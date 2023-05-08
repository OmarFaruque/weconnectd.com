<?php
    if(isset($_POST['gallary_submit'])){
        $coinmate->upload_gallary($_FILES, $userDetails['id']);
    }

    /**
     * Get gallary all images
     */
    $images = isset($userDetails['gallary']) && !empty($userDetails['gallary']) ? json_decode($userDetails['gallary']) : array();

    
    
?>



<!-- Gallary -->
<?php if(count($images) > 0): ?>
<div id="gallary" class="p-4 mt-3">
    <h4 class="mb-4">Gallary Images:</h4>
    <div class="row">
        <?php foreach($images as $img): ?>
            <div class="col-sm-4 col-md-4 col-xs-6 mb-4">
                <a href="<?php echo ROOT_URL; ?>/uploads/gallary/<?php echo $userDetails['id']; ?>/<?php echo $img; ?>" data-toggle="lightbox">
                    <img src="<?php echo ROOT_URL; ?>/uploads/gallary/<?php echo $userDetails['id']; ?>/<?php echo $img; ?>" class="img-fluid rounded-top shadow-sm rounded" alt="">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>



<!-- Message lists -->
<div class="personal-information p-4">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mt-4">
                <label for="formFileMultiple" class="form-label">Upload Gallary Images</label>
                <div class="d-flex gap-4">
                    <input class="form-control" type="file" name="gallarys[]" id="formFileMultiple" multiple>
                    <input type="submit" value="Upload" class="btn btn-primary" name="gallary_submit">
                </div>
            </div>
        </form>
    </div>
</div>

