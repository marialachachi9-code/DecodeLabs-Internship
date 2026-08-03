<?php
require 'db.php';

$subject_id = intval($_GET['id']);

$subject_name = $conn->query("SELECT name FROM subjects WHERE id = $subject_id")->fetch_assoc();

$sql = "SELECT students.name, grades.grade, grades.exam_type
        FROM grades
        JOIN students ON grades.student_id = students.id
        WHERE grades.subject_id = $subject_id
        ORDER BY grades.grade DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Subject Grades</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #333; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
        .fail { color: red; font-weight: bold; }
    </style>
</head>
<body>
<h1>Grades for: <?php echo htmlspecialchars($subject_name['name']); ?></h1>
<table>
  <tr><th>Student</th><th>Grade</th><th>Type</th></tr>
  <?php while ($row = $result->fetch_assoc()) { 
      $class = $row['grade'] < 10 ? 'fail' : '';
  ?>
    <tr>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td class="<?php echo $class; ?>"><?php echo $row['grade']; ?></td>
      <td><?php echo htmlspecialchars($row['exam_type']); ?></td>
    </tr>
  <?php } ?>
</table>
<br><a href="students.php">← Back to Students</a>
</body>
</html>