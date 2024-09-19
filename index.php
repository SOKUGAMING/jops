<?php
// index.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "0648402365Sk";
$dbname = "job_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle job posting
if (isset($_POST['post_job'])) {
    $job_title = $_POST['job_title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $query = "INSERT INTO jobs (job_title, description, salary) VALUES ('$job_title', '$description', '$salary')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('โพสต์งานใหม่สำเร็จ');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: " . $conn->error . "');</script>";
    }
}

// Handle job application
if (isset($_POST['apply_job'])) {
    $job_id = $_POST['job_id'];
    $applicant_name = $_POST['applicant_name'];
    $query = "INSERT INTO applications (job_id, applicant_name) VALUES ('$job_id', '$applicant_name')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('สมัครงานเรียบร้อย');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>เว็บไซต์ประกาศงาน</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', sans-serif; background-color: #f0f4f8; color: #333; }
        .container { width: 80%; margin: auto; padding: 20px; }
        .header, .footer { text-align: center; padding: 20px; background-color: #003366; color: #ffffff; }
        .header h1 { margin: 0; font-size: 2.5em; }
        .button { background-color: #00509e; color: #ffffff; border: none; padding: 10px 20px; margin: 5px; cursor: pointer; border-radius: 5px; font-size: 1em; }
        .button:hover { background-color: #003d6a; }
        .form-container { display: none; padding: 20px; margin-top: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: #ffffff; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .job-listing { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #ffffff; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        .job-listing h3 { margin-top: 0; }
        .job-listing p { margin: 5px 0; }
        .footer p { margin: 0; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="header">
        <h1>เว็บไซต์ประกาศงาน</h1>
        <button class="button" onclick="toggleForm('post-job-form')">ประกาศงาน</button>
        <button class="button" onclick="toggleForm('search-jobs')">ค้นหางาน</button>
        <button class="button" onclick="toggleForm('apply-job-form')">สมัครงาน</button>
    </div>
    
    <div class="container">
        <!-- Post Job Form -->
        <div id="post-job-form" class="form-container">
            <h2>ประกาศงานใหม่</h2>
            <form method="post">
                <div class="form-group">
                    <label for="job_title">ตำแหน่งงาน:</label>
                    <input type="text" id="job_title" name="job_title" required>
                </div>
                <div class="form-group">
                    <label for="description">รายละเอียด:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="salary">เงินเดือน:</label>
                    <input type="text" id="salary" name="salary" required>
                </div>
                <input type="submit" name="post_job" class="button" value="โพสต์งาน">
            </form>
        </div>
        
        <!-- Search Jobs -->
        <div id="search-jobs" class="form-container">
            <h2>งานที่เปิดรับ</h2>
            <?php
            $result = $conn->query("SELECT * FROM jobs");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="job-listing">';
                    echo '<h3>' . htmlspecialchars($row['job_title']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p>เงินเดือน: ' . htmlspecialchars($row['salary']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>ไม่มีงานที่เปิดรับในขณะนี้</p>';
            }
            ?>
        </div>
        
        <!-- Apply Job Form -->
        <div id="apply-job-form" class="form-container">
            <h2>สมัครงาน</h2>
            <form method="post">
                <div class="form-group">
                    <label for="job_id">รหัสงาน:</label>
                    <input type="text" id="job_id" name="job_id" required>
                </div>
                <div class="form-group">
                    <label for="applicant_name">ชื่อของคุณ:</label>
                    <input type="text" id="applicant_name" name="applicant_name" required>
                </div>
                <input type="submit" name="apply_job" class="button" value="สมัครงาน">
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 เว็บไซต์ประกาศงาน</p>
    </div>

    <script>
        function toggleForm(formId) {
            var forms = document.querySelectorAll('.form-container');
            forms.forEach(function(form) {
                form.style.display = form.id === formId ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
