<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="baseballMainCss.css" />
    <title>기록실</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Carter+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Cabin+Condensed:wght@400;500;600;700&family=Carter+One&display=swap');
        th {
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php
$servername = "localhost";
$dbname = "DB_baseball";
$user = "phmn";
$password = "1204";

try {
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute SQL query for 팀
    $sql = "SELECT * FROM 팀";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $teamResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $ex) {
    echo "서버와의 연결 실패! : " . $ex->getMessage() . "<br>";
}
?>

<div class="header">
    <ul>
        <li><a href="HitterPage.php">Hitter Records</a></li>
        <li><a href="PitcherPage.php">Pitcher Records</a></li>
    </ul>
    <div class="header_title"><h3>Baseball Records</h3></div>
</div>

<div class="content">
    <!-- Display team records -->
    <div class="team-records">
        <h2>Team Records</h2>
        <table id="team-table">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">순위</th>
                    <th onclick="sortTable(1)">팀명</th>
                    <th onclick="sortTable(2)">경기</th>
                    <th onclick="sortTable(3)">승</th>
                    <th onclick="sortTable(4)">패</th>
                    <th onclick="sortTable(5)">무</th>
                    <th onclick="sortTable(6)">승률</th>
                    <th onclick="sortTable(7)">게임차</th>
                    <th onclick="sortTable(8)">최근 10 경기</th>
                    <th onclick="sortTable(9)">연속</th>
                    <th onclick="sortTable(10)">홈</th>
                    <th onclick="sortTable(11)">방문</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($teamResults)) : ?>
                    <?php foreach ($teamResults as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['순위']); ?></td>
                            <td><?php echo htmlspecialchars($row['팀명']); ?></td>
                            <td><?php echo htmlspecialchars($row['경기']); ?></td>
                            <td><?php echo htmlspecialchars($row['승']); ?></td>
                            <td><?php echo htmlspecialchars($row['패']); ?></td>
                            <td><?php echo htmlspecialchars($row['무']); ?></td>
                            <td><?php echo htmlspecialchars($row['승률']); ?></td>
                            <td><?php echo htmlspecialchars($row['게임차']); ?></td>
                            <td><?php echo htmlspecialchars($row['최근10경기']); ?></td>
                            <td><?php echo htmlspecialchars($row['연속']); ?></td>
                            <td><?php echo htmlspecialchars($row['홈']); ?></td>
                            <td><?php echo htmlspecialchars($row['방문']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="12">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="end-card">
    <p>&copy; 2024 Company Name. All rights reserved.</p>
    <p>Contact us: <a href="mailto:contact@company.com">contact@company.com</a></p>
    <p>Address: 1234 Street Name, City, Country</p>
</div>

<script>
    function sortTable(columnIndex) {
        const table = document.getElementById("team-table");
        const tbody = table.getElementsByTagName("tbody")[0];
        const rows = Array.from(tbody.rows);
        let isNumeric = !isNaN(rows[0].cells[columnIndex].innerText);
        let isAsc = table.getAttribute("data-sort-direction") !== "asc";
        
        rows.sort((rowA, rowB) => {
            let cellA = rowA.cells[columnIndex].innerText;
            let cellB = rowB.cells[columnIndex].innerText;
            
            if (isNumeric) {
                cellA = parseFloat(cellA);
                cellB = parseFloat(cellB);
            } else {
                cellA = cellA.toLowerCase();
                cellB = cellB.toLowerCase();
            }
            if (isAsc) return cellA > cellB ? 1 : -1;
             else return cellA < cellB ? 1 : -1;
            
        });
        
        table.setAttribute("data-sort-direction", isAsc ? "asc" : "desc");
        rows.forEach(row => tbody.appendChild(row));
    }
</script>

</body>
</html>
