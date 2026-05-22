<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Courses | UniVerse</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }

  .courses-card {
    background: #fff;
    border-radius: 12px;
    /* Blue border removed */
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    padding: 20px;
    margin-bottom: 20px;
  }

  .courses-card header {
    background: linear-gradient(90deg,#003366,#004080);
    padding: 12px 16px;
    border-radius: 8px;
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  th, td {
    border: 1px solid rgba(0,0,0,0.1);
    padding: 10px;
    text-align: center;
  }

  th {
    background: #004080;
    color: #fff;
    font-weight: 600;
  }

  tr:nth-child(even) { background: #f9f9f9; }
  tr:hover { background: #e6f0ff; }

  @media(max-width:900px){
    th, td { font-size:12px; padding:6px; }
  }
</style>
</head>
<body>

<div id="layoutContainer"></div>

<script>
fetch("layout.html")
.then(res=>res.text())
.then(data=>{
  const container = document.getElementById("layoutContainer");
  container.innerHTML = data;

  const contentDiv = container.querySelector("#content");

  const coursesHTML = `
    <div class="courses-card">
      <header>My Courses — Department & Semester Wise</header>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Department</th>
              <th>Semester</th>
              <th>Course Code</th>
              <th>Course Name</th>
            </tr>
          </thead>
          <tbody id="coursesBody">
          </tbody>
        </table>
      </div>
    </div>
  `;

  contentDiv.innerHTML = coursesHTML;

  // Sample teacher course data
  const courses = [
    { dept: "Computer Science", semester: "1st", code: "CS101", name: "Introduction to Programming" },
    { dept: "Computer Science", semester: "2nd", code: "CS201", name: "Data Structures" },
    { dept: "Computer Science", semester: "3rd", code: "CS301", name: "Database Systems" },
    { dept: "Electrical Engineering", semester: "1st", code: "EE101", name: "Circuit Analysis" },
    { dept: "Electrical Engineering", semester: "2nd", code: "EE201", name: "Digital Electronics" },
    { dept: "Mechanical Engineering", semester: "1st", code: "ME101", name: "Engineering Mechanics" }
  ];

  const tbody = document.getElementById("coursesBody");
  courses.forEach(c=>{
    const tr = document.createElement("tr");
    tr.innerHTML = `<td>${c.dept}</td><td>${c.semester}</td><td>${c.code}</td><td>${c.name}</td>`;
    tbody.appendChild(tr);
  });

  // Highlight sidebar
  const sidebarLinks = container.querySelectorAll(".sidebar a");
  sidebarLinks.forEach(link=>{
    if(link.textContent.trim()==="Courses") link.classList.add("active");
  });
});
</script>

</body>
</html>
