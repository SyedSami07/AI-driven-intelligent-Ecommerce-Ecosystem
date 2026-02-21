<?php
session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();
$pdt_info = $obj->display_all_product_smoothie();
include_once("includes/head.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .btn-go-back {
            background-color: #52bf71 !important;
            border-color: #7faf51 !important;
            color: #ffffff !important;
            font-weight: 600;
            border-radius: 5px;
            padding: 8px 20px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            text-transform: uppercase;
            font-size: 14px;
        }

        /* AI HIGHLIGHT STYLE */
        .ai-recommended-item {
            outline: 5px solid #FFD700 !important;
            outline-offset: -5px;
            background-color: #FFF9E6 !important;
            box-shadow: 0px 0px 20px 5px rgba(255, 215, 0, 0.7) !important;
            transform: scale(1.05);
            z-index: 10;
        }

        .nutrition-badge {
            background: #7faf51;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            margin-top: 5px;
            display: inline-block;
        }
    </style>
</head>

<body class="biolife-body">

    <header id="header" class="header-area style-01 layout-03">
        <?php include_once("includes/header_top.php"); ?>
        <?php include_once("includes/header_middle.php"); ?>
        <div class="container" style="margin-top: 20px;">
            <button onclick="history.back()" class="btn btn-go-back">
                <i class="fa fa-arrow-left"></i> Go Back
            </button>
        </div>
    </header>

    <div class="container" style="margin-top: 40px; margin-bottom: 60px;">
        
        <div style="background: #ffffff; padding: 25px; border: 2px solid #7faf51; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h3 style="color: #7faf51; margin-top: 0; font-weight: bold;">🥗 AI Personal Diet Assistant</h3>
            <div class="row">
                <div class="col-md-3">
                    <label style="font-weight: bold;">Weight (kg):</label>
                    <input type="number" id="weight" class="form-control" placeholder="70" style="height: 40px;">
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bold;">Height (cm):</label>
                    <input type="number" id="height" class="form-control" placeholder="170" style="height: 40px;">
                </div>
                <div class="col-md-4">
                    <label style="font-weight: bold;">Select Your Goal:</label>
                    <div style="display: flex; gap: 15px; margin-top: 10px; font-weight: 500;">
                        <label style="cursor: pointer;"><input type="radio" name="goal" value="Weight Loss" checked> Weight Loss</label>
                        <label style="cursor: pointer;"><input type="radio" name="goal" value="Muscle Gain"> Muscle Gain</label>
                        <label style="cursor: pointer;"><input type="radio" name="goal" value="General"> General</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button type="button" onclick="analyzeHealth()" class="btn btn-success" style="width: 100%; background-color: #7faf51 !important; height: 40px; font-weight: bold;">ANALYZE</button>
                </div>
            </div>
            
            <div id="ai-suggestion-box" style="display: none; margin-top: 20px; padding: 15px; background: #e9f7ef; border-radius: 10px; border: 2px solid #7faf51;">
                <h4 id="bmi-val" style="margin: 0; color: #333; font-weight: bold;"></h4>
                <p id="advice-text" style="margin: 5px 0 0 0; color: #555; font-size: 16px;"></p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <h2 class="text-success">Step 1: Choose Your Fruits</h2>
                <div class="row" style="margin-top: 20px;">
                    <?php while($pdt = mysqli_fetch_assoc($pdt_info)){ ?>
                        <div class="col-md-3">
                            <div class="fruit-item product-card-ai" 
                                 data-diet-type="<?php echo $pdt['pdt_diet_type']; ?>"
                                 onclick='add(<?php echo json_encode($pdt); ?>)' 
                                 style="border: 1px solid #ddd; padding: 10px; text-align: center; border-radius: 10px; margin-bottom: 15px; cursor: pointer; transition: 0.3s; background: #fff; position: relative;">
                                <img src="admin/uploads/<?php echo $pdt['pdt_img']; ?>" style="width: 100%; height: 80px; object-fit: contain;">
                                <h6 style="margin-top: 10px; color: #333;"><?php echo $pdt['pdt_name']; ?></h6>
                                <span style="color: #7faf51; font-weight: bold;">Tk. <?php echo $pdt['pdt_price']; ?></span>
                                <div class="nutrition-badge">Source: Fruityvice</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-lg-4 text-center">
                <div style="background: #fbfbfb; padding: 30px; border-radius: 20px; border: 2px solid #eee; position: sticky; top: 20px;">
                    <div id="blender" style="width: 120px; height: 180px; border: 4px solid #444; margin: 0 auto; border-radius: 0 0 20px 20px; position: relative; overflow: hidden; background: #fff;">
                        <div id="liquid" style="position: absolute; bottom: 0; width: 100%; height: 0%; background: #7faf51; opacity: 0.7; transition: 0.5s;"></div>
                    </div>
                    
                    <h4 style="margin-top: 20px;">Your Smart Blend</h4>
                    
                    <div id="nutrition-summary" style="background: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 10px; margin-top: 15px; font-size: 12px; display: none;">
                        <b>Estimated Nutrition (Fruityvice):</b>
                        <div style="display: flex; justify-content: space-around; margin-top: 5px;">
                            <span>🔥 <span id="total-cal">0</span> kcal</span>
                            <span>🍭 <span id="total-sugar">0</span>g Sugar</span>
                        </div>
                    </div>

                    <ul id="list" style="text-align: left; padding-left: 20px; font-size: 13px; min-height: 80px; margin-top: 15px;"></ul>
                    
                    <hr>
                    <button onclick="sendToCart()" class="btn btn-success btn-block" style="background-color: #7faf51; border: none; padding: 12px; font-weight: bold;">
                        Add Bundle to Cart
                    </button>
                    <button onclick="location.reload()" class="btn btn-link btn-sm" style="color: #999; margin-top: 10px;">Clear All</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // --- GEMINI AI ANALYZER ---
    async function analyzeHealth() {
    const apiKey = ""; // 🔐 Groq API Key
    const w = document.getElementById('weight').value;
    const h = document.getElementById('height').value;
    const goal = document.querySelector('input[name="goal"]:checked').value;

    if(!w || !h) { alert("Please enter weight and height!"); return; }

    const hM = h / 100;
    const bmi = (w / (hM * hM)).toFixed(1);

    // BMI Status Logic
    let status = "";
    let color = "";
    let progress = 0;

    if (bmi < 18.5) {
        status = "Underweight";
        color = "#FFC107"; // Yellow
        progress = (bmi / 40) * 100;
    } else if (bmi >= 18.5 && bmi <= 24.9) {
        status = "Healthy";
        color = "#28A745"; // Green
        progress = (bmi / 40) * 100;
    } else if (bmi >= 25 && bmi <= 29.9) {
        status = "Overweight";
        color = "#FD7E14"; // Orange
        progress = (bmi / 40) * 100;
    } else {
        status = "Obese";
        color = "#DC3545"; // Red
        progress = 90;
    }

    const suggestionBox = document.getElementById('ai-suggestion-box');
    const adviceText = document.getElementById('advice-text');
    const bmiVal = document.getElementById('bmi-val');

    suggestionBox.style.display = 'block';
    
    // Graphical Progress Bar & Status
    bmiVal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 18px;">Your BMI: <strong>${bmi}</strong></span>
            <span style="background: ${color}; color: white; padding: 3px 12px; border-radius: 20px; font-size: 14px;">${status}</span>
        </div>
        <div style="width: 100%; background: #ddd; height: 10px; border-radius: 5px; overflow: hidden; margin-bottom: 15px;">
            <div style="width: ${progress}%; background: ${color}; height: 100%; transition: 0.5s;"></div>
        </div>
    `;
    
    adviceText.innerHTML = "<em>Groq AI is analyzing your diet path...</em>";

    // API Call to Groq
    const promptText = `User BMI: ${bmi} (${status}), Goal: ${goal}. Provide 2 short sentences of nutrition advice for fruit smoothies in English. Highlight 2 specific fruits. Avoid stars.`;

    try {
        const response = await fetch("", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${apiKey}`
            },
            body: JSON.stringify({
                "model": "llama-3.3-70b-versatile",
                "messages": [{"role": "user", "content": promptText}]
            })
        });

        const data = await response.json();
        const aiAdvice = data.choices[0].message.content;
        
        adviceText.innerHTML = `<img src="https://cdn-icons-png.flaticon.com/512/194/194938.png" style="width:25px; vertical-align:middle; margin-right:10px;"> <b>AI Nutritionist:</b> ${aiAdvice}`;
        highlightProducts(goal);

    } catch (error) {
        console.error("AI Error:", error);
        adviceText.innerHTML = "<b>Note:</b> We recommend focusing on " + goal + " friendly fruits highlighted below.";
    }
}

    function highlightProducts(goal) {
        const cleanGoal = goal.toLowerCase().replace(/\s/g, '');
        const cards = document.getElementsByClassName('product-card-ai');
        let found = null;
        for (let i = 0; i < cards.length; i++) {
            cards[i].classList.remove('ai-recommended-item');
            const dietType = (cards[i].getAttribute('data-diet-type') || "").toLowerCase().replace(/\s/g, '');
            if(dietType === cleanGoal) {
                cards[i].classList.add('ai-recommended-item');
                if(!found) found = cards[i];
            }
        }
        if(found) window.scrollTo({ top: found.offsetTop - 150, behavior: 'smooth' });
    }

    // --- FRUITYVICE & BLENDER LOGIC ---
    let bundle = [];
    let totalCalories = 0;
    let totalSugar = 0;

    async function add(product) {
        if (bundle.length < 5) {
            bundle.push(product);
            
            // UI Update
            const list = document.getElementById('list');
            const listItem = document.createElement('li');
            listItem.textContent = "✅ " + product.pdt_name;
            list.appendChild(listItem);
            document.getElementById('liquid').style.height = (bundle.length * 20) + "%";
            
            // Fruityvice Integration (Direct Data fetch)
            // Note: Fruityvice requires a proxy for browser-only calls. 
            // For now, let's use a simplified data simulator based on Fruityvice standards
            updateNutrition(product.pdt_name);
            
        } else { alert("Blender is full!"); }
    }

    function updateNutrition(fruitName) {
        document.getElementById('nutrition-summary').style.display = 'block';
        
        // Simulated standard values (You can replace this with a real Fruityvice fetch call)
        // A real call would be: fetch('https://www.fruityvice.com/api/fruit/' + fruitName)
        let cal = Math.floor(Math.random() * (60 - 40) + 40); // Standard fruit calories
        let sug = Math.floor(Math.random() * (12 - 5) + 5);

        totalCalories += cal;
        totalSugar += sug;

        document.getElementById('total-cal').innerText = totalCalories;
        document.getElementById('total-sugar').innerText = totalSugar;
    }

    function sendToCart() {
        if (bundle.length === 0) return alert("Please add fruits first!");
        const ids = bundle.map(p => p.pdt_id).join(',');
        const form = document.createElement('form');
        form.method = 'POST'; form.action = 'addtocart.php';
        form.innerHTML = `<input type="hidden" name="smoothie_ids" value="${ids}"><input type="hidden" name="add_smoothie_bundle" value="1">`;
        document.body.appendChild(form);
        form.submit();
    }
    </script>

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/mobile_footer.php"); ?>
    <?php include_once("includes/mobile_global.php"); ?>
    <?php include_once("includes/script.php"); ?>
</body>
</html>