-- =============================================
--  MediAlert — Smart Health Emergency System
--  medialert_db.sql
--  Run in phpMyAdmin: Import this file
--  OR in MySQL CLI:   source medialert_db.sql
-- =============================================

CREATE DATABASE IF NOT EXISTS medialert_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE medialert_db;

-- ─────────────────────────────────────────────
--  TABLE: users
-- ─────────────────────────────────────────────
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name  VARCHAR(100) DEFAULT '',
  email      VARCHAR(191) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  role       ENUM('admin','responder','hospital_staff','public') DEFAULT 'public',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Default admin  →  password: Admin@1234
INSERT INTO users (first_name, last_name, email, password, role) VALUES
('Admin',    'User',      'admin@medialert.in',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Rajesh',   'Kumar',     'rajesh@medialert.in',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'responder'),
('Priya',    'Sharma',    'priya@medialert.in',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hospital_staff'),
('Suresh',   'Nair',      'suresh@medialert.in',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'responder'),
('Anitha',   'Gowda',     'anitha@medialert.in',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'public');
-- All test users share password: Admin@1234

-- ─────────────────────────────────────────────
--  TABLE: incidents
-- ─────────────────────────────────────────────
DROP TABLE IF EXISTS incidents;
CREATE TABLE incidents (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  reporter_name    VARCHAR(150) NOT NULL,
  reporter_phone   VARCHAR(15)  NOT NULL,
  reporter_email   VARCHAR(191) DEFAULT '',
  type             VARCHAR(100) NOT NULL,
  severity         ENUM('critical','high','medium','low') NOT NULL,
  location         TEXT NOT NULL,
  latitude         DECIMAL(10,7) DEFAULT NULL,
  longitude        DECIMAL(10,7) DEFAULT NULL,
  victims_count    INT DEFAULT 1,
  description      TEXT NOT NULL,
  status           ENUM('pending','active','resolved') DEFAULT 'pending',
  assigned_unit    VARCHAR(100) DEFAULT NULL,
  reported_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
  resolved_at      DATETIME DEFAULT NULL
);

-- 20 sample incidents
INSERT INTO incidents
  (reporter_name, reporter_phone, reporter_email, type, severity, location, latitude, longitude, victims_count, description, status, assigned_unit, reported_at, resolved_at)
VALUES
('Ramesh Kumar',   '9876543210', 'ramesh@gmail.com',  'Cardiac Arrest',  'critical', 'Tumkur City Hospital, B.H. Road',          13.3379, 77.1173, 1, 'Patient collapsed in hospital corridor. No pulse. CPR in progress.',               'active',   'Unit A-3', NOW() - INTERVAL 25 MINUTE,  NULL),
('Sunita Murthy',  '9845012345', 'sunita@gmail.com',  'Road Accident',   'high',     'NH 48, Near Km Marker 43, Tumkur',         13.3150, 77.0800, 3, 'Three-vehicle collision. Two passengers unconscious, one with head injury.',        'active',   'Unit B-1', NOW() - INTERVAL 55 MINUTE,  NULL),
('Pradeep Verma',  '9731234567', '',                  'Fire Injury',     'medium',   'Sira Road, Behind Bus Stand, Tumkur',      13.3410, 77.0920, 1, 'Burn injuries on hands and arms from kitchen fire. Victim is stable.',             'resolved', 'Unit C-2', NOW() - INTERVAL 2 HOUR,    NOW() - INTERVAL 90 MINUTE),
('Kavitha Reddy',  '9980001234', 'kavitha@gmail.com', 'Stroke',          'critical', 'Gubbi Town, Near Old Market',              13.3112, 76.9426, 1, 'Elderly woman, sudden speech loss and facial drooping. Suspected stroke.',          'active',   'Unit A-1', NOW() - INTERVAL 110 MINUTE, NULL),
('Mahesh Tiwari',  '9632587410', '',                  'Minor Injury',    'low',      'Madhugiri Main Road, Tumkur District',     13.6631, 77.2164, 1, 'Fall from bicycle. Minor abrasions on knee and elbow. No fracture suspected.',     'resolved', 'Unit D-4', NOW() - INTERVAL 4 HOUR,    NOW() - INTERVAL 3 HOUR),
('Nandini Iyer',   '9741230987', 'nandini@gmail.com', 'Poisoning',       'high',     'Koratagere Bus Stand, Tumkur District',    13.5218, 77.2362, 1, 'Young man suspected food poisoning after street food. Vomiting and dizziness.',    'pending',  NULL,       NOW() - INTERVAL 15 MINUTE,  NULL),
('Venkat Rao',     '9886541230', '',                  'Road Accident',   'critical', 'Tiptur Road, NH 206, Near Checkpost',      13.2640, 76.8160, 2, 'Truck vs motorcycle collision. Motorcyclist with severe head trauma.',              'active',   'Unit B-2', NOW() - INTERVAL 3 HOUR,    NULL),
('Lakshmi Devi',   '9900112233', 'lakshmi@gmail.com', 'Childbirth',      'high',     'Pavagada, Tumkur District',                14.0970, 77.2779, 1, 'Pregnant woman in labour, 38 weeks. Road blocked, cannot reach hospital.',         'resolved', 'Unit E-1', NOW() - INTERVAL 5 HOUR,    NOW() - INTERVAL 4 HOUR),
('Girish Patil',   '9845678901', '',                  'Cardiac Arrest',  'critical', 'Tumkur Railway Station, Platform 2',       13.3420, 77.1090, 1, 'Middle-aged man collapsed on platform. Bystanders performing CPR.',                'resolved', 'Unit A-2', NOW() - INTERVAL 6 HOUR,    NOW() - INTERVAL 5 HOUR),
('Meena Kumari',   '9712345678', 'meena@gmail.com',   'Drowning',        'critical', 'Devarayanadurga Lake, Tumkur',             13.3720, 77.0100, 1, 'Child fell into lake. Bystanders attempted rescue. Child unconscious.',            'resolved', 'Unit F-1', NOW() - INTERVAL 7 HOUR,    NOW() - INTERVAL 6 HOUR),
('Ravi Shankar',   '9845001122', '',                  'Fire Injury',     'high',     'Industrial Area, Vasanthanarasapura',      13.3200, 77.2700, 4, 'Chemical fire at factory. Four workers with burn injuries. Factory evacuated.',    'resolved', 'Unit C-1', NOW() - INTERVAL 8 HOUR,    NOW() - INTERVAL 7 HOUR),
('Deepa Nair',     '9741002233', 'deepa@gmail.com',   'Stroke',          'high',     'Sira Town, Near Govt Hospital',            13.7426, 76.9071, 1, 'Elderly man with sudden severe headache and confusion. Cannot move right arm.',     'active',   'Unit A-4', NOW() - INTERVAL 40 MINUTE,  NULL),
('Santosh Hegde',  '9886003344', '',                  'Road Accident',   'medium',   'Kunigal Road, Near Toll Plaza',            13.0240, 77.0210, 2, 'Car skidded off road. Driver and passenger with minor to moderate injuries.',       'resolved', 'Unit D-2', NOW() - INTERVAL 9 HOUR,    NOW() - INTERVAL 8 HOUR),
('Ananya Singh',   '9900234567', 'ananya@gmail.com',  'Poisoning',       'critical', 'Turuvekere Town, Tumkur District',         13.1640, 76.6660, 1, 'Suspected pesticide poisoning. Farmer found unconscious in field.',                 'resolved', 'Unit B-3', NOW() - INTERVAL 10 HOUR,   NOW() - INTERVAL 9 HOUR),
('Kiran Kumar',    '9632001122', '',                  'Minor Injury',    'low',      'Chikkanayakanahalli, Tumkur',              13.4430, 76.5550, 1, 'Construction worker fell from scaffold (2 feet). Ankle sprain, no fracture.',      'resolved', 'Unit D-3', NOW() - INTERVAL 11 HOUR,   NOW() - INTERVAL 10 HOUR),
('Bhavana Rao',    '9741567890', 'bhavana@gmail.com', 'Cardiac Arrest',  'critical', 'Tumkur Medical College Campus',            13.3460, 77.1230, 1, 'Medical student found unresponsive in hostel room. No heartbeat detected.',        'resolved', 'Unit A-5', NOW() - INTERVAL 12 HOUR,   NOW() - INTERVAL 11 HOUR),
('Mohan Das',      '9845901234', '',                  'Road Accident',   'high',     'Bangalore-Tumkur Expressway, Km 68',       13.2100, 77.2000, 5, 'Bus accident. Driver lost control. Multiple passengers injured.',                   'resolved', 'Unit B-4', NOW() - INTERVAL 13 HOUR,   NOW() - INTERVAL 11 HOUR),
('Savitha Gowda',  '9900345678', 'savitha@gmail.com', 'Minor Injury',    'low',      'Madhugiri Fort Trail',                     13.6670, 77.2110, 1, 'Tourist slipped on trail. Knee laceration, needs stitches.',                       'resolved', 'Unit D-5', NOW() - INTERVAL 14 HOUR,   NOW() - INTERVAL 13 HOUR),
('Prakash Naidu',  '9712890123', '',                  'Fire Injury',     'medium',   'Tumkur Old Town Market',                   13.3390, 77.1050, 2, 'Shop fire in market. Two vendors with minor burns. Fire brigade on the way.',       'resolved', 'Unit C-3', NOW() - INTERVAL 15 HOUR,   NOW() - INTERVAL 14 HOUR),
('Rekha Pillai',   '9886789012', 'rekha@gmail.com',   'Childbirth',      'medium',   'Tumkur-Bangalore Highway, Near Nelamangala', 13.0980, 77.3920, 1, 'Woman in labour, water broke in vehicle. Husband requesting emergency assistance.', 'resolved', 'Unit E-2', NOW() - INTERVAL 16 HOUR,   NOW() - INTERVAL 15 HOUR);

-- ─────────────────────────────────────────────
--  TABLE: hospitals
-- ─────────────────────────────────────────────
DROP TABLE IF EXISTS hospitals;
CREATE TABLE hospitals (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  name           VARCHAR(200) NOT NULL,
  address        TEXT,
  latitude       DECIMAL(10,7),
  longitude      DECIMAL(10,7),
  phone          VARCHAR(20),
  total_beds     INT DEFAULT 0,
  available_beds INT DEFAULT 0,
  icu_beds       INT DEFAULT 0,
  icu_available  INT DEFAULT 0,
  blood_bank     TINYINT(1) DEFAULT 0,
  updated_at     DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO hospitals (name, address, latitude, longitude, phone, total_beds, available_beds, icu_beds, icu_available, blood_bank) VALUES
('Tumkur District Government Hospital', 'B.H. Road, Tumkur 572101',           13.3379, 77.1173, '0816-2272650', 300, 42, 20, 5, 1),
('Siddaganga Hospital & Research Centre','Siddaganga, Tumkur',                 13.3400, 77.1020, '0816-2277100', 200, 28, 15, 3, 1),
('Gubbi Government Hospital',           'Gubbi Town, Tumkur District',         13.3112, 76.9426, '08131-223456',  80, 14,  5, 1, 0),
('Sira Government Hospital',            'Sira Town, Tumkur District',          13.7426, 76.9071, '08135-272200', 100, 19,  8, 2, 0),
('Madhugiri Government Hospital',       'Madhugiri, Tumkur District',          13.6631, 77.2164, '08136-251234',  60, 10,  4, 1, 0),
('Pavagada Rural Hospital',             'Pavagada, Tumkur District',           14.0970, 77.2779, '08136-265100',  40,  8,  2, 0, 0),
('Tiptur Government Hospital',          'Tiptur, Tumkur District',             13.2640, 76.8160, '08134-252500',  80, 11,  6, 2, 0),
('Kunigal Taluk Hospital',              'Kunigal, Tumkur District',            13.0240, 77.0210, '08132-234100',  60,  7,  4, 1, 0);

-- ─────────────────────────────────────────────
--  TABLE: contact_messages
-- ─────────────────────────────────────────────
DROP TABLE IF EXISTS contact_messages;
CREATE TABLE contact_messages (
  id      INT AUTO_INCREMENT PRIMARY KEY,
  name    VARCHAR(150) NOT NULL,
  email   VARCHAR(191) NOT NULL,
  subject VARCHAR(255) DEFAULT '',
  message TEXT NOT NULL,
  sent_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sample messages
INSERT INTO contact_messages (name, email, subject, message) VALUES
('Ravi Shankar',  'ravi@gmail.com',  'Technical Support', 'The dashboard is not loading on mobile. Please fix.'),
('Meena Pillai',  'meena@gmail.com', 'General Enquiry',   'How do I register our hospital to the MediAlert network?'),
('Dr. Anand',     'anand@hosp.in',   'Partnership',       'We would like to integrate MediAlert into our hospital management system.');

-- ─────────────────────────────────────────────
--  INDEXES for performance
-- ─────────────────────────────────────────────
CREATE INDEX idx_incidents_status   ON incidents(status);
CREATE INDEX idx_incidents_severity ON incidents(severity);
CREATE INDEX idx_incidents_date     ON incidents(reported_at);

-- ─────────────────────────────────────────────
--  Quick check — run after import
-- ─────────────────────────────────────────────
SELECT 'users'           AS tbl, COUNT(*) AS total FROM users
UNION ALL
SELECT 'incidents',               COUNT(*)          FROM incidents
UNION ALL
SELECT 'hospitals',               COUNT(*)          FROM hospitals
UNION ALL
SELECT 'contact_messages',        COUNT(*)          FROM contact_messages;
