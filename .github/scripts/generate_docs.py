import os
import requests

def ask_cerebras(code_content):
    api_key = os.getenv('CEREBRAS_API_KEY')
    if not api_key: return None
    url = "https://api.cerebras.ai/v1/chat/completions"
    headers = {"Authorization": f"Bearer {api_key}", "Content-Type": "application/json"}
    data = {
        "model": "llama3.1-8b",
        "messages": [{"role": "system", "content": "You are a Laravel expert. Generate technical documentation in Markdown. Return ONLY markdown."}],
        "temperature": 0.1
    }
    try:
        response = requests.post(url, json=data, headers=headers, timeout=30)
        return response.json()['choices'][0]['message']['content'] if response.status_code == 200 else None
    except: return None

def should_skip(filename):
    base = filename.replace(".php", "")
    return all([
        os.path.exists(os.path.join('docs', f"{base}.md")),
        os.path.exists(os.path.join('tests/Unit', f"{base}Test.php")),
        os.path.exists(os.path.join('tests/Browser', f"{base}Test.php"))
    ])

source_dirs = ['app/Http', 'app/SOLID']
output_dir = 'docs'
if not os.path.exists(output_dir): os.makedirs(output_dir)

for s_dir in source_dirs:
    if not os.path.exists(s_dir): continue
    for root, _, files in os.walk(s_dir):
        for filename in files:
            if filename.endswith(".php") and not should_skip(filename):
                path = os.path.join(root, filename)
                try:
                    with open(path, 'r', encoding='utf-8') as f:
                        res = ask_cerebras(f.read())
                        if res:
                            with open(os.path.join(output_dir, filename.replace(".php", ".md")), 'w', encoding='utf-8') as out:
                                out.write(res)
                except: pass
print("Done.")
