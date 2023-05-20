<?php
/**
 * Page header 
 * 
 * @author Omar Faruque <ronymaha@gmail.com>
 */
require_once($_SESSION['ROOT_PATH'] . '/functions/default_functions.php');

// Burn Profile 
if (isset($_GET['action']) && $_GET['action'] == 'burn-profile')
{
    burnUserProfile($_GET['bid'], $conn);
}




if (isset($_SESSION['siteusername'])) {
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $_SESSION['siteusername']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        if ($row['banstatus'] != "A") {
            header("Location: ../ban.php");
        }
    }
    $stmt->close();
}




if (!defined('ROOT_URL')){
    $root_url = 'https://weconnectd.com/';
    if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == '192.168.64.2'){
        $root_url = 'http://192.168.64.2/weconnectd.com/';
    }

    if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost'){
        $root_url = 'http://localhost:'.$_SERVER['SERVER_PORT']. $_SERVER['REQUEST_URI'];
    }
    define('ROOT_URL', $root_url);
}

    


$active_user = get_user_by_status('normal', $conn);
$deletded_user = get_user_by_status('deleted', $conn);
$unread_pm_count = $unread_gm_count = $unread_friend_count = 0;
if (isset($_SESSION['siteusername'])) {
    $stmt = $conn->prepare("SELECT * FROM `pms` WHERE sto = ? AND isRead = 0");
    $stmt->bind_param("s", $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->store_result();
    $unread_pm_count = $stmt->num_rows;
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM `friends` WHERE reciever = ? AND status = 'u'");
    $stmt->bind_param("s", $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->store_result();
    $unread_friend_count = $stmt->num_rows;
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM `pms` WHERE sto = ? AND isRead = 0");
    $stmt->bind_param("s", $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->store_result();
    $unread_pm_count = $stmt->num_rows;
    $stmt->close();

    $stmt2 = $conn->prepare("SELECT * FROM `ghost_chat` WHERE reciever = ? AND sender!= ? AND status = 0");
    $stmt2->bind_param("ss", $_SESSION['siteusername'], $_SESSION['siteusername']);
    $stmt2->execute();
    $stmt2->store_result();
    $unread_gm_count = $stmt2->num_rows;
    $stmt2->close();
}

?>
<div class="headerTop">
    <div>
        <a href="<?php echo ROOT_URL; ?>">
            <img src="<?php echo ROOT_URL; ?>static/spacemy.png">
        </a>
    </div>
    <div>
        <h6><strong>Minted Profiles
        <?php echo $active_user; ?></strong>
        </h6>
        <h6><strong>Burned Profiles
            <?php echo $deletded_user; ?></strong>
        </h6>
    </div>
    <div>
        <small id="floatRight" class="d-flex justify-content-end">
            <?php if (isset($_SESSION['siteusername'])) { ?>
            <a href="<?php ROOT_URL; ?>logout.php">Logout</a>
            <?php } else { ?>
            <a href="<?php echo ROOT_URL; ?>login.php">Login</a> &bull;
            <a href="<?php echo $root_url; ?>register.php">Register</a>
            <?php } ?>&nbsp;&nbsp;
        </small>
        <span id="floatRight">
            <form method="get" class="d-flex gap-1 justify-content-end" action="/browse.php">
                <select name="searchmethod">
                    <option value="users">User</option>
                    <option value="blog">Blog</option>
                    <option value="groups">WeLinks</option>
                    <option value="forum">Forum</option>
                </select>
                <input type="text" size="30" name="search">
                <input type="submit" value="Search">
            </form>
        </span>
    </div>
</div>
<div class="headerBottom">
        <div id="mainManu" class="mainmanu">
            <ul>
                <li><a href="/links">WeChat</a></li>
                <li><a href="/blogs">Blogs</a></li>
                <li><a href="/connectoclocks">ConnectO'Clock</a></li>
                <li><a href="/bulletin">Bulletin</a></li>
                <li><a href="<?php echo ROOT_URL; ?>coinmate.php">Club Meme</a></li>
                <li><a href="/exchange.php">Exchanges</a></li>
                <li><a href="http://coinconnect.info">Block Explorer</a></li>
                <li><a href="<?php echo ROOT_URL; ?>forum/">Forum</a></li>
                <li><a href="/pms.php">PMs <?php echo ($unread_pm_count === 0 ? "" : " (" . $unread_pm_count . ")") ?></a></li>
                <?php if(isset($_SESSION['siteusername'])): ?>
                    <li><a href="/ghost_chat.php?recieve=<?php echo $_SESSION['siteusername']; ?>">GMs <?php echo ($unread_gm_count === 0 ? "" : " (" . $unread_gm_count . ")") ?></a></li>
                <?php endif; ?>
                <li><a href="/friends/">Coinconnects <?php echo ($unread_friend_count === 0 ? "" : " (" . $unread_friend_count . ")") ?></a></li>
                <li class="haveChild"><a class="openButton" onClick="openChildUI(this, 'open')" href="#">More</a>
                    <ul id="subMenu" class="">
                        <li><a href="https://weconnectd.com/blogs/view.php?id=4">Crypto 101</a></li>
                        <li><a href="http://goldenaddress.org">Web/Paper Wallet Address</a></li>
                        <li><a href="/undercon.php">Coinconnect Fountain </a></li>
                        <li><a href="http://coinconnect.info">Block Explorer</a></li>
                        <li><a href="http://coinconnect.world">Coinconnect.World</a></li>
                        
                        <li><a href="/sc-top-40.php">SC Top 20 </a></li>
                        <li><a href="/sports">Sports</a></li>
                        <li><a href="<?php echo ROOT_URL; ?>undercon.php">Blockbeeper</a></li>
                        <li><a href="/coinroll.php">Coinroll </a></li>
                        <li><a href="<?php echo ROOT_URL; ?>undercon.php">Satoshilist</a></li>
                        <li><a href="/undercon.php">Jobs</a></li>
                        <li><a href="http://gamestart.run">The Coinade</a></li>
                        <li><a href="/webit.php">WeBitstation</a></li>
                        <li><a href="/users.php">All Users</a></li>
                        <li><a href="/scam.php">Scam Alert List</a></li>
                        <li><a href="/wejail.php">WeJailhouse</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <?php if (isset($_SESSION['siteusername'])) { ?>
        <div id="floatRight" class="headerManuBar">
            <ul id="custompadding">
                <li class="burnProfile"><a onclick="return confirm('Are you sure you want to burn your profile?')" href="profile.php?action=burn-profile&bid=<?php echo htmlspecialchars(getUserFromUsername($_SESSION['siteusername'], $conn)["id"]); ?>"><span>Burn Profile</span></a></li>
                <li><a href="/manage.php">Manage User</a></li>
                <li><a href="/edit">Edit Items</a></li>
                <li><a href="#">Weconnectd Wallet</a></li>
                <li>
                    <a
                        href="/profile.php?id=<?php echo (htmlspecialchars(getUserFromUsername($_SESSION['siteusername'], $conn)["id"])); ?>">
                        <?php echo $_SESSION['siteusername']; ?>
                    </a>
                </li>
            </ul>
        </div>
        <?php } ?>
</div>
<?php
if (isset($_SESSION['siteusername'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['siteusername']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0)
        die("the whole squad is laughing");
    $stmt->close();
};
?>
<script>
    const openChildUI = (el, className) => {
        if(!document.getElementById('subMenu').matches('.open')){
            document.getElementById('subMenu').classList.add("open");
        }else{
            document.getElementById('subMenu').classList.remove("open");
        }
    }
</script>