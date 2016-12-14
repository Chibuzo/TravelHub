<?php
require "includes/head.php";
require "includes/side-bar.php";
require_once "../../api/models/bookingissues.class.php";
require_once "../../classes/utility.class.php";

$bookingIssue = new BookingIssues();

$date = isset($_POST['travel_date']) ? $_POST['travel_date'] : date('Y-m-d');

$html = '';
foreach ($bookingIssue->getBookingIssues() AS $issue) {
    $route = explode(" - ", $issue->route);
    $_route = $route[0] . " [ " . $issue->origin_park . " ] - " . $route[1];
    $n++;
    $html .= "<tr id='{$issue->id}'>
				<td>{$issue->c_name}</td>
				<td>{$issue->phone_no}</td>
				<td data-park='$issue->origin_park'>{$issue->abbr}</td>
				<td>{$_route}</td>
				<td>" . Utility::ordinal($issue->departure_order) . " {$issue->vehicle_name}</td>
				<td class='text-right'>{$issue->seat_no}</td>
				<td>{$issue->channel}</td>
				<td>{$issue->issue}</td>
				<td>" . date('d-m-Y', strtotime($issue->travel_date)) . "</td>
				<td>" . date('d/m/Y H:i A', strtotime($issue->logged_at)) . "</td>
				<td class='action-icons text-center'>
				    <a href='' title='Contact Ticketing office' class='view-details' data-travel_id='{$issue->travel_id}' data-park_id='{$issue->park_id}'><i class='glyphicon glyphicon-phone-alt'></i></a>
				    <a href='' title='Mark issue as resolved' class='resolve-issue'><i class='fa fa-check fa-lg text-green'></i></a>
				</td>
			</tr>";
}
?>
<link href="../../css/datepicker.css" rel="stylesheet" />
<link href="../../css/datepicker3.css" rel="stylesheet" />
<link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Issues
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Issues</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h2 style='font-size: 18px' class="box-title"><i class="fa fa-book"></i> &nbsp;Unresolved Issues</h2>
                    </div>

                    <div class="box-body">
                        <div>
                            <div style="margin-bottom: 8px">
                                <form action="" method="post" class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="form-control" name="sort_type">
                                                <option value="">-- All issues --</option>
                                                <option value="Daily">Daily issues</option>
                                                <option value="Monthly">Monthly Issues</option>
                                                <option value="Range">Within Range</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="input-group form-group">
                                                <input name="travel_date" class="form-control date" id="tdate" type="text" value="<?php echo isset($_POST['travel_date']) ? $_POST['travel_date'] : ''; ?>" placeholder="Pick date..." />
												<span class="input-group-btn">
													<input type="submit" class="btn btn-primary" name="submit" value="Display" />
												</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <table class='table table-striped table-bordered' id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Travel</th>
                                        <th>Route</th>
                                        <th>Vehicle</th>
                                        <th>Seat</th>
                                        <th>Channel</th>
                                        <th>Reason</th>
                                        <th style="width: 90px">Travel Date</th>
                                        <th>Logged At</th>
                                        <th class="text-center"  style="width: 80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     echo $html;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.html"; ?>
<script src="../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function() {
    $('#tdate').datepicker({
        format: 'dd-M-yyyy',
        keyboardNavigation: false,
        forceParse: false,
        todayHighlight: true,
        autoclose: true
    });


    $('.resolve-issue').click(function(e) {
        e.preventDefault();

        if (confirm("Are you sure this issue has been completely resolved?")) {
            var $this = $(this).parents('tr');
            var id = $this.attr("id");
            $.post('../../ajax/issues-fns.php', {'op': 'change-issue-status', 'id': id}, function(d) {
                if (d.trim() == 'Done') {
                    $this.fadeOut();
                }
            });
        }
    });


    $('.view-details').click(function(e) {
        e.preventDefault();
        var travel_id = $(this).data('travel_id');
        var park_id = $(this).data('park_id');
        var travel = $(this).parents('tr').find('td:nth-child(3)').text();
        var park = $(this).parents('tr').find('td:nth-child(3)').data('park');

        $.post('../../ajax/issues-fns.php', {'op': 'fetch-travel-contact', 'travel_id': travel_id, 'park_id': park_id}, function(d) {
            if (d.status.trim() == 'success') {
                $('#contactModal .modal-title').text(travel + ", " + park + " park");
                $("#contactModal .modal-body").html(d.address + "<br><div>" + d.phone + "</div>");
                $("#contactModal").modal();
            }
        }, 'JSON');
    });
});

$(function () {
    $('#dataTable').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    });
});
</script>
