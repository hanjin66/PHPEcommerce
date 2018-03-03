<?php
include 'includes/head.php';
include 'includes/navigation.php';
require_once '../core/init.php';

//get brands from database
$sql = "SELECT * FROM brand ORDER BY brand";
$results = $db->query($sql);
$errors = array();

//Edit brand
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = (int) $_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql = "SELECT * FROM  brand WHERE id='$edit_id'";
    $edit_result = $db->query($sql);
    $eBrand = mysqli_fetch_assoc($edit_result);
}

///

//delete brand
if (isset($_GET['delete']) && !empty($_GET['delete'])) {

    $delete_id = (int) $_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "DELETE FROM brand WHERE id='$delete_id'";
    $db->query($sql);
    header('Location: brands.php');
}

//if add form is submitted
if (isset($_POST['add_submit'])) {
    $brand = sanitize($_POST['brand']);
    if ($_POST['brand'] == '') {
        $errors[] .= 'Pleaes enter a brand!';

    }
    //check if brand exists in database
    $sql = "SELECT * FROM brand WHERE brand = '$brand' ";
    //   if(isset($_GET['edit'])){ 
    //     $sql= "SELECT * FROM brand WHERE brand = '$brand' AND id !='edit_id'";
    //  }



    $result = $db->query($sql);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $errors[] .= $brand . ' brand already exists, please choose another band';
    }
    //display errors
    if (!empty($errors)) {
        echo display_error($errors);
    } else {

        //Add brand to database
        $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
        //eidt
         if(isset($_GET['edit'])){ 
         $sql= "UPDATE brand SET brand='$brand' WHERE id='$edit_id'" ;
        }
        $db->query($sql);
        Header('Location: brands.php');
    }
}

//reset the form
if (isset($_POST['reset_all'])) {
    $reset = sanitize($_POST['reset_all']);

    $sql = "TRUNCATE brand";
    $result = $db->query($sql);
    Header('Location: brands.php');
}

?>

<h2 class='text-center'>Brands</h2><hr>
<!-- // Brand Form -->
<div class='text-center'>
    <form class='form-inline' action="brands.php<?=((isset($_GET['edit'])) ? '?edit=' . $edit_id : '');?>"  method='post'>
     <div class='form-group'>
        <label for="brand"> <?=((isset($_GET['edit'])) ? 'EDIT ' : 'ADD A ');?>BRAND:</label>
          <?php 
          $brand_VALUE='';
          if ( ((isset($_GET['edit'])))) {
            $brand_VALUE=$eBrand['brand'];
          } 
          else{
              if(isset($_POST['brand'])){
                  $brand_VALUE=sanitize($_POST['brand']);
              }
          }
          ?>
        <!--user input stays after submit //(isset($_POST['brand']))?$_POST['brand']:'' -->
        <input type="text" name='brand' id="brand" class="form-control" value="<?=$brand_VALUE;?>">
         <?php if ( (isset($_GET['edit']))):?>
            <a href="brands.php" class="btn btn-default">Cancel</a>
          <?php endif; ?>
        <input type="submit" name='add_submit' value="<?=((isset($_GET['edit'])) ? 'Edit ' : 'ADD A ');?> Brand" class="btn btn-large btn btn-success">
     </div>
    </form>
</div><hr>


<table class='table table-bordered table-striped table-auto table-condensed'>

<thead>
    <th></th> <th>Brands</th> <th></th>
</thead>
<tbody>
    <?php while ($brand = mysqli_fetch_assoc($results)): ?>
<tr>
    <td><a href="brands.php?edit=<?=$brand['id'];?>" class='btn btn-sx btn-default'><span class='glyphicon glyphicon-pencil'></span></a></td>

    <td> <?=$brand['brand'];?></td>
    <td><a href="brands.php?delete=<?=$brand['id'];?>" class='btn btn-sx btn-default'><span class='glyphicon glyphicon-remove-sign'></span> </a></td>

</tr>

 <?php endwhile;?>

</tbody>


</table>

 <?php include 'includes/footer.php';?>


<form action = "" method = "post">
 <input type="submit" name='reset_all' value="Reset ALL Brands" class="btn btn-large btn btn-success" method='post'>
</form>