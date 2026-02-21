<?php

session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();

$cata_info = $obj->p_display_catagory();
$cataDatas = array();
while ($data = mysqli_fetch_assoc($cata_info)) {
    $cataDatas[] = $data;
}

// --- Pagination Logic Start ---
$limit = 8; // Products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $limit;

$pdt_info = $obj->view_all_product();
$all_pdts = array();

while($pdt_ftecth = mysqli_fetch_assoc($pdt_info)){
    $all_pdts[] = $pdt_ftecth;
}

$total_products = count($all_pdts);
$total_pages = ceil($total_products / $limit);

// Slice the array to only show products for the current page
$pdt_datas = array_slice($all_pdts, $start, $limit);
// --- Pagination Logic End ---

?>

<?php
include_once("includes/head.php");
?>

<body class="biolife-body">
    <?php include_once("includes/preloader.php"); ?>

    <header id="header" class="header-area style-01 layout-03">
        <?php include_once("includes/header_top.php"); ?>
        <?php include_once("includes/header_middle.php"); ?>
        <?php include_once("includes/header_bottom.php"); ?>
    </header>

    <div class="page-contain">
        <div id="main-content" class="main-content">
            <div class="container">
                <div class="product-category grid-style">
                    <div class="row">
                        <ul class="products-list">

                            <?php
                            foreach ($pdt_datas as $pdt_data) {
                            ?>
                                <li class="product-item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="contain-product layout-default">
                                        <div class="product-thumb">
                                            <a href="single_product.php?status=singleproduct&&id=<?php echo $pdt_data['pdt_id'] ?>" class="link-to-product">
                                                <img src="admin/uploads/<?php echo $pdt_data['pdt_img'] ?>" alt="dd" width="270" height="270" class="product-thumnail">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <b class="categories"> <?php echo $pdt_data['ctg_name'] ?> </b>
                                            <h4 class="product-title"><a href="single_product.php?status=singleproduct&&id=<?php echo $pdt_data['pdt_id'] ?>" class="pr-name"><?php echo $pdt_data['pdt_name'] ?></a></h4>
                                            <div class="price">
                                                <ins><span class="price-amount"><span class="currencySymbol">Tk. </span><?php echo $pdt_data['pdt_price'] ?></span></ins>
                                            </div>
                                            <div class="shipping-info">
                                                <p class="shipping-day">3-Day Shipping</p>
                                                <p class="for-today">Pree Pickup Today</p>
                                            </div>
                                            <div class="slide-down-box">
                                                <p class="message">All products are carefully selected to ensure food safety.</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>

                        </ul>
                    </div>

                    <div class="biolife-panigations-block">
                        <ul class="panigation-contain">
                            
                            <?php if($page > 1): ?>
                                <li><a href="?page=<?php echo $page - 1; ?>" class="link-page"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <?php endif; ?>

                            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                <li>
                                    <a href="?page=<?php echo $i; ?>" class="link-page <?php echo ($i == $page) ? 'current-page' : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if($page < $total_pages): ?>
                                <li><a href="?page=<?php echo $page + 1; ?>" class="link-page next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/mobile_footer.php"); ?>
    <?php include_once("includes/mobile_global.php") ?>

    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>
    <?php include_once("includes/script.php") ?>
</body>
</html>