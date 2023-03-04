<?php include '../includes/dbconn.php'; ?>

<?php 
// Location
if(isset($_POST['continent_id']) AND !empty($_POST['continent_id'])){
    $continent_id = $_POST['continent_id'];
}
if(isset($_POST['country_id']) AND !empty($_POST['country_id'])){
    $country_id = $_POST['country_id'];
}
if(isset($_POST['state_id']) AND !empty($_POST['state_id'])){
    $state_id = $_POST['state_id'];
}

// Category
if(isset($_POST['category_id']) AND !empty($_POST['category_id'])){
    $category_id = $_POST['category_id'];
}


if(isset($continent_id)){
    $country = $conn->query("SELECT * FROM countries WHERE continent_id='$continent_id'");
    if($country->num_rows > 0){
        while($country_d = $country->fetch_assoc()){
            ?>
            <option value="<?php echo $country_d['id']; ?>"><?php echo $country_d['name']; ?></option>
            <?php
        }
    }else{
        ?>
        <option value="">No country exist.</option>
        <?php
    }
}

if(isset($country_id)){
    $states = $conn->query("SELECT * FROM states WHERE country_id='$country_id'");
    if($states->num_rows > 0){
        while($states_d = $states->fetch_assoc()){
            ?>
            <option value="<?php echo $states_d['id']; ?>"><?php echo $states_d['name']; ?></option>
            <?php
        }
    }else{
        ?>
        <option value="">No State exist.</option>
        <?php
    }
}

if(isset($state_id)){
    $cities = $conn->query("SELECT * FROM cities WHERE state_id='$state_id'");
    if($cities->num_rows > 0){
        while($cities_d = $cities->fetch_assoc()){
            ?>
            <option value="<?php echo $cities_d['id']; ?>"><?php echo $cities_d['name']; ?></option>
            <?php
        }
    }else{
        ?>
        <option value="">No City exist.</option>
        <?php
    }
}

if(isset($category_id)){
    $subcategories = $conn->query("SELECT * FROM subcategories WHERE category_id='$category_id'");
    if($subcategories->num_rows > 0){
        while($subcategories_d = $subcategories->fetch_assoc()){
            ?>
            <option value="<?php echo $subcategories_d['id']; ?>"><?php echo $subcategories_d['name']; ?></option>
            <?php
        }
    }else{
        ?>
        <option value="">No Subcategory exist.</option>
        <?php
    }
}
?>