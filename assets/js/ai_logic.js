function analyzeHealth() {
    const weight = document.getElementById('weight').value;
    const heightCm = document.getElementById('height').value;
    const goal = document.getElementById('goal').value;
    const suggestionBox = document.getElementById('ai-suggestion');

    if (!weight || !heightCm) {
        alert("Please enter your weight and height correctly.");
        return;
    }

    // BMI Calculation Logic
    const heightM = heightCm / 100;
    const bmi = (weight / (heightM * heightM)).toFixed(1);
    
    suggestionBox.classList.remove('d-none');
    document.getElementById('bmi-result').innerText = `Your BMI is: ${bmi}`;

    let advice = "";
    let targetCalorie = 0;

    // AI Rule-based Recommendation Logic
    if (goal === "Weight Loss") {
        targetCalorie = 250;
        advice = "Advice: Choose low-calorie and high-fiber fruits (e.g., Apple, Strawberry). We have highlighted the best fruits for your goal.";
    } else if (goal === "Muscle Gain") {
        targetCalorie = 550;
        advice = "Advice: Select energy-dense fruits (e.g., Banana, Mango). These will help in your muscle recovery and growth.";
    } else {
        targetCalorie = 400;
        advice = "Advice: Maintain a balanced mix of various nutritious fruits for general wellness.";
    }

    document.getElementById('diet-advice').innerHTML = `<strong>${advice}</strong> <br> Target Smoothie Calories: <strong>${targetCalorie} kcal</strong>`;

    recommendFruits(goal);
}

function recommendFruits(goal) {
    const fruits = document.querySelectorAll('.product-item'); 
    fruits.forEach(fruit => {
        // Resetting styles before applying recommendation highlights
        fruit.style.border = "1px solid #ddd"; 
        fruit.style.boxShadow = "none";
        fruit.style.backgroundColor = "transparent";

        if (fruit.getAttribute('data-diet') === goal) {
            fruit.style.border = "2px solid #28a745"; 
            fruit.style.boxShadow = "0px 0px 15px rgba(40, 167, 69, 0.3)";
            fruit.style.backgroundColor = "#f0fff4"; // Light green background for recommended items
        }
    });
}