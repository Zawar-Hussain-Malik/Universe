<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Course Materials - UniVerse</title>
<style>
/* ===== COURSE MATERIALS PAGE CONTENT STYLES ===== */
.main-content {
  padding: 40px 60px;
  flex-direction: column;
}

/* Back button styling */
.back-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #004080;
  color: white;
  padding: 6px 14px;
  font-size: 13px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 20px;
}
.back-btn:hover {
  background: #003366;
}

/* Header row with back button and title */
.header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 25px;
}
.header-row h3 {
  color: #004080;
  font-size: 2.8rem;
  font-weight: 700;
  text-align: center;
  flex: 1;
}
.header-row .spacer {
  width: 70px;
}

.list-card {
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e3e8f0;
  box-shadow: 0 6px 16px rgba(0,0,0,0.05);
  padding: 20px;
}

.file-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid #eef3fb;
}

.file-row:last-child {
  border-bottom: none;
}

.file-info strong {
  font-size: 16px;
  color: #004a99;
}

.file-info .muted {
  color: #667;
  font-size: 14px;
}

.small-btn {
  background: #004a99;
  color: #fff;
  border: none;
  padding: 8px 14px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.2s;
}

.small-btn:hover {
  background: #002b5c;
}
</style>
</head>
<body>

<div id="layoutContainer"></div>

<script>
// Fetch layout.html dynamically
fetch("layout.html")
  .then(res => res.text())
  .then(data => {
    const container = document.getElementById("layoutContainer");
    container.innerHTML = data;

    // Inject Course Materials content inside layout's #content
    const contentDiv = container.querySelector("#content");
    const mainHTML = `
      <div class="main-content">
        <div class="header-row">
          <!-- Back button left -->
          <button class="back-btn" id="backBtn">⬅ Back</button>
          <!-- Heading centered -->
          <h3>Course Materials</h3>
          <div class="spacer"></div>
        </div>

        <div class="list-card">
          <div class="file-row">
            <div class="file-info">
              <strong>Lecture 1 - Introduction to Databases</strong>
              <div class="muted">Slides & Notes • 02-Oct-2025</div>
            </div>
            <button class="small-btn">Download</button>
          </div>

          <div class="file-row">
            <div class="file-info">
              <strong>Lecture 2 - Data Models</strong>
              <div class="muted">ER Model Overview • 05-Oct-2025</div>
            </div>
            <button class="small-btn">Download</button>
          </div>

          <div class="file-row">
            <div class="file-info">
              <strong>Lecture 3 - Relational Model</strong>
              <div class="muted">Lecture Slides • 08-Oct-2025</div>
            </div>
            <button class="small-btn">Download</button>
          </div>

          <div class="file-row">
            <div class="file-info">
              <strong>Lecture 4 - SQL Basics</strong>
              <div class="muted">SQL Queries & Examples • 12-Oct-2025</div>
            </div>
            <button class="small-btn">Download</button>
          </div>
        </div>

        
      </div>
    `;
    contentDiv.innerHTML = mainHTML;

    // BACK BUTTON CLICK
    const backBtn = document.getElementById("backBtn");
    backBtn.addEventListener("click", () => {
      window.location.href = "studentcourseinfo.html";
    });

    // Highlight sidebar active link
    const sidebarLinks = container.querySelectorAll(".sidebar a");
    sidebarLinks.forEach(link => {
      if(link.textContent.trim() === "Course Materials") link.classList.add("active");
    });

    // Optional: logout button behavior
    const logoutBtn = container.querySelector("#logoutBtn");
    if(logoutBtn){
      logoutBtn.addEventListener("click", ()=>{
        alert("You have been logged out successfully!");
      });
    }
  });
</script>

</body>
</html>
