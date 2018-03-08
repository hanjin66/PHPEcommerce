<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tutorial/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
$sqlParent = "SELECT * FROM categories WHERE parent=0";
$ParentResults = $db->query($sqlParent);
$errors = array();
$category='';
$category_value='';
$parent_value=0;
$post_parent='';
//Edit Category
 if(isset($_GET['edit']) && !empty($_GET['edit'])){ 
     $edit_id=(int)$_GET['edit'];
     $edit_id=sanitize($edit_id);
    $edit_sql="SELECT * FROM categories WHERE id='$edit_id'";
    $edit_result=$db->query($edit_sql);
    $editCategory=mysqli_fetch_assoc($edit_result); 
    $category_value=$editCategory['category'];
    $parent_value=$editCategory['parent'];

}else {
    if(isset($_POST)){ 
     $category_value=$category;
     $parent_value=$post_parent;
     
    }

}






//delete categories
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sqlDeleteParent = "SELECT * FROM categories WHERE id='$delete_id'";
    $DeleteResult = $db->query($sqlDeleteParent);
    $category = mysqli_fetch_assoc($DeleteResult);
    if ($category['parent'] == 0) {
        $sqlOrphan = "DELETE FROM categories WHERE parent='$delete_id' ";
        $db->query($sqlOrphan);
    }

    $sqlDelete = "DELETE FROM categories WHERE id='$delete_id'";
    $db->query($sqlDelete);
    header('Location: categories.php');
}

//process form
if (isset($_POST) && !empty($_POST)) {
    $post_parent = sanitize($_POST['parent']);
    $category = sanitize($_POST['category']);
    $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";
     if(isset($_GET['edit'])){ 
        $id=$editCategory['id'];
        $sqlform="SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id !='$id'";

    }
    $fresult = $db->query($sqlform);
    $count = mysqli_num_rows($fresult);
    if ($category == '') {
        # code...
        $errors[] .= 'The Category can not be left blank.';
    }

    if ($count > 0) {
        $errors[] .= $category . ' already exists. Please choose a new category.';

    }
    //Display Error or Add to
    if (!empty($errors)) {
        //display errors
        $display = display_error($errors);
        ?>

    <script>
        jQuery('document').ready(function () {
            jQuery('#errors').html('<?=$display;?>');
        });
    </script>
    <?php

    } else {
        $updateSQL = "INSERT into Categories (category,parent) VALUES ('$category','$post_parent')";
         if(isset($_GET['edit'])){ 
           $updateSQL="UPDATE Categories SET category='$category', parent='$post_parent' WHERE id='$edit_id'";
        }
        $db->query($updateSQL);
        header('Location: categories.php');
        //echo $parent;
    }

}

?>

 
        <h2 class='text-center'>Categories</h2>
        <hr>
        <div class="row">

            <!-- Category Form -->
            <div class='col-md-6'>
                <form action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id : ' ');?>" method="post" class="form">
                    <legend> <?=  ((isset($_GET['edit']))?'Edit':'Add A');?> Category</legend>
                    <div id="errors"></div>
                    <div class='form-group'>
                        <label for="parent">Parent</label>
                        <select class="form-control" id="parent" name='parent'>
                            <option value="0"<?=(($parent_value==0)?' selected="selected"':'');?>>Parent</option>

                            <?php while ($parent = mysqli_fetch_assoc($ParentResults)): ?>
                            <option value='<?=$parent['id'];?>'<?=(($parent_value==$parent['id'])?' selected="selected"':'');?>>
                                <?=$parent['category'];?>
                            </option>
                            <?php endwhile;?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Category">Category</label>

                        <input type="text" class="form-control" id="category" name="category" value="<?=$category_value;?>">
                    </div>
                    <div calss='form-group'>
                        <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Category" class="btn btn-success"> 

                    </div>
                </form>
            </div>



            <!-- Category Table -->
            <div class='col-md-6'>
                <table class="table table-bordered">
                    <thead>
                        <th>Categories</th>
                        <th>Parent</th>
                        <th></th>
                    </thead>
                    <tbody>

                            <?php
                            $sql = "SELECT * FROM categories WHERE parent=0";
                            $results = $db->query($sql);
                            while ($parent = mysqli_fetch_assoc($results)):
                                $parent_id = (int) $parent['id'];
                                $sql2 = "SELECT * FROM categories WHERE parent='$parent_id'";
                                $childResult = $db->query($sql2);

                             ?>
	                            <tr class='bg-primary'>
	                                <td>
	                                    <?=$parent['category'];?>
	                                </td>
	                                <td> parent</td>
	                                <td>
	                                    <a href="categories.php?edit=<?=$parent['id'];?>" class='btn btn-xs btn-default'>
	                                        <span class='glyphicon glyphicon-pencil'></span>
	                                    </a>
	                                    <a href="categories.php?delete=<?=$parent['id'];?>" class='btn btn-xs btn-default'>
	                                        <span class='glyphicon glyphicon-remove-sign'></span>
	                                    </a>

	                                </td>
	                            </tr>
	                            <?php while ($child = mysqli_fetch_assoc($childResult)): ?>
	                            <tr class='bg-info'>
	                                <td>
	                                    <?=$child['category'];?>
	                                </td>
	                                <td>
	                                    <?=$parent['category'];?>
	                                </td>
	                                <td>
	                                    <a href="categories.php?edit=<?=$child['id'];?>" class='btn btn-xs btn-default'>
	                                        <span class='glyphicon glyphicon-pencil'></span>
	                                    </a>
	                                    <a href="categories.php?delete=<?=$child['id'];?>" class='btn btn-xs btn-default'>
	                                        <span class='glyphicon glyphicon-remove-sign'></span>
	                                    </a>

	                                </td>
	                            </tr>


	                            <?php endwhile;?>
                            <?php endwhile;?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include 'includes/footer.php';?>