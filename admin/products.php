 <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tutorial/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';



if (isset($_GET['add'])) {
    $brandSql = $db->query("SELECT * FROM brand ORDER By Brand");
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent=0 ORDER BY category");
    if ($_POST) {
        $errors=array();
        if (!empty($_POST['sizes'])) {
            $sizeString=sanitize($_POST['sizes']);
            $sizeString=rtrim($sizeString,',');echo $sizesString;
            $sizesArray = explode(',',$sizeString);
            $sArray=array();
            $qArray=array();
            foreach ($sizesArray as $ss) {
            $s=explode(':',$ss);
            $sArray[]=$s[0];
            $qArray[]=$s[1];

            }
        }else{$sizesArray=array();}
        $required = array('title','brand','price','parent','child','sizes');
        foreach($required as $field){
            if($_POST[$field] == ''){
                $errors[]='All fields with and Astrisk are required.';
                break;
            }
        }
        if(!empty($_FILES)) {
            var_dump($_FILES);
            $name=$_FILES[0];
            $name= $photo['name'];
            $nameArray = explode('.');

        }


        if(!empty($errors)){
            echo display_error($errors);
        } else{
            //update file and insert into database
        }
    }
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
    <input type="text" it="price" name="price" class="form-control" value="<?=((isset($_POST['price'])) ? sanitize($_POST['price']) : ' ');?>">
</div>
<div class="form-group col-md-3">
    <label for="price">List Price:</label>
    <input type="text" it="list_price" name="list_price" class="form-control" value="<?=((isset($_POST['list_price'])) ? sanitize($_POST['list_price']) : ' ');?>">
</div>
<div class="form-group col-md-3">
<label for="">Quantity and sizes*:</label>
<btn class='btn btn-default form-control' onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity and sizes</btn>
</div>
<div class="form-group col-md-3">
<label for="sizes">Sizes & Quanity Preview</label>
<input type="text" class="form-control" name="size" id="sizes" value="<?=((isset($_POST['sizes'])) ? $_POST['sizes'] : ' ');?>" readonly>
</div>
<div class ="form-group col-md-6">
<label for="photo">Product photo</label>
<input type="file"  name ="photo" id="photo" class="form-control">
</div>
<div class="form-group col-md-6">
<label for="description">description</label>
<textarea name="description" id="description" class="form-control" cols="30" rows="6">
<?=((isset($_POST['description'])) ? sanitize($_POST['description']) : ' ');?>
</textarea>
</div>
<div class="col-md-3 pull-right">
<input type="submit" value="Add Product" class="form-control-btn btn-success pull-right">
</div>
<div class="clearfix">
</div>
</form>

<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModal" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sizesModal">Size and Quantity</h5></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container-fluid">
        <?php for ($i = 1; $i <= 12; $i++) : ?>
            <div class="form-group col-md-4">
                <label for="size<?= $i; ?>">Size: </label>
                <input type="text" name="size<?= $i; ?>" id="size<?= $i ?>"  value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="qty<?= $i; ?>">Quantity: </label>
                <input type="number" name="qty<?= $i; ?>" id="qty<?= $i ?>"  value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">  
            </div> 
            <?php endfor; ?>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>





 <?php } else {
    # code...

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


 <h2 class="text-center">Products</h2><hr>
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

<?php }
include 'includes/footer.php';?>
