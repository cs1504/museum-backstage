<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"/Applications/XAMPP/xamppfiles/htdocs/think/public/../application/index/view/index/index.html";i:1522569436;s:78:"/Applications/XAMPP/xamppfiles/htdocs/think/application/common/view/frame.html";i:1522582385;s:77:"/Applications/XAMPP/xamppfiles/htdocs/think/application/common/view/base.html";i:1522563191;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/static/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/static/css/lineicons/style.css">


    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/style-responsive.css">

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<section id="container" >

    

<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <!--logo start-->
    <a href="index" class="logo"><b>博物馆后台管理系统</b></a>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                    <i class="fa fa-tasks"></i>
                    <span class="badge bg-theme">4</span>
                </a>
                <ul class="dropdown-menu extended tasks-bar">
                    <div class="notify-arrow notify-arrow-green"></div>
                    <li>
                        <p class="green">You have 4 pending tasks</p>
                    </li>
                    <li>
                        <a href="index.html#">
                            <div class="task-info">
                                <div class="desc">DashGum Admin Panel</div>
                                <div class="percent">40%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="index.html#">
                            <div class="task-info">
                                <div class="desc">Database Update</div>
                                <div class="percent">60%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="index.html#">
                            <div class="task-info">
                                <div class="desc">Product Development</div>
                                <div class="percent">80%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    <span class="sr-only">80% Complete</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="index.html#">
                            <div class="task-info">
                                <div class="desc">Payments Sent</div>
                                <div class="percent">70%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                    <span class="sr-only">70% Complete (Important)</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="external">
                        <a href="#">See All Tasks</a>
                    </li>
                </ul>
            </li>
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <li id="header_inbox_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-theme">5</span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <div class="notify-arrow notify-arrow-green"></div>
                    <li>
                        <p class="green">You have 5 new messages</p>
                    </li>
                    <li>
                        <a href="index.html#">
                            <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                            <span class="subject">
                                    <span class="from">Zac Snider</span>
                                    <span class="time">Just now</span>
                                    </span>
                            <span class="message">
                                        Hi mate, how is everything?
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="index.html#">
                            <span class="photo"><img alt="avatar" src="assets/img/ui-divya.jpg"></span>
                            <span class="subject">
                                    <span class="from">Divya Manian</span>
                                    <span class="time">40 mins.</span>
                                    </span>
                            <span class="message">
                                     Hi, I need your help with this.
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="index.html#">
                            <span class="photo"><img alt="avatar" src="assets/img/ui-danro.jpg"></span>
                            <span class="subject">
                                    <span class="from">Dan Rogers</span>
                                    <span class="time">2 hrs.</span>
                                    </span>
                            <span class="message">
                                        Love your new Dashboard.
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="index.html#">
                            <span class="photo"><img alt="avatar" src="assets/img/ui-sherman.jpg"></span>
                            <span class="subject">
                                    <span class="from">Dj Sherman</span>
                                    <span class="time">4 hrs.</span>
                                    </span>
                            <span class="message">
                                        Please, answer asap.
                                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="index.html#">See all messages</a>
                    </li>
                </ul>
            </li>
            <!-- inbox dropdown end -->
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-menu">
        <ul class="nav pull-right top-menu">
            <li><a class="logout" href="logout">Logout</a></li>
        </ul>
    </div>
</header>


    

<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="profile"><img src="<?php echo $admin['avatar']; ?>" class="img-circle" width="60"></a></p>
            <h5 class="centered"><?php echo $admin['nickname']; ?></h5>

            <li class="mt">
                <a class="active" href="index">
                    <i class="fa fa-dashboard"></i>
                    <span>首页</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-tasks"></i>
                    <span>博物馆管理</span>
                </a>
                <ul class="sub">
                    <li><a  href="general.html">查看和修改博物馆信息</a></li>
                    <li><a  href="buttons.html">添加博物馆信息</a></li>
                    <li><a  href="panels.html">删除博物馆信息</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-tasks"></i>
                    <span>展览管理</span>
                </a>
                <ul class="sub">
                    <li><a  href="calendar.html">查看和修改展览信息</a></li>
                    <li><a  href="gallery.html">添加展览</a></li>
                    <li><a  href="todo_list.html">删除展览</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-tasks"></i>
                    <span>音频管理</span>
                </a>
                <ul class="sub">
                    <li><a  href="blank.html">审核管理</a></li>
                    <li><a  href="login.html">修改音频信息</a></li>
                    <li><a  href="lock_screen.html">删除音频</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-tasks"></i>
                    <span>评论管理</span>
                </a>
                <ul class="sub">
                    <li><a  href="form_component.html">查看最近评论</a></li>
                    <li><a  href="form_component.html">修改评论</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-user"></i>
                    <span>用户管理</span>
                </a>
                <ul class="sub">
                    <li><a  href="basic_table.html">查看用户信息</a></li>
                    <li><a  href="responsive_table.html">修改用户信息</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class=" fa fa-bar-chart-o"></i>
                    <span>管理员信息管理</span>
                </a>
                <ul class="sub">
                    <li><a  href="morris.html">查看管理员</a></li>
                    <li><a  href="chartjs.html">修改管理员信息</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class=" fa fa-bar-chart-o"></i>
                    <span>配置项管理</span>
                </a>
                <ul class="sub">
                    <li><a  href="morris.html">查看配置项</a></li>
                    <li><a  href="chartjs.html">修改配置项</a></li>
                    <li><a  href="chartjs.html">数据库备份</a></li>
                </ul>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>


    
<section id="main-content">
    <section class="wrapper site-min-height">
        <h3><i class="fa fa-angle-right"></i> 数据总览</h3>
        <div class="row mt">
            <div class="col-md-4 mt">
                <div class="content-panel centered">
                    共有博物馆<h1 class="inline-block"><?php echo $count['museum']; ?></h1>家
                </div>
            </div>
            <div class="col-md-4 mt">
                <div class="content-panel centered">
                    共有展览<h1 class="inline-block"><?php echo $count['exhibition']; ?></h1>场
                </div>
            </div>
            <div class="col-md-4 mt">
                <div class="content-panel centered">
                    共有新闻<h1 class="inline-block"><?php echo $count['news']; ?></h1>条
                </div>
            </div>
            <div class="col-md-4 mt">
                <div class="content-panel centered">
                    共有音频<h1 class="inline-block"><?php echo $count['audio']; ?></h1>个
                </div>
            </div>
            <div class="col-md-4 mt">
                <div class="content-panel centered">
                    共有用户<h1 class="inline-block"><?php echo $count['user']; ?></h1>人
                </div>
            </div>
        </div>
        <h3><i class="fa fa-angle-right"></i> 服务器监控</h3>
        <div class="row mt">

        </div>
    </section><!-- /wrapper -->
</section><!-- /MAIN CONTENT -->





    
<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        2018 - BUCT CS1504
        <a href="index.html#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->


</section>

<script src="/static/js/jquery.scrollTo.min.js"></script>
<script src="/static/js/jquery.nicescroll.js"></script>
<script src="/static/js/jquery.sparkline.js"></script>
<script src="/static/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="/static/js/common-scripts.js"></script>

</body>
</html>