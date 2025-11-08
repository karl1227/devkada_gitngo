# AI Assistant Setup - Quick Summary

## 📋 Setup Checklist

### Before Publishing:
- [ ] Get OpenAI API key from https://platform.openai.com/api-keys
- [ ] Set usage limits in OpenAI dashboard
- [ ] Test locally with API key

### After Publishing:
- [ ] Upload all files to server
- [ ] Add API key to server (choose method below)
- [ ] Test chat on live site
- [ ] Verify AI responses are working
- [ ] Set up monitoring/alerts

---

## 🔑 Adding API Key (Choose One Method)

### Method 1: Environment Variable (Best) ⭐
```
In cPanel: Environment Variables → Add:
OPENAI_API_KEY = sk-proj-your-key-here
```

### Method 2: Edit config.php
```
Open: config/config.php
Find: define('OPENAI_API_KEY', ...)
Replace: 'YOUR_OPENAI_API_KEY_HERE' with your key
```

### Method 3: Separate File
```
Create: config/api_keys.php
Add: define('OPENAI_API_KEY', 'sk-proj-your-key-here');
```

---

## ✅ Testing Steps

1. **Visit your live website**
2. **Click chat button** (bottom-right)
3. **Send:** "Hello, how can I get started?"
4. **Check response:**
   - ✅ AI response = Working!
   - ❌ Rule-based response = Check API key

---

## 🔒 Security Checklist

- [ ] API key NOT in version control
- [ ] Config files protected (.htaccess)
- [ ] Usage limits set in OpenAI
- [ ] Rate limiting enabled (optional)

---

## 📚 Full Documentation

- **Complete Tutorial:** `docs/AI_ASSISTANT_DEPLOYMENT_TUTORIAL.md`
- **Quick Start:** `docs/DEPLOYMENT_QUICK_START.md`
- **Testing Guide:** `docs/TESTING_GUIDE.md`

---

## 🆘 Quick Troubleshooting

**Problem:** Still using rule-based responses
- ✅ Check API key is set correctly
- ✅ Verify environment variable (if using)
- ✅ Check server error logs

**Problem:** "API key invalid" error
- ✅ Verify you copied entire key
- ✅ Check for extra spaces
- ✅ Generate new key if needed

---

## 💰 Cost Estimate

- **Per conversation:** ~$0.0002
- **1,000 conversations/month:** ~$0.20
- **10,000 conversations/month:** ~$2.00

**Set monthly limit:** $50-100 recommended

---

**Need help?** See full tutorial: `docs/AI_ASSISTANT_DEPLOYMENT_TUTORIAL.md`

