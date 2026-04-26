<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediAlert — Smart Health Emergency System</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ALERT BANNER -->
<div class="alert-banner">
  <span class="pulse"></span>
  <strong>ACTIVE ALERT:</strong> Mass casualty incident reported — Tumkur City Hospital — 3 units dispatched
</div>

<!-- NAVBAR -->
<nav>
  <div class="nav-inner">
    <div class="logo" onclick="showPage('home')">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
      </div>
      <span class="logo-text">Medi<span>Alert</span></span>
    </div>
    <div class="nav-links">
      <a onclick="showPage('home')"      id="nav-home"      class="active">Home</a>
      <a onclick="showPage('about')"     id="nav-about">About</a>
      <a onclick="showPage('dashboard')" id="nav-dashboard">Dashboard <span class="badge-live"><span class="pulse"></span>LIVE</span></a>
      <a onclick="showPage('report')"    id="nav-report" class="btn-alert">&#x1F6A8; Report Emergency</a>
      <a onclick="showPage('login')"     id="nav-login">Login</a>
      <a onclick="showPage('contact')"   id="nav-contact">Contact</a>
    </div>
  </div>
</nav>

<!-- ══ HOME ══ -->
<div class="page active" id="page-home">
  <div class="hero">
    <div class="hero-content">
      <div class="hero-tag"><span class="pulse"></span> System Online — Monitoring Active</div>
      <h1>Smart<em>Fastest</em><br>Health Emergency Network</h1>
      <p>Real-time incident reporting, live dispatch coordination, and hospital bed tracking — protecting communities across Karnataka 24/7.</p>
      <div class="hero-btns">
        <button class="btn btn-primary"   onclick="showPage('report')">&#x1F6A8; Report Emergency</button>
        <button class="btn btn-secondary" onclick="showPage('dashboard')">View Live Dashboard</button>
      </div>
      <div class="hero-stats">
        <div class="hero-stat"><div class="num">2,847</div><div class="label">Incidents Resolved</div></div>
        <div class="hero-stat"><div class="num">18</div><div class="label">Avg. Response (min)</div></div>
        <div class="hero-stat"><div class="num">142</div><div class="label">Hospitals Connected</div></div>
        <div class="hero-stat"><div class="num">24/7</div><div class="label">Active Monitoring</div></div>
      </div>
    </div>
  </div>
  <div class="section">
    <div class="section-title">What We Do</div>
    <div class="section-sub">A complete emergency health management platform for rapid response</div>
    <div class="grid-3">
      <div class="card"><div class="card-icon icon-red">&#x1F6A8;</div><h3>Emergency Reporting</h3><p>Citizens report incidents instantly. Each report is triaged, logged to the database, and dispatched to the nearest unit.</p></div>
      <div class="card"><div class="card-icon icon-teal">&#x1F4CA;</div><h3>Live Dashboard</h3><p>Real-time incident feed, severity filters, and response status — all pulled live from MySQL.</p></div>
      <div class="card"><div class="card-icon icon-amber">&#x1F3E5;</div><h3>Hospital Network</h3><p>Live bed availability and ICU status across 142 hospitals in Karnataka, updated every 60 seconds.</p></div>
      <div class="card"><div class="card-icon icon-red">&#x1F4CD;</div><h3>Location Tracking</h3><p>GPS-tagged incidents plotted on interactive maps. Nearest responders automatically identified and routed.</p></div>
      <div class="card"><div class="card-icon icon-teal">&#x1F510;</div><h3>Secure Access</h3><p>Role-based login system with PHP sessions. Admins, responders, and public users each see tailored views.</p></div>
      <div class="card"><div class="card-icon icon-amber">&#x1F4F1;</div><h3>Instant Alerts</h3><p>Notifications on critical incidents with automatic escalation if no response is logged within 10 minutes.</p></div>
    </div>
  </div>
</div>

<!-- ══ ABOUT ══ -->
<div class="page" id="page-about">
  <div class="about-hero">
    <h1>About MediAlert</h1>
    <p>A student-built health emergency platform designed for Karnataka, powered by PHP, MySQL, and real community data.</p>
  </div>
  <div class="section">
    <div class="contact-grid">
      <div>
        <div class="section-title">Our Mission</div>
        <p class="body-text">MediAlert bridges the critical gap between emergency incidents and health response teams. In rural Karnataka, delayed responses cost lives — our system aims to cut response time by 40% through real-time communication.</p>
        <p class="body-text top-gap">Built as a final year project using PHP, MySQL, HTML/CSS/JS, and deployed on a live server for real-world testing.</p>
        <div class="section-title timeline-title">System Timeline</div>
        <div class="timeline">
          <div class="tl-item"><div class="tl-dot"></div><h4>Phase 1 — UI Design</h4><p>All pages designed in HTML/CSS with full responsive layout and navigation.</p></div>
          <div class="tl-item"><div class="tl-dot"></div><h4>Phase 2 — JS Validation</h4><p>Client-side form validation, live dashboard filters, and interactive components.</p></div>
          <div class="tl-item"><div class="tl-dot"></div><h4>Phase 3 — PHP Backend</h4><p>Form handlers, session management, and server-side logic built in PHP 8.</p></div>
          <div class="tl-item"><div class="tl-dot"></div><h4>Phase 4 — MySQL Integration</h4><p>Incident table, users table, hospitals table. Full CRUD operations wired up.</p></div>
          <div class="tl-item"><div class="tl-dot"></div><h4>Phase 5 — Deployment</h4><p>Hosted on cPanel/InfinityFree with GitHub version control.</p></div>
        </div>
      </div>
      <div>
        <div class="section-title">Tech Stack</div>
        <div class="stack-list">
          <div class="card stack-card"><span class="stack-emoji">&#x1F310;</span><div><strong>Frontend</strong><p>HTML5, CSS3, Vanilla JavaScript</p></div></div>
          <div class="card stack-card"><span class="stack-emoji">&#x2699;&#xFE0F;</span><div><strong>Backend</strong><p>PHP 8.x with session handling &amp; PDO</p></div></div>
          <div class="card stack-card"><span class="stack-emoji">&#x1F5C4;&#xFE0F;</span><div><strong>Database</strong><p>MySQL — incidents, users, hospitals tables</p></div></div>
          <div class="card stack-card"><span class="stack-emoji">&#x1F680;</span><div><strong>Deployment</strong><p>GitHub + InfinityFree / cPanel hosting</p></div></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══ DASHBOARD ══ -->
<div class="page" id="page-dashboard">
  <div class="dash-header">
    <div class="dash-header-inner">
      <div>
        <h2>Live Alert Dashboard</h2>
        <p>All data fetched live from MySQL · Auto-refreshes every 30s</p>
      </div>
      <span class="badge-live large"><span class="pulse"></span>LIVE MONITORING</span>
    </div>
  </div>
  <div class="section" style="padding-top:36px">
    <div class="grid-4" style="margin-bottom:32px">
      <div class="stat-card"><div class="stat-num red" id="stat-active">—</div><div class="stat-label">Active Incidents</div></div>
      <div class="stat-card"><div class="stat-num" id="stat-total">—</div><div class="stat-label">Total Today</div></div>
      <div class="stat-card"><div class="stat-num teal" id="stat-resolved">—</div><div class="stat-label">Resolved Today</div></div>
      <div class="stat-card"><div class="stat-num" id="stat-avg">—<span class="min-label">min</span></div><div class="stat-label">Avg Response Time</div></div>
    </div>
    <div class="filter-bar">
      <button class="filter-btn active" onclick="filterTable('all',this)">All</button>
      <button class="filter-btn" onclick="filterTable('active',this)">Active</button>
      <button class="filter-btn" onclick="filterTable('critical',this)">Critical</button>
      <button class="filter-btn" onclick="filterTable('resolved',this)">Resolved</button>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>ID</th><th>Time</th><th>Type</th><th>Location</th><th>Severity</th><th>Status</th><th>Responder</th></tr></thead>
        <tbody id="tableBody">
          <tr><td colspan="7" class="loading-cell">Loading incidents from database...</td></tr>
        </tbody>
      </table>
    </div>
    <div class="map-section">
      <div class="map-label">&#x1F4CD; Incident Map — Tumkur District</div>
      <div class="map-placeholder">
        <p style="font-size:28px">&#x1F5FA;&#xFE0F;</p>
        <p>Leaflet.js / Google Maps integration</p>
        <p class="map-sub">Add lat/lng to incidents table to render live pins</p>
      </div>
    </div>
  </div>
</div>

<!-- ══ REPORT ══ -->
<div class="page" id="page-report">
  <div class="form-page">
    <div class="form-page-header">
      <div class="form-icon">&#x1F6A8;</div>
      <h2>Report an Emergency</h2>
      <p>Fill in all required fields. This report is sent to our response team immediately via PHP/MySQL.</p>
    </div>
    <div class="success-banner" id="successBanner">
      <h3>&#x2705; Emergency Reported!</h3>
      <p>Your report #<strong id="reportId"></strong> has been submitted. A response team has been notified. Expected arrival: <strong>15-20 minutes</strong>.</p>
    </div>
    <div class="form-card" id="reportForm">
      <div class="field-row">
        <div class="field"><label>Full Name <span class="req">*</span></label><input type="text" id="r-name" placeholder="e.g. Rahul Kumar"><div class="err-msg" id="err-name">Please enter your full name</div></div>
        <div class="field"><label>Phone Number <span class="req">*</span></label><input type="tel" id="r-phone" placeholder="e.g. 9876543210"><div class="err-msg" id="err-phone">Enter a valid 10-digit number</div></div>
      </div>
      <div class="field-row">
        <div class="field">
          <label>Emergency Type <span class="req">*</span></label>
          <select id="r-type">
            <option value="">Select type...</option>
            <option value="Cardiac Arrest">Cardiac Arrest</option>
            <option value="Road Accident">Road Accident</option>
            <option value="Fire Injury">Fire Injury</option>
            <option value="Stroke">Stroke</option>
            <option value="Poisoning">Poisoning</option>
            <option value="Childbirth">Childbirth</option>
            <option value="Drowning">Drowning</option>
            <option value="Other">Other</option>
          </select>
          <div class="err-msg" id="err-type">Please select an emergency type</div>
        </div>
        <div class="field">
          <label>Severity Level <span class="req">*</span></label>
          <select id="r-severity">
            <option value="">Select severity...</option>
            <option value="critical">Critical — Life threatening</option>
            <option value="high">High — Urgent care needed</option>
            <option value="medium">Medium — Stable but serious</option>
            <option value="low">Low — Minor emergency</option>
          </select>
          <div class="err-msg" id="err-severity">Please select a severity level</div>
        </div>
      </div>
      <div class="field"><label>Location / Address <span class="req">*</span></label><input type="text" id="r-location" placeholder="e.g. Near Tumkur Bus Stand, Tumkur 572101"><div class="err-msg" id="err-location">Please provide a location</div></div>
      <div class="field-row">
        <div class="field"><label>Number of Victims</label><input type="number" id="r-victims" placeholder="e.g. 2" min="1" value="1"></div>
        <div class="field"><label>Email (optional)</label><input type="email" id="r-email" placeholder="for status updates"></div>
      </div>
      <div class="field"><label>Describe the Emergency <span class="req">*</span></label><textarea id="r-desc" placeholder="Describe what happened, condition of victim(s), any specific medical needs..."></textarea><div class="err-msg" id="err-desc">Please describe the emergency (min 20 chars)</div></div>
      <div class="location-hint">&#x1F4CD; Location will be auto-captured from your browser if you allow permission, or enter manually above.</div>
      <button class="submit-btn" onclick="submitReport()">&#x1F6A8; Submit Emergency Report</button>
    </div>
  </div>
</div>

<!-- ══ LOGIN ══ -->
<div class="page" id="page-login">
  <div class="auth-page">
    <div class="auth-header">
      <div style="font-size:40px;margin-bottom:12px">&#x1F510;</div>
      <div class="section-title">Secure Portal Access</div>
      <p class="auth-sub">Admins, responders and staff login here</p>
    </div>
    <div class="auth-tabs">
      <button class="auth-tab active" onclick="switchTab('login',this)">Login</button>
      <button class="auth-tab"        onclick="switchTab('register',this)">Register</button>
    </div>
    <div id="loginForm">
  <form method="POST" action="php/login.php">

    <div class="form-card">

      <div class="notify-msg" id="login-notify"></div>

      <div class="field">
        <label>Email Address <span class="req">*</span></label>
        <input type="email" id="l-email" name="email" placeholder="admin@medialert.in">
        <div class="err-msg" id="err-lemail">Enter a valid email</div>
      </div>

      <div class="field">
        <label>Password <span class="req">*</span></label>
        <input type="password" id="l-pass" name="password" placeholder="••••••••">
        <div class="err-msg" id="err-lpass">Password is required</div>
      </div>

      <div class="remember-row">
        <label class="checkbox-label">
          <input type="checkbox" style="width:auto;accent-color:var(--red)"> Remember me
        </label>
        <a href="#" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" class="submit-btn navy">Login to Dashboard</button>

      <p class="form-hint">
        Default admin: <code>admin@medialert.in</code> / <code>Admin@1234</code>
      </p>

    </div>

  </form>
</div>
    <div id="registerForm" style="display:none">
      <div class="form-card">
        <div class="notify-msg" id="register-notify"></div>
        <div class="field-row">
          <div class="field"><label>First Name <span class="req">*</span></label><input type="text" id="reg-first" placeholder="First name"><div class="err-msg" id="err-reg-first">First name required</div></div>
          <div class="field"><label>Last Name</label><input type="text" id="reg-last" placeholder="Last name"></div>
        </div>
        <div class="field"><label>Email Address <span class="req">*</span></label><input type="email" id="reg-email" placeholder="your@email.com"><div class="err-msg" id="err-reg-email">Valid email required</div></div>
        <div class="field"><label>Role <span class="req">*</span></label>
          <select id="reg-role">
            <option value="">Select your role...</option>
            <option value="admin">Admin</option>
            <option value="responder">Responder</option>
            <option value="hospital_staff">Hospital Staff</option>
            <option value="public">Public User</option>
          </select>
          <div class="err-msg" id="err-reg-role">Please select a role</div>
        </div>
        <div class="field"><label>Password <span class="req">*</span></label><input type="password" id="reg-pass" placeholder="Min 8 characters"><div class="err-msg" id="err-reg-pass">Min 8 characters required</div></div>
        <div class="field"><label>Confirm Password <span class="req">*</span></label><input type="password" id="reg-confirm" placeholder="Repeat password"><div class="err-msg" id="err-reg-confirm">Passwords do not match</div></div>
        <button class="submit-btn navy" onclick="submitRegister()">Create Account</button>
        <p class="form-hint">Password stored with <code>password_hash()</code></p>
      </div>
    </div>
  </div>
</div>

<!-- ══ CONTACT ══ -->
<div class="page" id="page-contact">
  <div class="section">
    <div class="contact-grid">
      <div class="contact-info">
        <div class="section-title">Contact Us</div>
        <p>Reach our team for system support, partnership queries, or to report a non-emergency concern.</p>
        <div class="contact-item"><div class="contact-icon">&#x1F4DE;</div><div><strong>Emergency Hotline</strong><p>1800-XXX-XXXX (24/7 Toll Free)</p></div></div>
        <div class="contact-item"><div class="contact-icon">&#x1F4E7;</div><div><strong>Email Support</strong><p>support@medialert.in</p></div></div>
        <div class="contact-item"><div class="contact-icon">&#x1F3E5;</div><div><strong>Headquarters</strong><p>District Health Office, Tumkur — 572101</p></div></div>
        <div class="contact-item"><div class="contact-icon">&#x1F550;</div><div><strong>Office Hours</strong><p>Mon-Sat · 9:00 AM - 6:00 PM</p></div></div>
      </div>
      <div class="form-card">
        <h2 class="contact-form-title">Send a Message</h2>
        <p class="contact-form-sub">We reply within 24 hours</p>
        <div class="success-banner" id="contactSuccess">
          <h3>&#x2705; Message Sent!</h3>
          <p>We will get back to you within 24 hours.</p>
        </div>
        <div class="field"><label>Full Name <span class="req">*</span></label><input type="text" id="c-name" placeholder="Your name"><div class="err-msg" id="err-c-name">Name required</div></div>
        <div class="field"><label>Email <span class="req">*</span></label><input type="email" id="c-email" placeholder="you@email.com"><div class="err-msg" id="err-c-email">Valid email required</div></div>
        <div class="field"><label>Subject</label><select id="c-subject"><option>General Enquiry</option><option>Technical Support</option><option>Partnership</option><option>Feedback</option></select></div>
        <div class="field"><label>Message <span class="req">*</span></label><textarea id="c-message" placeholder="Write your message here..."></textarea><div class="err-msg" id="err-c-message">Message too short</div></div>
        <button class="submit-btn teal" onclick="submitContact()">Send Message</button>
      </div>
    </div>
  </div>
</div>

<footer>
  MediAlert &middot; Smart Health Emergency System &middot; Built with PHP, MySQL, HTML/CSS/JS &middot; 
</footer>

<script src="js/main.js"></script>
</body>
</html>
