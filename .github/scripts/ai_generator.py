#!/usr/bin/env python3
"""
🤖 Cerebras AI Ultimate Generator 2026
Tasks: Technical Docs + PHPUnit + Selenium (Dusk) + Source PHPDoc
"""

import os
import requests
import re
import pathlib
import sys
from datetime import datetime

# ============ CONFIGURATION ============
CEREBRAS_API_KEY = os.getenv("CEREBRAS_API_KEY")
API_URL = "https://api.cerebras.ai/v1/chat/completions"
MODEL = "llama3.3-70b"

# Directories
DOCS_DIR = "docs/ai"
UNIT_TESTS_DIR = "tests/Generated/Unit"
SELENIUM_TESTS_DIR = "tests/Generated/Selenium"
TRACKER_FILE = ".ai_docs_tracker.txt"

# Target Folders in your Repo
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
        "max_tokens": 4000
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

# ============ TASK GENERATORS ============

def generate_docs(code, path):
    system = "You are a senior technical writer. Generate professional Markdown documentation."
    prompt = f"Create a technical MD documentation for this PHP file: {path}\nInclude: Purpose, Functions Table, and Usage Example.\n\nCode:\n{code[:3500]}"
    return ask_cerebras(prompt, system)

def generate_unit_tests(code, path):
    system = "You are a senior PHP QA Engineer. Generate pure PHPUnit code only."
    prompt = f"Generate a complete PHPUnit test class for this file: {path}. Use Mockery, test all public methods, and edge cases. Return ONLY valid PHP starting with <?php."
    return ask_cerebras(prompt, system)

def generate_selenium_tests(code, path):
    system = "You are a Laravel Dusk (Selenium) expert. Generate browser tests."
    prompt = f"Generate a Laravel Dusk test class for this Controller: {path}. Focus on UI interactions and form submissions. Return ONLY valid PHP starting with <?php."
    return ask_cerebras(prompt, system)

def generate_phpdoc_version(code):
    system = "You are a PHP standards expert. Add PHPDoc to every method and property."
    prompt = f"Add full PHPDoc blocks (summary, @param, @return, @throws) to the following code. Return the ENTIRE file content with PHPDoc added. Keep original logic exactly the same.\n\nCode:\n{code}"
    return ask_cerebras(prompt, system)

# ============ MAIN PROCESS ============

def main():
    log("INFO", "🚀 Starting Cerebras AI Generation Suite...")
    
    for d in [DOCS_DIR, UNIT_TESTS_DIR, SELENIUM_TESTS_DIR]:
        os.makedirs(d, exist_ok=True)

    processed = set()
    if os.path.exists(TRACKER_FILE):
        with open(TRACKER_FILE, 'r') as f:
            processed = set(line.strip() for line in f)

    files_to_process = []
    for p in TARGET_PATHS:
        if os.path.isdir(p):
            for root, _, files in os.walk(p):
                for f in files:
                    if f.endswith(".php") and "Test" not in f:
                        files_to_process.append(os.path.join(root, f))
        elif os.path.isfile(p):
            files_to_process.append(p)

    log("INFO", f"📂 Found {len(files_to_process)} candidate files.")
    
    batch_count = 0
    for file_path in files_to_process:
        if file_path in processed:
            continue
        
        if batch_count >= 3:
            log("INFO", "⏸️ Batch limit reached (3 files). Stopping.")
            break

        log("INFO", f"🛠️ Processing: {file_path}")
        
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                original_code = f.read()

            # 1. Documentation
            doc_md = generate_docs(original_code, file_path)
            if doc_md:
                doc_file = os.path.join(DOCS_DIR, f"{pathlib.Path(file_path).stem}.md")
                with open(doc_file, 'w') as f:
                    f.write(doc_md)
                log("SUCCESS", f"Docs generated -> {doc_file}")

            # 2. Unit Tests
            u_test = generate_unit_tests(original_code, file_path)
            if u_test and "<?php" in u_test:
                t_file = os.path.join(UNIT_TESTS_DIR, f"{pathlib.Path(file_path).stem}Test.php")
                with open(t_file, 'w') as f:
                    f.write(u_test)
                log("SUCCESS", f"Unit Test generated -> {t_file}")

            # 3. Selenium (Controllers only)
            if "Controller" in file_path:
                s_test = generate_selenium_tests(original_code, file_path)
                if s_test and "<?php" in s_test:
                    s_file = os.path.join(SELENIUM_TESTS_DIR, f"{pathlib.Path(file_path).stem}DuskTest.php")
                    with open(s_file, 'w') as f:
                        f.write(s_test)
                    log("SUCCESS", f"Selenium Test generated -> {s_file}")

            # 4. In-place PHPDoc Update
            updated_code = generate_phpdoc_version(original_code)
            if updated_code and "<?php" in updated_code:
                with open(file_path, 'w') as f:
                    f.write(updated_code)
                log("SUCCESS", "PHPDoc added to source file.")

            with open(TRACKER_FILE, 'a') as f:
                f.write(f"{file_path}\n")
            
            batch_count += 1

        except Exception as e:
            log("ERROR", f"Failed to process {file_path}: {e}")

    log("INFO", "✅ All tasks finished.")

if __name__ == "__main__":
    main()
