<?php
include('includes/config.php'); // เปลี่ยนเป็นชื่อไฟล์ที่ใช้เชื่อมกับฐานข้อมูลของคุณ
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
