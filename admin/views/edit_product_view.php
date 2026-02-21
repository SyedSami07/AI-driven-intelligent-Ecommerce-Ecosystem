<?php 
    ini_set("display_erros", "Off");
    $obj=new adminback();
    $cata_info = $obj-> p_display_catagory();
    
    if(isset($_GET['prostatus'])){
        $id = $_GET['id'];
        if($_GET['prostatus']=='edit'){
           $pdt_info= $obj->edit_product($id);
           $pdt = mysqli_fetch_assoc($pdt_info);
        }
    }

    if(isset($_POST['update_pdt'])){
        $update_msg = $obj->update_product($_POST); 
    }
?>

<div class="d-flex justify-content-between align-items-center">
    <h4>Update Product</h4>
    <button type="button" class="btn btn-dark" onclick="generateAIDesc()" id="aiBtn">
       <i class="fa fa-magic"></i> Generate AI Description
    </button>
</div>

<?php 
    if(isset($update_msg)){
        echo $update_msg;
    }
?>

<form action="" method="post" enctype="multipart/form-data" class="form">
    <div class="form-group">
        <label for="pdt_name">Product Name</label>
        <input type="text" name="u_pdt_name" id="pdt_name" class="form-control" value="<?php echo $pdt['pdt_name'] ?>" >
    </div>

    <input type="hidden" name="pdt_id" value="<?php echo $pdt['pdt_id'] ?>">
    
    <div class="form-group">
        <label for="pdt_price">Product Price</label>
        <input type="text" name="u_pdt_price" class="form-control" value="<?php echo $pdt['pdt_price'] ?>">
    </div>

    <div class="form-group">
        <label for="pdt_des">Product Description</label>
        <textarea name="u_pdt_des" id="pdt_des" cols="30" rows="10" class="form-control"><?php echo $pdt['pdt_des']?></textarea>
        <small class="text-info" id="aiStatus" style="display:none;">AI is thinking...</small>
    </div>

    <div class="form-group">
        <label for="pdt_stock">Product Stock</label>
        <input type="number" name="pdt_stock" class="form-control" max='30' min='1' value="<?php echo $pdt['product_stock']?>">
    </div>

    <div class="form-group">
        <label for="pdt_ctg">Product Categories</label>
        <select name="u_pdt_ctg" id="pdt_ctg" class="form-control">
            <option value="">Select a Category</option>
            <?php 
                // ক্যাটাগরি ডাটা আবার রিচ করার জন্য ইন্টারনাল লজিক (যদি প্রয়োজন হয়)
                mysqli_data_seek($cata_info, 0); 
                while($cata = mysqli_fetch_assoc($cata_info)){ 
            ?>
            <option value="<?php echo $cata['ctg_id'] ?>" <?php if($pdt['pdt_ctg'] == $cata['ctg_id']){echo "selected";} ?> >
                <?php echo $cata['ctg_name'] ?>
            </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="pdt_img">Product Image</label>
        <div class="mb-3">
            <img src="uploads/<?php echo $pdt['pdt_img']?>" style="width: 80px;" >
        </div>
        <input type="file" name="u_pdt_img" class="form-control">
    </div>

    <div class="form-group">
        <label for="pdt_status">Status</label>
        <select name="u_pdt_status" class="form-control">
            <option value="1" <?php if($pdt['pdt_status']==1){ echo "selected";} ?> >Published</option>
            <option value="0" <?php if($pdt['pdt_status']==0){echo "selected";} ?> >Unpublished</option>
        </select>
    </div>

    <input type="submit" value="Update Product" name="update_pdt" class="btn btn-block btn-primary">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function generateAIDesc(){
    var pName = $('#pdt_name').val();
    var pCat = $('#pdt_ctg option:selected').text();
    
    if(pName == ""){
        alert("Please enter product name first");
        return;
    }

    // UI Updates
    $('#aiBtn').html('<i class="fa fa-spinner fa-spin"></i> Generating...');
    $('#aiBtn').prop('disabled', true);
    $('#aiStatus').show();

    $.ajax({
        url: 'views/ai_gen.php', // আপনার ai_gen.php এর সঠিক পাথ দিন
        method: 'POST',
        data: { pdt_name: pName, diet_type: pCat },
        dataType: 'json',
        success: function(data){
            if(data.success){
                $('#pdt_des').val(data.description);
            } else {
                alert("Error: " + data.error);
            }
        },
        error: function(){
            alert("Something went wrong with the AI server.");
        },
        complete: function(){
            $('#aiBtn').html('<i class="fa fa-magic"></i> Generate AI Description');
            $('#aiBtn').prop('disabled', false);
            $('#aiStatus').hide();
        }
    });
}
</script>