<?php
if (isset($_REQUEST["show"]) && $_COOKIE["login"] == "login") {

    echo "<style>
                input {
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
                  padding: 15px 20px;
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
    echo "<table >";
    echo "<tr>
            <th> id </th>
            <th> User Name </th>
            <th> Email </th>
            <th> Password </th>
            <th> Room Number </th>
            <th>profile Picture</th>
            <tr>";
    $result = json_decode($_REQUEST["data"]);
    $counter = 0;
    foreach ($result as $val) {
        $counter++;
        if ($counter == 6) {
            echo "<td><img width='200px' height='200px' src='profilePicture/$val'/></td>";
        } else {
            echo "<td>" . $val . "</td>";
        }
    }
    echo "</tr>";
    echo "</table>";
    echo "<form  class='container' action='home.php'>
        <input type='submit' name='backToHome' value='Back to Home'>
        </form>";
}else{
    header("Location:login.php");
}
