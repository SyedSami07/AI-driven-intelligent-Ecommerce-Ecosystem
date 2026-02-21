<?php
$obj = new adminback();
$links = $obj->display_links();
$link = mysqli_fetch_assoc($links);
?>

<div class="header-bottom hidden-sm hidden-xs">
    <div class="container">
        <div class="row" style="display: flex; align-items: center;">
            <div class="col-lg-3 col-md-4">
                <?php include_once("vertical_menu.php") ?>
            </div>
            
            <div class="col-lg-9 col-md-8 padding-top-2px">
                <div style="display: flex; align-items: center; justify-content:建设-between;">
                    
                    <div style="flex-grow: 1;">
                        <?php include_once("search_bar.php") ?>
                    </div>

                    <div style="margin: 0 15px;">
                        <a href="smoothie_builder.php" class="smoothie-btn">
                            <i class="fa fa-flask"></i> Smoothie Builder
                        </a>
                    </div>

                    <div class="live-info">
                        <p class="telephone"><i class="fa fa-phone" aria-hidden="true"></i><b class="phone-number"> <?php echo $link['phone'] ?> </b></p>
                        <p class="working-time">Mon-Fri: 8:30am-7:30pm; Sat-Sun: 9:30am-4:30pm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
.smoothie-btn {
    background: linear-gradient(to right, #7faf51, #4a7c1a);
    color: white !important;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 12px;
    display: inline-block;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(127, 175, 81, 0.3);
    text-decoration: none;
    border: none;
}
.smoothie-btn:hover {
    background: linear-gradient(to right, #4a7c1a, #7faf51);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(127, 175, 81, 0.4);
}
.smoothie-btn i {
    margin-right: 8px;
}
</style>