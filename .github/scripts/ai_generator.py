name: 📘 AI Full Docs & Automation Tests (Cerebras)

on:
  push:
    branches: [ main, dev1 ]
  workflow_dispatch: # التشغيل اليدوي
    inputs:
      target_branch:
        description: ''
        required: true
        default: 'main'
      run_mode:
        description: ''
        type: choice
        options:
          - full_suite (Docs+Unit+Selenium+PHPDoc)
          - docs_only
          - tests_only
        default: 'full_suite'

permissions:
  contents: write

jobs:
  generate:
    runs-on: ubuntu-latest
    steps:
      - name: 📥 Checkout Code
        uses: actions/checkout@v4
        with:
          ref: ${{ github.event.inputs.target_branch || github.ref }}
          fetch-depth: 0

      - name: 🐍 Set up Python
        uses: actions/setup-python@v4
        with:
          python-version: '3.10'

      - name: 📦 Install Dependencies
        run: pip install requests

      - name: 🤖 Run Cerebras AI Generator
        env:
          CEREBRAS_API_KEY: ${{ secrets.CEREBRAS_API_KEY }}
          RUN_MODE: ${{ github.event.inputs.run_mode || 'full_suite' }}
        run: python .github/scripts/ai_generator.py

      - name: 📤 Commit & Push Changes
        run: |
          git config --global user.name 'Cerebras AI Bot'
          git config --global user.email 'ai-bot@cerebras.ai'
          
          mkdir -p docs/ai tests/Generated/Unit tests/Generated/Selenium
          
          git add docs/ai/ tests/Generated/ .ai_docs_tracker.txt .ai_tests_tracker.txt
          git add app/ 
          
          git commit -m "chore: AI generated docs & tests [skip ci]" || echo "No changes to commit"
          git push origin HEAD:${{ github.event.inputs.target_branch || github.ref_name }}
