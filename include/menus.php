<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div id="navbar" class="navbar-collapse collapse">

    <ul class="nav navbar-nav">
        <li ><a href="#">首页</a></li>
        <li><a href="#">About</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">基本数据管理<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $CFG->wwwroot.'/course/course.php'?>">课程管理</a></li>
                <li><a href="">知识点管理</a></li>

            </ul>
        </li>
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">题目管理<span class="caret"></a>
            <ul class="dropdown-menu">
                <li><a href="">浏览题目</a></li>
                <li><a href="">录入题目</a></li>
                <li><a href="">修改题目</a></li>

            </ul>
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">组卷规则管理<span class="caret"></a>
            <ul class="dropdown-menu">
                <li><a href="">浏览规则</a></li>
                <li><a href="">录入规则</a></li>
                <li><a href="">修改规则</a></li>

            </ul>
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">组卷<span class="caret"></a>
            <ul class="dropdown-menu">
                <li><a href="">浏览试卷</a></li>
                <li><a href="">组卷</a></li>
                <li><a href="">修改试卷</a></li>

            </ul>
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">账户管理<span class="caret"></a>
            <ul class="dropdown-menu">
                <li><a href="">个人资料</a></li>
                <li><a href="">修改密码</a></li>
            </ul>
        </li>
    </ul>
        <?php if (isset($_SESSION['username'])){?>
            <ul class="nav navbar-nav navbar-right">
                <li><input type="submit" value="注销" name="logout"
                    class="btn btn-lg btn-primary btn-block" />
            
            </ul>
            <?php }?>
        </div>
    </div>
</nav>