#!/usr/bin/env python3
import os, requests, re, pathlib, sys

# Config
CEREBRAS_API_KEY = os.getenv("CEREBRAS_API_KEY")
MODEL = "llama3.1-70b" # الموديل المعتمد للـ API
API_URL = "https://api.cerebras.ai/v1/chat/completions"

# المسارات (تأكد أن هذه المجلدات موجودة في مشروعك)
TARGET_PATHS = ["app/Http/Controllers/", "app/Models/", "app/Services/"]
DOCS_DIR = "docs/ai"
UNIT_DIR = "tests/Generated/Unit"
SELENIUM_DIR = "tests/Generated/Selenium"

def ask_ai(prompt, system):
    headers = {"Authorization": f"Bearer {CEREBRAS_API_KEY}", "Content-Type": "application/json"}
    data = {
        "model": MODEL,
        "messages": [{"role": "system", "content": system}, {"role": "user", "content": prompt}],
        "temperature": 0.2
    }
    try:
        r = requests.post(API_URL, json=data, headers=headers, timeout=60)
        if r.status_code == 200:
            content = r.json()['choices'][0]['message']['content']
            return re.sub(r'```php|```markdown|```', '', content).strip()
    except: return None
    return None

def main():
    os.makedirs(DOCS_DIR, exist_ok=True)
    os.makedirs(UNIT_DIR, exist_ok=True)
    os.makedirs(SELENIUM_DIR, exist_ok=True)

    files = []
    for path in TARGET_PATHS:
        if os.path.exists(path):
            files.extend([os.path.join(r, f) for r, d, fs in os.walk(path) for f in fs if f.endswith('.php')])

    for file_path in files[:5]: # معالجة 5 ملفات في كل مرة لتجنب الـ Rate Limit
        print(f"🛠️ Processing {file_path}...")
        with open(file_path, 'r') as f: code = f.read()

        # 1. التوثيق
        doc = ask_ai(f"Generate technical Markdown documentation for this PHP code:\n{code}", "Technical Writer")
        if doc:
            with open(f"{DOCS_DIR}/{pathlib.Path(file_path).stem}.md", 'w') as f: f.write(doc)

        # 2. Unit Test
        utest = ask_ai(f"Generate a PHPUnit test using Mockery for this class:\n{code}", "QA Engineer. Return ONLY PHP code.")
        if utest and "<?php" in utest:
            with open(f"{UNIT_DIR}/{pathlib.Path(file_path).stem}Test.php", 'w') as f: f.write(utest)

        # 3. Selenium (Dusk)
        if "Controller" in file_path:
            sel = ask_ai(f"Generate a Laravel Dusk Selenium test for this controller:\n{code}", "Selenium Expert. Return ONLY PHP code.")
            if sel and "<?php" in sel:
                with open(f"{SELENIUM_DIR}/{pathlib.Path(file_path).stem}DuskTest.php", 'w') as f: f.write(sel)

        # 4. PHPDoc
        phpdoc = ask_ai(f"Add full PHPDoc blocks to this file. Return entire file:\n{code}", "PHP Standard Expert")
        if phpdoc and "<?php" in phpdoc:
            with open(file_path, 'w') as f: f.write(phpdoc)

if __name__ == "__main__":
    main()
