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
        .content-card { background: #ffffff; padding: 40px; border: 2px solid #7faf51; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .page-title { color: #7faf51; font-weight: bold; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        .contact-info-item { margin-bottom: 25px; display: flex; align-items: flex-start; }
        .contact-info-item i { font-size: 20px; color: #7faf51; margin-right: 15px; margin-top: 5px; }
        .contact-info-item h4 { margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-control { border-radius: 8px; border: 1px solid #eee; padding: 12px; margin-bottom: 15px; }
        .form-control:focus { border-color: #7faf51; box-shadow: none; }
        .btn-send { background: #7faf51; color: #fff; padding: 12px 35px; border-radius: 30px; border: none; font-weight: bold; transition: 0.3s; width: 100%; }
        .btn-send:hover { background: #6a9645; transform: translateY(-2px); }
        .map-wrapper { border-radius: 15px; overflow: hidden; border: 1px solid #eee; margin-top: 20px; line-height: 0; }
        .map-wrapper iframe { width: 100% !important; height: 450px !important; border: 0; }
        .hours-text { font-size: 14px; color: #666; line-height: 1.6; }
    </style>

    <div class="container" style="margin-top: 40px; margin-bottom: 60px;">
        <div class="content-card">
            <h2 class="page-title">Contact Us</h2>
            
            <div class="row">
                <div class="col-md-5">
                    <h3 style="margin-bottom: 30px; color: #333;">Get In Touch</h3>
                    
                    <div class="contact-info-item">
                        <i class="fa fa-map-marker"></i>
                        <div>
                            <h4>Visit Our Office</h4>
                            <p>Sheikhghat, Sylhet 3100, Bangladesh</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="fa fa-phone"></i>
                        <div>
                            <h4>Direct Call</h4>
                            <p>+880 1303968132</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="fa fa-envelope"></i>
                        <div>
                            <h4>Support Email</h4>
                            <p>syedsami.conenct@gmail.com</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="fa fa-clock-o"></i>
                        <div>
                            <h4>Working Hours</h4>
                            <div class="hours-text">
                                <strong>Mon-Fri:</strong> 8:30am - 7:30pm<br>
                                <strong>Sat-Sun:</strong> 9:30am - 4:30pm
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div style="background: #f9f9f9; padding: 30px; border-radius: 12px;">
                        <h3 style="margin-bottom: 20px; color: #333;">Send Us a Message</h3>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                </div>
                            </div>
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                            <textarea name="message" class="form-control" rows="4" placeholder="How can we help you?" required></textarea>
                            <button type="submit" class="btn-send">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 40px;">
                <div class="col-lg-12">
                    <h3 style="margin-bottom: 20px; color: #333;">Our Location</h3>
                    <div class="map-wrapper">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3619.231019818651!2d91.8583805760475!3d24.890100344069598!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3751aacd70cd7665%3A0xc8ae330ad72490dd!2sNorth%20East%20University%20Bangladesh%2CSylhet!5e0!3m2!1sen!2sbd!4v1768587812647!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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