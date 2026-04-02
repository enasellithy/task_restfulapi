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
            {"role": "system", "content": "You are a specialized PHP QA engineer. Return ONLY the PHP code. No talk, no markdown wrappers."},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.1
    }
    try:
        response = requests.post(API_URL, json=data, headers=headers, timeout=60)
        if response.status_code == 200:
            content = response.json()['choices'][0]['message']['content']
            clean_code = re.sub(r'```php|```', '', content).strip()
            return clean_code
        print(f"API Error: {response.status_code} - {response.text}")
        return None
    except Exception as e:
        print(f"Exception during API call: {str(e)}")
        return None

def process_files():
    files = glob.glob('app/**/*.php', recursive=True)
    
    os.makedirs("tests/Unit", exist_ok=True)
    os.makedirs("tests/Browser", exist_ok=True)

    for file_path in files:
        if os.path.isdir(file_path): continue
        
        with open(file_path, 'r') as f:
            original_code = f.read()

        if len(original_code) < 50: continue

        print(f"--- Working on: {file_path} ---")

        doc_prompt = f"Rewrite this PHP code adding full PHPDoc documentation for every function and class. Return the complete updated file:\n\n{original_code}"
        documented_code = ask_cerebras(doc_prompt)
        if documented_code and "<?php" in documented_code:
            with open(file_path, 'w') as f:
                f.write(documented_code)
            print(f"✅ Documentation added to {file_path}")

        unit_prompt = f"Write a complete PHPUnit Unit Test for the following PHP code. Ensure all existing functions are covered. Use Mockery if needed. Return ONLY the code:\n\n{documented_code if documented_code else original_code}"
        unit_test = ask_cerebras(unit_prompt)
        if unit_test and "<?php" in unit_test:
            test_filename = os.path.basename(file_path).replace(".php", "Test.php")
            test_path = os.path.join("tests/Unit", test_filename)
            with open(test_path, 'w') as f:
                f.write(unit_test)
            print(f"✅ Unit Test generated: {test_path}")

        if "Controller" in file_path:
            dusk_prompt = f"Write a Laravel Dusk test class for this controller. Return ONLY the code:\n\n{original_code}"
            dusk_test = ask_cerebras(dusk_prompt)
            if dusk_test and "<?php" in dusk_test:
                browser_filename = os.path.basename(file_path).replace(".php", "BrowserTest.php")
                browser_path = os.path.join("tests/Browser", browser_filename)
                with open(browser_path, 'w') as f:
                    f.write(dusk_test)
                print(f"✅ Browser Test generated: {browser_path}")

if __name__ == "__main__":
    if not CEREBRAS_API_KEY:
        print("❌ CRITICAL: CEREBRAS_API_KEY is not set in environment variables.")
    else:
        process_files()
