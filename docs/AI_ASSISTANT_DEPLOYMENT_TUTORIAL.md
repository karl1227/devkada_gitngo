# AI Assistant Deployment Tutorial

## Complete Guide to Implementing the AI Assistant After Publishing

This tutorial will guide you through setting up the AI assistant (OpenAI integration) in your production environment.

---

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Getting Your OpenAI API Key](#getting-your-openai-api-key)
3. [Setting Up API Key in Production](#setting-up-api-key-in-production)
4. [Security Best Practices](#security-best-practices)
5. [Testing the Integration](#testing-the-integration)
6. [Monitoring and Costs](#monitoring-and-costs)
7. [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before you begin, make sure you have:
- ✅ Your website deployed to a hosting server
- ✅ Access to your server's file system (FTP, cPanel, SSH, etc.)
- ✅ An OpenAI account (sign up at https://platform.openai.com)
- ✅ Basic understanding of file editing

---

## Step 1: Getting Your OpenAI API Key

### 1.1 Create an OpenAI Account

1. Go to **https://platform.openai.com**
2. Click **"Sign Up"** or **"Log In"**
3. Complete the registration process
4. Verify your email address

### 1.2 Create an API Key

1. Once logged in, go to: **https://platform.openai.com/api-keys**
2. Click **"Create new secret key"**
3. Give it a name (e.g., "LearnSafe.AI Production")
4. **IMPORTANT:** Copy the API key immediately - you won't be able to see it again!
   - It will look like: `sk-proj-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`
5. Save it securely (password manager, secure note, etc.)

### 1.3 Set Usage Limits (Recommended)

1. Go to **https://platform.openai.com/account/billing/limits**
2. Set a **hard limit** to prevent unexpected charges
   - Recommended: $50-100/month for a small to medium website
3. Set a **soft limit** for warnings
   - Recommended: $30-50/month

---

## Step 2: Setting Up API Key in Production

You have **3 options** for adding your API key. Choose the one that works best for your hosting setup:

### Option A: Environment Variable (Recommended - Most Secure)

This is the **best practice** for production environments.

#### For cPanel/Shared Hosting:

1. Log into your **cPanel**
2. Go to **"Environment Variables"** or **"Advanced"** → **"Environment Variables"**
3. Click **"Add Variable"**
4. Set:
   - **Variable Name:** `OPENAI_API_KEY`
   - **Variable Value:** `sk-proj-your-actual-api-key-here`
5. Click **"Save"**

#### For VPS/Dedicated Server (SSH):

1. Connect to your server via SSH
2. Edit your server's environment file (location depends on your setup):
   ```bash
   # For Apache with .htaccess
   nano /path/to/your/site/.htaccess
   
   # Add this line:
   SetEnv OPENAI_API_KEY "sk-proj-your-actual-api-key-here"
   ```

   OR

   ```bash
   # For PHP-FPM/Nginx
   nano /etc/php/8.x/fpm/php.ini
   
   # Add under [PHP]:
   env[OPENAI_API_KEY] = "sk-proj-your-actual-api-key-here"
   ```

3. Restart your web server:
   ```bash
   sudo systemctl restart apache2
   # OR
   sudo systemctl restart php-fpm
   ```

#### For Cloud Hosting (AWS, Azure, Google Cloud):

1. Go to your hosting platform's **Environment Variables** or **Configuration** section
2. Add a new environment variable:
   - **Key:** `OPENAI_API_KEY`
   - **Value:** `sk-proj-your-actual-api-key-here`
3. Save and restart your application

---

### Option B: Direct Edit in config.php (Easier but Less Secure)

**⚠️ Warning:** This method stores the API key directly in your code. Only use if you can't set environment variables.

1. **Via FTP/cPanel File Manager:**
   - Navigate to: `config/config.php`
   - Open the file for editing

2. **Find this line:**
   ```php
   define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: 'YOUR_OPENAI_API_KEY_HERE');
   ```

3. **Replace with your API key:**
   ```php
   define('OPENAI_API_KEY', 'sk-proj-your-actual-api-key-here');
   ```

4. **Save the file**

5. **Important Security Steps:**
   - Make sure `config/config.php` is NOT publicly accessible
   - Add to `.htaccess` if using Apache:
     ```apache
     <Files "config.php">
         Order allow,deny
         Deny from all
     </Files>
     ```

---

### Option C: Separate Config File (Good Balance)

Create a separate file that's not in version control:

1. **Create a new file:** `config/api_keys.php`
   ```php
   <?php
   // API Keys Configuration
   // DO NOT commit this file to version control!
   define('OPENAI_API_KEY', 'sk-proj-your-actual-api-key-here');
   ```

2. **Add to `.gitignore`** (if using Git):
   ```
   config/api_keys.php
   ```

3. **Update `config/config.php`:**
   ```php
   // Load API keys if file exists
   if (file_exists(__DIR__ . '/api_keys.php')) {
       require_once __DIR__ . '/api_keys.php';
   }
   
   // Fallback to environment variable or default
   if (!defined('OPENAI_API_KEY')) {
       define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: 'YOUR_OPENAI_API_KEY_HERE');
   }
   ```

4. **Upload `api_keys.php`** to your server (but don't commit it to Git)

---

## Step 3: Security Best Practices

### 3.1 Protect Your API Key

✅ **DO:**
- Use environment variables when possible
- Keep your API key secret
- Set usage limits in OpenAI dashboard
- Monitor your API usage regularly
- Use separate API keys for development and production

❌ **DON'T:**
- Commit API keys to Git/version control
- Share API keys publicly
- Hardcode keys in JavaScript (client-side)
- Use the same key for multiple projects without limits

### 3.2 File Permissions

Make sure your config files have proper permissions:

```bash
# For config.php
chmod 644 config/config.php

# For api_keys.php (if using separate file)
chmod 600 config/api_keys.php  # Only owner can read/write
```

### 3.3 .htaccess Protection (Apache)

Add to your `.htaccess` file:

```apache
# Protect config files
<FilesMatch "^(config\.php|api_keys\.php)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Protect entire config directory
<Directory "config">
    Order allow,deny
    Deny from all
</Directory>
```

### 3.4 Rate Limiting (Optional but Recommended)

Add rate limiting to prevent abuse:

1. **Create:** `api/rate_limit.php`
   ```php
   <?php
   session_start();
   
   $rate_limit = 10; // messages per minute
   $time_window = 60; // seconds
   
   if (!isset($_SESSION['chat_requests'])) {
       $_SESSION['chat_requests'] = [];
   }
   
   // Clean old requests
   $_SESSION['chat_requests'] = array_filter(
       $_SESSION['chat_requests'],
       function($timestamp) use ($time_window) {
           return time() - $timestamp < $time_window;
       }
   );
   
   if (count($_SESSION['chat_requests']) >= $rate_limit) {
       http_response_code(429);
       echo json_encode([
           'success' => false,
           'message' => 'Too many requests. Please wait a moment.'
       ]);
       exit;
   }
   
   $_SESSION['chat_requests'][] = time();
   ```

2. **Include in `api/chat.php`** at the top:
   ```php
   require_once __DIR__ . '/rate_limit.php';
   ```

---

## Step 4: Testing the Integration

### 4.1 Test Locally First (Before Publishing)

1. **Add your API key** to `config/config.php` (temporarily for testing)
2. **Open:** `http://localhost/devkada_gitngo/index.php`
3. **Click the chat button**
4. **Send a test message:** "Hello, how can I get started?"
5. **Check the response:**
   - ✅ If you get an AI-generated response → API is working!
   - ❌ If you get a rule-based response → API key might be wrong or not set

### 4.2 Test in Production

1. **Upload your files** to your production server
2. **Set up your API key** using one of the methods above
3. **Visit your live website**
4. **Test the chat:**
   - Send: "What is LearnSafe.AI?"
   - Send: "How do I find a teacher?"
   - Send: "What are your pricing options?"

5. **Check browser console** (F12 → Console tab) for any errors

### 4.3 Verify API Calls

1. **Open browser DevTools** (F12)
2. **Go to Network tab**
3. **Send a chat message**
4. **Look for:** `chat.php` request
5. **Check the response:**
   - Status should be `200 OK`
   - Response should contain `"success": true`
   - Response should have an AI-generated message

---

## Step 5: Monitoring and Costs

### 5.1 Monitor Usage

1. **Go to:** https://platform.openai.com/usage
2. **Check:**
   - Daily usage
   - Monthly usage
   - Cost per day/month
   - Token usage

### 5.2 Set Up Alerts

1. **Go to:** https://platform.openai.com/account/billing/limits
2. **Set up email alerts** when you reach:
   - 50% of your limit
   - 80% of your limit
   - 100% of your limit

### 5.3 Cost Estimation

**GPT-3.5-turbo pricing:**
- Input: $0.50 per 1M tokens
- Output: $1.50 per 1M tokens

**Typical conversation:**
- User message: ~20 tokens
- AI response: ~100 tokens
- **Cost per conversation:** ~$0.0002 (very cheap!)

**Monthly estimate for 1,000 conversations:**
- ~$0.20 per month

---

## Step 6: Troubleshooting

### Problem: Chat still uses rule-based responses

**Solutions:**
1. ✅ Check if API key is set correctly in `config/config.php`
2. ✅ Verify environment variable is set (if using that method)
3. ✅ Check file permissions on config files
4. ✅ Look for PHP errors in server logs
5. ✅ Test API key directly:
   ```php
   // Create test file: test_api.php
   <?php
   require_once 'config/config.php';
   echo OPENAI_API_KEY === 'YOUR_OPENAI_API_KEY_HERE' ? 'NOT SET' : 'SET';
   ```

### Problem: "API key is invalid" error

**Solutions:**
1. ✅ Verify you copied the entire API key (starts with `sk-`)
2. ✅ Check for extra spaces or characters
3. ✅ Make sure you're using the correct API key (not revoked)
4. ✅ Generate a new API key if needed

### Problem: "Rate limit exceeded" error

**Solutions:**
1. ✅ You're making too many requests too quickly
2. ✅ Wait a few minutes and try again
3. ✅ Implement rate limiting (see Step 3.4)
4. ✅ Check your OpenAI account for rate limits

### Problem: Chat not responding

**Solutions:**
1. ✅ Check browser console for JavaScript errors
2. ✅ Verify `api/chat.php` is accessible
3. ✅ Check server error logs
4. ✅ Test API endpoint directly:
   ```bash
   curl -X POST http://yoursite.com/api/chat.php \
     -H "Content-Type: application/json" \
     -d '{"message":"test"}'
   ```

### Problem: CORS errors

**Solutions:**
1. ✅ Add CORS headers to `api/chat.php`:
   ```php
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Methods: POST');
   header('Access-Control-Allow-Headers: Content-Type');
   ```

---

## Step 7: Production Checklist

Before going live, verify:

- [ ] API key is set (environment variable or config file)
- [ ] API key is NOT in version control
- [ ] Usage limits are set in OpenAI dashboard
- [ ] Rate limiting is implemented (optional but recommended)
- [ ] Config files are protected (.htaccess)
- [ ] Tested chat functionality on production server
- [ ] Browser console shows no errors
- [ ] API responses are working correctly
- [ ] Fallback to rule-based responses works if API fails
- [ ] Monitoring/alerting is set up

---

## Quick Reference

### File Locations:
- **Config:** `config/config.php`
- **API Endpoint:** `api/chat.php`
- **Frontend:** `index.php` (chat widget)

### Important URLs:
- **OpenAI Dashboard:** https://platform.openai.com
- **API Keys:** https://platform.openai.com/api-keys
- **Usage:** https://platform.openai.com/usage
- **Billing:** https://platform.openai.com/account/billing

### API Key Format:
```
sk-proj-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### Test Message:
```
"Hello, how can I get started with LearnSafe.AI?"
```

---

## Support

If you encounter issues:

1. **Check OpenAI Status:** https://status.openai.com
2. **Review OpenAI Docs:** https://platform.openai.com/docs
3. **Check server error logs**
4. **Test with a simple curl command** (see troubleshooting section)

---

## Next Steps

After successful deployment:

1. ✅ Monitor usage for the first week
2. ✅ Adjust rate limits if needed
3. ✅ Collect user feedback
4. ✅ Consider adding conversation history (optional)
5. ✅ Add analytics to track chat usage

---

**Good luck with your deployment! 🚀**

