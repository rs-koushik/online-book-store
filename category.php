 <?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>
 
<link href="admin/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap');
</style>
<script src="admin/assets/vendor/jquery/jquery.min.js"></script>
<script src="admin/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<?php
$categories = $conn->query("SELECT * FROM `category_list` order by `name` asc");
if($categories->num_rows > 0):
?>
<li class="nav-item position-relative " id="cat-menu-link">
    <div id="category-menu" class="">
    <ol>
        <?php 
        while($row = $categories->fetch_assoc()):
        ?>
        <li><a href="category.php?page=category&id=<?= $row['id'] ?>"><?= $row['name'] ?></a></li>
        <?php endwhile; ?>
    </ol>
    </div>
</li>
<?php endif; ?>


<header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-center mb-4 page-title">
                    	<h1 class="text-white"><?= $data['name'] ?? "" ?></h1>
                        <hr class="divider my-4 bg-dark" />

                    </div>
                    
                </div>
            </div>
        </header>
	<section class="page-section" id="menu">
        <h1 class="text-center text-cursive" style="font-size:3em"><b><?= $data['name'] ?? "" ?>'s Menu</b></h1>
        <div class="d-flex justify-content-center">
            <hr class="border-dark" width="5%">
        </div>
        <div class="row mx-0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="menu-field" class="card-deck px-2 py-3 justify-content-center">
                        <?php 
                            include 'config.php';
                            $limit = 10;
                            $page = (isset($_GET['_page']) && $_GET['_page'] > 0) ? $_GET['_page'] - 1 : 0 ;
                            $offset = $page > 0 ? $page * $limit : 0;
                            $all_menu =$conn->query("SELECT id FROM  products")->num_rows;
                            $page_btn_count = ceil($all_menu / $limit);
                            $qry = $conn->query("SELECT * FROM  products where `category_id` = '{$user_id}' order by `name` asc Limit $limit OFFSET $offset ");
                            while($row = $qry->fetch_assoc()):
                            ?>
                            <div class="col-lg-3 mb-3">
                            <div class="card menu-item  rounded-0">
                                <div class="position-relative overflow-hidden" id="item-img-holder">
                                    <img src="uploaded_img/<?php echo $row['image'] ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body rounded-0">
                                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                                <p class="card-text truncate"><?php echo $row['description'] ?></p>
                                <h3 class="card-text truncate">&#8377;<?php echo $row['offer_price'] ?> /- </h3>
                                <div class="text-center">
                                    <button class="btn btn-sm btn-outline-dark view_prod btn-block" data-id=<?php echo $row['id'] ?>><i class="fa fa-eye"></i> View</button>
                                    
                                </div>
                                </div>
                                
                            </div>
                            </div>
                            <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php //$page_btn_count = 10;exit; ?>
        
        
        
    </section>
    <script>
        
        $('.view_prod').click(function(){
            uni_modal_right('Product Details','view_prod.php?id='+$(this).attr('data-id'))
        })
    </script>
    <?php if(isset($_GET['_page'])): ?>
        <script>
            $(function(){
                document.querySelector('html').scrollTop = $('#menu').offset().top - 100
            })
        </script>
    <?php endif; ?>
	
