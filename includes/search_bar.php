<div class="header-search-bar layout-01">
    <form action="search_product.php" class="form-search" id="v-search-form" method="get">
        <div style="position: relative; display: flex; align-items: center;">
            <input type="text" name="keyword" id="v-search-input" class="input-text" placeholder="Search, say, or upload photo" style="padding-right: 90px;">
            
            <button type="button" id="v-mic-btn" style="position: absolute; right: 115px; border: none; background: none; cursor: pointer; font-size: 22px; z-index: 99;">
                🎤
            </button>

            <label for="v-image-input" id="v-camera-label" style="position: absolute; right: 80px; border: none; background: none; cursor: pointer; font-size: 22px; z-index: 99; margin-bottom: 0;">
                📷
            </label>
            <input type="file" id="v-image-input" accept="image/*" style="display: none;">

            <input type="submit" class="btn-submit" value="search" name="search">
        </div>
    </form>
</div>

<script>
    (function() {
        const micBtn = document.getElementById('v-mic-btn');
        const cameraLabel = document.getElementById('v-camera-label');
        const imageInput = document.getElementById('v-image-input');
        const searchInput = document.getElementById('v-search-input');
        const searchForm = document.getElementById('v-search-form');

        const pageRoutes = {
            "smoothie": "smoothie_builder.php",
            "login": "user_login.php",
            "sign in": "user_login.php",
            "register": "user_register.php",
            "all product": "all_product.php",
            "cart": "addtocart.php",
            "checkout": "userprofile.php",
            "dashboard": "exist_order.php",
            "user": "exist_order.php",
            "my profile": "exist_order.php",
            "home": "index.php"
        };

        function speak(text) {
            const msg = new SpeechSynthesisUtterance(text);
            msg.lang = 'en-US';
            window.speechSynthesis.speak(msg);
        }

        // --- IMAGE RECOGNITION LOGIC ---
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                cameraLabel.innerHTML = "⏳";
                speak("Analyzing image...");

                let formData = new FormData();
                formData.append('image', this.files[0]);

                fetch('http://localhost:5000/predict', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    cameraLabel.innerHTML = "📷";
                    if(data.label) {
                        searchInput.value = data.label;
                        speak("Found " + data.label + ". Searching now.");
                        setTimeout(() => { searchForm.submit(); }, 1500);
                    }
                })
                .catch(err => {
                    cameraLabel.innerHTML = "📷";
                    speak("Deep learning server is not connected.");
                });
            }
        });

        // --- EXISTING VOICE RECOGNITION ---
        window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (window.SpeechRecognition) {
            const recognition = new window.SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript.toLowerCase().trim();
                micBtn.innerHTML = "🎤";
                
                // Routes & Logic (Keep your existing scroll/info logic here)
                for (let key in pageRoutes) {
                    if (transcript.includes(key)) {
                        speak("Navigating to " + key);
                        setTimeout(() => { window.location.href = pageRoutes[key]; }, 1000);
                        return;
                    }
                }

                searchInput.value = transcript;
                speak("Searching for " + transcript);
                setTimeout(() => { searchForm.submit(); }, 1200);
            };
            micBtn.addEventListener('click', () => {
                recognition.start();
                micBtn.innerHTML = "⏳";
            });
        }
    })();
</script>