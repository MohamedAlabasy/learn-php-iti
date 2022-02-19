<?php
if (isset($_REQUEST["edit"]) && $_COOKIE["login"] == "login") {
    try {
        $connect = new pdo("mysql:dbname=student;host=localhost", "alabasy", "");
        $userData = $connect->prepare("select * from student where id = ?");
        $userData->execute([
            $_REQUEST["id"]
        ]);

        $result = $userData->fetch(PDO::FETCH_ASSOC);
        echo '<html lang="en">
<head>
    <title>Edit</title>
  <link rel="stylesheet" href="myStyles.css">
</head>
<body>
<div class="login-page">
    <div class="form">
        <form action="AppControl.php" method="post" class="login-form"
                 enctype="multipart/form-data">
            <input type="hidden" name="id" value="' . $result['id'] . '"/>
            <input type="text" name="userName" value="' . $result['userName'] . '"/>
            <input type="email" name="userEmail" value="' . $result['email'] . '"/>
            <input type="password" name="userPassword" value="' . $result['pass'] . '"/>
                            <select  name="roomNumber" >
                                <option value="' . $result['roomNumber'] . '">"' . $result["roomNumber"] . '"</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
            <input type="file" name="profilePicture" />
            <input type="submit" class="button" name="update" value="Update"/>
        </form>
    </div>
</div>
</body>
</html>';
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $connect = null;
} else{
    header("Location:login.php");
}
