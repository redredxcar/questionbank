<?php

    include_once '../../config.php';

    include_once '../../session.php';
    include_once '../lib.php';

    if (isset($_SESSION['questiontype'])){
        $questiontype = $_SESSION['questiontype'];
    }

    $questionId = null;
    $question_name= null;
    $question_answer=null;
    if (!empty($_GET['id'])){
        $questionId = $_REQUEST['id'];
    }

    if (null != $questionId ){
        // for edit a existing question
        // get question details and show on page
        
        $result = getQuestionInfo($questionId);
        if (!$result ){
            //error
        }else{
            $row = mysqli_fetch_assoc($result);
            $question_id= $row['question_id'];
            $question_name= $row['question_name'];
            $qbody = $row['question_body'];
            
            $point = $row['point'];
            $subject_id= $row['subject_id'];
            $$difficultylevelIdevelId = $row['difficultylevel_id'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require '../../include/header.php';
    ?>
    </head>
<body class="no-skin">
     <?php
    require_once '../../include/navigation.php';
    ?>
    <div class="main-container ace-save-state" id="main-container"> 
        <script type="text/javascript">
            try{ace.settings.loadState('main-container')}catch(e){}
        </script>
        <div id="sidebar" class="sidebar responsive ace-save-state">
            <script type="text/javascript">
                try{ace.settings.loadState('sidebar')}catch(e){}
            </script>
            <ul class="nav nav-list">
                <li class="">
                    <a href="<?php echo $qb_url_root?>/index2.php"> <i class="menu-icon fa fa-tachometer"></i> <span class="menu-text">Dashboard</span>
                    </a> <b class="arrow"></b>
                </li>
                <?php if ($user->isLoggedIn() ){ //if logged in?>
                <li class="">
                    <a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-right"></i><span class="menu-text">我的课程</span><b class="arrow fa fa-angle-down"></b></a>
                    <b class="arrow"></b> 
                    <!-- todo: course list -->
                    <ul class="submenu">
                    <?php $allCourses = getAllCourses ();
                          foreach ( $allCourses as $course ) {?>
                          <li class="">
                            <a href="<?php echo $qb_url_root.'/question/question.php?courseid='.$course['course_id']?>"><i class="menu-icon fa fa-caret-right"></i><?php echo $course['course_name']?></a>
                            <b class="arrow"></b>
                          </li>
                    <?php }?>
                    </ul>
                </li>
                <?php }?>
                <li class="">
                    <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-desktop"></i> <span class="menu-text">系统管理</span> <b class="arrow fa fa-angle-down"></b>
                    </a> <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="">
                            <a href="<?php echo $qb_url_root?>/course/course.php"> <i class="menu-icon fa fa-caret-right"></i> 课程 
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="#"> <i class="menu-icon fa fa-caret-right"></i> 用户
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="active open">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-list"></i><span class="menu-text">课程管理</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a> 
                    <b class="arrow"></b>
                    <ul class="submenu">
                            <li class="">
                                <a href="<?=$qb_url_root?>/subject/subject.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    知识点
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="active">
                                <a href="<?php echo $qb_url_root.'/question/question.php?courseid=5'?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    题库
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="<?=$qb_url_root?>/rule/view.php">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    组卷规则
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                </li>
            </ul>
            <!-- /.nav-list -->
            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>
        </div>
        <!-- /.sidebar -->
        <div class="main-content">
            <div class="main-content-inner">
                 <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="ace-icon fa fa-home home-icon"></i>
                            <a href="#">首页</a>
                        </li>
                        <li>
                            <a href="#">课程管理</a>
                        </li>
                        <li>
                            <a href="#">course_name</a>
                        </li>
                        <li class="active">short anwser</li>
                    </ul>
                </div>
                <!-- /.breadcrumbs -->
                <div class="page-content">
                    <div class="page-header">
                        <h1>填空<small><i class="ace-icon fa fa-angle-double-right"></i>course_name</small></h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <form name="question_form" id="question_form" class="form-horizontal" role="form" method="post" onsubmit="return onSubmitQForm();" data-toggle="validator">
                                <fieldset>
                                    <legend>概要</legend>
                                    <input type="hidden" name="hidden_question_id" id="hidden_question_id" value="<?php echo (!empty($questionId) ? $questionId: '')?>">
                                    <div id="item_question_name" class="form-group">
                                        <div class="col-sm-2 control-label">
                                            <label for="question_name">题目名称</label>
                                        </div>
                                        <div class="col-sm-8 col-lg-8">
                                            <input id="question_name" name="question_name" class="form-control" required value="<?php echo !empty($question_name) ? $question_name: ''?>"></input>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div id="item_question_body" class="form-group">
                                        <div class="col-sm-2 control-label">
                                            <label for="question_text">题干</label>
                                        </div>
                                        <div class="col-sm-8 col-lg-8">
                                            <textarea id="question_body" name="question_body" class="field  form-control" rows="5" required><?php echo !empty($qbody) ? $qbody:'';?></textarea>
                                            <input type="hidden" value="fillblank" name="qtype">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div id="qitem_course" class="form-group">
                                        <div class="col-sm-2 control-label">
                                            <label for="question_mark">课程</label>
                                        </div>
                                        <div class="col-sm-8 col-lg-8">
                                            <select id="qitem_course_id" name="qitem_course_id" class="form-control ">
                                                <option value="">--请选择课程--</option>
                <?php
                $courses = getCourses ();
                if ($courses->num_rows > 0) {
                    foreach ( $courses as $course ) {
                        $courseselected = ($course_id == $course ['course_id']) ? "selected" : "";
                        echo '<option value="' . $course ['course_id'] . '" ' . $courseselected . ' >' . $course ['course_name'] . '</option>';
                    }
                }
                ?>    
                </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-sm-2 control-label">
                                            <label for="subject_list">知识点</label>
                                        </div>
                                        <div class="col-sm-8 col-lg-8">
                                            <select id="subject_list" name="subject_id" class="form-control">
                                                
                                                <option value="">--请选择知识点--</option>
                <?php
                $query = "select * from tk_subjects order by subject_id;";
                
                $result = $DB->query ( $query ) or die ( exit ( mysqli_error ( $DB ) ) );
                
                if ($result->num_rows > 0) {
                    foreach ( $result as $row ) {
                        $selected = ($subject_id == $row ['subject_id']) ? "selected" : "";
                        echo '<option value="' . $row ['subject_id'] . '" ' . $selected . ' >' . $row ['subject_name'] . '</option>';
                    }
                }
                ?>
                </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label">
                                            <label for="difficultylevel_list">难度</label>
                                        </div>
                                        <div class="col-sm-8 col-lg-8">
                                            <select id="difficultylevel_list" name="difficultyLevel_id" class="form-control">
                                                <option value="">--请选择难度--</option>
                <?php
                $query = 'select * from vw_difficultylevels';
                
                $result = $DB->query ( $query ) or die ( exit ( mysqli_error ( $DB ) ) );
                
                if ($result->num_rows > 0) {
                    foreach ( $result as $row ) {
                        $selected = ($difficultylevel_id == $row ['dictionary_id']) ? "selected" : "";
                        echo '<option value="' . $row ['dictionary_id'] . '"' . $selected . ' >' . $row ['dictionary_value'] . '</option>';
                    }
                }
                ?>
                </select>
                                        </div>
                                    </div>
                                    <div id="item_question_mark" class="form-group">
                                        <div class="col-sm-2 control-label">
                                            <label for="question_mark">分数</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input id="question_mark" name="question_mark" class="form-control" value="<?php echo !empty($point) ? $point: ''?>"> 
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>答案</legend>
                                    <div id="item_question_answer1" class="form-group">
                                        <div class="col-sm-2 control-label">
                                            <label for="answer_content1">答案1</label>
                                        </div>
                                        <div class="col-sm-8 col-lg-8">
                                            <textarea id="answer_content1" name="answer_content1" class="field  form-control" rows="5" required><?php echo !empty($question_answer) ? $question_answer:'';?></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <button type="submit" class="btn btn-success">保存</button>
                                        <button type="button" class="btn btn-default" onclick="history.back();">取消</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->
            </div>
        </div>
        <!-- /.main-content -->
    </div>
    <!-- /.main-container -->
   
    <?php
    require '../../include/scripts.php';
    ?>
    <!--  custom javascript -->
    <script src="../../lib/jqueryvalidation/jquery.validate.js" type="text/javascript"></script>
    <script src="../../lib/bootstrapValidator/js/bootstrapValidator.js" type="text/javascript"></script>
  </body>
</html>