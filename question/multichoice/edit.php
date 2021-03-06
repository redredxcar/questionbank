<?php
/*
 * ****************************************************
 * ** Yan Lao Shi Question Management System        ***
 * **-----------------------------------------------***
 * ** Developer: Wan Yongquan                       ***
 * ** Title: Choice  Question                       ***
 * ** Function: Add,Edit,Delete                     ***
 * ****************************************************
 */

/*
 * ***********************************************
 * ---------------*
 * PHP goes here  *
 * ---------------*
 
    Case 1: add new question
    Case 2: Edit a question
 *************************************************
 */
error_reporting(E_ALL);
?>
<?php require_once '../../config.php'; ?>
 
<?php require_once '../../includes/html_header.php'; ?>

<?php if (!loginRequired($_SERVER['REQUEST_URI'])){die();} ?>

<?php 
if (isset($_REQUEST['courseid'])){
    $courseid = $_REQUEST['courseid'];
}
if (isset($_REQUEST['qid'])){
    $qid = $_REQUEST['qid'];
}
$id = null;
$question_id = null;
$question_name = null;
$qbody = null;
$point = null;
$subject_id = null;
$difficultyLevelId = null;


global $DB;

if (isset( $courseid) ) {
    
    if (!empty($qid)){
        // --------------Case 2---- edit a existing question----------
        // get question details and show on page
        $result = getQuestionDetails($qid);
        if (! $result) {
            die(mysqli_error($DB));
        } else {
            $row = mysqli_fetch_assoc ( $result );
            $question_id = $row ['question_id'];
            
            $qbody = $row ['question_body'];
            $point = $row ['point'];
            $course_id = $row ['courseid'];
            $subject_id = $row ['subjectid'];
            $cognitionId = $row['cognitionid'];
            $difficultyLevelId = $row ['difficultylevel_id'];
            
            // get list of answers of this question
            $qanswers = getQuestionAnswers($qid);
        }
    }
}else{
    header("location:../../index.php", true, 303);
}
?>
    <div class="container body">
      <div class="main_container">
        <?php require_once $abs_doc_root.$qb_url_root.'/includes/menu.php';?>
        
        <!-- top navigation -->
        <?php   require_once $abs_doc_root.$qb_url_root."/includes/topnavigation.php";  ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                
                <div class="nav" style="float:left; font-size:16px;">
                   <ul class="breadcrumb">
                     <li class=""><i class="fa fa-home"></i> <a href="#"><?=get_string('home') ?></a></li>
                     <li class=""><a href="#"><?=get_string('editquestion') ?></a></li>
                   </ul>
                 </div>
              </div>

            </div>

            <div class="clearfix"></div>
           
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?=get_string('multichoice') ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <br>
                      <div class="class col-sm-12">
                         <form name="question_form" id="question_form" class="form-horizontal form-label-left" role="form" method="post" onsubmit="return onSubmitQForm();">
                           <input type="hidden" name="courseid" id="courseid" value="<?php echo $courseid?>">
                            <input type="hidden" name="questionid" id="questionid" value="<?php if (isset($qid)){echo $qid;}?>">
                           <input type="hidden" value="multichoice" name="qtype">
                           <input name="returnurl" type="hidden" value="<?=$qb_url_root ?>/question/admin_questions.php?courseid=<?=$courseid ?>" />
                                <div id="item_question_body" class="form-group">
                                   <label class="control-label col-md-2 col-sm-2 col-xs-12" >题干</label>
                                    <div class="col-sm-9 col-md-9 col-xs-12">
                                        <textarea id="question_body" name="question_body" rows="5" class="field  form-control" required><?php echo !empty($qbody) ? $qbody:''?></textarea>
                                        
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                  <div id="item_question_mark" class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" >分数</label>
                    <div class="col-sm-9 col-md-9 col-xs-12">
                        <input id="question_mark" name="question_mark" class="form-control" value="<?php echo !empty($point) ? $point: ''?>"></input>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-sm-3">
                        
                    </div>
                </div>
                    <div class="form-group ">
                       <label class="control-label col-md-2 col-sm-2 col-xs-12" >知识点</label> 
                        <div class="col-sm-9 col-md-9 col-xs-12">
                            <select id="qitem_subject_id" name="subject_id" class="form-control" required>
                                <option value="">--请选择知识点--</option>
                                <?php
                                $query = "select * from tk_subjects order by subjectname;";
                                
                                $result = $DB->query ( $query ) or die ( exit ( mysqli_error ( $DB ) ) );
                                
                                if ($result->num_rows > 0) {
                                    foreach ( $result as $row ) {
                                        $selected = ($subject_id == $row ['subject_id']) ? "selected" : "";
                                        echo '<option value="' . $row ['subject_id'] . '" ' . $selected . ' >' . $row ['subjectname'] . '</option>';
                                    }
                                }
                                ?>
                              </select>
                        </div>
                    </div>
                    <div class="form-group ">
                       <label class="control-label col-md-2 col-sm-2 col-xs-12" ><?=get_string('congnition') ?></label> 
                        <div class="col-sm-9 col-md-9 col-xs-12">
                            <select id="ques_cognitionid" name="ques_cognitionid" class="select2 form-control" required data-placeholder="请选择认知能力...">
                                <option value="">$nbsp;</option>
                                <?php
                                $cognitionData = getCognitions();

                                if ($cognitionData && $cognitionData->num_rows > 0) {
                                    foreach ( $cognitionData as $row ) {
                                        $selected = ($cognitionId == $row ['id']) ? "selected" : "";
                                        echo '<option value="' . $row ['id'] . '" ' . $selected . ' >' . $row ['CognitionName'] . '</option>';
                                    }
                                }
                                ?>
                              </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" >难度</label> 
                        <div class="col-sm-9 col-md-9 col-xs-12">
                            <select id="difficultylevel_list" name="difficultyLevel_id" class="form-control">
                                <option value="">--请选择难度--</option>
                                <?php
                                $difficultyData = getDifficultyLevels();
                                  
                                if ($difficultyData->num_rows > 0) {
                                    foreach ( $difficultyData as $row ) {
                                        $selected = ($difficultyLevelId == $row ['id']) ? "selected" : "";
                                        echo '<option value="' . $row ['id'] . '"' . $selected . ' >' . $row ['item_name'] . '</option>';
                                    }
                                }
                                ?>
                                </select>
                        </div>
                    </div>     
                  <fieldset>     
                  <legend>选项</legend>        
                      <div class="well" style="overflow:auto">  
                         <div id="option_a" class="form-group">
                           
                             <?php 
                             if (isset($qanswers)){
                               foreach ($qanswers as $vl){
                                   if ($vl['answerlabel'] == 'A'){
                                       $qanswerid_a = $vl['id'];
                                       $answertext_a = $vl['answer'];
                                       $iscorrect_a = $vl['iscorrectanswer'];
                                   }
                                   
                               }
                             }
                            ?>  
                               <label class="control-label col-md-2 col-sm-2 col-xs-12" >选项A</label>
                                 <input type="hidden" name="qanswer_a" value="<?=(!empty($qanswerid_a))?$qanswerid_a:'' ?>">
                                <div class="col-sm-9 col-md-9 col-xs-12">
                                    <input type="text" name="optiona" class="form-control" required 
                                    value="<?= (!empty($answertext_a))? $answertext_a:'' ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12" ></label>
                                 <div class="col-sm-9 col-md-9 col-xs-12">
                                    <label><input type="checkbox" id="is_correct_a" name="is_correct_a"  
                                    <?=(!empty($iscorrect_a))? "checked":'' ?>>本选项是正确答案</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                          </div>
                        </div>  
                    
                          <div id="option_b" class="form-group">
                            <div class="well" style="overflow:auto">
                           <?php 
                           if (isset($qanswers)){
                               foreach ($qanswers as $vl){
                                   if ($vl['answerlabel'] == 'B'){
                                       $qanswerid_b = $vl['id'];
                                       $answertext_b = $vl['answer'];
                                       $iscorrect_b = $vl['iscorrectanswer'];
                                   }
                                   
                               }
                           }
                            ?>   
                               <label class="control-label col-md-2 col-sm-2 col-xs-12" >选项B</label>
                                <input type="hidden" name="qanswer_b" value="<?=(!empty($qanswerid_b))?$qanswerid_b:'' ?>">
                                <div class="col-sm-9 col-md-9 col-xs-12">
                                    <input type="text" name="optionb" class="form-control" required 
                                    value="<?= !empty($answertext_b)? $answertext_b:'' ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12" ></label>
                                 <div class="col-sm-9 col-md-9 col-xs-12">
                                    <label><input type="checkbox" id="is_correct_b" name="is_correct_b" 
                                    value="B" <?= !empty($iscorrect_b)? "checked":'' ?>>本选项是正确答案</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                             </div>
                          </div>  
                          <div id="option_c" class="form-group">
                            <div class="well" style="overflow:auto">
                                <?php 
                                if (isset($qanswers)){
                                   foreach ($qanswers as $vl){
                                       if ($vl['answerlabel'] == 'C'){
                                           $qanswerid_c = $vl['id'];
                                           $answertext_c = $vl['answer'];
                                           $iscorrect_c = $vl['iscorrectanswer'];
                                       }
                                       
                                   }
                                }
                                ?> 
                               <label class="control-label col-md-2 col-sm-2 col-xs-12" >选项C</label>
                                <input type="hidden" name="qanswer_c" value="<?=(!empty($qanswerid_c))?$qanswerid_c:'' ?>">
                                <div class="col-sm-9 col-md-9 col-xs-12">
                                    <input type="text" name="optionc" class="form-control" required
                                    value="<?= !empty($answertext_c)? $answertext_c:'' ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12" ></label>
                                 <div class="col-sm-9 col-md-9 col-xs-12">
                                    <label><input type="checkbox" id="is_correct_c" name="is_correct_c" value="C" 
                                    <?= !empty($iscorrect_c)? "checked":'' ?>>本选项是正确答案</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                              </div>
                          </div>  
                          <div id="option_d" class="form-group">
                            <div class="well" style="overflow:auto">
                                <?php
                                if (isset($qanswers)){
                                   foreach ($qanswers as $vl){
                                       if ($vl['answerlabel'] == 'D'){
                                           $qanswerid_d = $vl['id'];
                                           $answertext_d = $vl['answer'];
                                           $iscorrect_d = $vl['iscorrectanswer'];
                                       }
                                       
                                   }
                                }
                                ?> 
                               <label class="control-label col-md-2 col-sm-2 col-xs-12" >选项D</label>
                                <input type="hidden" name="qanswer_d" value="<?=(!empty($qanswerid_d))?$qanswerid_d:'' ?>">
                                <div class="col-sm-9 col-md-9 col-xs-12">
                                    <input type="text" name="optiond" class="form-control" required
                                    value="<?=!empty($answertext_d)? $answertext_d:'' ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12" ></label>
                                 <div class="col-sm-9 col-md-9 col-xs-12">
                                    <label><input type="checkbox" id="is_correct_d" name="is_correct_d" value="D"
                                    <?= !empty($iscorrect_d)? "checked":'' ?> >本选项是正确答案</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                              </div>
                          </div>   
                </fieldset>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" name="savechoice" class="btn btn-primary">保存</button>
                                <a class="btn btn-warning" href="<?php echo $qb_url_root?>/question/admin_questions.php?courseid=<?=$courseid ?>">Cancel</a>
                            </div>
                        </div>
                    </form>
                    
                      </div>
                     
                      
                  </div><!-- /x_content -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <?php echo get_string('title'); ?> 技术支持：Wan Yongquan
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo $qb_url_root?>/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $qb_url_root?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $qb_url_root?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo $qb_url_root?>/vendors/nprogress/nprogress.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo $qb_url_root?>/js/custom.min.js"></script>
    
    <!-- Form validation JavaScript -->
    <script src="<?=$qb_url_root?>/script/form-validator.min.js" type="text/javascript"></script>
    <script src="../../lib/bootstrapValidator/js/bootstrapValidator.js" type="text/javascript"></script>
    <script src="<?=$qb_url_root?>/lib/jqueryvalidation/jquery.validate.js" type="text/javascript"></script>
    
    <script src="<?php echo $qb_url_root?>/vendors/select2/dist/js/select2.full.min.js"></script>
    
    <script src="formutil.js" type="text/javascript"></script>
  </body>
</html>

