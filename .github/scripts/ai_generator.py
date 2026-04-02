import os
import requests
import sys

API_KEY = os.getenv("CEREBRAS_API_KEY")
API_URL = "https://api.cerebras.ai/v1/chat/completions"

# 1. حدد هنا المجلدات التي تريد فحصها فقط
TARGET_DIRECTORIES = ["app/Http", "app/Solid"] 

def ask_cerebras(prompt, code):
    if not API_KEY:
        print("❌ ERROR: CEREBRAS_API_KEY is missing!")
        return None
    
    headers = {
        "Authorization": f"Bearer {API_KEY}",
        "Content-Type": "application/json"
    }
    payload = {
        "model": "llama3.1-8b",
        "messages": [
            {"role": "system", "content": "You are a developer. Return ONLY code/markdown without explanations."},
            {"role": "user", "content": f"{prompt}\n\nCode:\n{code}"}
        ],
        "temperature": 0
    }
    
    try:
        response = requests.post(API_URL, json=payload, headers=headers)
        if response.status_code == 200:
            return response.json()['choices'][0]['message']['content']
        else:
            print(f"❌ API Error: {response.status_code} - {response.text}")
            return None
    except Exception as e:
        print(f"❌ Request Exception: {e}")
        return None

def save_file(path, content):
    if content and len(content.strip()) > 10:
        os.makedirs(os.path.dirname(path), exist_ok=True)
        with open(path, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"✅ Saved: {path}")
        return True
    return False

def process_files():
    found_any = False
    
    # التأكد من وجود المجلدات المطلوبة قبل البدء
    valid_dirs = [d for d in TARGET_DIRECTORIES if os.path.exists(d)]
    
    if not valid_dirs:
        print(f"⚠️ None of the target directories {TARGET_DIRECTORIES} were found!")
        return

    print(f"🔍 Searching in: {valid_dirs}")
    
    for target in valid_dirs:
        for root, _, files in os.walk(target):
            for file in files:
                # تصفية الملفات حسب الامتداد
                if file.endswith((".php", ".py", ".js", ".ts", ".java")):
                    found_any = True
                    full_path = os.path.join(root, file)
                    print(f"📄 Processing: {full_path}")
                    
                    with open(full_path, "r", encoding="utf-8") as f:
                        source_code =
