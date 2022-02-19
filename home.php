<?php
if (isset($_REQUEST["backToHome"]) && $_COOKIE["login"]=="login") {
    try {
        $connect = new pdo("mysql:dbname=student;host=localhost", "alabasy", "");
        $allUserData = $connect->query("select * from student");


         echo "<style>
               .logout{
                    background-color: white;
                    color: black;
                    border: 2px solid #008CBA;
                    border-radius: 50px;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    display:flow;
                    font-size: 16px;
                    cursor: pointer;
                    width: 200px; 
                    margin:50px auto ;   
                }
                
                
                .logout:hover {
                    background-color: #008CBA;
                    color: white;
                }
                input {
                    background-color: white;
                    color: black;
                    border: 2px solid #008CBA;
                    border-radius: 50px;
                    padding: 15px ;
                    text-align: center;
                    text-decoration: none;
                    display:flow;
                    font-size: 16px;
                    cursor: pointer;
                    width: 100px; 
                }
                
                
                input:hover {
                    background-color: #008CBA;
                    color: white;
                }
                
                table {
                  border-collapse: collapse;
                  border-radius: 10px;
                  overflow: hidden;
                  margin:50px auto ; 
                }
                td {
                  border: 0 solid black;
                  height: 20px;
                  width: 50px;
                  text-align: center;
                  font-size: 14px;
                  white-space: nowrap;
                  padding: 15px 10px;
                }
                th {
                  color: white;
                  padding: 20px 20px 20px 20px;
                }
                th:nth-child(1) {
                  background-color: #7887ab;
                  align-content: center;
                }
                th:nth-child(2) {
                  background-color: #4f628e;
                  align-content: center;
                }
                th:nth-child(3) {
                  background-color: #2e4172;
                  align-content: center;
                }
                th:nth-child(4) {
                  background-color: #162955;
                  align-content: center;
                }
                th:nth-child(5) {
                  background-color: #061539;
                  align-content: center;
                }                
                th:nth-child(6) {
                  background-color: #010a1c;
                  align-content: center;
                }                th:nth-child(7) {
                  background-color: black;
                  align-content: center;
                }                th:nth-child(8) {
                  background-color: black;
                  align-content: center;
                }                th:nth-child(9) {
                  background-color: black;
                  align-content: center;
                }
                tr:nth-child(2n) {
                  background: #ececec;
                }
                tr:nth-child(2n-1) {
                  background: #dbdbdb;
                }
                td:nth-child(2n) {
                  background: lightgray;
                }
                tr:nth-child(odd) td:nth-child(even) {
                  background: #e7e7e7;
                }
                tr:nth-child(even) td:nth-child(even) {
                  background: #f3f3f3;
                }
     </style>";
        echo "<form action='login.php' >
        <input type='submit'  class='logout' name='backToHome' value='Log Out'>
        </form>";
        echo "<table  ";
        echo "<tr>
            <th>id</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Room Number</th>
            <th>profile Picture</th>
            <th></th>
            <th>Actions</th>
            <th></th>
            <tr>";

        while ($result = $allUserData->fetch(PDO::FETCH_ASSOC)) {
            $counter = 0; //to put image in the last place
            foreach ($result as $val) {
                $counter++;
                if ($counter == count($result)) { //last place = 6;
                    echo "<td><img width='200px' height='200px' src='profilePicture/$val'/></td>";
                } else {
                    echo "<td>" . $val . "</td>";
                }
            }
            echo "<td><form action='AppControl.php' method='get'>
                  <input type='hidden' name='id' value='{$result['id']}'/>
                  <input type='submit' name='show' value='show'>
                 </form></td>";
            echo "<td><form action='edit.php' method='get'>
                  <input type='hidden' name='id' value='{$result['id']}'/>
                  <input type='submit' name='edit' value='Edit'>
                 </form></td>";
            echo "<td><form action='AppControl.php' method='get'>
                  <input type='hidden' name='id' value='{$result['id']}'/>
                  <input type='submit' name='delete' value='Delete'>
                 </form></td>";
            echo "</tr>";
        }
        echo "</table>";

    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $connect = null;
}else{
    header("Location:login.php");
}