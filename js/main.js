/* =============================================
   MediAlert — Smart Health Emergency System
   main.js — All frontend logic
   ============================================= */

/* ── Page navigation ── */
function showPage(id) {
  document.querySelectorAll('.page').forEach(function(p) { p.classList.remove('active'); });
  document.querySelectorAll('.nav-links a').forEach(function(a) { a.classList.remove('active'); });
  document.getElementById('page-' + id).classList.add('active');
  var navEl = document.getElementById('nav-' + id);
  if (navEl) navEl.classList.add('active');
  window.scrollTo(0, 0);
  if (id === 'dashboard') loadDashboard();
}

/* ── Auth tab switch ── */
function switchTab(tab, btn) {
  document.querySelectorAll('.auth-tab').forEach(function(t) { t.classList.remove('active'); });
  btn.classList.add('active');
  document.getElementById('loginForm').style.display    = tab === 'login'    ? 'block' : 'none';
  document.getElementById('registerForm').style.display = tab === 'register' ? 'block' : 'none';
}

/* ── Dashboard filter ── */
function filterTable(filter, btn) {
  document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
  btn.classList.add('active');
  document.querySelectorAll('#tableBody tr').forEach(function(row) {
    if (filter === 'all')      row.style.display = '';
    else if (filter === 'critical') row.style.display = row.dataset.sev === 'critical' ? '' : 'none';
    else                       row.style.display = row.dataset.status === filter ? '' : 'none';
  });
}

/* ── Generic field validator ── */
function validate(id, errId, checkFn) {
  var val   = document.getElementById(id).value.trim();
  var valid = checkFn(val);
  document.getElementById(id).className      = valid ? '' : 'err';
  document.getElementById(errId).className   = valid ? 'err-msg' : 'err-msg show';
  return valid;
}

/* ── Notify helper (replaces alert()) ── */
function notify(elId, msg, type) {
  var el = document.getElementById(elId);
  if (!el) return;
  el.textContent = msg;
  el.className   = 'notify-msg show ' + (type || 'error');
}

/* ═══════════════════════════════════════
   DASHBOARD — load from PHP
   ═══════════════════════════════════════ */
function loadDashboard() {
  fetch('php/fetch_incidents.php')
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (!data.success) {
        document.getElementById('tableBody').innerHTML =
          '<tr><td colspan="7" class="loading-cell">Could not load data: ' + (data.error || 'Unknown error') + '</td></tr>';
        return;
      }

      /* Stats */
      var s = data.stats;
      document.getElementById('stat-active').textContent   = s.active   || 0;
      document.getElementById('stat-total').textContent    = s.total    || 0;
      document.getElementById('stat-resolved').textContent = s.resolved || 0;
      var avg = s.avg_response ? Math.round(s.avg_response) : '—';
      document.getElementById('stat-avg').innerHTML = avg + '<span class="min-label">min</span>';

      /* Table rows */
      var tbody = document.getElementById('tableBody');
      if (!data.incidents || data.incidents.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="loading-cell">No incidents found.</td></tr>';
        return;
      }

      tbody.innerHTML = '';
      data.incidents.forEach(function(inc) {
        var time = new Date(inc.reported_at).toLocaleTimeString('en-IN', { hour:'2-digit', minute:'2-digit' });
        var sev  = (inc.severity || 'low').toLowerCase();
        var stat = (inc.status   || 'pending').toLowerCase();
        tbody.innerHTML +=
          '<tr data-status="' + stat + '" data-sev="' + sev + '">' +
          '<td>#' + inc.id + '</td>' +
          '<td>' + time + '</td>' +
          '<td>' + inc.type + '</td>' +
          '<td>' + inc.location + '</td>' +
          '<td><span class="severity sev-' + sev + '">' + capitalise(sev) + '</span></td>' +
          '<td><span class="status-dot"><span class="dot dot-' + stat + '"></span>' + capitalise(stat) + '</span></td>' +
          '<td>' + (inc.assigned_unit || 'Unassigned') + '</td>' +
          '</tr>';
      });
    })
    .catch(function(err) {
      document.getElementById('tableBody').innerHTML =
        '<tr><td colspan="7" class="loading-cell">Network error — make sure PHP server is running.</td></tr>';
    });
}

function capitalise(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

/* Auto-refresh dashboard every 30 seconds */
setInterval(function() {
  if (document.getElementById('page-dashboard').classList.contains('active')) {
    loadDashboard();
  }
}, 30000);

/* ═══════════════════════════════════════
   REPORT INCIDENT
   ═══════════════════════════════════════ */
function submitReport() {
  var v1 = validate('r-name',     'err-name',     function(v){ return v.length >= 2; });
  var v2 = validate('r-phone',    'err-phone',    function(v){ return /^[0-9]{10}$/.test(v); });
  var v3 = validate('r-type',     'err-type',     function(v){ return v !== ''; });
  var v4 = validate('r-severity', 'err-severity', function(v){ return v !== ''; });
  var v5 = validate('r-location', 'err-location', function(v){ return v.length >= 5; });
  var v6 = validate('r-desc',     'err-desc',     function(v){ return v.length >= 20; });

  if (!v1 || !v2 || !v3 || !v4 || !v5 || !v6) return;

  var btn = document.querySelector('#reportForm .submit-btn');
  btn.textContent = 'Submitting...';
  btn.disabled    = true;

  var formData = new FormData();
  formData.append('name',        document.getElementById('r-name').value);
  formData.append('phone',       document.getElementById('r-phone').value);
  formData.append('type',        document.getElementById('r-type').value);
  formData.append('severity',    document.getElementById('r-severity').value);
  formData.append('location',    document.getElementById('r-location').value);
  formData.append('victims',     document.getElementById('r-victims').value || 1);
  formData.append('email',       document.getElementById('r-email').value);
  formData.append('description', document.getElementById('r-desc').value);

  /* Try to get browser location */
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function(pos) {
        formData.append('lat', pos.coords.latitude);
        formData.append('lng', pos.coords.longitude);
        sendReport(formData, btn);
      },
      function() { sendReport(formData, btn); }
    );
  } else {
    sendReport(formData, btn);
  }
}

function sendReport(formData, btn) {
  fetch('php/submit_report.php', { method:'POST', body: formData })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      btn.textContent = 'Submit Emergency Report';
      btn.disabled    = false;
      if (data.success) {
        document.getElementById('reportForm').style.display = 'none';
        document.getElementById('reportId').textContent     = data.incident_id;
        document.getElementById('successBanner').classList.add('show');
      } else {
        notify('err-desc', (data.errors || ['Submission failed']).join(', '), 'error');
        document.getElementById('err-desc').className = 'err-msg show';
      }
    })
    .catch(function() {
      btn.textContent = 'Submit Emergency Report';
      btn.disabled    = false;
      document.getElementById('err-desc').textContent = 'Network error — could not reach server.';
      document.getElementById('err-desc').className   = 'err-msg show';
    });
}

/* ═══════════════════════════════════════
   LOGIN
   ═══════════════════════════════════════ */


/* ═══════════════════════════════════════
   REGISTER
   ═══════════════════════════════════════ */
function submitRegister() {
  var ok1 = validate('reg-first',   'err-reg-first',   function(v){ return v.length >= 2; });
  var ok2 = validate('reg-email',   'err-reg-email',   function(v){ return /\S+@\S+\.\S+/.test(v); });
  var ok3 = validate('reg-role',    'err-reg-role',    function(v){ return v !== ''; });
  var ok4 = validate('reg-pass',    'err-reg-pass',    function(v){ return v.length >= 8; });
  var pass    = document.getElementById('reg-pass').value;
  var confirm = document.getElementById('reg-confirm').value;
  var ok5 = pass === confirm;
  document.getElementById('reg-confirm').className    = ok5 ? '' : 'err';
  document.getElementById('err-reg-confirm').className = ok5 ? 'err-msg' : 'err-msg show';

  if (!ok1 || !ok2 || !ok3 || !ok4 || !ok5) return;

  var btn = document.querySelector('#registerForm .submit-btn');
  btn.textContent = 'Creating account...';
  btn.disabled    = true;

  var fd = new FormData();
  fd.append('first_name',       document.getElementById('reg-first').value);
  fd.append('last_name',        document.getElementById('reg-last').value);
  fd.append('email',            document.getElementById('reg-email').value);
  fd.append('role',             document.getElementById('reg-role').value);
  fd.append('password',         pass);
  fd.append('confirm_password', confirm);

  fetch('php/register.php', { method:'POST', body: fd })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      btn.textContent = 'Create Account';
      btn.disabled    = false;
      if (data.success) {
        notify('register-notify', 'Account created! You can now login.', 'ok');
        setTimeout(function() {
          switchTab('login', document.querySelector('.auth-tab'));
        }, 1200);
      } else {
        notify('register-notify', (data.errors || ['Registration failed']).join(' | '), 'error');
      }
    })
    .catch(function() {
      btn.textContent = 'Create Account';
      btn.disabled    = false;
      notify('register-notify', 'Network error.', 'error');
    });
}

/* ═══════════════════════════════════════
   CONTACT
   ═══════════════════════════════════════ */
function submitContact() {
  var ok1 = validate('c-name',    'err-c-name',    function(v){ return v.length >= 2; });
  var ok2 = validate('c-email',   'err-c-email',   function(v){ return /\S+@\S+\.\S+/.test(v); });
  var ok3 = validate('c-message', 'err-c-message', function(v){ return v.length >= 10; });
  if (!ok1 || !ok2 || !ok3) return;

  var btn = document.querySelector('#page-contact .submit-btn');
  btn.textContent = 'Sending...';
  btn.disabled    = true;

  var fd = new FormData();
  fd.append('name',    document.getElementById('c-name').value);
  fd.append('email',   document.getElementById('c-email').value);
  fd.append('subject', document.getElementById('c-subject').value);
  fd.append('message', document.getElementById('c-message').value);

  fetch('php/contact.php', { method:'POST', body: fd })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      btn.textContent = 'Send Message';
      btn.disabled    = false;
      if (data.success) {
        document.getElementById('contactSuccess').classList.add('show');
        document.getElementById('c-name').value    = '';
        document.getElementById('c-email').value   = '';
        document.getElementById('c-message').value = '';
      }
    })
    .catch(function() {
      btn.textContent = 'Send Message';
      btn.disabled    = false;
    });
}
