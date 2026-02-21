<?php 
  $five_catagory_result = $obj->display_five_catagory();
  $five_catagories = array();

  while($cata = mysqli_fetch_assoc($five_catagory_result)){
      $five_catagories[] = $cata;
  }

  // Optimized: Map categories to their products using a loop or array
  // We use the actual ID from the database to fetch products
  $pdt_feeds = array();
  foreach($five_catagories as $index => $cat) {
      // Assuming your display_five_products function takes the Category ID
      $pdt_feeds[$index] = $obj->display_five_products($cat['ctg_id']);
  }
?>

<div class="product-tab z-index-20 sm-margin-top-193px xs-margin-top-30px">
    <div class="container">
        <div class="biolife-title-box">
            <span class="subtitle">All the best item for You</span>
            <h3 class="main-title">Related Products</h3>
        </div>
        <div class="biolife-tab biolife-tab-contain sm-margin-top-34px">
            <div class="tab-head tab-head__icon-top-layout icon-top-layout">
                <ul class="tabs md-margin-bottom-35-im xs-margin-bottom-40-im">
                    <?php 
                    $icons = ['icon-lemon', 'icon-grape2', 'icon-blueberry', 'icon-orange', 'icon-broccoli'];
                    $tab_ids = ['1st', '2nd', '3rd', '4th', '5th'];
                    
                    foreach($five_catagories as $key => $cat): ?>
                        <li class="tab-element <?php echo ($key == 0) ? 'active' : ''; ?>">
                            <a href="#tab01_<?php echo $tab_ids[$key]; ?>" class="tab-link">
                                <span class="biolife-icon <?php echo $icons[$key] ?? 'icon-lemon'; ?>"></span>
                                <?php echo $cat['ctg_name']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="tab-content">
                <?php foreach($five_catagories as $key => $cat): ?>
                <div id="tab01_<?php echo $tab_ids[$key]; ?>" class="tab-contain <?php echo ($key == 0) ? 'active' : ''; ?>">
                    <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile eq-height-contain" data-slick='{"rows":2 ,"arrows":true,"dots":false,"infinite":true,"speed":400,"slidesMargin":10,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":20}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":15}}]}'>

                        <?php 
                            $product_result = $pdt_feeds[$key];
                            while($pdt = mysqli_fetch_assoc($product_result)): 
                        ?>
                        <li class="product-item">
                            <div class="contain-product layout-default">
                                <div class="product-thumb">
                                    <a href="single_product.php?status=singleproduct&id=<?php echo $pdt['pdt_id'] ?>" class="link-to-product">
                                        <img src="admin/uploads/<?php echo $pdt['pdt_img'] ?>" alt="Fruit" width="270" height="270" class="product-thumnail">
                                    </a>
                                </div>
                                <div class="info">
                                    <b class="categories"><?php echo $cat['ctg_name'] ?></b>
                                    <h4 class="product-title">
                                        <a href="single_product.php?status=singleproduct&id=<?php echo $pdt['pdt_id'] ?>" class="pr-name">
                                            <?php echo $pdt['pdt_name'] ?>
                                        </a>
                                    </h4>
                                    <div class="price">
                                        <ins><span class="price-amount"><span class="currencySymbol">TK. </span><?php echo $pdt['pdt_price'] ?></span></ins>
                                    </div>
                                    <div class="slide-down-box">
                                        <p class="message">All products are carefully selected to ensure food safety.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>