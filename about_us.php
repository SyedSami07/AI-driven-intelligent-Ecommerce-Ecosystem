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
        .main-content { padding: 60px 0; background: #fff; }
        .content-card {
            background: #ffffff;
            padding: 60px;
            border: 1px solid #e1e1e1;
            border-top: 5px solid #7faf51;
            border-radius: 0 0 15px 15px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .page-title {
            color: #333;
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section-subtitle {
            color: #7faf51;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            display: block;
        }
        .text-content p {
            font-size: 17px;
            line-height: 2;
            color: #666;
            margin-bottom: 25px;
            text-align: justify;
        }
        .feature-box-large {
            text-align: center;
            padding: 40px 20px;
            background: #fdfdfd;
            border: 1px solid #f0f0f0;
            border-radius: 15px;
            transition: 0.4s;
            height: 100%;
        }
        .feature-box-large:hover {
            border-color: #7faf51;
            background: #fff;
            box-shadow: 0 15px 35px rgba(127, 175, 81, 0.1);
        }
        .feature-icon-circle {
            width: 80px;
            height: 80px;
            line-height: 80px;
            background: #f4fcf6;
            color: #7faf51;
            border-radius: 50%;
            font-size: 35px;
            margin: 0 auto 20px;
            display: block;
        }
        .highlight-quote {
            border-left: 6px solid #7faf51;
            padding: 30px 40px;
            background: #f9fdfa;
            margin: 50px 0;
            font-size: 20px;
            font-style: italic;
            color: #444;
            border-radius: 0 15px 15px 0;
        }
        .ai-label {
            background: #7faf51;
            color: white;
            font-size: 11px;
            padding: 2px 10px;
            border-radius: 50px;
            vertical-align: middle;
            margin-left: 8px;
        }
    </style>

    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-card">
                        <span class="section-subtitle">Since 2026</span>
                        <h2 class="page-title">Our Story & Mission</h2>
                        
                        <div class="text-content">
                            <p>Welcome to <strong>Fruid</strong>, the premier destination for premium organic fruits in Sylhet. We started with a vision to revolutionize the agricultural supply chain in Bangladesh. Our journey is rooted in the belief that everyone deserves access to fruits that are as nature intended: fresh, vibrant, and completely free from harmful chemicals.</p>
                            
                            <p>We work directly with local orchard owners and global sustainable farms to ensure that every mango, apple, and citrus fruit we deliver meets our "Gold Standard" for quality. By cutting out the middlemen, we ensure that our farmers get fair pay and you get the freshest harvest possible within 72 hours.</p>

                            <div class="row" style="margin-top: 60px; margin-bottom: 60px;">
                                <div class="col-md-4 mb-4">
                                    <div class="feature-box-large">
                                        <div class="feature-icon-circle"><i class="fa fa-leaf"></i></div>
                                        <h4 style="font-weight:700;">100% Organic</h4>
                                        <p style="font-size:14px; line-height:1.6;">Zero Formalin, Zero Pesticides. Our produce is lab-tested for safety and natural ripening.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="feature-box-large">
                                        <div class="feature-icon-circle"><i class="fa fa-truck"></i></div>
                                        <h4 style="font-weight:700;">3-Day Shipping</h4>
                                        <p style="font-size:14px; line-height:1.6;">A specialized cold-chain logistics network designed to maintain the biological integrity of the fruit.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="feature-box-large">
                                        <div class="feature-icon-circle"><i class="fa fa-microchip"></i></div>
                                        <h4 style="font-weight:700;">AI Intelligence</h4>
                                        <p style="font-size:14px; line-height:1.6;">Utilizing modern AI algorithms to track your nutrition and suggest the best fruits for your BMI.</p>
                                    </div>
                                </div>
                            </div>

                            <h3 style="color: #333; font-weight: 700; margin-bottom: 20px;">Why We Are Different</h3>
                            <p>Unlike traditional markets, Fruid is an agro-tech ecosystem. We have integrated <strong>Artificial Intelligence</strong> to help you make smarter health decisions. Our unique services include:</p>
                            
                            <ul style="list-style: none; padding-left: 0; margin-bottom: 40px;">
                                <li style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;">
                                    <i class="fa fa-check" style="color:#7faf51; margin-right:10px;"></i> 
                                    <strong>AI Smoothie Builder:</strong> Real-time nutrient and calorie calculation.
                                </li>
                                <li style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;">
                                    <i class="fa fa-check" style="color:#7faf51; margin-right:10px;"></i> 
                                    <strong>Smart BMI Integration:</strong> Personalized fruit diet recommendations.
                                </li>
                                <li style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;">
                                    <i class="fa fa-check" style="color:#7faf51; margin-right:10px;"></i> 
                                    <strong>Voice-Command Shopping:</strong> Hands-free browsing for a modern experience.
                                </li>
                            </ul>

                            

                            <div class="highlight-quote">
                                "Our mission is simple: To empower every household in Sylhet with the gift of health, driven by nature and optimized by intelligence."
                            </div>

                            <p>As we continue to grow, our commitment remains the same: Transparency in sourcing, excellence in delivery, and innovation in health. Thank you for choosing Fruid as your trusted partner in wellness.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/mobile_footer.php"); ?>
    <?php include_once("includes/mobile_global.php"); ?>
    <?php include_once("includes/script.php"); ?>
</body>
</html>