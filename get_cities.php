<?php
// get_cities.php
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $selectedState =intval($_POST['state']);
  $cities = array();

  $amphures_query = mysqli_query($con, "SELECT * FROM amphures WHERE province_id = (SELECT id FROM provinces WHERE name_en = '$selectedState')");

  while ($amphure = mysqli_fetch_array($amphures_query)) {
    $cities[] = $amphure;
  }

  echo json_encode($cities);
}
?>

<?php
include('includes/config.php');
if (!empty($_POST["province_id"])) {
    $id = intval($_POST['province_id']);
    $query = mysqli_query($con, "SELECT * FROM amphures WHERE province_id=$id");
    ?>
    <option value="">Select Amphure</option>
    <?php
    while ($row = mysqli_fetch_array($query)) {
        ?>
        <option value="<?php echo htmlentities($row['id']); ?>">
            <?php echo htmlentities($row['name_en']); ?>
        </option>
        <?php
    }
}


?>
