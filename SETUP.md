# LearnSafe.AI - Setup Instructions

## Database Setup

1. **Create the database:**
   - Open phpMyAdmin or MySQL command line
   - Import the file: `database/schema.sql`
   - This will create the database `learnsafe_ai` with all necessary tables

2. **Configure database connection:**
   - Edit `config/database.php` if needed
   - Default settings:
     - Host: localhost
     - User: root
     - Password: (empty)
     - Database: learnsafe_ai

## File Structure

```
devkada_gitngo/
├── api/              # API endpoints
│   ├── login.php
│   └── register.php
├── config/           # Configuration files
│   ├── config.php
│   └── database.php
├── database/         # Database schema
│   └── schema.sql
├── includes/         # PHP includes
│   └── auth.php
├── uploads/          # File uploads directory
│   └── licenses/     # Teacher license uploads
├── parent/           # Parent dashboard pages
├── teacher/          # Teacher dashboard pages
├── admin/            # Admin dashboard pages
└── index.php, signin.php, signup.php
```

## Default Admin Account

- Email: admin@learnsafe.ai
- Password: admin123

**IMPORTANT:** Change this password in production!

## Features Implemented

### Authentication
- ✅ User login (Parent/Teacher)
- ✅ User registration (Parent/Teacher)
- ✅ Session management
- ✅ Password hashing
- ✅ Role-based access control

### Database
- ✅ Complete database schema
- ✅ All necessary tables created
- ✅ Foreign key relationships
- ✅ Indexes for performance

### API Endpoints
- ✅ `/api/login.php` - User authentication
- ✅ `/api/register.php` - User registration

## Next Steps

The following functionality needs to be implemented in the dashboard pages:
- Dashboard data loading
- Find teacher functionality
- Book session functionality
- Profile management
- Progress tracking
- Admin verification system
- And more...

## Notes

- Make sure the `uploads/licenses/` directory has write permissions
- All passwords are hashed using PHP's `password_hash()` function
- Session management is handled in `config/config.php`

