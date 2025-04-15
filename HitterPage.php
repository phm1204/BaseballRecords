<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baseball Records</title>
    <link rel="stylesheet" href="HitterCss.css"> <!-- 스타일 시트를 적용하기 위해 -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Carter+One&display=swap');
    </style>
</head>
<body>
<header class="header">
    <h1 class="header_title">Hitter Records</h1>
    <input type="text" id="search-input" class="search-bar" placeholder="Enter the name.." onkeyup="filterTable(1)">
</header>

<section id="hitter-records" class="records_section">
    <table class="records_table">
        <thead>
            <tr>
                <th onclick="sortTable(0)">순위</th>
                <th onclick="sortTable(1)">이름</th>
                <th onclick="sortTable(2)">팀명</th>
                <th onclick="sortTable(3)">타율</th>
                <th onclick="sortTable(4)">경기수</th>
                <th onclick="sortTable(5)">타석수</th>
                <th onclick="sortTable(6)">타수</th>
                <th onclick="sortTable(7)">득점</th>
                <th onclick="sortTable(8)">안타</th>
                <th onclick="sortTable(9)">2루타</th>
                <th onclick="sortTable(10)">3루타</th>
                <th onclick="sortTable(11)">홈런</th>
                <th onclick="sortTable(12)">루타</th>
                <th onclick="sortTable(13)">타점</th>
                <th onclick="sortTable(14)">희생번트</th>
                <th onclick="sortTable(15)">희생플라이</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // 데이터베이스 연결 설정
            $servername = "localhost";
            $username = "phmn";
            $password = "1204";
            $dbname = "db_baseball";

            // MySQL 데이터베이스에 연결
            $conn = new mysqli($servername, $username, $password, $dbname);

            // 연결 오류 확인
            if ($conn->connect_error) {
                die("연결 실패: " . $conn->connect_error);
            }

            // 타자 기록 가져오기
            $sql = "SELECT 타자.순위, 타자.이름, 팀.팀명, 타자.HRA_RT, 타자.GAME, 타자.PA, 타자.AB, 타자.RUN, 
                           타자.HIT, 타자.H2, 타자.H3, 타자.HR, 타자.TB, 타자.RBI, 타자.SH, 타자.SF 
            FROM 타자 INNER JOIN 팀 WHERE 타자.팀ID = 팀.팀ID";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["순위"]."</td>";
                    echo "<td>".$row["이름"]."</td>";
                    echo "<td>".$row["팀명"]."</td>";
                    echo "<td>".$row["HRA_RT"]."</td>";
                    echo "<td>".$row["GAME"]."</td>";
                    echo "<td>".$row["PA"]."</td>";
                    echo "<td>".$row["AB"]."</td>";
                    echo "<td>".$row["RUN"]."</td>";
                    echo "<td>".$row["HIT"]."</td>";
                    echo "<td>".$row["H2"]."</td>";
                    echo "<td>".$row["H3"]."</td>";
                    echo "<td>".$row["HR"]."</td>";
                    echo "<td>".$row["TB"]."</td>";
                    echo "<td>".$row["RBI"]."</td>";
                    echo "<td>".$row["SH"]."</td>";
                    echo "<td>".$row["SF"]."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='16'>기록이 없습니다.</td></tr>";
            }

            // MySQL 연결 종료
            $conn->close();
        ?>
        </tbody>
    </table>
</section>

<footer class="footer">
    <p>&copy; 2024 야구 기록. 모든 권리 보유.</p>
</footer>

<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-input");
        filter = input.value.toUpperCase();
        table = document.getElementById("hitter-records"); // 변경된 부분
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // 이름 열에 대한 인덱스 (0부터 시작)
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("hitter-records").getElementsByTagName('tbody')[0]; // 변경된 부분
        switching = true;
        dir = "asc"; 
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 0; i < (rows.length - 1); i++) { // 변경된 부분
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;      
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>




</body>
</html>
