<?php 
    $cata_info = $obj->p_display_catagory();
    if(isset($_POST['add_pdt'])){
        $rtn_msg = $obj->add_product($_POST);
    }
?>

<style>
    .input-group-append button { border-top-left-radius: 0; border-bottom-left-radius: 0; }
    #ai_loader { display: none; margin-bottom: 10px; font-weight: bold; }
    .ai-writing { border: 2px solid #17a2b8 !important; }
    #scan_status { font-size: 12px; font-weight: bold; display: none; }
</style>

<h2>Add Product</h2>
<h6 class="text-success"><?php if(isset($rtn_msg)){ echo $rtn_msg; } ?></h6>

<form action="" method="post" enctype="multipart/form-data" class="form">
    <div class="form-group">
        <label for="pdt_name">Product Name</label>
        <div class="input-group">
            <input type="text" name="pdt_name" id="pdt_name" class="form-control" placeholder="Enter fruit name...">
            <div class="input-group-append">
                <button type="button" id="generate_ai_btn" class="btn btn-info">✨ AI Write</button>
            </div>
        </div>
        <span id="scan_status" class="text-info">🔍 AI is identifying image...</span>
    </div>

    <div class="form-group">
        <label for="pdt_price">Product Price</label>
        <input type="number" name="pdt_price" class="form-control">
    </div>

    <div class="form-group">
        <label for="pdt_des">Product Description</label>
        <div id="ai_loader" class="text-info"> <i class="fas fa-robot"></i> Groq AI is generating description...</div>
        <textarea name="pdt_des" id="pdt_des" cols="30" rows="10" class="form-control" placeholder="Description will appear here..."></textarea>
    </div>

    <div class="form-group">
        <label for="pdt_stock">Product Stock</label>
        <input type="number" name="pdt_stock" class="form-control" max='30' min='1'>
    </div>

    <div class="form-group">
        <label for="pdt_ctg">Product Catagories</label>
        <select name="pdt_ctg" id="pdt_ctg" class="form-control">
            <option value="">Select a Catagory</option>
            <?php while($cata = mysqli_fetch_assoc($cata_info)){ ?>
                <option value="<?php echo $cata['ctg_id'] ?>"><?php echo $cata['ctg_name'] ?></option>
            <?php }?>
        </select>
    </div>

    <div class="form-group">
        <label>Diet Category (for AI Suggestion)</label>
        <select name="pdt_diet_type" id="pdt_diet_type" class="form-control">
            <option value="General">General Health</option>
            <option value="Weight Loss">Weight Loss (Low Calorie)</option>
            <option value="Muscle Gain">Muscle Gain (Energy Boost)</option>
        </select>
    </div>

    <div class="form-group">
        <label for="pdt_img">Product Image</label>
        <input type="file" name="pdt_img" id="pdt_img_input" class="form-control">
    </div>

    <div class="form-group">
        <label for="pdt_status">Status</label>
        <select name="pdt_status" class="form-control">
            <option value="1">Published</option>
            <option value="0">Unpublished</option>
        </select>
    </div>

    <input type="submit" value="Add Product" name="add_pdt" class="btn btn-block btn-primary">
</form>

<script>
// --- PART 1: IMAGE CLASSIFICATION LOGIC ---
document.getElementById('pdt_img_input').addEventListener('change', function() {
    const file = this.files[0];
    const nameInput = document.getElementById('pdt_name');
    const scanStatus = document.getElementById('scan_status');
    const aiBtn = document.getElementById('generate_ai_btn');

    if (file) {
        scanStatus.style.display = "inline";
        nameInput.value = "Detecting fruit...";

        let formData = new FormData();
        formData.append('image', file);

        fetch('http://localhost:5000/predict', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            scanStatus.style.display = "none";
            if(data.label) {
                // Set the name detected by your Keras model
                nameInput.value = data.label.charAt(0).toUpperCase() + data.label.slice(1);
                
                // AUTOMATICALLY TRIGGER THE DESCRIPTION GENERATION
                setTimeout(() => {
                    aiBtn.click();
                }, 500);
            }
        })
        .catch(err => {
            scanStatus.style.display = "none";
            nameInput.value = "";
            console.error("AI Server not running", err);
        });
    }
});

// --- PART 2: YOUR ORIGINAL GROQ AI LOGIC ---
document.getElementById('generate_ai_btn').addEventListener('click', function() {
    const pdtName = document.getElementById('pdt_name').value;
    const dietType = document.getElementById('pdt_diet_type').value;
    const textArea = document.getElementById('pdt_des');
    const loader = document.getElementById('ai_loader');
    const btn = this;

    if (pdtName.trim() === "" || pdtName === "Detecting fruit...") {
        alert("Please enter a product name first!");
        return;
    }

    loader.style.display = "block";
    btn.disabled = true;
    textArea.classList.add('ai-writing');
    textArea.value = "Please wait, Groq is processing...";

    const formData = new FormData();
    formData.append('pdt_name', pdtName);
    formData.append('diet_type', dietType);

    fetch('views/ai_gen.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        loader.style.display = "none";
        btn.disabled = false;
        textArea.classList.remove('ai-writing');
        
        if (data.success) {
            textArea.value = data.description;
        } else {
            textArea.value = "";
            alert("Error: " + data.error);
        }
    })
    .catch(error => {
        loader.style.display = "none";
        btn.disabled = false;
        textArea.classList.remove('ai-writing');
        console.error('Error:', error);
    });
});
</script>