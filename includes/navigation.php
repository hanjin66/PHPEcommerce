<?php
  $sql = "SELECT * FROM categories  WHERE parent = 0";
  $pquery =$db->query($sql);
?>


    <!-- top nav bar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <a href="index.php" class="navbar-brand">New page </a>
            <ul class="nav navbar-nav">
                <?php while($parent = mysqli_fetch_assoc($pquery)) :?>
                <?php 
                $parent_id = $parent['id'];
                $sql2 = "SELECT * FROM categories WHERE parent = $parent_id";
                $cquery = $db->query($sql2);
                ?>


                <!-- mens closing -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'];?>
                        <span class="caret">
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php while($child = mysqli_fetch_assoc($cquery)):?>

                        <li>
                            <a href="#"> <?php echo $child['category'];?></a>
                        </li>
                        <?php endwhile;?>
                        
                    </ul>
                </li>
                <?php endwhile;?>
              

                <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Women
                        <span class="caret">
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="#"> Shirts</a>
                        </li>
                        <li>
                            <a href="#"> pants</a>
                        </li>
                        <li>
                            <a href="#"> Shoes</a>
                        </li>
                        <li>
                            <a href="#"> Shirts</a>
                        </li>
                    </ul>
                </li> -->
            </ul>
            </a>
        </div>
    </nav>