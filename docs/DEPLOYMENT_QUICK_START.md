# Quick Start: AI Assistant Setup

## 5-Minute Setup Guide

### Step 1: Get OpenAI API Key
1. Go to: https://platform.openai.com/api-keys
2. Click "Create new secret key"
3. Copy the key (starts with `sk-`)

### Step 2: Add API Key to Your Server

**Option A: Environment Variable (Best)**
- In cPanel: Go to Environment Variables → Add `OPENAI_API_KEY` = `your-key-here`
- Or add to `.htaccess`: `SetEnv OPENAI_API_KEY "your-key-here"`

**Option B: Edit config.php**
- Open: `config/config.php`
- Find: `define('OPENAI_API_KEY', ...)`
- Replace: `'YOUR_OPENAI_API_KEY_HERE'` with your actual key
- Save

### Step 3: Test
1. Visit your website
2. Click the chat button
3. Send: "Hello"
4. ✅ If you get an AI response → Success!
5. ❌ If you get a rule-based response → Check API key

### Step 4: Set Usage Limits
1. Go to: https://platform.openai.com/account/billing/limits
2. Set monthly limit: $50-100
3. Enable email alerts

### Done! 🎉

**Need help?** See the full tutorial: `docs/AI_ASSISTANT_DEPLOYMENT_TUTORIAL.md`

