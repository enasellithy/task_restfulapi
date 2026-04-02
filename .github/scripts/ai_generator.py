#!/usr/bin/env python3
import os
import requests
import re
import pathlib
import sys
from datetime import datetime

# ============ CONFIGURATION ============
CEREBRAS_API_KEY = os.getenv("CEREBRAS_API_KEY")
API_URL = "https://api.cerebras.ai/v1/chat/completions"
MODEL = "llama3.1-70b"  # الموديل المستقر والمضمون

DOCS_DIR = "docs/ai"
UNIT_TESTS_DIR = "tests/Generated/Unit"
SELENIUM_TESTS_DIR = "tests/Generated/Selenium"
TRACKER_FILE = ".ai_docs_tracker.txt"

TARGET_PATHS = [
    "app/Facades/",
    "app/Features/PatientSatisfaction/",
    "app/Features/ClinicUsers",
    "app/Http/Controllers/",
    "app/Models/",
    "app/Services/"
]

# ============ CORE FUNCTIONS ============

def log(level, msg):
    print(f"[{level}] {datetime.now().strftime('%H:%M:%S')} - {msg}")

def ask_cerebras(prompt, system_role):
    if not CEREBRAS_API_KEY:
        log("ERROR", "CEREBRAS_API_KEY is missing!")
        sys.exit(1)

    headers = {
        "Authorization": f"Bearer {CEREBRAS_API_KEY}",
        "Content-Type": "application/json"
    }
    
    data = {
        "model": MODEL,
        "messages": [
            {"role": "system", "content": system_role},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.1,
        "max_tokens": 3000
    }

    try:
        response = requests.post(API_URL, json=data, headers=headers, timeout=120)
        if response.status_code == 200:
            content = response.json()['choices'][0]['message']['content']
            return re.sub(r'```php|```markdown|```', '', content).strip()
        else:
            log("ERROR", f"API Fail: {response.status_code} - {response.text}")
            return None
    except Exception as e:
        log("ERROR", f"Request Exception: {str(e)}")
        return None

# ============ GENERATORS ============

def generate_docs(code, path):
    return ask_cerebras(f"Generate technical Markdown docs for: {path}\nCode:\n{code[:3000]}", "You are a technical writer.")

def generate_unit_tests(code, path):
    return ask_cerebras(f"Generate PHPUnit test for: {path}. Return ONLY valid PHP.", "You are a QA Engineer.")

def generate_selenium_tests(code, path):
    return ask_cerebras(f"Generate Laravel Dusk test for Controller: {path}. Return ONLY valid PHP.", "You are a Selenium Expert.")

def generate_phpdoc(code):
    return ask_cerebras(f"Add full PHPDoc to this code. Return the ENTIRE file content.\nCode:\n{code}", "You are a PHP standards expert.")

# ============ MAIN ============

def main():
    log("INFO", f"🚀 Starting AI Suite with model: {MODEL}")
    
    for d in [DOCS_DIR, UNIT_TESTS_DIR, SELENIUM_TESTS_DIR]:
        os.makedirs(d, exist_ok=True)

    processed = set()
    if os.path.exists(TRACKER_FILE):
        with open(TRACKER_FILE, 'r') as f:
            processed = set(line.strip() for line in f)

    files_to_process = []
    for p in TARGET_PATHS:
        if os.path.exists(p):
            if os.path.isdir(p):
                for root, _, files in os.walk(p):
                    for f in files:
                        if f.endswith(".php") and "Test" not in f:
                            files_to_process.append(os.path.join(root, f))
            else:
                files_to_process.append(p)

    log("INFO", f"📂 Found {len(files_to_process)} candidate files.")
    
    batch_count = 0
    for file_path in files_to_process:
        if file_path in processed or batch_count >= 3:
            continue

        log("INFO", f"🛠️ Processing: {file_path}")
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                code = f.read()

            # 1. Docs
            res = generate_docs(code, file_path)
            if res:
                with open(os.path.join(DOCS_DIR, f"{pathlib.Path(file_path).stem}.md"), 'w') as f:
                    f.write(res)

            # 2. Unit Tests
            res = generate_unit_tests(code, file_path)
            if res and "<?php" in res:
                with open(os.path.join(UNIT_TESTS_DIR, f"{pathlib.Path(file_path).stem}Test.php"), 'w') as f:
                    f.write(res)

            # 3. Selenium
            if "Controller" in file_path:
                res = generate_selenium_tests(code, file_path)
                if res and "<?php" in res:
                    with open(os.path.join(SELENIUM_TESTS_DIR, f"{pathlib.Path(file_path).stem}DuskTest.php"), 'w') as f:
                        f.write(res)

            # 4. PHPDoc
            res = generate_phpdoc(code)
            if res and "<?php" in res:
                with open(file_path, 'w') as f:
                    f.write(res)

            with open(TRACKER_FILE, 'a') as f:
                f.write(f"{file_path}\n")
            
            batch_count += 1
            log("SUCCESS", f"Finished {file_path}")
        except Exception as e:
            log("ERROR", f"Failed {file_path}: {e}")

    log("INFO", "✅ Finished all tasks.")

if __name__ == "__main__":
    main()
