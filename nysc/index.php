<?php
require_once "../includes/banner.php";
require_once "../includes/db_handle.php";
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
    margin-top: 80px;
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
    <div class="row" style="padding-top: 15px">
        <div class="col-md-6" id="form">
            <div class="alert alert-info">
                <i class="fa fa-info-circle fa-lg"></i>
                If you don't know your <strong>destination camp and travel date</strong>, just leave those fields empty.
                Travelhub will contact you before the camp dates to confirm.
            </div>
            <form action="" class="form-horizontal" id="form-nysc">
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Fullname *</label>
                    <div class="col-sm-7">
                        <input type="text" name="fullname" id="name" class="form-control" required />
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
                            <option value="Enugu">Enugu</option>
                            <option value="Lagos">Lagos</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="camp" class="col-sm-4 control-label">Arrival Camp</label>
                    <div class="col-sm-7">
                        <select name="camp" id="camp" class="form-control">
                            <option value="">-- Select camp state --</option>
                            <?php
                                foreach ($db->query("SELECT * FROM states ORDER BY state_name") AS $st) {
                                    echo "<option value='{$st['state_name']}'>{$st['state_name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="travel_date" class="col-sm-4 control-label">Travel Date</label>
                    <div class="col-sm-7">
                        <select name="travel_date" id="travel_date" class="form-control">
                            <option value="">-- Pick travel date --</option>
                            <option value="2017-01-23">1st day (Not know yet)</option>
                            <option value="2017-01-24">2nd day (Not know yet)</option>
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
                    <div class="col-sm-offset-4 col-sm-7"><input type="submit" name="submit" value="Save & Proceed" class="btn btn-warning btn-fill" /></div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="tips">
                <div class="feats">
                    <h3>Take a direct trip to nysc camp</h3>
                    <strong>Travelhub</strong> partners with various transport companies to take you directly to your nysc orientation camp.
                    You also have the pleasure of travelling with your friends and fellow corpers.
                </div>
            </div>
        </div>
    </div>

    <div id="content-holder" class="hidden">
        <div>
            <h3>Payment Options</h3><br>
            <div class="alert alert-info">You need to make payment at least 3 days before your travel date so that we
            can book ahead for the vehicle you'll travel with to avoid disappointment.</div>
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Online Payment</h3></div>
                <div class="panel-body" style="position:relative;">
                    <img src="../images/visa-mastercard.png" class="pull-left" />
                    <a href="#" class="btn btn-fill btn-warning" style="position: absolute; bottom: 18px; right:17px">Proceed to payment <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Collection Centers</h3></div>
                <div class="panel-body">
                    You can pay cash at the following locations
                    <div id="ifesinachi-park-Enugu" class="hidden">
                        Ifesinachi Plaza, Market Road, Holy Ghost, Enugu
                    </div>
                    <div id="ifesinachi-park-Lagos" class="hidden">
                        No 2 Ikorodu road, Jibowu, Yaba, Lagos
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Bank Payment</h3></div>
                <div class="panel-body">
                    You can pay directly into our bank account using your booking reference number: <br>
                    <br>
                    Bank: Diamond Bank<br>
                    Accounnt Name: Travelhub<br>
                    Account number: 000000000
                </div>
            </div>

            <div class="">
                If you have any issue or questions please feel free to call us any time: <h4 style="margin-top:3px"><i class="fa fa-phone"></i> 08048579309</h4>
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
                    $(this).html($("#content-holder").html()).fadeIn();
                });
                $("#ifesinachi-park-" + origin).removeClass('hidden');
            }
        });
    });
});
</script>
