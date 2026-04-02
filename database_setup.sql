-- E-Voting System Sample Database
-- Run this script in phpMyAdmin or MySQL CLI to set up demo data

CREATE DATABASE IF NOT EXISTS e_voting;
USE e_voting;

-- ============================================
-- Students Table (Voters)
-- ============================================
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nid VARCHAR(20) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample voter data (for testing)
INSERT INTO students (nid, phone, name, email) VALUES
('12345678', '+254700000001', 'John Doe', 'john@university.edu'),
('23456789', '+254700000002', 'Jane Smith', 'jane@university.edu'),
('34567890', '+254700000003', 'Michael Johnson', 'michael@university.edu'),
('45678901', '+254700000004', 'Emily Brown', 'emily@university.edu'),
('56789012', '+254700000005', 'David Wilson', 'david@university.edu'),
('67890123', '+254700000006', 'Sarah Davis', 'sarah@university.edu'),
('78901234', '+254700000007', 'Robert Miller', 'robert@university.edu'),
('89012345', '+254700000008', 'Lisa Taylor', 'lisa@university.edu'),
('90123456', '+254700000009', 'James Anderson', 'james@university.edu'),
('01234567', '+254700000010', 'Mary Thomas', 'mary@university.edu');

-- ============================================
-- Votes Table (Vote Recording)
-- ============================================
CREATE TABLE IF NOT EXISTS votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    nid VARCHAR(20) NOT NULL,
    president VARCHAR(100),
    vice_president VARCHAR(100),
    secretary VARCHAR(100),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id),
    UNIQUE KEY unique_voter (student_id)
);

-- ============================================
-- Candidates Table (Election Options)
-- ============================================
CREATE TABLE IF NOT EXISTS candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    position VARCHAR(50),
    name VARCHAR(100),
    party VARCHAR(100),
    bio TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample candidates
INSERT INTO candidates (position, name, party, bio, image) VALUES
-- President
('President', 'Sarah Johnson', 'Progressive Alliance', 'Experienced leader with 15 years in community development', 'images/sarah.jpeg'),
('President', 'Michael Chien', 'Unity Party', 'Innovative thinker focused on sustainable growth', 'images/michael.jpeg'),
('President', 'Emily Rodriguez', 'Democratic Front', 'Advocate for education and youth programs', 'images/emily.jpeg'),

-- Vice President
('Vice President', 'David Okonkwo', 'Progressive Alliance', 'Strong communicator and talented organizer', 'images/david.jpeg'),
('Vice President', 'Lisa Chen', 'Unity Party', 'Financial expert with passion for transparency', 'images/lisa.jpeg'),
('Vice President', 'James Patterson', 'Democratic Front', 'Dedicated to environmental and social justice', 'images/james.jpeg'),

-- Secretary
('Secretary', 'Amanda Foster', 'Progressive Alliance', 'Detail-oriented professional with 8 years experience', 'images/amanda.jpeg'),
('Secretary', 'Marcus Webb', 'Unity Party', 'Excellent writer and public speaker', 'images/marcus.jpeg'),
('Secretary', 'Sophia Reyes', 'Democratic Front', 'Multilingual with strong administrative skills', 'images/sophia.jpeg');

-- ============================================
-- Results View (for displaying election results)
-- ============================================
CREATE VIEW election_results AS
SELECT 
    'President' as position,
    president as candidate,
    COUNT(*) as vote_count
FROM votes
WHERE president IS NOT NULL
GROUP BY president
UNION ALL
SELECT 
    'Vice President' as position,
    vice_president as candidate,
    COUNT(*) as vote_count
FROM votes
WHERE vice_president IS NOT NULL
GROUP BY vice_president
UNION ALL
SELECT 
    'Secretary' as position,
    secretary as candidate,
    COUNT(*) as vote_count
FROM votes
WHERE secretary IS NOT NULL
GROUP BY secretary
ORDER BY position, vote_count DESC;
