<?php
require 'db.php';
 
$sql = "SELECT students.id, students.name, 
        SUM(grades.grade * subjects.coefficient) / SUM(subjects.coefficient) AS weighted_average
        FROM students
        JOIN grades ON students.id = grades.student_id
        JOIN subjects ON grades.subject_id = subjects.id
        GROUP BY students.id, students.name
        ORDER BY weighted_average DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Averages</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #333; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
    </style>
</head>
<body>
<h1>Student Averages</h1>
<table>
  <tr><th>Name</th><th>Weighted Average</th></tr>
  <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td><?php echo round($row['weighted_average'], 2); ?></td>
    </tr>
  <?php } ?>
</table>

<h2>Subjects</h2>
<?php
$subjects = $conn->query("SELECT id, name FROM subjects");
while ($s = $subjects->fetch_assoc()) {
    echo '<a href="subject.php?id=' . $s['id'] . '">' . htmlspecialchars($s['name']) . '</a><br>';
}
?>
</body>
</html>