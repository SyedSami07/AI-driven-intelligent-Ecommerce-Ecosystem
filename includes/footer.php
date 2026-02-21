<?php 
$obj= new adminback();
    $links = $obj->display_links();
    $link = mysqli_fetch_assoc($links);
   

?>
<footer id="footer" class="footer layout-03">
        <div class="footer-content background-footer-03">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-9">
                        <section class="footer-item">
                            <!--  -->
                            <div class="footer-phone-info">
                                <i class="biolife-icon icon-head-phone"></i>
                                <p class="r-info">
                                    <span>Got Questions ?</span>
                                    <span class="h4"> <a class="fa fa-envelope" href="#" style="color: gray; font-size:24px"> &nbsp;
                           <?php 
                            
                            
                             echo $link['phone'];

                             ?>
                             

                          </a></span>
                                </p>
                            </div>
                            <div class="newsletter-block layout-01">
                                <h4 class="title">Newsletter Signup</h4>
                                <div class="form-content">
                                    <form action="#" name="new-letter-foter">
                                        <input type="email" class="input-text email" value="" placeholder="Your email here...">
                                        <button type="submit" class="bnt-submit" name="ok">Sign up</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                        <section class="footer-item">
                            <h3 class="section-title">Useful Links</h3>
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-xs-6">
                                    <div class="wrap-custom-menu vertical-menu-2">
                                        <ul class="menu">
                                            <li><a href="about_us.php">About Us</a></li>
                                            <li><a href="delivery_info.php">Delivery information</a></li>
                                            <li><a href="privacy_policy.php">Privacy Policy</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xs-6">
                                    <div class="wrap-custom-menu vertical-menu-2">
                                        <ul class="menu">
                                            <li><a href="our_services.php">Our Services</a></li>
                                            <li><a href="contact_us.php">Contacts Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                        <section class="footer-item">
                            <h3 class="section-title">Transport Offices</h3>
                            <div class="contact-info-block footer-layout xs-padding-top-10px">
                                <ul class="contact-lines">
                                    <li>
                                        <p class="info-item">
                                            <i class="biolife-icon icon-location"></i>
                                            <b class="desc">Sheikhghat, Sylhet 3200, Bangladesh</b>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="info-item">
                                            <i class="biolife-icon icon-phone"></i>
                                            <b class="desc">Phone: <?php echo $link['phone'] ?></b>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="info-item">
                                            <i class="biolife-icon icon-letter"></i>
                                            <b class="desc">Email:  <?php echo $link['email'] ?></b>
                                        </p>  
                                    </li>
                                    <li>
                                        <p class="info-item">
                                            <i class="biolife-icon icon-clock"></i>
                                            <b class="desc">Hours: 7 Days a week from 10:00 am</b>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="biolife-social inline">
                                <ul class="socials">
                                    <li><a href="<?php echo $link['tweeter'] ?>" title="twitter" class="socail-btn"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo $link['fb_link'] ?>" title="facebook" class="socail-btn"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo $link['YouTube'] ?>" title="YouTube" class="socail-btn"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                                   
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="separator sm-margin-top-62px xs-margin-top-40px"></div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                       <div class="copy-right-text"><p>WE ACCEPT</p></div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="payment-methods">
                            <ul>
                                <li><a href="#" class="payment-link"><img src="assets/images/bkash.png" width="51" height="36" alt=""></a></li>
                                <li><a href="#" class="payment-link"><img src="assets/images/stripe.png" width="51" height="36" alt=""></a></li>
                                <li><a href="#" class="payment-link"><img src="assets/images/cod.jpg" width="51" height="36" alt=""></a></li>
                                <li><a href="#" class="payment-link"><img src="assets/images/card4.jpg" width="51" height="36" alt=""></a></li>
                                <li><a href="#" class="payment-link"><img src="assets/images/card5.jpg" width="51" height="36" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="user-chat" style="position:fixed; bottom:20px; right:20px; z-index:1000;">
    <div id="chat-ui" style="display:none; width:280px; height:350px; background:white; border:1px solid #ccc; border-radius:10px; flex-direction:column;">
        <div style="background:#2ecc71; color:white; padding:10px; border-radius:10px 10px 0 0;">Chat Support</div>
        <div id="msg-holder" style="flex:1; overflow-y:auto; padding:10px;"></div>
        <div style="display:flex; padding:5px;">
            <input type="text" id="user-msg" style="flex:1; border:1px solid #ddd;">
            <button onclick="sendMsg()" style="background:#2ecc71; color:white; border:none;">Send</button>
        </div>
    </div>
    <button onclick="$('#chat-ui').toggle(); loadUserMsgs();" style="width:50px; height:50px; border-radius:50%; background:#2ecc71; color:white; border:none; font-size:20px; cursor:pointer;">💬</button>
</div>

<script>
const myID = "<?php echo $_SESSION['user_id'] ?? ''; ?>";
function loadUserMsgs() {
    if(!myID || $('#chat-ui').is(':hidden')) return;
    $.get('admin/chat_system/get_messages.php?user_id=' + myID, function(data) {
        let msgs = JSON.parse(data);
        $('#msg-holder').html(msgs.map(m => `<div style="text-align:${m.sender_id == myID ? 'right' : 'left'}"><span style="background:${m.sender_id == myID ? '#dcf8c6' : '#eee'}; padding:5px; border-radius:5px; display:inline-block; margin:2px;">${m.message}</span></div>`).join(''));
        $('#msg-holder').scrollTop($('#msg-holder')[0].scrollHeight);
    });
}
function sendMsg() {
    let m = $('#user-msg').val();
    if(!myID) return alert("Please login first");
    $.post('admin/chat_system/save_message.php', {sender_id: myID, receiver_id: 1, message: m}, function() {
        $('#user-msg').val('');
        loadUserMsgs();
    });
}
if(myID) setInterval(loadUserMsgs, 3000);
</script>
    </footer>