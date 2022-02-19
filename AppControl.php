<?php
require("DBControl.php");
$databaseControl = new DBControl();
$ERRORS["status"] = "success";

////delete form DB
if (isset($_REQUEST["delete"])) {
    $databaseControl->deleteFromDB("id={$_REQUEST["id"]}");
}
//update
if (isset($_REQUEST["update"])) {
    $databaseControl->updateDB("id={$_REQUEST["id"]}", $_FILES['profilePicture'],
        [$_REQUEST["userName"], $_REQUEST["userEmail"], $_REQUEST["userPassword"], $_REQUEST["roomNumber"], $_FILES["profilePicture"]["name"]]);
}
//show from DB
if (isset($_REQUEST["show"])) {
    $result = $databaseControl->showDB(" id={$_REQUEST["id"]}");
    header("Location:show.php?show&data=" . $result);
}

//for login
if (isset($_REQUEST["login"])) {
//    $emailPattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
    $userEmail = strtolower($_REQUEST['userEmailLogin']);
    $userPassword = $_REQUEST['userPasswordLogin'];

    $result = $databaseControl->loginCheck($userEmail, $userPassword);

    //checking email
    if (empty(trim($userEmail))) {
        $ERRORS["status"] = "failure";
        $ERRORS["emailError"] = "Please Check You've Entered Your Email";
    } else {
        if ($userEmail != $result["email"]) {
            $ERRORS["status"] = "failure";
            $ERRORS["emailError"] = "This email does not exist";
        }
        //checking password
        if (empty(trim($userPassword))) {
            $ERRORS["status"] = "failure";
            $ERRORS["passError"] = "Please Check You've Entered Your Password";
        } else {
            if ($userPassword != $result["pass"] && strlen($userPassword) <= 8) {
                $ERRORS["status"] = "failure";
                $ERRORS["passError"] = "Invalid Password";
            }
        }
    }
    if ($ERRORS["status"] == "success") {
        setcookie("login", "login");
        header("Location:home.php?backToHome");
    } else {
        setcookie("emailError", $ERRORS["emailError"], time() + 3600);
        setcookie("passError", $ERRORS["passError"], time() + 3600);
        header("Location:login.php");
    }
}
//for signup
if (isset($_REQUEST["signup"])) {
    $emailPattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
    //for username
    if (empty(trim($_REQUEST["userName"]))) {
        $ERRORS["status"] = "failure";
        $ERRORS["userNameError"] = "Please Check You've Entered your name";
    }
    if (strlen($_REQUEST["userName"]) <= 3) {
        $ERRORS["status"] = "failure";
        $ERRORS["userNameError"] = "Please Check You've name is larger than 3 character ";
    }
    //for email
    if (empty(trim($_REQUEST["userEmail"]))) {
        $ERRORS["status"] = "failure";
        $ERRORS["emailError"] = "Please Check You've Entered your email";
    } else {
        if (!filter_var(trim($_REQUEST["userEmail"]), FILTER_VALIDATE_EMAIL) //first one user filter
//        || preg_match($emailPattern,$userEmail)
        ) {//second one used pattern
            $ERRORS["status"] = "failure";
            $ERRORS["emailError"] = "Invalid email format";
        }
    }
    //for Password
    if (empty(trim($_REQUEST["userPassword"]))) {
        $ERRORS["status"] = "failure";
        $ERRORS["passError"] = "Please Check You've Entered your Password";
    } else {
        if (strlen(trim($_REQUEST["userPassword"])) <= 8) {
            $ERRORS["status"] = "failure";
            $ERRORS["passError"] = "Your Password Must Contain At Least 8 Characters";
        } elseif (!preg_match("#[0-9]+#", trim($_REQUEST["userPassword"]))) {
            $ERRORS["status"] = "failure";
            $ERRORS["passError"] = "Your Password Must Contain At Least 1 Number";
        } elseif (!preg_match("#[A-Z]+#", trim($_REQUEST["userPassword"]))) {
            $ERRORS["status"] = "failure";
            $ERRORS["passError"] = "Your Password Must Contain At Least 1 Capital Letter";
        } elseif (!preg_match("#[a-z]+#", trim($_REQUEST["userPassword"]))) {
            $ERRORS["status"] = "failure";
            $ERRORS["passError"] = "Your Password Must Contain At Least 1 Lowercase Letter";
        }
    }
    //for conformPassword
    if (trim($_REQUEST["userPassword"]) != trim($_REQUEST["conformPassword"])) {
        $ERRORS["status"] = "failure";
        $ERRORS["conformPassError"] = "Please Check You've Entered confirmed Password like password";
    }

    if ($ERRORS["status"] == "success") {
        $databaseControl->addNewUser($_FILES['profilePicture'],
            [$_REQUEST["userName"], $_REQUEST["userEmail"], $_REQUEST["userPassword"], $_REQUEST["roomNumber"], $_FILES["profilePicture"]["name"]]);
        header("Location:login.php");
    } else {
        setcookie("userNameError", $ERRORS["userNameError"], time() + 3600);
        setcookie("emailError", $ERRORS["emailError"], time() + 3600);
        setcookie("passError", $ERRORS["passError"], time() + 3600);
        setcookie("conformPassError", $ERRORS["conformPassError"], time() + 3600);
        header("Location:singUp.php");
    }
}

