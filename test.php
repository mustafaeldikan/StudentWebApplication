<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="tr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Tablosu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: ltr;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-button {
            cursor: pointer;
            background-color: #f2f2f2;
            border: none;
            padding: 5px 10px;
            margin: 2px;
        }
        .add-button {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
    <script>
        function addRow() {
            var isim = document.getElementById("isim").value;
            var soyisim = document.getElementById("soyisim").value;
            var dogumYeri = document.getElementById("dogumYeri").value;
            var dogumTarihi = document.getElementById("dogumTarihi").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "add_student.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response);
                    // After successfully adding to the database, add it to the table
                    var table = document.getElementById("studentsTable").getElementsByTagName('tbody')[0];
                    var newRow = table.insertRow();

                    var cell1 = newRow.insertCell(0);
                    var cell2 = newRow.insertCell(1);
                    var cell3 = newRow.insertCell(2);
                    var cell4 = newRow.insertCell(3);
                    var cell5 = newRow.insertCell(4);
                    var cell6 = newRow.insertCell(5);
                    var cell7 = newRow.insertCell(6);

                    cell1.innerHTML = table.rows.length;
                    cell2.innerHTML = isim;
                    cell3.innerHTML = soyisim;
                    cell4.innerHTML = dogumYeri;
                    cell5.innerHTML = dogumTarihi;
                    cell6.innerHTML = "<button class='action-button' onclick='editRow(this)'>Güncelle</button>";
                    cell7.innerHTML = "<button class='action-button' onclick='deleteRow(this)'>Sil</button>";

                    // Clear input fields after adding the record
                    document.getElementById("isim").value = "";
                    document.getElementById("soyisim").value = "";
                    document.getElementById("dogumYeri").value = "";
                    document.getElementById("dogumTarihi").value = "";
                }
            };
            xhr.send("isim=" + isim + "&soyisim=" + soyisim + "&dogumYeri=" + dogumYeri + "&dogumTarihi=" + dogumTarihi);
        }

        function deleteRow(row) {
            var confirmDelete = confirm("Bu kaydı silmek istediğinizden emin misiniz ?");
            if (confirmDelete) {    
                var i = row.parentNode.parentNode.rowIndex;
                var sid = document.getElementById("studentsTable").rows[i].cells[0].innerHTML;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_student.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        var response = xhr.responseText;
                        alert(response);
                        document.getElementById("studentsTable").deleteRow(i);
                    }
                };
                xhr.send("sid=" + sid);
            } else {
                return;
            }
        }

        function editRow(row) {
            var i = row.parentNode.parentNode.rowIndex;
            var table = document.getElementById("studentsTable");
            var sid = table.rows[i].cells[0].innerHTML;
            var isim = prompt("Yeni adı girin:", table.rows[i].cells[1].innerHTML);
            if (isim === null) {
                return;
            }

            var soyisim = prompt("Yeni soyadı girin:", table.rows[i].cells[2].innerHTML);
            if (soyisim === null) {
                return;
            }

            var dogumYeri = prompt("Yeni doğum yeri girin:", table.rows[i].cells[3].innerHTML);
            if (dogumYeri === null) {
                return;
            }

            var dogumTarihi = prompt("Yeni doğum tarihini girin:", table.rows[i].cells[4].innerHTML);
            if (dogumTarihi === null) {
                return;
            }

            table.rows[i].cells[1].innerHTML = isim;
            table.rows[i].cells[2].innerHTML = soyisim;
            table.rows[i].cells[3].innerHTML = dogumYeri;
            table.rows[i].cells[4].innerHTML = dogumTarihi;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_student.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response);
                }
            };
            xhr.send("sid=" + sid + "&isim=" + isim + "&soyisim=" + soyisim + "&dogumYeri=" + dogumYeri + "&dogumTarihi=" + dogumTarihi);
        }
    </script>
</head>
<body>

    <h1>Öğrenci Tablosu</h1>
    
    <table id="studentsTable">
        <thead>
            <tr>
                <th>Sid</th>
                <th>İsim</th>
                <th>Soyisim</th>
                <th>Doğum Yeri</th>
                <th>Doğum Tarihi</th>
                <th>Güncelleme işlemi</th>
                <th>Silme işlemi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "mustafa";
            $password = "1234";
            $dbname = "sdb";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch students
            $sql = "SELECT * FROM studentdb";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Print data into table
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["sid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["birthPlace"] . "</td>";
                    echo "<td>" . $row["birthDate"] . "</td>";
                    echo "<td><button class='action-button' onclick='editRow(this)'>Güncelle</button></td>";
                    echo "<td><button class='action-button' onclick='deleteRow(this)'>Sil</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <h2>Yeni Öğrenci Ekle İşlemi</h2>
    <form id="addStudentForm" onsubmit="event.preventDefault(); addRow();">
        <label for="isim">İsim:</label>
        <input type="text" id="isim" name="isim" required><br><br>
        <label for="soyisim">Soyisim:</label>
        <input type="text" id="soyisim" name="soyisim" required><br><br>
        <label for="dogumYeri">Doğum Yeri:</label>
        <input type="text" id="dogumYeri" name="dogumYeri" required><br><br>
        <label for="dogumTarihi">Doğum Tarihi:</label>
        <input type="date" id="dogumTarihi" name="dogumTarihi" required><br><br>
        <button type="submit" class="add-button">Ekle</button>
        <button type="reset" class="add-button">Reset</button>
    </form>

</body>
</html>
