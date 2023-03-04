<div class="forum-post">
    <div class="pimg">
        <div style="background-image:url(<?php echo $profileImg; ?>)">
            <img src="<?php echo $profileImg; ?>" alt="<?php echo $answerRow['username']; ?>">
        </div>
    </div>
    <div>
        <div class="cate">
            <a href="<?php echo ROOT_URL; ?>forum/?category=<?php echo str_replace(' ', '_', $row['category']); ?>"><?php echo $row['category']; ?></a>
        </div>
        <div class="title">
            <div><?php echo $row['title']; ?></div>
            <div>
                <small><i><?php echo date('jS M y h:i A', strtotime($row['update_on'])); ?></i></small>
            </div>
        </div>
        <div class="cate-cret">        
            <div class="cret">
                <a href="<?php echo ROOT_URL; ?>profile.php?id=<?php echo $row['creator']; ?>"><?php echo $answerRow['username']; ?></a>
            </div>
        </div>
        <div class="content">
            <?php echo substr($row['content'], 0, 100) . "..."; ?>
            <div class="more-btn"><a href="<?php echo ROOT_URL; ?>forum/post.php?id=<?php echo $row['id']; ?>">More</a></div>
            <small>Viewed by <span>
            <?php echo $row['views']; ?>
            </span> People(s)</small>
        </div>
    </div>
</div>