<?php
session_start();
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();

$page_title = "Book Bus Traveling Directly to your Nysc Orientation Camp";
require_once "../includes/banner.php";
/*require_once "../includes/db_handle.php";*/
require_once "../api/models/Nysc.php";

$nysc = new Nysc();
$camp_fares = $nysc->getCampFares();
?>
<style>
.tips {
    position: relative;
    float: right;
    background: url('../images/nysc.jpg') no-repeat center top;
    background-position: center center;
    min-height: 350px;
    width: 90%;
    -webkit-background-size: 100%;
    -moz-background-size: 100%;
    -o-background-size: 100%;
    background-size: 100%;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    backgroundcolor: #f0f0f0;
    margin-top: 40px;
    color: #fff;
}

.tips h3 {
    color: #fff;
    margin-bottom: 6px;
}

.tips .feats {
    position: absolute;
    bottom: 0;
    background-color: rgba(0,0,0,0.7);
    padding: 8px 12px;
    width: 100%;
    line-height: 20px;
    padding-bottom: 17px;
    font-weight: 300;
}

h3.panel-title {
    font-weight: 400;
}

.payment-opt {
    border: #f0f0f0 solid thin;
    padding: 10px;
    margin: 15px; 0;
    cursor: pointer;
    background-color: #fff;
}


@media screen and (min-width: 200px) and (max-width: 600px) {
    .tips {
        float: none;
        width: 100%;
    }
}


</style>

<div class="container">
    <div class="row" style="padding-top: 15px; margin-bottom: 70px;">
        <div class="col-md-6" id="form">
            <div class="alert alert-info">
                <i class="fa fa-info-circle fa-lg"></i>
                If you don't know your <strong>destination camp and travel date</strong>, just leave those fields empty.
                Travelhub will contact you before the camp dates to confirm.
            </div>
            <form action="" class="form-horizontal" id="form-nysc">
                <input type="hidden" name="token" value="<?php echo $token; ?>" />
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Fullname *</label>
                    <div class="col-sm-7">
                        <input type="text" name="fullname" id="fullname" class="form-control" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-4 control-label">Phone *</label>
                    <div class="col-sm-7">
                        <input type="text" name="phone" id="phone" class="form-control" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-7">
                        <input type="email" name="email" id="email" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="origin" class="col-sm-4 control-label">Travelling from *</label>
                    <div class="col-sm-7">
                        <select name="origin" id="origin" class="form-control" required>
                            <option value="">-- Departure State --</option>
<!--                            <option value="Enugu">Enugu</option>-->
                            <option value="Lagos">Lagos</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="camp" class="col-sm-4 control-label">Arrival Camp</label>
                    <div class="col-sm-7">
                        <div class="row">
                            <div class="col-md-7 col-xs-7">
                                <select name="camp" id="camp-fare" class="form-control">
                                    <option value="">-- Camp state --</option>
                                    <?php
                                    foreach ($camp_fares AS $st) {
                                        if ($st->fare < 1) { continue; }
                                        echo "<option value='{$st->state_name}' data-fare='{$st->fare}'>{$st->state_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-5 col-xs-5" id="fare-div"><input type="text" name="fare" id="fare" class="form-control" placeholder="0.00" readonly /></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="travel_date" class="col-sm-4 control-label">Travel Date</label>
                    <div class="col-sm-7">
                        <select name="travel_date" id="travel_date" class="form-control">
                            <option value="">-- Pick travel date --</option>
                            <option value="2017-01-23">23-01-2017</option>
                            <option value="2017-01-24">24-01-2017</option>
                            <option value="2017-01-25">25-01-2017</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="travelers" class="col-sm-4 control-label">No of Travellers</label>
                    <div class="col-sm-7">
                        <input type="number" name="travelers" id="travelers" class="form-control" min="1" max="5" value="1" />
                    </div>
                </div>
                <input type="hidden" name="op" value="book-nysc" />
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-7 col-xs-12"><input type="submit" name="submit" value="Save & Proceed" class="btn btn-warning btn-fill" /></div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <h4 class="text-center"><span class="glyphicon glyphicon-phone-alt"></span> Call us: 0906 3369 208</h4>
            <div class="tips">
                <div class="feats">
                    <h3>Take a direct trip to nysc camp</h3>
                    <strong>Travelhub</strong> partners with various transport companies to take you directly to your nysc orientation camp.
                    You also have the pleasure of travelling with your friends and other corper members.
                </div>
            </div>
        </div>
    </div>

    <div id="content-holder" class="hidden">
        <div>
            <h3>Payment Options</h3><br>
            <div class="alert alert-info">We recommend that you make payment 72 or 48 hours before your departure date to enable us finalise your reservation.
            <br><br>
            <strong>You'll get an SMS containing your reservation details, shortly.</strong></div>
            <div class="panel panel-default hidden">
                <div class="panel-heading"><h3 class="panel-title">Online Payment</h3></div>
                <div class="panel-body" style="position:relative;">
                    <img src="../images/visa-mastercard.png" class="pull-left" />
                    <a href="#" class="btn btn-fill btn-warning" style="position: absolute; bottom: 18px; right:17px">Proceed to payment <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Payment Centers</h3></div>
                <div class="panel-body">
                    You can make payment at the following location:<br><br>
                    <div id="ifesinachi-park-Enugu" class="hidden">
                        Ifesinachi Plaza, Market Road, Holy Ghost, Enugu
                    </div>
                    <div id="ifesinachi-park-Lagos" class="hidden">
                        <strong>Ifesinachi Transport Limited</strong><br>
                        No 2 Ikorodu road, Jibowu, Yaba, Lagos
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Bank Payment/Transfer</h3></div>
                <div class="panel-body">
                    You can transfer or pay directly into our bank account using the same fullname you used to make your reservation. <br>
                    <strong>Travelhub</strong> will send an SMS and email to you as soon as your payment alert is received.
                    <br><br>
                    <strong>Bank:</strong> Diamond Bank<br>
                    <strong>Accounnt Name:</strong> Travelhub Transport Services LTD<br>
                    <strong>Account number:</strong> 0086410673
                </div>
            </div>

            <div class="text-center">
                <h4 style="margin: 2px"><span class="glyphicon glyphicon-phone-alt"></span> 0906 3369 208</h4>
                If you have any issue or questions please feel free to call us any time<br><br><br>
            </div>
        </div>
    </div>
</div>

<?php
require_once "../includes/footer.php";
?>
<script>
$(document).ready(function() {
    $("#form-nysc").submit(function(e) {
        e.preventDefault();
        $(this).find('input[type=submit]').prop('disabled', true);
        var origin = $("#origin").val();
        $.post('ajax/fns.php', $(this).serialize(), function(d) {
            if (d.trim() == 'Done') {
                $("#form").fadeOut(function() {
                    var details = "<address><strong>Fullname:</strong> " + $("#fullname").val()
                                +"<br><strong>Phone:</strong> " + $("#phone").val()
                                +"<br><strong>Route:</strong> " + origin + " to " + $("#camp-fare").val() + " camp"
                                +"<br><strong>Fare:</strong> &#8358;" + $("#fare").val() * $("#travelers").val() + "</address>";

                    $("#content-holder .alert-info").prepend(details);
                    $(this).html($("#content-holder").html()).fadeIn();
                });
                $("#ifesinachi-park-" + origin).removeClass('hidden');
            }
            $('html, body').animate({scrollTop: '0px'}, 300);
        });
    });


    $("#camp-fare").change(function() {
        var fare = $("#camp-fare option:selected").data('fare');
        $("#fare").val(fare);
        //$("#fare-div div").html("&#8358;" + fare);
    });
});
</script>
