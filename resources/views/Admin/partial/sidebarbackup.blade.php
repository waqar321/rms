<div class="col-md-3 left_col menu_fixed mCustomScrollbar _mCS_1 mCS-autoHide">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <!-- <a href="{{ url_secure('') }}" class="site_title">   <img src="<?php echo url_secure('build/images/logo/LCS-logo1.png'); ?>" alt="..." class="profile_img" width="65%"></a> -->
            <a href="{{ url_secure('') }}" class="site_title">  <h1 style="font-weight: bold;color: #343a40;">L M S</h1></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <!-- <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo url_secure('build/images/logo/logo-removebg-preview.png'); ?>" alt="..." class="img-circle profile_img" style="height: 55px;">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo auth()->user()->username ?></h2>
            </div>
        </div> -->
        <!-- /menu profile quick info -->

        <br />
    <?php
    $segments = request()->segments();

    $uri_segment_1 = isset($segments[0]) ? $segments[0] : null;
    $uri_segment_2 = isset($segments[1]) ? $segments[1] : null;
    ?>
    <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="<?php echo url_secure('/dashboard') ?>">
                            <i class="fa fa-home"></i> Dashboard
                        </a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo url_secure('/manage_user') ?>">
                            <i class="fa fa-group"></i> User
                        </a>
                    </li> -->

                    <li class="side-bar-menus" data-module-id="4"><a><i class="fa fa-group"></i> Manage Users <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li data-sub-module-id="20" data-screen-permission-id="91"><a href="<?php echo url_secure('/manage_user') ?>">Users</a></li>
                            <li data-sub-module-id="21" data-screen-permission-id="96"><a href="<?php echo url_secure('/manage_user/roles/index') ?>">Roles</a></li>
                            <!-- <li data-sub-module-id="21" data-screen-permission-id="96"><a href="<?php echo url_secure('/manage_user/roles/merchant/index') ?>">Merchant Roles</a></li> -->
                        </ul>
                    </li>
                    <!-- <li class="side-bar-menus" data-module-id="3"><a><i class="fa fa-group"></i> Manage Clients <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li data-sub-module-id="18" data-screen-permission-id="73"><a href="<?php echo url_secure('/manage_client/merchant') ?>">Manage Clients</a></li>
                            <li data-sub-module-id="51" data-screen-permission-id="178"><a href="<?php echo url_secure('/manage_client/client') ?>">Client User</a></li>
                            <li data-sub-module-id="15" data-screen-permission-id="60"><a href="<?php echo url_secure('/manage_client/shipper') ?>">Manage Shipper</a></li>
                            <li data-sub-module-id="16" data-screen-permission-id="65"><a href="<?php echo url_secure('/manage_client/consignee') ?>">Manage Consignee</a></li>
                            <li data-sub-module-id="19" data-screen-permission-id="79"><a href="<?php echo url_secure('/manage_client/material') ?>">Packing Material</a></li>
                            <li data-sub-module-id="28" data-screen-permission-id="84"><a href="<?php echo url_secure('/manage_client/material/assignment') ?>">Material Assignment</a></li>
                            <li data-sub-module-id="29" data-screen-permission-id="90"><a href="<?php echo url_secure('/manage_client/batch/index') ?>">Batch Update</a></li>
                            <li data-sub-module-id="17" data-screen-permission-id="70"><a href="<?php echo url_secure('/manage_client/merchant/request') ?>">Account Opening Request</a></li>
                        </ul>
                    </li> -->

                    <!-- New Menu Item for Category Management -->
                    <li>
                        <a><i class="fa fa-folder"></i> Manage Category <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo url_secure('/category-management/category/') ?>">Category</a></li>
                            <!-- Add more submenu items related to content management -->
                            <li><a href="<?php echo url_secure('/category-management/sub_category/') ?>">Sub Category</a></li>
                            <!-- Add more submenu items if needed -->
                        </ul>
                    </li>

                    <!-- New Menu Item for Student  Management -->
                    <li>
                        <a href="<?php echo url_secure('/student-management/student/') ?>">
                            <i class="fa fa-folder"></i> Students
                        </a>
                    </li>
                    <!-- New Menu Item for Teachers  Management -->
                    <li>
                        <a href="<?php echo url_secure('/teacher-management/teacher/') ?>">
                            <i class="fa fa-folder"></i> Teachers
                        </a>
                    </li>
                    
                    <!-- New Menu Item for Content Management -->
                    <li>
                        <a href="<?php echo url_secure('/content-management/course/') ?>">
                            <i class="fa fa-folder"></i> Courses
                        </a>
                    </li>
<!-- 
                    <li>
                        <a><i class="fa fa-folder"></i> Manage Courses <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo url_secure('/content-management/course/') ?>">Courses</a></li>
                            <li><a href="<?php echo url_secure('/lecture-videos') ?>">Lecture Videos</a></li>
                            <li><a href="<?php echo url_secure('/documents') ?>">Documents</a></li>
                            <li><a href="<?php echo url_secure('/assessments') ?>">Assessments</a></li> 
                        </ul>
                    </li> -->
                    <!-- Reporting and Analytics Menu -->
                    <!-- <li>
                        <a><i class="fa fa-bar-chart"></i> Reporting & Analytics <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo url_secure('/completion-rates') ?>">Course Completion Rates</a></li>
                            <li><a href="<?php echo url_secure('/assessment-scores') ?>">Assessment Scores</a></li>
                            <li><a href="<?php echo url_secure('/employee-feedback') ?>">Employee Feedback</a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a><i class="fa fa-desktop"></i> Turtorials <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo url_secure('/tutorials') ?>" target="_blank">Video Tutorials</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <!--        <div class="sidebar-footer hidden-small">-->
        <!--            <a data-toggle="tooltip" data-placement="top" title="Settings">-->
        <!--                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>-->
        <!--            </a>-->
        <!--            <a data-toggle="tooltip" data-placement="top" title="FullScreen">-->
        <!--                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>-->
        <!--            </a>-->
        <!--            <a data-toggle="tooltip" data-placement="top" title="Lock">-->
        <!--                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>-->
        <!--            </a>-->
        <!--            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">-->
        <!--                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>-->
        <!--            </a>-->
        <!--        </div>-->
        <!-- /menu footer buttons -->
    </div>
</div>

