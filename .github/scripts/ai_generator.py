name: 📘 AI Full Docs & Automation Tests (Cerebras)

on:
  push:
    branches: [ main, dev1 ]
  # إضافة التشغيل اليدوي مع خيارات
  workflow_dispatch:
    inputs:
      target_branch:
        description: 'البرانش المراد العمل عليه'
        required: true
        default: 'main'
      run_type:
        description: 'ماذا تريد أن تولد؟'
        type: choice
        options:
          - all
          - docs_only
          - tests_only
        default: 'all'

permissions:
  contents: write

jobs:
  ai-generation:
    runs-on: ubuntu-latest
    steps:
      - name: 📥 Checkout Code
        uses: actions/checkout@v4
        with:
          ref: ${{ github.event.inputs.target_branch || github.ref }}
          fetch-depth: 0

      - name: 💾 Persistent AI Cache
        uses: actions/cache@v4
        with:
          path: |
            .ai_docs_tracker.txt
            .ai_tests_tracker.txt
          key: ai-cerebras-cache-v1

      - name: 🐍 Set up Python
        uses: actions/setup-python@v4
        with:
          python-version: '3.10'

      - name: 📦 Install Dependencies
        run: pip install requests

      - name: 🤖 Run AI Full Generator
        env:
          CEREBRAS_API_KEY: ${{ secrets.CEREBRAS_API_KEY }}
          RUN_TYPE: ${{ github.event.inputs.run_type || 'all' }}
        run: python .github/scripts/ai_generator.py

      - name: 📤 Commit & Push Changes
        run: |
          git config --global user.name 'Cerebras AI Bot'
          git config --global user.email 'ai-bot@cerebras.ai'
          
          mkdir -p docs/ai tests/Generated/Unit tests/Generated/Selenium
          
          git add .
          git commit -m "chore: AI generated docs, unit tests & selenium [skip ci]" || echo "No changes to commit"
          
          # دفع التغييرات للبرانش المختار
          git push origin HEAD:${{ github.event.inputs.target_branch || github.ref_name }}
