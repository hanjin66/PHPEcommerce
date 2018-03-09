 <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tutorial/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

if (isset($_GET['add'])) {
    $brandSql = $db->query("SELECT * FROM brand ORDER By Brand");
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent=0 ORDER BY category");
    ?>

<h2 class="text-center"> Add A New Product</h2><hr>
<form action="products.php?add=1" method="post" enctype="multipart/form-data">
<div class="form-group col-md-3">
<label for="title"> Title: </label>
<input type="text" name="title" class="form-control" id="title" value="<?=((isset($_POST['title'])) ? sanitize($_POST['title']) : '');?>">
</div>
<div class="form-group col-md-3">
<label for="brand">Brand*:</label>
<select class="form-control" name="brand" id="brand">
<option value=""<?=((isset($_POST['brand']) && $_POST['brand'] == '') ? ' selected' : '');?>></option>

 <?php while ($brand = mysqli_fetch_assoc($brandSql)): ?>
 <option value="<?=$brand['id'];?>"<?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id']) ? ' selected' : '');?>><?=$brand['brand'];?></option>
<?php endwhile;?>
</select>
</div>
<div class="form-group col-md-3">
<label for="parent">Parent Category*:</label>
<select class="form-control" name="parent" id="parent">

<option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '') ? ' selected' : '');?>></option>

<?php while ($parent = mysqli_fetch_assoc($parentQuery)): ?>
    <option value="<?=$parent['id'];?>"<?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id']) ? 'selected' : '');?>><?=$parent['category'];?></option>
 <?php endwhile;?>

</select>
</div>
<div class= "form-group col-md-3">
<label for="child">Child Category*:</label>
<select name="child" id="child" class="form-control">
</select>
</div>
<div class="form-group col-md-3">
    <label for="price">Price*:</label>
    <input type="text" it="price" name="price" class="form-control" value="<?=  ((isset($_POST['price']))?$_POST['price']:' ');?>">  
</div>
<div class="form-group col-md-3">
    <label for="price">List Price*:</label>
    <input type="text" it="list_price" name="list_price" class="form-control" value="<?=  ((isset($_POST['list_price']))?$_POST['list_price']:' ');?>">  
</div>
<div class="form-group col-md-3">
<label for="">Quantity and sizes*:</label>
<btn class='btn btn btn-default form-control' onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity and sizes</btn>
</div>
<div class="form-group col-md-3">
<label for="sizes">Sizes & Quanity</label>
<input type="text" class="form-control" name="size" id="size" value="<?=  ((isset($_POST['sizes']))?$_POST['sizes']:' ');?>" readonly>
</div>


</form>

 <?php } else {
    # code...
}

//set featured products
$sql = "SELECT * FROM products WHERE deleted= 0";
$results = $db->query($sql);
if (isset($_GET['featured'])) {
    $id = (int) $_GET['id'];
    $featured = (int) $_GET['featured'];
    $featuredSQL = "UPDATE products SET featured = '$featured' WHERE id='$id'";
    $db->query($featuredSQL);
    header('Location:products.php');
}
?>


 <!-- <h2 class="text-center">Products</h2><hr> -->
 <a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product
 </a>

<div class="clearfix"></div>
<br>
 <table class="table table-bordered table-condensed table-striped">
<thead>
<th></th><th>Products</th><th>Price</th><Th>Category</Th><th>Feature</th><th>Sold</th>
</thead>
<tbody></tbody>
<!-- // display category -->
 <?php while ($product = mysqli_fetch_assoc($results)):
    $childID = $product['categories'];
    $catSql = "SELECT * FROM categories WHERE id=$childID";
    $result = $db->query($catSql);
    $child = mysqli_fetch_assoc($result);
    $parentID = $child['parent'];
    $pSql = "SELECT * FROM categories Where id = '$parentID'";
    $presult = $db->query($pSql);
    $parent = mysqli_fetch_assoc($presult);
    $category = $parent['category'] . '~' . $child['category'];
    ?>
			 <tr>
			     <td><a href="products.php?edit=<?$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span> </a>
			     <a href="products.php?edit=<?$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span> </a>

			</td>
			     <td> <?=$product['title'];?></td>
			     <td> <?=money($product['price']);?></td>
			     <td> <?=$category;?></td>
			     <td><a href="products.php?featured=<?=(($product['featured'] == 0) ? '1' : '0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default">
			     <span class="glyphicon glyphicon-<?=(($product['featured'] == 1) ? 'minus' : 'plus');?>"></span></a>
			     &nbsp  <?=(($product['featured'] == 1) ? 'Featured Product' : '');?>
			     </td>

			     <td>0</td>
			 </tr>

			<?php endwhile;?>
</table>

  <?php include 'includes/footer.php';?>
