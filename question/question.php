<?php 
    include_once '../config.php';
    
    include_once '../session.php';
    error_reporting(1);
    
?>
<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
     <!-- the above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $CFG->wwwroot.'/bootstrap/css/bootstrap.min.css'?>" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/nav-sidebar.css" rel="stylesheet">
    <link href="../css/footer.css" rel="stylesheet">
    <title>Question Bank </title>     
    </head>
    <body>
    <?php if (isset($_SESSION['username'])){
         include '../include/menus.php';
        }?>
        
       <div class="container">
        <div class="page-question">
            <h2>试题</h2>
            <div><button class="btn btn-success" data-toggle="modal" data-target="#choose_questiontype_modal" data-backdrop="false">新增试题</button>
            </div>
            <div class="question_content">
                <!-- question content table starts here -->
            </div>
        </div>
        
       </div>
       <!--  Modal dialog for add question -->
        <div id="choose_questiontype_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!--  Modal dialog content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">选择题型</h4>
                    </div>
                    <div class="modal-body">
                    <form id="choose_questiontype_form" action="multichoice/edit.php" method="post" class="form-horizontal" role="form" data-toggle="validator">
                        
                          <div class="row">
                            <div class="col-sm-5 col-md-5 ">
                            <div class="sidebar-nav">
                            <div class="navbar navbar-default " role="navigation">
                             
                              <div id="typeoptions" class="navbar-collapse collapse sidebar-navbar-collapse">
                              <ul class="nav navbar-nav">
                                <li class="active">
                                  <label><input id="option1" type="radio" name="questiontype" value="multichoice">
                                    <span class="typename">选择题</span>
                                    
                                  </label>
                                </li>
                                <li class="">
                                  <label><input id="option2" type="radio" name="questiontype"  value="truefalse">
                                  <span class="typename">判断题</span></label>
                                </li>
                                <li class="">
                                  <label><input id="option3" type="radio" name="questiontype"  value="shortanswer">
                                  <span class="typename">填空题</span></label>
                                </li>
                                <li class="">
                                  <label><input id="option4" type="radio" name="questiontype" value="essay">
                                  <span class="typename">简答题</span></label>
                                </li>
                                <li class="">
                                  <label><input id="option5" type="radio" name="questiontype" value="genaral">
                                  <span class="typename">综合题</span></label>
                                </li>
                              </ul>
                              </div>
                              </div>
                            </div>
                            </div>
                            <div class="col-sm-7  col-md-7 main">
                              <div >
                                
                                <div class="summarycontent option1">从预先定义的选项中选择一个或多个做为答案。</div>
                                
                                <div class="summarycontent option2">判断题目的正确或错误</div>
                                <div class="summarycontent option3">在空白处填入正确答案</div>
                                <div class="summarycontent option4">根据题目回答</div>
                                <div class="summarycontent option5">综合题目</div>
                              </div>
                              
                            </div>
                          </div>
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnAddQuestion">添加</button>
                        
                    </div> <!-- End of modal footer -->
                </div><!-- End of modal content -->
            </div> <!-- End of modal dialog -->
          </div> <!-- End of Modal  -->
     <footer class="footer">
      <div class="container">
        <p class="text-muted">Copyright.</p>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../script/form-validator.min.js" type="text/javascript"></script>
    <script src="question.js" type="text/javascript"></script>   
    </body>
</html>