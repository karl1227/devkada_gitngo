# AI Assistant Setup Instructions

## OpenAI API Integration

The chat assistant now uses OpenAI's GPT-3.5-turbo model for natural conversations. If no API key is provided, it falls back to rule-based responses.

### Setup Steps:

1. **Get an OpenAI API Key:**
   - Go to: https://platform.openai.com/api-keys
   - Sign up or log in to your OpenAI account
   - Create a new API key
   - Copy the API key

2. **Add API Key to Configuration:**
   
   **Option A: Edit config.php directly**
   - Open `config/config.php`
   - Find the line: `define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: 'YOUR_OPENAI_API_KEY_HERE');`
   - Replace `YOUR_OPENAI_API_KEY_HERE` with your actual API key:
   ```php
   define('OPENAI_API_KEY', 'sk-your-actual-api-key-here');
   ```

   **Option B: Use Environment Variable (Recommended for Production)**
   - Set an environment variable `OPENAI_API_KEY` with your API key
   - The system will automatically use it

3. **Test the Integration:**
   - Open `index.php` in your browser
   - Click the chat button
   - Send a message
   - You should receive AI-powered responses

### Features:

- ✅ Real AI conversations using GPT-3.5-turbo
- ✅ Automatic fallback to rule-based responses if API fails
- ✅ Context-aware responses
- ✅ Natural language understanding
- ✅ Same UI/UX as before

### Cost:

- OpenAI API charges per token used
- GPT-3.5-turbo is very affordable (~$0.0015 per 1K tokens)
- Typical conversation costs: $0.01-0.05 per session
- You can set usage limits in your OpenAI account

### Fallback Behavior:

If the API key is not set or the API call fails, the system automatically falls back to the rule-based chatbot, so the chat will always work.

### Security Note:

- Never commit your API key to version control
- Keep your API key secure
- Consider using environment variables for production

