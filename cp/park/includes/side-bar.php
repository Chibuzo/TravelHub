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
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="dashboard.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="travel-routes.php">
                    <i class="fa fa-cogs"></i> <span>Routes</span>
                </a>
            </li>

            <!--<li>
                <a href="manage_fares.php">
                    <i class="fa fa-money"></i>
                    <span>Manage Fares</span>
                </a>
            </li>-->

            <li>
                <a href="bookings.php">
                    <i class="fa fa-car"></i>
                    <span>Reservations</span>
                </a>
            </li>

            <li>
                <a href="bushire.php">
                    <i class="fa fa-bus"></i>
                    <span>Bus Hire</span>
                </a>
            </li>

            <li>
                <a href="travel-vehicles.php">
                    <i class="fa fa-bus"></i>
                    <span>Manage Vehicles</span>
                </a>
            </li>

            <li>
                <a href="view_reports.php">
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