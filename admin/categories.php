<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tutorial/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
$sql= "SELECT * FROM categories WHERE parent=0" ;
$results=$db->query($sql);
?>

    <h2 class='text-center'>Categories</h2>
    <div class='row'>
        <div class='col-md-6'></div>
        <div class='col-md-6'>
            <table class="table table-bordered">
                <thead>
                    <th>Categories</th>
                    <th>Parent</th>
                    <th></th>
                </thead>
                <tbody>
                      <?php while($parent =mysqli_fetch_assoc($results)):
                        $parent_id=(int)$parent['id'];
                        $sql2= "SELECT * FROM categories WHERE parent='$parent_id'" ;
                        $childResult=$db->query($sql2);
                      //  var_dump[$parent_id];
                        ?>
                    <tr class='bg-primary'>
                        <td> <?= $parent['category'];?></td>
                        <td> parent</td>
                        <td>
                            <a href="categories.php?edit=<?= $parent['id'];?>" class='btn btn-xs btn-default'> <span class ='glyphicon glyphicon-pencil'></span>  </a>
                            <a href="categories.php?delete=<?= $parent['id'];?>" class='btn btn-xs btn-default'> <span class ='glyphicon glyphicon-remove-sign'></span>  </a>

                        </td>
                    </tr>
                     <?php while($child =mysqli_fetch_assoc($childResult)):?>
                     <tr class='bg-info'>
                        <td> <?= $child['category'];?></td>
                        <td> <?= $parent['category'];?></td>
                        <td>
                            <a href="categories.php?edit=<?= $child['id'];?>" class='btn btn-xs btn-default'> <span class ='glyphicon glyphicon-pencil'></span>  </a>
                            <a href="categories.php?delete=<?= $child['id'];?>" class='btn btn-xs btn-default'> <span class ='glyphicon glyphicon-remove-sign'></span>  </a>

                        </td>
                    </tr>


                      <?php endwhile;?>
                <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'includes/footer.php';?>