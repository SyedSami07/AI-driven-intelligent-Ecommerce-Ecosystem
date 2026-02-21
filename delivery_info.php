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
        .info-header {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            margin-top: 40px;
        }
        .delivery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        .delivery-step {
            padding: 30px;
            background: #fdfdfd;
            border: 1px solid #f0f0f0;
            border-radius: 15px;
            text-align: center;
        }
        .step-icon {
            font-size: 40px;
            color: #7faf51;
            margin-bottom: 20px;
        }
        .pricing-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }
        .pricing-table th {
            background: #f4fcf6;
            color: #333;
            padding: 20px;
            border: 1px solid #eee;
            text-align: left;
        }
        .pricing-table td {
            padding: 20px;
            border: 1px solid #eee;
            color: #666;
        }
        .shipping-badge {
            display: inline-block;
            background: #7faf51;
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .freshness-box {
            background: #f9fdfa;
            border-left: 6px solid #7faf51;
            padding: 30px;
            margin-top: 50px;
            border-radius: 0 15px 15px 0;
        }
    </style>

    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-card">
                        <h2 class="page-title">Delivery & Shipping Information</h2>
                        
                        <div class="text-content">
                            <p>At <strong>Fruid</strong>, we don't just deliver food; we deliver health. Our logistics system is specifically designed to handle delicate organic produce, ensuring that every fruit arrives with the same nutritional profile it had when it left the tree.</p>

                            <h3 class="info-header">The 3-Day Quality Cycle</h3>
                            <p>To guarantee 100% freshness, we operate on a specialized 72-hour fulfillment cycle. This allows us to harvest your produce only after you order, avoiding long storage times that degrade vitamins and minerals.</p>

                            

                            <div class="delivery-grid">
                                <div class="delivery-step">
                                    <div class="step-icon"><i class="fa fa-calendar-check-o"></i></div>
                                    <h4>Day 1: Harvest</h4>
                                    <p>Your order is sent to our partner orchards in Sylhet. Fruits are picked at peak ripeness.</p>
                                </div>
                                <div class="delivery-step">
                                    <div class="step-icon"><i class="fa fa-search"></i></div>
                                    <h4>Day 2: Quality Audit</h4>
                                    <p>Fruits are cleaned, lab-tested for chemical traces, and packed in eco-friendly containers.</p>
                                </div>
                                <div class="delivery-step">
                                    <div class="step-icon"><i class="fa fa-paper-plane"></i></div>
                                    <h4>Day 3: Dispatch</h4>
                                    <p>Our cold-chain couriers deliver the order to your doorstep by the afternoon.</p>
                                </div>
                            </div>

                            <h3 class="info-header">Shipping Rates & Zones</h3>
                            <table class="pricing-table">
                                <thead>
                                    <tr>
                                        <th>Shipping Zone</th>
                                        <th>Delivery Window</th>
                                        <th>Charge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Sylhet City</strong></td>
                                        <td>3-4 hours</td>
                                        <td>Tk. 60</td>
                                    </tr>
                                
                                    <tr>
                                        <td><strong>Outside Sylhet</strong></td>
                                        <td><span class=>1-2 days</span></td>
                                        <td>Tk. 150</td>
                                    </tr>
                                   
                                </tbody>
                            </table>

                            <div class="freshness-box">
                                <h4 style="color:#7faf51; margin-bottom:15px;"><i class="fa fa-shield"></i> Our Freshness Guarantee</h4>
                                <p style="margin-bottom:0;">If your fruit arrives damaged or does not meet our freshness standards, we provide a no-questions-asked replacement within 24 hours. Every delivery is monitored via AI-optimized route tracking to minimize time spent in transit.</p>
                            </div>

                            <p style="margin-top: 50px; color: #999; font-size: 14px;">
                                *Please note: Delivery times may be affected by extreme weather conditions or regional holidays. You will receive an SMS with a live tracking link as soon as your order is dispatched.
                            </p>
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