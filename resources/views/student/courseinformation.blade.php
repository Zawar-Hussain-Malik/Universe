<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Course Information - UniVerse</title>
<style>
/* ===== COURSE INFORMATION PAGE CONTENT STYLES ===== */
.main {
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

.main p {
  color: #666;
  text-align: center;
  margin-bottom: 25px;
}

.card {
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e3e8f0;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
  padding: 26px;
  margin-bottom: 20px;
}
.section-title {
  font-size: 17px;
  font-weight: 600;
  color: #004a99;
  margin-bottom: 10px;
  border-bottom: 2px solid #004a99;
  display: inline-block;
  padding-bottom: 4px;
}
.info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 18px;
}
.info-item {
  background: #f0f4fa;
  padding: 10px 14px;
  border-radius: 8px;
  font-size: 14px;
  color: #333;
}
.highlight {
  font-weight: 600;
  color: #002b5c;
}
ul {
  margin-left: 20px;
  margin-top: 6px;
  color: #333;
  line-height: 1.6;
}
p {
  margin-top: 6px;
  color: #333;
  line-height: 1.6;
}
</style>
</head>
<body>

<!-- Layout will be injected here -->
<div id="layoutContainer"></div>

<script>
// Fetch layout.html dynamically
fetch("layout.html")
  .then(res => res.text())
  .then(data => {
    const container = document.getElementById("layoutContainer");
    container.innerHTML = data;

    // Inject Course Information content into layout's #content
    const contentDiv = container.querySelector("#content");
    const mainHTML = `
      <div class="main">
        <div class="header-row">
          <!-- Back button left -->
          <button class="back-btn" id="backBtn">⬅ Back</button>
          <!-- Heading centered -->
          <h3>Course Information</h3>
          <div class="spacer"></div>
        </div>

        <div class="card">
          <div class="section-title">Basic Course Details</div>
          <div class="info-grid">
            <div class="info-item"><span class="highlight">Course Code:</span> CSC-321</div>
            <div class="info-item"><span class="highlight">Course Title:</span> Database Management Systems</div>
            <div class="info-item"><span class="highlight">Credit Hours:</span> 3 (2 Lectures + 1 Lab)</div>
            <div class="info-item"><span class="highlight">Semester:</span> Fall 2025</div>
            <div class="info-item"><span class="highlight">Instructor:</span> Dr. Ahmed Khan</div>
            <div class="info-item"><span class="highlight">Email:</span> ahmed.khan@universe.edu</div>
          </div>
        </div>

        <div class="card">
          <div class="section-title">Course Description</div>
          <p>
            This course introduces the fundamental concepts of database systems, 
            focusing on data modeling, relational databases, SQL, normalization, 
            and transaction management. It emphasizes both theoretical understanding 
            and practical skills needed to design and implement real-world databases.
          </p>
        </div>

        <div class="card">
          <div class="section-title">Course Objectives</div>
          <ul>
            <li>Understand the basic concepts and architecture of database systems.</li>
            <li>Develop skills in database design using the ER model and normalization techniques.</li>
            <li>Write SQL queries for data manipulation and definition.</li>
            <li>Understand transaction processing and concurrency control.</li>
          </ul>
        </div>

        <div class="card">
          <div class="section-title">Learning Outcomes</div>
          <ul>
            <li>Apply relational modeling techniques to design efficient databases.</li>
            <li>Use SQL to create, query, and manage databases.</li>
            <li>Identify and resolve data anomalies through normalization.</li>
            <li>Implement secure and consistent database transactions.</li>
          </ul>
        </div>

        <div class="card">
          <div class="section-title">Textbooks & References</div>
          <ul>
            <li><b>Database System Concepts</b> by Abraham Silberschatz, Henry Korth, and S. Sudarshan (7th Edition)</li>
            <li><b>Fundamentals of Database Systems</b> by Ramez Elmasri and Shamkant B. Navathe (7th Edition)</li>
            <li>Online SQL documentation and tutorials for MySQL or PostgreSQL</li>
          </ul>
        </div>

        <div class="card">
          <div class="section-title">Class Schedule</div>
          <p>
            <b>Lecture:</b> Monday & Wednesday — 09:00 AM to 10:30 AM (Room 204, 2nd Floor) <br>
            <b>Lab:</b> Monday — 11:00 AM to 01:00 PM (CLAB-6, 3rd Floor)
          </p>
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
      if (link.textContent.trim() === "Course Info") link.classList.add("active");
    });

    // Optional: logout button behavior
    const logoutBtn = container.querySelector("#logoutBtn");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", () => {
        alert("You have been logged out successfully!");
      });
    }
  });
</script>

</body>
</html>
