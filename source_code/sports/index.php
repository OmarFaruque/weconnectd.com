<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/conn.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/lib/profile.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['pr_title']; ?></title>
        <link rel="stylesheet" href="/static/css/required.css"> 
        <style>
            .customtopLeft {
                float: left;
                width: calc( 22% - 20px );
                padding: 10px;
            }

            .customtopRight {
                float: right;
                width: calc( 78% - 20px );
                padding: 10px;
            }
			.sports_header{
				width: 100%;
				display:flex
			}
			.sports_header .sports_logo{
				width: 100%;
			}
			.sports_header .sports_logo img{
				width:100%;
			}
			.sports_header .sports_title{
				 width: calc(100% - 310px);
			}
						.ctitle{
    width: 100%;
    text-align: center;
    font-size: 60px;
    font-weight: 700;
    color: #fff;
    text-shadow: 2px 2px #b70404;
							margin: 15px 0px 0px 0px;
			}
			.blog-image{
				width:100%;
				height:250px;
			}
			.blog-image img{
				width:100%;
				height:250px;
			}
			.blog{
				margin:10px 0px;
			}
			.blog .blogPost{
				padding: 5px 0px;
			}
			.about-author{
				display:flex;
				margin: 2px;
                border-bottom: 1px solid #ddd3d3;
			}
			.about-author img{
				height: 40px;
                width: 40px;
                border-radius: 50px;
			}
			.about-author .author{
				padding:12px;
			}
			.about-author .date-time{
				padding:12px;
			}
			.subject{
				padding:0px 5px;
				padding: 0px 5px;
                font-size: 18px;
                font-weight: 550;
			}
			.btn{
				border: 1px solid #fff;
    background: #008d00;
    color: #fff;
    padding: 5px 10px;
    font-size: 16px;
    font-weight: 550;
			}
			.add-blog img{
				
				width: 200px;
				
			}
			#sports-blog-section{
				background:#000;
			}
        </style>
    </head>
    <body>
        <div class="container">
			
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/header.php"); ?>
           <div class="sports_header">
				<div class="sports_logo">
					<img src="https://weconnectd.com/images/photo_2022-08-12_21-21-54.jpg" alt="Sports">
				</div>
			</div>
			
            <div class="padding">
                <div class="customtopLeft">  
                    <div class="sideblog">
                        <h3>My Controls</h3>
                        <ul>
                            <li><a href="" class="man">Blog Home</a></li>
                            <li><a href="" class="man">My Subscriptions</a></li>
                            <li><a href="" class="man">My Readers</a></li>
                            <li class="last"><a href="" class="man">My Preferred List</a></li>
                        </ul>
                    </div><br>
                    <div class="sideblog">
                        <h3>Top 3 Bloggers</h3>
                        <ul>
                            <?php
                                $blogTop = array();
                                $stmt = $conn->prepare("SELECT * FROM sports");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()) {
                                    if(!isset($blogsTop[$row['author']])) {
                                        $blogsTop[$row['author']] = 1;
                                    } else {
                                        $blogsTop[$row['author']]++;
                                    }   
                                }
                                $blogsTopBackup = $blogsTop;
                                rsort($blogsTop);
                                $top3 = array_slice($blogsTop, 0, 3);
                                foreach ($top3 as $key => $val) {?>
                                    <li><a href="" class="man"><?php echo $val; ?> : <?php $keysquared = array_search($val, $blogsTopBackup); echo $keysquared; ?></a></li> 
                                <?php } ?>
                        </ul>
                    </div>
                </div>
                
                <div class="customtopRight">  
                    <div class="add-blog">
                        <a href="new.php"><img src="add-blog-button.jpg" alt="add blog button"></a>
                    </div><br>
                    
                    <div class="login" id="sports-blog-section">
                        <div class="loginTopbar">
                            <b>All Blogs</b>
                        </div>
                        <div class="padding">
                            <?php
                                $total_pages = $conn->query('SELECT COUNT(*) FROM sports WHERE visiblity = "Visible"')->fetch_row()[0]; 
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $num_results_on_page = 16;

                                $stmt = $conn->prepare("SELECT * FROM sports WHERE visiblity = 'Visible' ORDER BY id DESC LIMIT ?,?");
                                $calc_page = ($page - 1) * $num_results_on_page;
                                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                                $stmt->execute();
                                $result = $stmt->get_result(); ?>
                            <div class="splashBlue">
                            <center>
                            <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                <?php if ($page > 1): ?>
                                <a href="index.php?page=<?php echo $page-1 ?>">Prev</a>
                                <?php endif; ?>

                                <?php if ($page > 3): ?>
                                <a href="index.php?page=1">1</a>
                                ...
                                <?php endif; ?>

                                <?php if ($page-2 > 0): ?><a href="index.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a><?php endif; ?>
                                <?php if ($page-1 > 0): ?><a href="index.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a><?php endif; ?>

                                <a href="index.php?page=<?php echo $page ?>"><?php echo $page ?></a>

                                <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><a href="index.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                                <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><a href="index.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                                <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                                ...
                                <a href="index.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                                <?php endif; ?>

                                <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                <a href="index.php?page=<?php echo $page+1 ?>">Next</a>
                                <?php endif; ?>
                            <?php endif; ?>
                                    <br>
                                    <form method="get" action="/users.php">
                                        <select name="searchmethod">
                                            <option value="new">Newest</option>
                                            <option value="old">Oldest</option>
                                            <option value="alph">Alphabetical</option>
                                        </select>
                                        <input type="submit" value="Go"> (Does not work yet)
                                    </form> 
                                </center>
                            </div>
                            <?php
                                while($row = $result->fetch_assoc()) { 
                            ?>
                                <div class="blog">
									<div class="blog-image">
										<img src="images/<?php echo $row['image']; ?>" alt=" <?php echo htmlspecialchars($row['subject']); ?>">
									</div>
									<div class="about-author">
										<img src="/dynamic/pfp/<?php echo getPFPFromUser($row['author'], $conn); ?>">
										<div class="author">
											Posted by <a href="/profile.php?id=<?php echo getIDFromUser($row['author'], $conn); ?>"><?php echo $row['author']; ?></a>
										</div>
										<div class="date-time">
											<?php echo $row['date']; ?>
										</div>
									</div>
                                    <span id="blogPost">
										<div class="subject">
											<?php echo htmlspecialchars($row['subject']); ?> from <a href="/profile.php?id=<?php echo getIDFromUser($row['author'], $conn); ?>"><?php echo htmlspecialchars($row['author']); ?></a>
										</div>
                                        <small>
                                            
                                            &nbsp;<br>
                                            <span id="floatRight"><a href="view.php?id=<?php echo $row['id']; ?>"><button class="btn">More Info</button></a></span><br>
                                            <?php $likes = (int)getLikesFromBlog($row['id'], $conn); ?>
                                            <?php $dislikes = (int)getDislikesFromBlog($row['id'], $conn); ?>
                                            <?php
                                                $total = $likes + $dislikes;
                                                $percent = round(($likes / $total) * 100);
                                            ?>
                                            <div id="rating_score" class="rating" style="display: inline-block;">Rating:<strong><?php echo $percent; ?>%</strong></div>
                                            <div id="rate_btns" style="display: inline-block;">
                                                <div id="rate_yes"><a href="like.php?id=<?php echo $row['id']; ?>">Booyah !</a></div>
                                                <div id="rate_no"><a href="dislike.php?id=<?php echo $row['id']; ?>">No Way !</a></div>
                                            </div>
                                        </small>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
	        
        </div>
       <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/footer.php"); ?>
    </body>
</html>