import os
import requests
import glob
import re

CEREBRAS_API_KEY = os.getenv("CEREBRAS_API_KEY")
# تأكد من أن هذا الرابط هو الصحيح كما هو مدعوم في لوحة تحكم Cerebras الخاصة بك
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
                "content": "You are a senior PHP QA engineer for Laravel REST APIs. Return ONLY valid, complete PHP code. Do not wrap in markdown or give explanations."
            },
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.1
    }
    try:
        response = requests.post(API_URL, json=data, headers=headers, timeout=120)
        if response.status_code == 200:
            content = response.json()['choices'][0]['message']['content']
            # تنظيف الكود
            clean_code = re.sub(r'```php|```', '', content).strip()
            return clean_code
        print(f"API Error: {response.status_code} - {response.text}")
        return None
    except Exception as e:
        print(f"Exception during API call: {str(e)}")
        return None

def process_files():
    files = glob.glob('app/Http/Controllers/**/*.php', recursive=True) + \
            glob.glob('app/Models/**/*.php', recursive=True)
    
    if not os.path.exists("tests/Unit"): os.makedirs("tests/Unit")
    if not os.path.exists("tests/Browser"): os.makedirs("tests/Browser")

    print(f"DEBUG: Found {len(files)} PHP files in app to process.")

    for file_path in files:
        if os.path.isdir(file_path): continue
        if "TestCase" in file_path or os.path.basename(file_path).endswith("Test.php"): continue
        
        with open(file_path, 'r') as f:
            original_code = f.read()

        if len(original_code) < 100: continue

        print(f"--- Processing source file: {file_path} ---")

        # 1. تحديث التوثيق (PHPDoc)
        doc_prompt = f"Add comprehensive PHPDoc comments to every function in this Laravel file. Keep logic unchanged:\n\n{original_code}"
        documented_code = ask_cerebras(doc_prompt)
        if documented_code and "<?php" in documented_code:
            with open(file_path, 'w') as f:
                f.write(documented_code)
            print(f"   ✅ Documentation added to {file_path}")

        source_reference = documented_code if documented_code else original_code

        unit_prompt = f"Write a professional PHPUnit test class covering ALL methods in this code. Use Mockery. Include necessary imports and setup:\n\n{source_reference}"
        unit_test = ask_cerebras(unit_prompt)
        if unit_test and "<?php" in unit_test:
            test_filename = os.path.basename(file_path).replace(".php", "Test.php")
            test_path = os.path.join("tests/Unit", test_filename)
            with open(test_path, 'w') as f:
                f.write(unit_test)
            print(f"   ✅ REAL Unit Test generated: {test_path}")
        else:
            print(f"   ❌ Failed to generate Unit Test for {file_path}")

        if "Controller" in file_path:
            dusk_prompt = f"Write a Laravel Dusk browser test covering UI functionality based on this controller. Return ONLY the code:\n\n{source_reference}"
            dusk_test = ask_cerebras(dusk_prompt)
            if dusk_test and "<?php" in dusk_test:
                browser_filename = os.path.basename(file_path).replace(".php", "BrowserTest.php")
                browser_path = os.path.join("tests/Browser", browser_filename)
                with open(browser_path, 'w') as f:
                    f.write(dusk_test)
                print(f"   ✅ REAL Browser Test generated: {browser_path}")

if __name__ == "__main__":
    if not CEREBRAS_API_KEY:
        print("❌ CRITICAL: CEREBRAS_API_KEY is not set.")
    else:
        process_files()
