<?php
    include ('../../config.php');
    
    if (isset($_POST['subjectname'] )){
        $subjectname = $_POST['subjectname'];

        $query = "insert into tk_subjects (subjectname) values('$subjectname')";
        $result = mysqli_query($DB, $query) or die( exit(mysqli_error($DB)) );

        echo ' 1 subject added';
    }