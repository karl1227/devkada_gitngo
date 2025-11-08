# Seed Data Instructions

## Quick Import

1. **Option 1: Use the provided seed.sql file**
   - Open phpMyAdmin
   - Select your database: `devkada_gitngo`
   - Go to the SQL tab
   - Copy and paste the contents of `seed.sql`
   - Click "Go"

2. **Option 2: Generate a fresh seed file with proper password hash**
   - Run: `php database/generate_seed.php`
   - This will generate a new `seed.sql` file with a valid password hash
   - Then import the generated file

## Password Hash Issue

If you get an error about the password hash, you need to generate a new one:

1. Create a PHP file (e.g., `hash.php`) with:
   ```php
   <?php
   echo password_hash('password123', PASSWORD_DEFAULT);
   ```

2. Run it: `php hash.php`

3. Copy the generated hash and replace all instances in `seed.sql`

## Login Credentials

All users have the same password: **password123**

- **Admin**: admin@learnsafe.ai / password123
- **Parents**: 
  - sarah.martinez@email.com / password123
  - michael.chen@email.com / password123
  - jennifer.williams@email.com / password123
  - david.johnson@email.com / password123
  - maria.garcia@email.com / password123
- **Teachers**:
  - emily.johnson@email.com / password123
  - david.chen@email.com / password123
  - sarah.williams@email.com / password123
  - jennifer.lopez@email.com / password123
  - robert.smith@email.com / password123
  - lisa.anderson@email.com / password123
  - james.brown@email.com / password123
  - patricia.davis@email.com / password123

## Troubleshooting

If you get a "Duplicate entry" error:
- The seed file now uses `INSERT IGNORE` which will skip duplicates
- If you want to start fresh, uncomment the TRUNCATE statements at the top of seed.sql

If you get a "Password hash" error:
- The password hash might be invalid
- Use the `generate_seed.php` script to create a new file with a valid hash

If you get a "Database doesn't exist" error:
- Make sure the database `devkada_gitngo` exists
- Or change the `USE devkada_gitngo;` line to your database name

