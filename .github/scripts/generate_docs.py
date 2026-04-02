import os
import requests
import glob
import re

CEREBRAS_API_KEY = os.getenv("CEREBRAS_API_KEY")
API_URL = "https://api.cerebras.ai/v1/chat/completions"

def ask_cerebras(prompt):
    headers = {
        "Authorization": f"Bearer {CEREBRAS_API_KEY}",
        "Content-Type": "application/json"
    }
    data = {
        "model": "llama-3.3-70b",
        "messages": [
            {
                "role": "system", 
                "content": "You are a senior PHP QA engineer. Your task is to generate PHPUnit tests for EVERY SINGLE function in the provided code. Do not skip any method. Return ONLY pure PHP code."
            },
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.1
    }
    try:
        response = requests.post(API_URL, json=data, headers=headers, timeout=120)
        if response.status_code == 200:
            content = response.json()['choices'][0]['message']['content']
            return re.sub(r'```php|```', '', content).strip()
        return None
    except Exception as e:
        print(f"Error: {e}")
        return None

def process_files():
    source_files = glob.glob('app/Http/Controllers/**/*.php', recursive=True) + \
                   glob.glob('app/Models/**/*.php', recursive=True) + \
                   glob.glob('app/Services/**/*.php', recursive=True)

    if not os.path.exists("tests/Unit"): os.makedirs("tests/Unit")

    for file_path in source_files:
        if os.path.isdir(file_path) or "TestCase" in file_path: continue
        
        test_filename = os.path.basename(file_path).replace(".php", "Test.php")
        test_path = os.path.join(os.getcwd(), "tests/Unit", test_filename

        if os.path.exists(test_path) and os.path.getsize(test_path) > 100:
            print(f"⚠️ Skipping {file_path} - Test already exists.")
            continue

        with open(file_path, 'r') as f:
            code = f.read()

        if len(code) < 50: continue

        print(f"🚀 Generating tests for EVERY function in: {file_path}")

        unit_prompt = (
            f"Analyze the following PHP class and write a PHPUnit test class. "
            f"CRITICAL: You must create at least one test method for EVERY existing function/method defined in this class. "
            f"Even simple getters or setters must be tested. Use Mockery for dependencies. "
            f"Source Code:\n\n{code}"
        )

        unit_test = ask_cerebras(unit_prompt)
        
        if unit_test and "<?php" in unit_test:
            with open(test_path, 'w') as f:
                f.write(unit_test)
            print(f"✅ Created: {test_path} (Full Coverage)")

        doc_prompt = f"Add PHPDoc to EVERY method in this code and return the full file:\n\n{code}"
        updated_code = ask_cerebras(doc_prompt)
        if updated_code and "<?php" in updated_code:
            with open(file_path, 'w') as f:
                f.write(updated_code)

if __name__ == "__main__":
    if CEREBRAS_API_KEY:
        process_files()
    else:
        print("Missing API Key")
