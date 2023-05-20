<?php
    /**
     * Get gallary all images
     */
    $images = $coinmate->get_gallary_images($_GET['id']);
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

