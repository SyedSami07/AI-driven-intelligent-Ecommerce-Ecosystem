from flask import Flask, request, jsonify
import pickle
import re

app = Flask(__name__)

# Load your models
try:
    vectorizer = pickle.load(open("tfidfvector.pkl", "rb"))
    model = pickle.load(open("LinearSVC_Tuned.pkl", "rb"))
except FileNotFoundError:
    print("Error: Model files not found. Ensure pkl files are in the same folder.")

def clean_bangla_text(text):
    text = str(text)
    # Keep only Bangla characters and spaces
    text = re.sub(r'[^\u0980-\u09FF\s]', '', text) 
    text = re.sub(r'\s+', ' ', text).strip()
    return text

@app.route('/check', methods=['POST'])
def check_safety():
    data = request.get_json()
    user_text = data.get('comment', '').lower()
    
    # 1. Manual Safety Net (Catch specific slang immediately)
    bad_words = ['fuck', 'bitch', 'বালের', 'বাল', 'কুত্তা', 'সালা', 'শুয়োরের']
    if any(word in user_text for word in bad_words):
        return jsonify({'is_bully': 1})

    # 2. Machine Learning Model Logic
    cleaned = clean_bangla_text(user_text)
    
    # If the comment is English or empty after cleaning, treat as safe
    if not cleaned or len(cleaned.strip()) < 2:
        return jsonify({'is_bully': 0})
    
    # Predict using TF-IDF and LinearSVC
    tfidf_text = vectorizer.transform([cleaned])
    prediction = model.predict(tfidf_text)[0]
    
    return jsonify({'is_bully': int(prediction)})

if __name__ == '__main__':
    app.run(port=5001, debug=True)