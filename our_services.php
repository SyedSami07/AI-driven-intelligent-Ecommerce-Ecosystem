<?php 
    session_start();
    include_once("admin/class/adminback.php"); 
    $obj = new adminback();

    // ADD THIS SECTION: Fetch categories so the header dropdown can see them
    $cata_info = $obj->p_display_catagory();
    $cataDatas = array();
    while ($data = mysqli_fetch_assoc($cata_info)) {
        $cataDatas[] = $data;
    }

    include_once("includes/head.php"); 
?>

<body class="biolife-body">
    <?php include_once("includes/preloader.php"); ?>

    <header id="header" class="header-area style-01 layout-03">
        <?php include_once("includes/header_top.php"); ?>
        <?php include_once("includes/header_middle.php"); ?>
        <?php include_once("includes/header_bottom.php"); ?>
    </header>

    <style>
        .content-card { background: #ffffff; padding: 40px; border: 2px solid #7faf51; border-radius: 15px; margin-bottom: 30px; }
        .service-item { padding: 25px; border: 1px solid #eee; border-radius: 12px; margin-bottom: 30px; height: 100%; transition: 0.3s; }
        .service-item:hover { border-color: #7faf51; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .ai-badge { background: #7faf51; color: #fff; font-size: 10px; padding: 2px 8px; border-radius: 10px; text-transform: uppercase; }
    </style>

    <div class="container" style="margin-top: 40px; margin-bottom: 60px;">
        <div class="content-card">
            <h2 class="page-title" style="color:#7faf51; font-weight:bold;">Our Services</h2>
            <div class="row">
                <div class="col-md-4"><div class="service-item"><h4>Retail</h4><p>Premium organic fruit sourcing.</p></div></div>
                <div class="col-md-4"><div class="service-item"><h4>AI Nutritionist <span class="ai-badge">AI</span></h4><p>BMI based fruit diet plans.</p></div></div>
                <div class="col-md-4"><div class="service-item"><h4>Smoothie Builder <span class="ai-badge">AI</span></h4><p>Real-time nutrient tracking.</p></div></div>
            </div>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/script.php"); ?>
</body>