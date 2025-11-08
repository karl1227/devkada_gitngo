# Testing Guide for AI Assistant

## How to Test Your AI Assistant

### Test 1: Verify API Key is Set

**Create a test file:** `test_api_key.php`

```php
<?php
require_once 'config/config.php';

echo "<h2>API Key Status</h2>";
echo "<p>API Key Set: " . (OPENAI_API_KEY !== 'YOUR_OPENAI_API_KEY_HERE' && !empty(OPENAI_API_KEY) ? '✅ YES' : '❌ NO') . "</p>";
echo "<p>API Key (first 10 chars): " . substr(OPENAI_API_KEY, 0, 10) . "...</p>";
echo "<p>Environment Variable: " . (getenv('OPENAI_API_KEY') ? '✅ Set' : '❌ Not Set') . "</p>";
```

**Access:** `http://yoursite.com/test_api_key.php`

**Expected:** Should show "✅ YES" if API key is set correctly.

---

### Test 2: Test API Endpoint Directly

**Using cURL (command line):**

```bash
curl -X POST http://yoursite.com/api/chat.php \
  -H "Content-Type: application/json" \
  -d '{"message":"Hello, how are you?"}'
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Hello! I'm doing well, thank you for asking...",
  "speak": true
}
```

**Using Browser (JavaScript Console):**

```javascript
fetch('api/chat.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({message: 'Hello'})
})
.then(r => r.json())
.then(data => console.log(data));
```

---

### Test 3: Test Chat Widget

1. **Open your website**
2. **Open Browser DevTools** (F12)
3. **Go to Console tab**
4. **Click the chat button**
5. **Send a message:** "What is LearnSafe.AI?"
6. **Check:**
   - ✅ Message appears in chat
   - ✅ Typing indicator shows
   - ✅ AI response appears
   - ✅ No errors in console

---

### Test 4: Verify AI vs Rule-Based

**Test Messages:**

1. **"Hello"** → Should get AI response (not rule-based)
2. **"What is your pricing?"** → Should get AI response
3. **"Tell me about your platform"** → Should get AI response

**How to tell if it's AI:**
- AI responses are more natural and varied
- AI can answer questions not in the rule-based list
- AI responses are longer and more detailed

---

### Test 5: Test Fallback

**Temporarily break the API key:**

1. Edit `config/config.php`
2. Change API key to: `'INVALID_KEY'`
3. Send a chat message
4. **Expected:** Should fall back to rule-based response
5. **Fix:** Restore correct API key

---

### Test 6: Test Rate Limiting (if enabled)

1. **Send 20+ messages quickly**
2. **Expected:** Should get "Too many requests" error after limit
3. **Wait 1 minute**
4. **Try again** → Should work

---

### Test 7: Test Voice Features

1. **Click microphone button** in chat header
2. **Speak a message**
3. **Expected:** 
   - Microphone icon changes
   - "Listening..." appears
   - Your speech is converted to text
   - Message is sent automatically

4. **Toggle TTS button** (volume icon)
5. **Send a message**
6. **Expected:**
   - When ON: Bot response is spoken
   - When OFF: Bot response is text only

---

## Common Test Scenarios

### Scenario 1: First-Time User
- **Message:** "Hi, I'm new here"
- **Expected:** Welcome message with onboarding info

### Scenario 2: Pricing Question
- **Message:** "How much does it cost?"
- **Expected:** Pricing information ($35-$55/hr)

### Scenario 3: Safety Concern
- **Message:** "Are your teachers safe?"
- **Expected:** Safety and verification information

### Scenario 4: Complex Question
- **Message:** "I have a 7-year-old with autism who loves math but struggles with social skills. Can you help?"
- **Expected:** AI should provide a thoughtful, personalized response

---

## Troubleshooting Tests

### If API doesn't work:

1. **Check API key:**
   ```php
   // In test_api_key.php
   var_dump(OPENAI_API_KEY);
   ```

2. **Check server logs:**
   - Look for PHP errors
   - Check Apache/Nginx error logs

3. **Test API connection:**
   ```php
   // test_connection.php
   $ch = curl_init('https://api.openai.com/v1/models');
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
       'Authorization: Bearer ' . OPENAI_API_KEY
   ]);
   $result = curl_exec($ch);
   var_dump($result);
   ```

---

## Performance Testing

### Test Response Time:

1. **Open Browser DevTools** → Network tab
2. **Send a chat message**
3. **Check:** `chat.php` request
4. **Expected:** Response time < 3 seconds
5. **If slow:** Check server performance or API latency

---

## Security Testing

### Test 1: API Key Protection

1. **Try to access:** `http://yoursite.com/config/config.php`
2. **Expected:** Should be blocked or return 403/404

### Test 2: SQL Injection Protection

1. **Send message:** `"'; DROP TABLE users; --"`
2. **Expected:** Should be sanitized and handled safely

### Test 3: XSS Protection

1. **Send message:** `"<script>alert('xss')</script>"`
2. **Expected:** Should be sanitized in response

---

## Success Criteria

✅ **All tests pass:**
- API key is set correctly
- API endpoint responds
- Chat widget works
- AI responses are generated
- Fallback works if API fails
- Voice features work
- No console errors
- Response time < 3 seconds

---

**Need help?** Check the main tutorial: `docs/AI_ASSISTANT_DEPLOYMENT_TUTORIAL.md`

