<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <a href='#'><i class="fa fa-user fa-2x"></i></a>
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION['username']; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li id="link-dashboard">
                <a href="dashboard.php#dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li id="link-routes">
                <a href="travel-routes.php#routes">
                    <i class="fa fa-cogs"></i> <span>State & Routes</span>
                </a>
            </li>

            <li id="link-book">
                <a href="bookings.php#book">
                    <i class="fa fa-car"></i>
                    <span>Reservations</span>
                </a>
            </li>

            <!--<li>
                <a href="bushire.php">
                    <i class="fa fa-bus"></i>
                    <span>Bus Hire</span>
                </a>
            </li>-->

            <li id="link-vehicles">
                <a href="travel-vehicles.php#vehicles">
                    <i class="fa fa-bus"></i>
                    <span>Manage Vehicles</span>
                </a>
            </li>

            <li id="link-report">
                <a href="view_reports.php#report">
                    <i class="fa fa-book"></i>
                    <span>Reports</span>
                </a>
            </li>

            <li>
                <a href="../logout.php">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>