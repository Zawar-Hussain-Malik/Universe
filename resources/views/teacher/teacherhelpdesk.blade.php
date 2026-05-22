<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Helpdesk | UniVerse</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }

  body, html {
    height: 100%;
    background: #f4f7fb;
  }

  .center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
  }

  .helpdesk-card {
    background: #fff;
    border-radius: 12px;
    /* Blue border removed */
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    padding: 20px;
    width: 100%;
    max-width: 600px;
  }

  .helpdesk-card header {
    background: linear-gradient(90deg,#003366,#004080);
    padding: 12px 16px;
    border-radius: 8px;
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 20px;
  }

  .form-group { margin-bottom: 15px; }
  label { display:block; margin-bottom:6px; font-weight:500; }
  select, input[type="text"], textarea {
    width:100%; padding:10px 12px; border-radius:6px; border:1px solid #ccc; font-size:14px; outline:none;
  }
  select:focus, input:focus, textarea:focus { border-color:#004080; }

  textarea { resize:none; height:100px; }

  .submit-btn { margin-top: 15px; background: #004080; color: #fff; border:none; padding:10px 22px; border-radius:8px; cursor:pointer; font-weight:600; transition: all 0.3s ease; }
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

  // Center wrapper
  const helpdeskHTML = `
    <div class="center-container">
      <div class="helpdesk-card">
        <header>Submit an Issue to Admin</header>

        <div class="form-group">
          <label for="issueType">Issue Type</label>
          <select id="issueType">
            <option value="">--Select Type--</option>
            <option value="Portal">Portal</option>
            <option value="Course">Course</option>
            <option value="Student">Student</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" id="subject" placeholder="Brief summary of the issue">
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" placeholder="Describe the issue in detail"></textarea>
        </div>

        <button class="submit-btn" id="submitBtn">Submit Issue</button>
      </div>
    </div>
  `;

  contentDiv.innerHTML = helpdeskHTML;

  const submitBtn = document.getElementById("submitBtn");
  submitBtn.addEventListener("click", ()=>{
    const type = document.getElementById("issueType").value;
    const subject = document.getElementById("subject").value.trim();
    const desc = document.getElementById("description").value.trim();

    if(!type || !subject || !desc){
      alert("Please complete all fields before submitting!");
      return;
    }

    console.log({type, subject, description: desc});
    alert(`Your issue has been submitted successfully to Admin!`);

    document.getElementById("issueType").value = "";
    document.getElementById("subject").value = "";
    document.getElementById("description").value = "";
  });

  // Highlight sidebar
  const sidebarLinks = container.querySelectorAll(".sidebar a");
  sidebarLinks.forEach(link=>{
    if(link.textContent.trim()==="Helpdesk") link.classList.add("active");
  });
});
</script>
</body>
</html>
