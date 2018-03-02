<?php
require_once '../core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
//get brands from database
$sql="SELECT * FROM brand ORDER BY brand";
$results = $db->query($sql);

?>

<h2 class='text-center'>Brands</h2>
<table class='table table-bordered table-striped table-auto'>

<thead>
    <th></th> <th>Brands</th> <th></th>
</thead>
<tbody>
    <?php while($brand = mysqli_fetch_assoc($results)): ?>
<tr>
    <td><a href="brand.php?edit=<?=$brand['id']; ?>" class='btn btn-sx btn-default'><span class='glyphicon glyphicon-pencil'></span></a></td>

    <td> <?= $brand['brand'];?></td>
    <td><a href="brand.php?delete=1" class='btn btn-sx btn-default'><span class='glyphicon glyphicon-remove-sign'></span></a></td>

</tr>

 <?php endwhile; ?>

</tbody>


</table>

 <?php include 'includes/footer.php';?>