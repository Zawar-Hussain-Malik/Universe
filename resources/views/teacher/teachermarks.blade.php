<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Assessment Upload | UniVerse</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }

  .assessment-card {
    background: #fff;
    border-radius: 12px;
    /* Blue border removed */
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    padding: 20px;
    margin-bottom: 20px;
  }

  .assessment-card header {
    background: linear-gradient(90deg,#003366,#004080);
    padding: 12px 16px;
    border-radius: 8px;
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 20px;
  }

  .form-group { margin-bottom: 15px; }

  select, input[type="number"] {
    width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline:none;
  }
  select:focus, input:focus { border-color:#004080; }
  input[type="number"] { width:80px; padding:6px; }

  .assessment-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  .assessment-table th, .assessment-table td {
    border: 1px solid rgba(0,0,0,0.1);
    padding: 10px;
    text-align: center;
  }

  .assessment-table th {
    background: #004080;
    color: #fff;
    font-weight: 600;
  }

  .submit-btn {
    margin-top: 15px;
    background: #004080;
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .submit-btn:hover { background: #003366; }
</style>
</head>
<body>

<div id="layoutContainer"></div>

<script>
fetch("layout.html")
.then(res => res.text())
.then(data => {
  const container = document.getElementById("layoutContainer");
  container.innerHTML = data;

  const contentDiv = container.querySelector("#content");

  const assessmentHTML = `
    <div class="assessment-card">
      <header>Teacher Assessment Upload</header>

      <div class="form-group">
        <label for="department">Select Department</label>
        <select id="department">
          <option value="">--Select Department--</option>
          <option value="CS">Computer Science</option>
          <option value="EE">Electrical Engineering</option>
          <option value="ME">Mechanical Engineering</option>
        </select>
      </div>

      <div class="form-group">
        <label for="semester">Select Semester</label>
        <select id="semester" disabled>
          <option value="">--Select Semester--</option>
        </select>
      </div>

      <div class="form-group">
        <label for="subject">Select Subject</label>
        <select id="subject" disabled>
          <option value="">--Select Subject--</option>
        </select>
      </div>

      <div class="form-group">
        <label for="assessment">Select Assessment Type</label>
        <select id="assessment" disabled>
          <option value="">--Select Assessment--</option>
          <option value="quiz">Quiz</option>
          <option value="assignment">Assignment</option>
          <option value="lab">Lab</option>
          <option value="mid">Mid</option>
          <option value="final">Final</option>
        </select>
      </div>

      <div class="table-wrap" style="overflow-x:auto;">
        <table class="assessment-table" id="marksTable" style="display:none;">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>Marks</th>
            </tr>
          </thead>
          <tbody id="marksBody"></tbody>
        </table>
      </div>

      <button class="submit-btn" id="submitBtn" style="display:none;">Submit Marks</button>
    </div>
  `;

  contentDiv.innerHTML = assessmentHTML;

  const semesters = {
    CS: ["1st", "2nd", "3rd", "4th", "5th"],
    EE: ["1st", "2nd", "3rd", "4th"],
    ME: ["1st", "2nd", "3rd"]
  };

  const subjects = {
    CS: { "1st": ["Intro to Programming", "Mathematics 1"], "2nd":["Data Structures", "Math 2"], "3rd":["DB Systems", "OS"] },
    EE: { "1st": ["Circuits 1", "Math 1"], "2nd":["Electronics 1", "Physics 2"] },
    ME: { "1st": ["Mechanics 1", "Math 1"], "2nd":["Thermodynamics", "Math 2"] }
  };

  const students = [
    {id:"S101", name:"Alice"}, {id:"S102", name:"Bob"}, {id:"S103", name:"Charlie"},
    {id:"S104", name:"David"}, {id:"S105", name:"Eva"}
  ];

  const departmentSelect = document.getElementById("department");
  const semesterSelect = document.getElementById("semester");
  const subjectSelect = document.getElementById("subject");
  const assessmentSelect = document.getElementById("assessment");
  const marksTable = document.getElementById("marksTable");
  const marksBody = document.getElementById("marksBody");
  const submitBtn = document.getElementById("submitBtn");

  departmentSelect.addEventListener("change", ()=>{
    const dept = departmentSelect.value;
    semesterSelect.innerHTML = '<option value="">--Select Semester--</option>';
    subjectSelect.innerHTML = '<option value="">--Select Subject--</option>';
    subjectSelect.disabled = true;
    assessmentSelect.disabled = true;
    marksTable.style.display="none";
    submitBtn.style.display="none";

    if(dept){
      semesters[dept].forEach(s => {
        const option = document.createElement("option");
        option.value = s; option.textContent = s;
        semesterSelect.appendChild(option);
      });
      semesterSelect.disabled = false;
    } else { semesterSelect.disabled = true; }
  });

  semesterSelect.addEventListener("change", ()=>{
    const dept = departmentSelect.value;
    const sem = semesterSelect.value;
    subjectSelect.innerHTML = '<option value="">--Select Subject--</option>';
    assessmentSelect.disabled = true;
    marksTable.style.display="none";
    submitBtn.style.display="none";

    if(dept && sem && subjects[dept][sem]){
      subjects[dept][sem].forEach(sub=>{
        const option = document.createElement("option");
        option.value = sub; option.textContent = sub;
        subjectSelect.appendChild(option);
      });
      subjectSelect.disabled = false;
    } else { subjectSelect.disabled = true; }
  });

  subjectSelect.addEventListener("change", ()=>{
    assessmentSelect.disabled = false;
    marksTable.style.display="none";
    submitBtn.style.display="none";
  });

  assessmentSelect.addEventListener("change", ()=>{
    marksBody.innerHTML="";
    students.forEach(s=>{
      const tr = document.createElement("tr");
      tr.innerHTML = `<td>${s.id}</td><td>${s.name}</td><td><input type="number" min="0" max="100"></td>`;
      marksBody.appendChild(tr);
    });
    marksTable.style.display="table";
    submitBtn.style.display="inline-block";
  });

  submitBtn.addEventListener("click", ()=>{
    const rows = marksBody.querySelectorAll("tr");
    const marksData = [];
    rows.forEach(r=>{
      const studentId = r.cells[0].textContent;
      const studentName = r.cells[1].textContent;
      const marks = r.cells[2].querySelector("input").value;
      marksData.push({studentId, studentName, marks});
    });
    console.log("Submitted Marks:", marksData);
    alert("Marks submitted successfully! Check console for data.");
  });

  // Highlight sidebar
  const sidebarLinks = container.querySelectorAll(".sidebar a");
  sidebarLinks.forEach(link=>{
    if(link.textContent.trim()==="Assessments") link.classList.add("active");
  });

});
</script>

</body>
</html>
