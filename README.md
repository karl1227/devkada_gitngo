# LEARNSAFE.AI - Hackathon Project

An AI-powered educational platform designed to connect parents of children with autism with verified SPED (Special Education) teachers for safe, personalized home learning.

## 🎯 Project Overview

LEARNSAFE.AI is a web service that facilitates:
- **Parent-Teacher Matching**: AI-powered matching system connecting parents with qualified SPED teachers
- **Progress Tracking**: Monitor student learning journey with AI-generated insights
- **Session Management**: Schedule and manage home learning sessions
- **Safety & Verification**: Comprehensive teacher verification system

## 🧩 System Architecture

### Three Main Modules:

1. **Parent Module** (`/parent/`)
   - Dashboard with child profile and AI insights
   - Find and book teachers
   - Track child's progress
   - Community support forum

2. **Teacher Module** (`/teacher/`)
   - Profile management
   - Availability calendar
   - Student list and progress reports
   - AI insights for teaching effectiveness
   - Verification status

3. **Admin Module** (`/admin/`)
   - User management
   - Teacher verification center
   - Platform analytics
   - System logs

## 📁 Project Structure

```
devkada_gitngo/
├── index.html              # Landing page
├── signin.html             # Sign in page with role selection
├── signup.html             # Sign up page (Parent/Teacher)
├── parent/                 # Parent module
│   ├── dashboard.html
│   ├── child-profile.html
│   ├── find-teacher.html
│   ├── book-session.html
│   ├── schedule.html
│   ├── progress.html
│   └── support.html
├── teacher/                # Teacher module
│   ├── dashboard.html
│   ├── profile.html
│   ├── availability.html
│   ├── students.html
│   ├── reports.html
│   ├── ai-insights.html
│   └── verification.html
├── admin/                   # Admin module
│   ├── dashboard.html
│   ├── users.html
│   ├── verification.html
│   ├── analytics.html
│   └── logs.html
└── README.md
```

## 🛠️ Tech Stack

- **HTML5**: Structure and content
- **Tailwind CSS**: Styling and responsive design (via CDN)
- **Font Awesome**: Icons (via CDN)
- **JavaScript**: Basic interactivity and form handling

## 🚀 Getting Started

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd devkada_gitngo
   ```

2. **Open in browser**
   - Simply open `index.html` in your web browser
   - Or use a local server:
     ```bash
     # Using Python
     python -m http.server 8000
     
     # Using Node.js (http-server)
     npx http-server
     ```

3. **Navigate the platform**
   - Start at `index.html` (landing page)
   - Click "Sign In" or "Get Started"
   - Choose your role (Parent/Teacher/Admin)
   - Explore the respective dashboard

## 📋 Features Implemented

### Landing Page
- Hero section with value proposition
- "How It Works" section for Parents and Teachers
- Testimonials section
- Call-to-action buttons

### Authentication
- Role-based sign in (Parent/Teacher/Admin)
- Separate sign up flows for Parents and Teachers
- Teacher verification document upload

### Parent Features
- Dashboard with child profile and matched teacher
- AI insights and recommendations
- Find and browse verified teachers
- Book sessions with calendar integration
- Progress tracking with weekly goals
- Community support forum

### Teacher Features
- Profile management with specialization
- Availability calendar
- Student list and progress reports
- AI insights for teaching effectiveness
- Verification status tracking

### Admin Features
- System overview dashboard
- User management (view, approve, suspend)
- Teacher verification center
- Platform analytics
- System activity logs

## 🎨 Design Features

- **Clean, modern UI** with Tailwind CSS
- **Responsive design** for all screen sizes
- **Consistent navigation** across all modules
- **Color-coded roles**: Blue (Parents), Purple (Teachers), Red (Admin)
- **Accessible icons** using Font Awesome
- **Gradient accents** for visual appeal

## 🔐 Security & Privacy

- Privacy notice on all pages
- Role-based access control
- Teacher verification workflow
- Secure document upload (UI ready for backend integration)

## 🚧 Future Enhancements

- Backend API integration (Node.js/Express)
- Database integration (MySQL)
- Real-time chat/messaging
- Payment processing (PayPal/GCash)
- Video session integration (WebRTC)
- Email notifications
- Advanced AI matching algorithms
- Mobile app (React Native)

## 📝 Notes

- This is a frontend-only implementation for the hackathon
- All forms are ready for backend integration
- AI features are UI placeholders (ready for API integration)
- Calendar widgets are static (ready for full calendar library)
- Charts are placeholders (ready for Chart.js integration)

## 👥 Team

This project was created for the AI Agent Hackathon.

## 📄 License

This project is created for hackathon purposes.

---

**Built with ❤️ for children with autism and their families**
