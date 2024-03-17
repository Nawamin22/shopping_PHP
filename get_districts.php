<?php
include('includes/config.php'); // เปลี่ยนเป็นชื่อไฟล์ที่ใช้เชื่อมกับฐานข้อมูลของคุณ

if (!empty($_POST["amphure_id"])) {
    $id = intval($_POST['amphure_id']);
    $query = mysqli_query($con, "SELECT * FROM districts WHERE amphure_id=$id");
    ?>
    <option value="">Select District</option>
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
