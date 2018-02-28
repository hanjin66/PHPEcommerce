<?php

require_once 'core/init.php';
include 'includes/head.php'; 
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftbar.php';

$sql = "SELECT * FROM products WHERE featured =1";
 ?>





        
        <!-- main content -->
        <div class="col-md-8">Feature products
            <div class="row">
                <h2 class="text-center">Feature products</h2>
                <div class="col-md-3">
                    <h4>Levis Jean</h4>
                    <img src="images/products/men4.png" alt="levis Jeans" class="img-thumb" />
                    <p class="list-price text-danger"> List price:
                        <s>54</s>
                    </p>
                    <p class="price">Our price: $19.99</p>
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
                </div>
                
            </div>
        </div>
    



<?php
include 'includes/detailsmodal.php';
include 'includes/rightbar.php';
include 'includes/footer.php';
 
 ?>
