#!/usr/bin/env python3
"""
🤖 AI Documentation & Test Generator using Cerebras API
Generates: Documentation + PHPUnit Tests + Selenium Tests + PHPDoc
"""

import os
import sys
import requests
import re
import glob
import json
from pathlib import Path
from datetime import datetime

# ============ CONFIGURATION ============
CEREBRAS_API_KEY = os.getenv("CEREBRAS_API_KEY", "")
API_URL = "https://api.cerebras.ai/v1/chat/completions"
MODEL = "llama-3.3-70b"

# File tracking
DOCS_TRACKER = ".ai_docs_tracker.txt"
TESTS_TRACKER = ".ai_tests_tracker.txt"

# Output directories
DOCS_DIR = "docs/ai"
UNIT_TESTS_DIR = "tests/Generated/Unit"
SELENIUM_TESTS_DIR = "tests/Generated/Selenium"
INTEGRATION_TESTS_DIR = "tests/Generated/Integration"

# Directories to process
TARGET_DIRS = [
    "app/Facades/",
    "app/Features/PatientSatisfaction/",
    "app/Features/ClinicUsers",
    "app/Http/Controllers/",
    "app/Models/",
    "app/Services/"
]

# ============ UTILITY FUNCTIONS ============

def log(level, message):
    """Colored console logging"""
    colors = {
        "INFO": "\033[94m",
        "SUCCESS": "\033[92m",
        "WARNING": "\033[93m",
        "ERROR": "\033[91m",
        "RESET": "\033[0m"
    }
    prefix = f"[{level}]"
    color = colors.get(level, colors["INFO"])
    print(f"{color}{prefix} {message}{colors['RESET']}")

def verify_api_key():
    """Verify Cerebras API key exists"""
    if not CEREBRAS_API_KEY:
        log("ERROR", "CEREBRAS_API_KEY environment variable not set")
        sys.exit(1)
    log("SUCCESS", "✅ API Key verified")

def ask_cerebras(prompt, system_role="You are a senior PHP engineer."):
    """
    Call Cerebras API and return response
    """
    headers = {
        "Authorization": f"Bearer {CEREBRAS_API_KEY}",
        "Content-Type": "application/json"
    }
    
    payload = {
        "model": MODEL,
        "messages": [
            {"role": "system", "content": system_role},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.1,
        "max_tokens": 4096
    }

    try:
        log("INFO", f"🔄 Calling Cerebras API...")
        response = requests.post(API_URL, json=payload, headers=headers, timeout=120)
        
        if response.status_code == 200:
            content = response.json()['choices'][0]['message']['content']
            log("SUCCESS", "✅ Received response from Cerebras")
            return content.strip()
        else:
            log("ERROR", f"API Error {response.status_code}: {response.text[:200]}")
            return None
            
    except requests.exceptions.Timeout:
        log("ERROR", "⏱️ Request timeout (120s)")
        return None
    except Exception as e:
        log("ERROR", f"Request failed: {str(e)}")
        return None

def extract_php_functions(code):
    """Extract all function/method names from PHP code"""
    patterns = [
        r'(?:public|private|protected)?\s+(?:static\s+)?function\s+(\w+)\s*\(',
        r'function\s+(\w+)\s*\('
    ]
    functions = []
    for pattern in patterns:
        functions.extend(re.findall(pattern, code))
    return list(set(functions))  # Remove duplicates

def extract_class_name(code):
    """Extract class name from PHP code"""
    match = re.search(r'class\s+(\w+)', code)
    return match.group(1) if match else "Unknown"

def clean_php_code(text):
    """Remove markdown code blocks from response"""
    return re.sub(r'```php|```', '', text).strip()

# ============ DOCUMENTATION GENERATION ============

def generate_documentation(code, file_path):
    """Generate markdown documentation"""
    class_name = extract_class_name(code)
    functions = extract_functions(code)
    
    prompt = f"""Generate comprehensive technical documentation in Markdown format.

FILE: {file_path}
CLASS: {class_name}
FUNCTIONS FOUND: {', '.join(functions) if functions else 'None'}

Create documentation with these sections:
1. **Overview** - Purpose and responsibility of this class
2. **Class Properties** - List all class properties/attributes
3. **Functions Reference** - Markdown table with columns:
   - Function Name
   - Access Level (public/private/protected)
   - Parameters
   - Return Type
   - Description
4. **Usage Examples** - Show how to instantiate and use the class
5. **Dependencies** - External dependencies or interfaces
6. **Exceptions** - What exceptions this class might throw

PHP Code:
{code[:4000]}

Return ONLY the markdown content."""

    system_role = "You are a senior PHP documentation expert. Generate clear, professional Markdown documentation."
    response = ask_cerebras(prompt, system_role)
    
    return response if response else None

# ============ TESTING GENERATION ============

def generate_unit_tests(code, file_path):
    """Generate PHPUnit tests for all functions"""
    class_name = extract_class_name(code)
    functions = extract_php_functions(code)
    
    if not functions:
        log("WARNING", f"⚠️ No functions found in {file_path}")
        return None

    prompt = f"""Generate a complete, production-ready PHPUnit test class.

CLASS TO TEST: {class_name}
FILE: {file_path}
FUNCTIONS TO TEST: {', '.join(functions)}

REQUIREMENTS:
1. Test EVERY function listed above
2. Create separate test methods: test{FunctionName}()
3. Use Mockery for external dependencies
4. Include setUp() and tearDown() methods
5. Test happy paths, error cases, and edge cases
6. Use data providers for parameterized tests where applicable
7. Mock database calls and external APIs
8. Include assertions for return values and side effects
9. Test exception throwing where applicable
10. Follow PHPUnit best practices

Source Code:
{code}

Return ONLY valid PHP code starting with:
<?php

namespace Tests\\Unit;

use PHPUnit\\Framework\\TestCase;
use Mockery;
"""

    system_role = """You are a senior PHP QA engineer with 10+ years experience.
Generate comprehensive PHPUnit tests that test EVERY SINGLE function.
Return ONLY pure, executable PHP code. No markdown formatting."""
    
    response = ask_cerebras(prompt, system_role)
    return clean_php_code(response) if response else None

def generate_selenium_tests(code, file_path):
    """Generate Laravel Dusk (Selenium) tests for controllers"""
    class_name = extract_class_name(code)
    functions = extract_php_functions(code)
    
    prompt = f"""Generate Laravel Dusk browser tests for this controller.

CONTROLLER: {class_name}
FILE: {file_path}
METHODS: {', '.join(functions)}

REQUIREMENTS:
1. Test each public method with browser interactions
2. Test form submissions and validations
3. Test page navigation and redirects
4. Test authentication and authorization
5. Test error messages and flash notifications
6. Use selectors for elements (id, class, or data-dusk attributes)
7. Test AJAX requests if present
8. Include assertions for page content and behavior
9. Follow Laravel Dusk best practices

Controller Code:
{code[:3000]}

Return ONLY valid PHP code starting with:
<?php

namespace Tests\\Browser;

use Laravel\\Dusk\\Browser;
use Tests\\DuskTestCase;
"""

    system_role = "You are a Laravel testing expert. Generate Dusk tests for controllers."
    response = ask_cerebras(prompt, system_role)
    return clean_php_code(response) if response else None

def generate_integration_tests(code, file_path):
    """Generate integration tests"""
    prompt = f"""Generate PHPUnit integration tests for this service/feature.

FILE: {file_path}

Create tests that:
1. Test interactions between multiple classes
2. Test database operations
3. Test API calls or external service integration
4. Test end-to-end workflows
5. Use real (or in-memory) database when possible
6. Test transaction handling
7. Test error handling across services

Source Code:
{code[:3000]}

Return ONLY valid PHP code."""

    system_role = "You are a PHP integration testing expert."
    response = ask_cerebras(prompt, system_role)
    return clean_php_code(response) if response else None

# ============ PHPDOC GENERATION ============

def add_phpdoc(code, file_path):
    """Add/update PHPDoc comments"""
    prompt = f"""Add comprehensive PHPDoc comments to EVERY method and class property.

For each method, add:
/**
 * Brief description of what the method does
 *
 * Longer description if needed
 *
 * @param Type $paramName Description
 * @return Type Description of return value
 * @throws ExceptionType When this exception is thrown
 */

For properties:
/**
 * @var Type Description
 */

Source Code:
{code}

Return the COMPLETE PHP file with added/updated PHPDoc comments.
Preserve all existing code exactly as-is."""

    system_role = "You are a PHP documentation expert. Add PHPDoc to every method and property."
    response = ask_cerebras(prompt, system_role)
    return response if response else None

# ============ FILE PROCESSING ============

def load_tracker(tracker_file):
    """Load previously processed files"""
    if os.path.exists(tracker_file):
        with open(tracker_file, 'r', encoding='utf-8') as f:
            return set(line.strip() for line in f if line.strip())
    return set()

def save_to_tracker(tracker_file, file_paths):
    """Append processed files to tracker"""
    if not file_paths:
        return
    with open(tracker_file, 'a', encoding='utf-8') as f:
        for path in file_paths:
            f.write(f"{path}\n")

def get_output_path(input_file, output_dir, suffix=""):
    """Convert input path to output path"""
    base_name = os.path.splitext(os.path.basename(input_file))[0]
    return os.path.join(output_dir, base_name + suffix + ".php")

def collect_php_files(target_dirs):
    """Collect all PHP files from target directories"""
    files = []
    for target in target_dirs:
        target = target.rstrip('/')
        if os.path.isdir(target):
            for root, _, filenames in os.walk(target):
                for filename in filenames:
                    if filename.endswith('.php') and 'Test' not in filename:
                        files.append(os.path.join(root, filename))
        elif os.path.isfile(target):
            files.append(target)
    return sorted(list(set(files)))  # Remove duplicates

def process_files(target_dirs, batch_limit=2):
    """Main processing loop"""
    log("INFO", "🚀 Starting AI Documentation & Test Generation...")
    
    # Create output directories
    for dir_path in [DOCS_DIR, UNIT_TESTS_DIR, SELENIUM_TESTS_DIR, INTEGRATION_TESTS_DIR]:
        Path(dir_path).mkdir(parents=True, exist_ok=True)

    # Load previously processed files
    docs_processed = load_tracker(DOCS_TRACKER)
    tests_processed = load_tracker(TESTS_TRACKER)

    # Collect files
    all_files = collect_php_files(target_dirs)
    log("INFO", f"📂 Found {len(all_files)} PHP files to process")

    processed_docs = []
    processed_tests = []

    for idx, file_path in enumerate(all_files, 1):
        if len(processed_docs) >= batch_limit and len(processed_tests) >= batch_limit:
            log("INFO", "⏸️ Batch limit reached")
            break

        log("INFO", f"\n📋 Processing ({idx}/{len(all_files)}): {file_path}")

        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                code = f.read()

            if len(code) < 100:
                log("WARNING", "⚠️ File too small, skipping")
                continue

            # ============ DOCUMENTATION ============
            if file_path not in docs_processed and len(processed_docs) < batch_limit:
                log("INFO", "📚 Generating documentation...")
                docs = generate_documentation(code, file_path)
                
                if docs:
                    doc_path = os.path.join(DOCS_DIR, os.path.splitext(file_path)[0] + ".md")
                    os.makedirs(os.path.dirname(doc_path), exist_ok=True)
                    
                    with open(doc_path, 'w', encoding='utf-8') as f:
                        f.write(f"# 📄 Documentation: `{file_path}`\n\n")
                        f.write(docs)
                        f.write(f"\n\n---\n*Generated by Cerebras AI on {datetime.now().strftime('%Y-%m-%d %H:%M')}*")
                    
                    processed_docs.append(file_path)
                    log("SUCCESS", f"✅ Documentation: {doc_path}")

            # ============ UNIT TESTS ============
            if file_path not in tests_processed and len(processed_tests) < batch_limit:
                log("INFO", "🧪 Generating unit tests...")
                unit_tests = generate_unit_tests(code, file_path)
                
                if unit_tests and "<?php" in unit_tests:
                    test_path = os.path.join(UNIT_TESTS_DIR, os.path.basename(file_path).replace(".php", "Test.php"))
                    with open(test_path, 'w', encoding='utf-8') as f:
                        f.write(unit_tests)
                    
                    processed_tests.append(file_path)
                    log("SUCCESS", f"✅ Unit tests: {test_path}")

            # ============ SELENIUM TESTS (Controllers only) ============
            if "Controller" in file_path and len(processed_tests) < batch_limit:
                log("INFO", "🌐 Generating Selenium tests...")
                selenium_tests = generate_selenium_tests(code, file_path)
                
                if selenium_tests and "<?php" in selenium_tests:
                    test_path = os.path.join(SELENIUM_TESTS_DIR, os.path.basename(file_path).replace(".php", "DuskTest.php"))
                    with open(test_path, 'w', encoding='utf-8') as f:
                        f.write(selenium_tests)
                    log("SUCCESS", f"✅ Selenium tests: {test_path}")

            # ============ INTEGRATION TESTS ============
            if "Service" in file_path or "Feature" in file_path:
                log("INFO", "🔗 Generating integration tests...")
                integration_tests = generate_integration_tests(code, file_path)
                
                if integration_tests and "<?php" in integration_tests:
                    test_path = os.path.join(INTEGRATION_TESTS_DIR, os.path.basename(file_path).replace(".php", "IntegrationTest.php"))
                    with open(test_path, 'w', encoding='utf-8') as f:
                        f.write(integration_tests)
                    log("SUCCESS", f"✅ Integration tests: {test_path}")

            # ============ ADD PHPDOC ============
            log("INFO", "📝 Adding PHPDoc comments...")
            phpdoc_code = add_phpdoc(code, file_path)
            
            if phpdoc_code and "<?php" in phpdoc_code:
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(phpdoc_code)
                log("SUCCESS", f"✅ PHPDoc added to source file")

        except Exception as e:
            log("ERROR", f"❌ Failed to process {file_path}: {str(e)}")
            continue

    # ============ SAVE PROGRESS ============
    save_to_tracker(DOCS_TRACKER, processed_docs)
    save_to_tracker(TESTS_TRACKER, processed_tests)

    # ============ SUMMARY ============
    log("INFO", "\n" + "="*50)
    log("SUCCESS", "✨ Generation Complete!")
    log("INFO", f"📚 Documentation files: {len(processed_docs)}")
    log("INFO", f"🧪 Test files: {len(processed_tests)}")
    log("INFO", f"📝 PHPDoc comments added to source files")
    log("INFO", "="*50)

# ============ MAIN ============

if __name__ == "__main__":
    verify_api_key()
    process_files(TARGET_DIRS, batch_limit=2)
