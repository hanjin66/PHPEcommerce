<?php
require_once '../core/init.php';
$id=$_POST['id'];
$id=(int)$id;
$sql="SELECT * FROM products WHERE id='$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$sql= "SELECT brand FROM brand Where id='$brand_id'" ;
$brand_query=$db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$sizestring = $product['sizes'];
$size_array = explode(',',$sizestring);
?>

    <!-- Details Modal -->

    <?php ob_start();?>
    <div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" onclick="closeModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-little text-center">
                        <?php echo $product['title']; ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class "container-fluid">
                        <div class="row" style="display: flex">
                            <div class="col-sm-6">
                                <div class="center-block">

                                    <img src="<?= $product['image'];?>" alt="<?php echo $product['title'];?>" class="details img-responsive">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4>Details</h4>
                                <p>
                                    <?= $product['description'];?>
                                </p>
                                <hr>
                                <p>
                                    <?= $product['price'];?>
                                </p>
                                <p>Brand:
                                    <?= $brand['brand'];?>
                                </p>

                               
                               
                                
                                
                                    <form action="add_cart.php" method="post">
                                            
                                            
                                                <div class="form-group">
                                                    <div class="col-xs-4">
                                                        <label for "quantity"> quantity:
                                                        </label>
                                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                                    </div>
                                                    <p>
                                                        <br>
                                                    </p>
                                                    <div class="col-sm-3"></div>
                                                </div>
                                                <br>
                                            
                                                <br>
                                            
                                            
                                            
                                                <div class="form-group">
                                                    <div class="col-xs-6">
                                                        <label for="size">
                                                            Size
                                                        </label>
                                                        <select name="size" id="size" class="form-control">
                                                            <option value=""></option>
                                                            <!-- seperating size array into size and quantity -->
                                                            <?php foreach($size_array as $string) {
                                                                             $string_array=explode(':',$string);
                                                                             $size = $string_array[0];
                                                                             $quantity = $string_array[1];
                                                                              echo '<option value="'.$size.'">'.$size.' ('.$quantity.' Avalable)</option>';
                                                                          }?>
                                            
                                            
                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                            
                                            
                                            </form>
                                
                                   
                               
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" onclick="closeModal()">Close</button>
                    <button class="btn btn-warning" type="submiit">
                        <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            jQuery('#details-modal').modal('hide');
            setTimeout(() => {
                jQuery('#details-modal').remove();
                jQuery('.modal-backdrop').remove();
            }, 500);
        }
    </script>


    <?php echo ob_get_clean();?>