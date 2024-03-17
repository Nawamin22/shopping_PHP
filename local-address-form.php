<!-- <?php
include('local-address-form.php');
?> -->


<?php
$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
$row = mysqli_fetch_array($query);
$provinces_query = mysqli_query($con, "SELECT * FROM provinces");
?>

<div class="container">
    <div class="col-md-4 col-sm-12 estimate-ship-tax">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <span class="estimate-title">Local Address</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="form-group">
                            <form class="register-form" role="form" method="post"
                                onsubmit="return saveLocalAddress(this);">
                                <div class="form-group">
                                    <label class="info-title" for="Local Address">Local Address<span>*</span></label>
                                    <textarea class="form-control unicase-form-control text-input" id="localaddress"
                                        name="localaddress"
                                        required="required"><?php echo $row['localAddress']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="province">Province</label>
                                    <select class="form-control" name="provinces" id="provinces"
                                        onChange="getAmphures(this.value);">
                                        <option value="">Select Province</option>
                                        <?php
                                        while ($province = mysqli_fetch_array($provinces_query)) {
                                            $selected = ($row['province_id'] == $province['id']) ? 'selected' : '';
                                            echo '<option value="' . $province['id'] . '" ' . $selected . '>' . $province['name_en'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amphures">Amphure</label>
                                    <select class="form-control" id="amphures" name="amphures"
                                        onChange="getDistricts(this.value);">
                                        <option value="">Select Amphure</option>
                                        <?php
                                        if ($row['province_id']) {
                                            $amphures_query = mysqli_query($con, "SELECT * FROM amphures WHERE province_id=" . $row['province_id']);
                                            while ($amphure = mysqli_fetch_array($amphures_query)) {
                                                $selected = ($row['amphure_id'] == $amphure['id']) ? 'selected' : '';
                                                echo '<option value="' . $amphure['id'] . '" ' . $selected . '>' . $amphure['name_en'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="districts">District</label>
                                    <select class="form-control" id="districts" name="districts">
                                        <option value="">Select District</option>
                                        <?php
                                        if ($row['amphure_id']) {
                                            $districts_query = mysqli_query($con, "SELECT * FROM districts WHERE amphure_id=" . $row['amphure_id']);
                                            while ($district = mysqli_fetch_array($districts_query)) {
                                                $selected = ($row['district_id'] == $district['id']) ? 'selected' : '';
                                                echo '<option value="' . $district['id'] . '" ' . $selected . '>' . $district['name_en'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <button type="submit" name="localupdate"
                                    class="btn-upper btn btn-primary checkout-page-button">Save</button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>