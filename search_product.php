<?php
session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();

$search_results = array(); // Initialize as empty array to avoid errors

if(isset($_GET['search']) || isset($_GET['keyword'])){
    $keyword = $_GET['keyword'];
    if(!empty($keyword)){
        $search_query = $obj->search_product($keyword);
        
        if($search_query){
            while($search = mysqli_fetch_assoc($search_query)){
                $search_results[] = $search;
            }
        }
    } else {
        header('location:all_product.php');
        exit();
    }
}
?>

<?php
include_once("includes/head.php");
?>

<body class="biolife-body">
    <?php
    include_once("includes/preloader.php");
    ?>

    <header id="header" class="header-area style-01 layout-03">

        <?php
        include_once("includes/header_top.php");
        ?>

        <?php
        include_once("includes/header_middle.php");
        ?>

        <?php
        include_once("includes/header_bottom.php");
        ?>

    </header>

    <div class="page-contain">

        <div id="main-content" class="main-content">

            <div class="container">

            <?php 
                $search_item =count($search_results);
             
                echo "{$search_item} Items Found";
            ?>

                <div class="product-category grid-style">

                    <div class="row">
                        <ul class="products-list">

                            <?php
                            foreach ($search_results as $search_pdt) {
                            ?>

                                <li class="product-item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="contain-product layout-default">
                                        <div class="product-thumb">
                                            <a href="single_product.php?status=singleproduct&&id=<?php echo $search_pdt['pdt_id'] ?>" class="link-to-product">
                                                <img src="admin/uploads/<?php echo $search_pdt['pdt_img'] ?>" alt="dd" width="270" height="270" class="product-thumnail">
                                            </a>
                                        </div>
                                        <div class="info">
                                        <b class="categories"> <?php echo $search_pdt['ctg_name'] ?> </b>
                                            
                                            <h4 class="product-title"><a href="single_product.php?status=singleproduct&&id=<?php echo $search_pdt['pdt_id'] ?>" class="pr-name"><?php echo $search_pdt['pdt_name'] ?></a></h4>
                                            <div class="price">
                                                <ins><span class="price-amount"><span class="currencySymbol">Tk. </span><?php echo $search_pdt['pdt_price'] ?></span></ins>

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
                            <li><span class="current-page">1</span></li>
                            <li><a href="#" class="link-page">2</a></li>
                            <li><a href="#" class="link-page">3</a></li>
                            <li><span class="sep">....</span></li>
                            <li><a href="#" class="link-page">20</a></li>
                            <li><a href="#" class="link-page next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>

                </div>





            </div>
        </div>
    </div>

    <?php
    include_once("includes/footer.php");
    ?>

    <?php
    include_once("includes/mobile_footer.php");
    ?>

    <?php
    include_once("includes/mobile_global.php")
    ?>


    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>

    <?php
    include_once("includes/script.php")
    ?>

    <script>
        window.addEventListener('load', function() {
            const count = <?php echo $search_item; ?>;
            const keyword = "<?php echo addslashes($keyword); ?>";
            
            if (keyword !== "") {
                let text = (count > 0) ? 
                    `I found ${count} items for ${keyword}.` : 
                    `Sorry, I could not find any ${keyword}.`;

                const speech = new SpeechSynthesisUtterance(text);
                speech.lang = 'en-US';
                window.speechSynthesis.speak(speech);
            }
        });
    </script>
</body>
</html>