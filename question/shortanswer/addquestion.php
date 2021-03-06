<?php
    
    require_once '../../config.php';
    require_once '../../lib/datelib.php';
    // get the form data submited by POST
    $courseId = $_POST['courseid'];
    $returnurl = $_POST['returnurl'];
    if (isset($_POST['qtype']) && isset($_POST['question_body'])){
        $qtype= $_POST['qtype'];
        $question_body= $_POST['question_body'];
        $subject_id = $_POST['subject_id'];
        $difficultyLevel_id = $_POST['difficultyLevel_id'];
        $question_mark = $_POST['question_mark'];
        $user_id = $user->_id;

            // start the transaction
            $DB->autocommit(false);

            // step1: insert question to table tk_questions and tk_questionmultichoise
            $now = getCurrentDatetime(); // Month, day, year, hour, minute,second
            //$query = "insert into tk_questions (question_name,question_body, point, difficultylevel_id, qtype, createdDate, createdBy)
            //                values('$question_name','$question_body',$question_mark , $difficultyLevel_id , '$qtype', '$now', $user_id);";
            $query = "insert into tk_questions (question_body, point, ";
            $query .= " courseid, subjectid,";
            $query .= " difficultylevel_id, qtype, createdDate, creatorId)";
            $query .= " values('$question_body',$question_mark ,";
            $query .= $courseId ."," . $subject_id .",";
            $query .= " $difficultyLevel_id , '$qtype', '$now', $user_id);";
            
            $result = mysqli_query($DB, $query) or die(exit(mysqli_error($DB)));
            $question_id =  $DB->insert_id;

            // step2: insert question answer options info into tk_question_answers;
            $stmt = $DB->prepare(" insert into tk_question_answers(question_id, answer, iscorrectanswer, answerlabel)
                    values( ?, ?, ?, 'A')");
            $stmt->bind_param("isss", $question_id, $answer_option, $option_is_true_answer);
            // option1
            $answer_option = $_POST['answer'];
            $option_is_true_answer = isset($_POST['is_correct'])?true:false;
            $stmt->execute();

            $stmt->close();
            $DB->commit();
            
            header("location:$returnurl", true, 303);


    }