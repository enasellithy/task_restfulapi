import os
import requests

API_KEY = os.getenv("CEREBRAS_API_KEY")
API_URL = "https://api.cerebras.ai/v1/chat/completions"

TARGET_DIRECTORIES = ["app", "src", "controllers", "models"]

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
            {"role": "system", "content": "You are a senior developer. Return ONLY code or markdown. No talk or explanations."},
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
    valid_dirs = [d for d in TARGET_DIRECTORIES if os.path.exists(d)]
    
    if not valid_dirs:
        print(f"⚠️ Target directories {TARGET_DIRECTORIES} not found in {os.getcwd()}")
        return

    for target in valid_dirs:
        for root, _, files in os.walk(target):
            for file in files:
                if file.endswith((".php", ".py", ".js", ".ts")):
                    found_any = True
                    full_path = os.path.join(root, file)
                    print(f"📄 Processing: {full_path}")
                    
                    try:
                        with open(full_path, "r", encoding="utf-8") as f:
                            source_code = f.read()
                        
                        if not source_code.strip():
                            continue

                        doc = ask_cerebras("Generate technical documentation in Markdown.", source_code)
                        save_file(f"docs/ai_generated/{file}.md", doc)

                        # 2. توليد Unit Test
                        test = ask_cerebras("Generate a unit test for this code.", source_code)
                        save_file(f"tests/AI_Generated/{file}_test.php", test)

                    except Exception as e:
                        print(f"❌ Error reading {file}: {e}")

    if not found_any:
        print("⚠️ No source files found to process.")

if __name__ == "__main__":
    process_files()
