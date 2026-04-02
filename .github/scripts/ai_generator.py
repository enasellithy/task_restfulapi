import os
import requests

API_KEY = os.getenv("CEREBRAS_API_KEY")
API_URL = "https://api.cerebras.ai/v1/chat/completions"
SOURCE_DIR = "src"

def ask_cerebras(prompt, code):
    headers = {
        "Authorization": f"Bearer {API_KEY}",
        "Content-Type": "application/json"
    }
    payload = {
        "model": "llama3.1-70b",
        "messages": [
            {"role": "system", "content": "You are a senior developer. Generate Unit tests, Selenium tests, and technical documentation for the provided code. Return only the code/markdown without explanations."},
            {"role": "user", "content": f"{prompt}\n\nCode:\n{code}"}
        ]
    }
    response = requests.post(API_URL, json=payload, headers=headers)
    return response.json()['choices'][0]['message']['content']

def save_file(path, content):
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, "w", encoding="utf-8") as f:
        f.write(content)

def process_files():
    for root, _, files in os.walk(SOURCE_DIR):
        for file in files:
            if file.endswith((".php", ".py", ".js")):
                path = os.path.join(root, file)
                with open(path, "r", encoding="utf-8") as f:
                    code = f.read()

                unit_test = ask_cerebras("Generate comprehensive unit tests for this code.", code)
                save_file(f"tests/Unit/{file}_test.spec", unit_test)

                selenium_test = ask_cerebras("Generate a Selenium automation script for the UI logic of this code.", code)
                save_file(f"tests/Selenium/test_{file}.py", selenium_test)

                docs = ask_cerebras("Generate technical documentation in Markdown for this code.", code)
                save_file(f"docs/{file}.md", docs)

if __name__ == "__main__":
    if API_KEY:
        process_files()
