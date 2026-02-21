<?php 
    date_default_timezone_set("Asia/Dhaka");

?>
<style>
    .mydiv{
        width: 200px;
        position: absolute;
        right: 38px;
        overflow: hidden;
    }
</style>
<h2>Dashborad </h2>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Customer Support Chat</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-4" style="border-right: 1px solid #ddd; height: 400px; overflow-y: auto;">
                        <h6 class="p-10">Active Customers</h6>
                        <div id="admin_user_list">Loading users...</div>
                    </div>

                    <div class="col-md-8">
                        <div id="admin_msgs" style="height: 350px; overflow-y: auto; background: #f5f7f9; padding: 15px; border: 1px solid #eee; margin-bottom: 10px;">
                            <p class="text-center text-muted">Select a user to start chatting</p>
                        </div>
                        
                        <div class="input-group">
                            <input type="text" id="admin-reply-input" class="form-control" placeholder="Type your reply here...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" onclick="adminReply()">Send</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mydiv">
<form action="" class="form">
    <select name="filterDate" id="filterDate" class="form-control">
        <option value="<?php echo date("Y/m/d")?>" >Today</option>
        <option value="<?php echo date('Y-m-d', strtotime('-7 days')) ?>" >This week</option>
        <option value="<?php echo date('Y-m-d', strtotime('-30 days')) ?>" >This Month</option>
        <option value="<?php echo date('Y-m-d', strtotime('-365 days')) ?>" >This Year</option>
        <option value="2020-01-01" >Life Time</option>
    </select>
</form>
</div>


<script>
    $(document).ready(function(){
      

        $("#filterDate").change(function(){
            var filterId = this.value;

            $.ajax({
                 url: "json/dashboard_json.php",
                 method: "POST",
                 data: {
                     action: 'load_allorder',
                     did: filterId
                 },
                 success: function(data) {
                     var html = data;
                    
                     $('#totalOrder').text(data);
                 }
             });

             $.ajax({
                 url: "json/dashboard_json.php",
                 method: "POST",
                 data: {
                     action: 'load_allsell',
                     did: filterId
                 },
                 success: function(data) {
                     var html = data;
                    
                     $('#totalSell').text(data);
                 }
             });

             $.ajax({
                 url: "json/dashboard_json.php",
                 method: "POST",
                 data: {
                     action: 'load_allcustomer',
                     did: filterId
                 },
                 success: function(data) {
                     var html = data;
                    
                     $('#totalCustomer').text(data);
                 }
             });

             $.ajax({
                 url: "json/dashboard_json.php",
                 method: "POST",
                 data: {
                     action: 'load_delivered_order',
                     did: filterId
                 },
                 success: function(data) {
                     var html = data;
                    
                     $('#DeliverOrder').text(data);
                 }
             });
             $.ajax({
                 url: "json/dashboard_json.php",
                 method: "POST",
                 data: {
                     action: 'load_processing_order',
                     did: filterId
                 },
                 success: function(data) {
                     var html = data;
                    
                     $('#processingOrder').text(data);
                 }
             });

             $.ajax({
                 url: "json/dashboard_json.php",
                 method: "POST",
                 data: {
                     action: 'load_pending_order',
                     did: filterId
                 },
                 success: function(data) {
                     var html = data;
                    
                     $('#pendingOrder').text(data);
                 }
             });



        })
    })
</script>


<br> <br> <br>
<div class="row">



<!-- order-card start -->

<div class="col-md-6 col-xl-3">
    <div class="card bg-c-blue order-card">
        <div class="card-block">
            <h6 class="m-b-20">Orders Received</h6>
            <h2 class="text-right"><i class="ti-shopping-cart f-left"></i><span id="totalOrder">0</span></h2>
            <p class="m-b-0"><span class="f-right"></span></p>
        </div>
    </div>
</div>


<div class="col-md-6 col-xl-3">
    <div class="card bg-c-green order-card">
        <div class="card-block">
            <h6 class="m-b-20">Total Sales</h6>
            <h2 class="text-right"><i class="ti-tag f-left"></i><span id="totalSell">0</span></h2>
            <p class="m-b-0"><span class="f-right"></span></p>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-yellow order-card">
        <div class="card-block">
            <h6 class="m-b-20">Satisfied Customer</h6>
            <h2 class="text-right"><i class="ti-reload f-left"></i><span id="totalCustomer">0</span></h2>
            <p class="m-b-0"><span class="f-right"></span></p>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-pink order-card">
        <div class="card-block">
            <h6 class="m-b-20">Delivered Order</h6>
            <h2 class="text-right"><i class="ti-wallet f-left"></i><span id="DeliverOrder">0</span></h2>
            <p class="m-b-0"><span class="f-right"></span></p>
        </div>
    </div>
</div>

<div class="col-md-6 col-xl-3">
    <div class="card bg-c-pink order-card">
        <div class="card-block">
            <h6 class="m-b-20">Processing Order</h6>
            <h2 class="text-right"><i class="ti-wallet f-left"></i><span id="processingOrder">0</span></h2>
            <p class="m-b-0"><span class="f-right"></span></p>
        </div>
    </div>
</div>

<div class="col-md-6 col-xl-3">
    <div class="card bg-c-yellow order-card">
        <div class="card-block">
            <h6 class="m-b-20">Pending Order</h6>
            <h2 class="text-right"><i class="ti-reload f-left"></i><span id="pendingOrder">0</span></h2>
            <p class="m-b-0"><span class="f-right"></span></p>
        </div>
    </div>
</div>


<!-- order-card end -->


<!-- users visite and profile start -->

<!-- users visite and profile end -->

</div>










<script>
let activeUser = null;

function loadUserList() {
    $.get('chat_system/get_users.php', function(data) {
        let users = typeof data === 'string' ? JSON.parse(data) : data;
        let html = users.map(u => {
            // Check if the AI flagged this user (from the bullying_count we added to get_users.php)
            let isFlagged = u.bullying_count > 0;
            let badge = isFlagged ? `<span class="label label-danger" style="float:right;">⚠️ AI Flagged (${u.bullying_count})</span>` : '';
            let style = isFlagged ? 'border-left: 4px solid #ed3c0d;' : ''; // Red border for bad actors

            return `
            <div onclick="activeUser=${u.sender_id}; loadChat();" 
                 style="padding:15px; cursor:pointer; border-bottom:1px solid #ddd; background:#fff; ${style}">
                <strong>${u.user_name}</strong>
                ${badge}
            </div>`;
        }).join('');
        $('#admin_user_list').html(html || 'No active chats');
    });
}


function loadChat() {
    if(!activeUser) return;
    $.get('chat_system/get_messages.php?user_id=' + activeUser, function(data) {
        let msgs = typeof data === 'string' ? JSON.parse(data) : data;
        let html = msgs.map(m => {
            let isBullying = m.is_bullying == 1;
            let isFromAdmin = m.sender_id == 1;
            
            let bgColor = isFromAdmin ? '#007bff' : (isBullying ? '#fff3cd' : '#eee');
            let textColor = isFromAdmin ? '#fff' : '#000';
            
            // Logic for the View Button
            let content = m.message;
            if(isBullying && !isFromAdmin) {
                content = `
                    <span id="msg-text-${m.id}" style="filter: blur(4px); opacity: 0.6;">${m.message}</span>
                    <button class="btn btn-mini btn-warning" style="margin-left:10px; padding: 2px 5px; font-size: 10px;" 
                        onclick="toggleBlur(${m.id})">
                        View Content
                    </button>
                    <div style="font-size: 10px; color: red; margin-top: 4px;">⚠️ AI detected toxicity</div>
                `;
            }

            return `
            <div style="text-align:${isFromAdmin ? 'right' : 'left'}; margin-bottom: 10px;">
                <span style="background:${bgColor}; color:${textColor}; padding:10px; border-radius:10px; display:inline-block; max-width: 70%; position: relative;">
                    ${content}
                </span>
            </div>`;
        }).join('');
        
        $('#admin_msgs').html(html);
        $("#admin_msgs").scrollTop($("#admin_msgs")[0].scrollHeight);
    });
}

// Function to unblur the message when admin clicks "View"
function toggleBlur(id) {
    let el = document.getElementById('msg-text-' + id);
    if(el.style.filter === 'none') {
        el.style.filter = 'blur(4px)';
        el.style.opacity = '0.6';
    } else {
        el.style.filter = 'none';
        el.style.opacity = '1';
    }
}

function adminReply() {
    let msg = $('#admin-reply-input').val();
    if(!activeUser || !msg) return;
    $.post('chat_system/save_message.php', {sender_id: 1, receiver_id: activeUser, message: msg}, function() {
        $('#admin-reply-input').val('');
        loadChat();
    });
}

$(document).ready(function() {
    loadUserList();
    setInterval(loadUserList, 5000); // Check for new users every 5s
    setInterval(loadChat, 2000);     // Check for new messages every 2s
});
</script>

</div>

