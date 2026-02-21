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
        .policy-section {
            margin-bottom: 40px;
        }
        .policy-section h3 {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .policy-section h3 i {
            color: #7faf51;
            margin-right: 15px;
        }
        .text-content p {
            font-size: 16px;
            line-height: 1.8;
            color: #666;
            margin-bottom: 20px;
            text-align: justify;
        }
        .data-card {
            background: #f4fcf6;
            border: 1px solid #e1f0e5;
            padding: 25px;
            border-radius: 12px;
            margin: 30px 0;
        }
        .data-card ul {
            list-style: none;
            padding-left: 0;
        }
        .data-card ul li {
            margin-bottom: 10px;
            color: #444;
            display: flex;
            align-items: center;
        }
        .data-card ul li i {
            color: #7faf51;
            margin-right: 10px;
        }
    </style>

    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-card">
                        <h2 class="page-title">Privacy Policy</h2>
                        
                        <div class="text-content">
                            <p>At <strong>Fruid</strong>, we respect your personal space and are committed to protecting the data you share with us. This policy explains how we handle your information across our website and AI-powered health platforms.</p>

                            <div class="policy-section">
                                <h3><i class="fa fa-user-circle"></i> 01. Information We Collect</h3>
                                <p>We collect information to provide better services to all our users. This includes basic details like your name and delivery address, as well as specialized data for our AI features:</p>
                                <div class="data-card">
                                    <ul>
                                        <li><i class="fa fa-check"></i> <strong>Account Data:</strong> Name, Email, Phone, and Shipping Address.</li>
                                        <li><i class="fa fa-check"></i> <strong>Health Metrics:</strong> BMI data, weight, and height (for personalized AI diet plans).</li>
                                        <li><i class="fa fa-check"></i> <strong>Usage Data:</strong> Smoothies built, fruit preferences, and order history.</li>
                                    </ul>
                                </div>
                            </div>

                            

                            <div class="policy-section">
                                <h3><i class="fa fa-shield"></i> 02. How We Protect Your Data</h3>
                                <p>We implement a variety of security measures to maintain the safety of your personal information. We use state-of-the-art encryption (SSL) for all transactions and health data processing. Access to your sensitive information is strictly limited to authorized personnel who are required to keep the information confidential.</p>
                            </div>

                            <div class="policy-section">
                                <h3><i class="fa fa-robot"></i> 03. AI and Data Processing</h3>
                                <p>Our <strong>AI Nutritionist</strong> and <strong>Smoothie Builder</strong> process your health metrics locally to provide real-time suggestions. This data is used solely to enhance your health experience and is never shared with third-party advertisers or external health agencies without your explicit consent.</p>
                            </div>

                            <div class="policy-section">
                                <h3><i class="fa fa-cookie-bite"></i> 04. Cookie Policy</h3>
                                <p>Fruid uses cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits, and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>
                            </div>

                            <div class="policy-section">
                                <h3><i class="fa fa-envelope-open"></i> 05. Contacting Us</h3>
                                <p>If there are any questions regarding this privacy policy, you may contact our Data Protection Officer at:</p>
                                <p style="font-weight: 700; color: #333;">
                                    Email: fruidt@gmail.com<br>
                                    Address: Sylhet 3100, Bangladesh
                                </p>
                            </div>

                            <p style="font-size: 13px; color: #999; margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px;">
                                Last Updated: January 2026. Fruid reserves the right to modify this policy at any time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>s

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/mobile_footer.php"); ?>
    <?php include_once("includes/mobile_global.php"); ?>
    <?php include_once("includes/script.php"); ?>
</body>
</html>