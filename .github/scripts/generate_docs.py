import os
import requests
import glob

# إعدادات API
CEREBRAS_API_KEY = os.getenv("CEREBRAS_API_KEY")
API_URL = "https://api.cerebras.ai/v1/chat/completions"

def ask_cerebras(prompt):
    headers = {
        "Authorization": f"Bearer {CEREBRAS_API_KEY}",
        "Content-Type": "application/json"
    }
    data = {
        "model": "llama-3.3-70b",
        "messages": [{"role": "user", "content": prompt}],
        "temperature": 0.2
    }
    response = requests.post(API_URL, json=data, headers=headers)
    if response.status_code == 200:
        return response.json()['choices'][0]['message']['content']
    else:
        print(f"Error: {response.status_code} - {response.text}")
        return None

def process_files():
    files = glob.glob('app/Http/Controllers/**/*.php', recursive=True) + \
            glob.glob('app/Models/**/*.php', recursive=True)

    for file_path in files:
        with open(file_path, 'r') as f:
            code = f.read()

        print(f"Processing: {file_path}")

        doc_prompt = f"Add professional PHPDoc comments to all methods in this PHP code. Return ONLY the updated code:\n\n{code}"
        updated_code = ask_cerebras(doc_prompt)
        if updated_code:
            with open(file_path, 'w') as f:
                clean_code = updated_code.replace('```php', '').replace('```', '').strip()
                f.write(clean_code)

        unit_prompt = f"Generate a Laravel PHPUnit Unit Test for the following class. Include necessary imports and follow PSR-12. Return ONLY the code:\n\n{code}"
        unit_test = ask_cerebras(unit_prompt)
        if unit_test:
            test_name = os.path.basename(file_path).replace('.php', 'Test.php')
            test_content = unit_test.replace('```php', '').replace('```', '').strip()
            with open(f"tests/Unit/{test_name}", 'w') as f:
                f.write(test_content)

        # 3. توليد Selenium (Laravel Dusk) Test
        if "Controller" in file_path:
            dusk_prompt = f"Generate a Laravel Dusk (Selenium) browser test for the functionality in this controller. Assume standard routes. Return ONLY the code:\n\n{code}"
            dusk_test = ask_cerebras(dusk_prompt)
            if dusk_test:
                dusk_name = os.path.basename(file_path).replace('.php', 'BrowserTest.php')
                dusk_content = dusk_test.replace('```php', '').replace('```', '').strip()
                with open(f"tests/Browser/{dusk_name}", 'w') as f:
                    f.write(dusk_content)

if __name__ == "__main__":
    if not CEREBRAS_API_KEY:
        print("API Key missing!")
    else:
        process_files()
