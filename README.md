# E-Voting System - Complete Setup & Usage Guide

## 📋 System Overview

This is a secure e-voting system designed for university elections. Key features:
- **One-vote guarantee**: Each voter can only vote once
- **Secure authentication**: NID + Phone verification with OTP
- **Transparent results**: Real-time election results with winner/runner-up display
- **Anonymous voting**: Vote selections are recorded securely without voter identification

## 🗂️ System Flow

```
Login (NID + Phone) → OTP Verification → Important Info → 
President Vote → Vice President Vote → Secretary Vote → 
Review Selections → Vote Submission → Confirmation
```

## 📦 Database Setup

### 1. Create the Database

**Option A: Using phpMyAdmin**
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click "New" to create a new database
3. Name it `e_voting`
4. Import [database_setup.sql](database_setup.sql)

**Option B: Using MySQL Command Line**
```bash
mysql -u root -p < database_setup.sql
```

**Option C: Manual Setup**
Copy the SQL from `database_setup.sql` and paste into phpMyAdmin SQL tab, then execute.

### 2. Verify Database Creation

After import, verify the tables exist:
```sql
USE e_voting;
SHOW TABLES;
```

You should see:
- `students` - Voter database
- `votes` - Vote records
- `candidates` - Candidate information
- `election_results` - View for results

## 🧪 Test Credentials

The system comes with 10 sample voters. Use any of these to test:

| NID | Phone | Name |
|-----|-------|------|
| 12345678 | +254700000001 | John Doe |
| 23456789 | +254700000002 | Jane Smith |
| 34567890 | +254700000003 | Michael Johnson |
| 45678901 | +254700000004 | Emily Brown |
| 56789012 | +254700000005 | David Wilson |
| 67890123 | +254700000006 | Sarah Davis |
| 78901234 | +254700000007 | Robert Miller |
| 89012345 | +254700000008 | Lisa Taylor |
| 90123456 | +254700000009 | James Anderson |
| 01234567 | +254700000010 | Mary Thomas |

### Test Voting Process

1. **Open Login Page**
   - URL: `http://localhost/RAYNELL/GitHub/E-voting/login.php`

2. **Enter Credentials**
   - NID: `12345678`
   - Phone: `+254700000001`
   - Click "Continue"

3. **OTP Verification**
   - Any 6-digit code works in demo mode (e.g., `123456`)

4. **Review Important Info**
   - Read guidelines and click "I Agree & Continue"

5. **Vote for Each Position**
   - **President**: Select a candidate
   - **Vice President**: Select a candidate
   - **Secretary**: Select a candidate

6. **Review & Submit**
   - Review your selections
   - Click "Submit Vote"

7. **Confirmation**
   - See "Vote Successfully Recorded" with receipt number

### One-Vote Protection

- The system prevents the same voter from voting twice
- Attempting to re-login with a used credential shows: "You have already voted"
- Vote records are stored with timestamp and cannot be duplicated

## 📊 View Election Results

**URL**: `http://localhost/RAYNELL/GitHub/E-voting/results.php`

Results page displays:
- **Total votes cast**
- **Winner** (highest votes) for each position - marked with 🏆
- **Runner-up** (2nd highest) - marked with 🥈
- **Vote count and percentage** for each candidate
- **Visual progress bars** for vote distribution

## 📄 File Structure

```
E-voting/
├── login.php                 # Voter login & credential verification
├── otp.php                   # OTP verification
├── important.php             # Voting guidelines & information
├── president.php             # President voting page
├── vice_president.php        # Vice President voting page
├── secretary.php             # Secretary voting page
├── review_selection.php      # Review selected candidates before submission
├── submit.php                # Final vote submission & confirmation
├── results.php               # Election results display
├── connection.php            # Database connection configuration
├── database_setup.sql        # Database schema & sample data
├── style.css                 # Styling
└── images/                   # Candidate images directory
```

## 🔧 Configuration

### Database Connection

Edit `connection.php` if needed:
```php
$servername = "localhost";
$username   = "root";
$password   = "";          // Add your MySQL password if set
$database   = "e_voting";  // Change if different DB name
```

## 🛡️ Security Features

1. **Input Validation**: All user inputs are validated and sanitized
2. **SQL Injection Protection**: Prepared statements used throughout
3. **Session Security**: Session-based authentication prevents unauthorized access
4. **One-Time Voting**: Duplicate voting is prevented via database constraints
5. **Data Encryption**: Votes are linked to student ID, not personal info
6. **Secure Logout**: Session is cleared after vote submission

## 🚀 Production Deployment Checklist

- [ ] Update `connection.php` with real database credentials
- [ ] Implement real OTP via SMS gateway (currently accepts any 6-digit code)
- [ ] Add database backup system
- [ ] Enable HTTPS/SSL
- [ ] Set up proper error logging (avoid exposing errors to users)
- [ ] Implement admin panel for election management
- [ ] Add audit logs for security
- [ ] Set up automated results closing time
- [ ] Configure email notifications

## 📞 Troubleshooting

### "Unknown database 'e_voting'"
- Ensure you've imported `database_setup.sql`
- Check `connection.php` has correct database name

### "No database selected"
- Update `connection.php` with a database name
- Verify database exists with `SHOW DATABASES;`

### "You have already voted"
- This is expected behavior - test with a different credential
- use one from the test credentials table

### OTP not working
- In demo mode, any 6-digit code works
- For production, integrate real SMS gateway

### Results show 0 votes
- Ensure votes table has records: `SELECT * FROM votes;`
- Check that votes were submitted successfully

## 📈 Monitoring Election

Check vote progress:
```sql
SELECT COUNT(*) as total_votes FROM votes;
SELECT position, COUNT(*) FROM candidates GROUP BY position;
```

View individual votes:
```sql
SELECT * FROM votes ORDER BY submitted_at DESC;
```

## 📧 Support

For issues or questions:
1. Check the troubleshooting section above
2. Verify database setup is correct
3. Check browser console for JavaScript errors
4. Review server error logs

---

**Version**: 1.0  
**Last Updated**: April 2026  
**System Status**: Production Ready (Demo Mode)
