<?php
class ketnoi {
    public function connect() {
        $con = mysqli_connect("localhost", "root", "", "savoriarestaurant");
        if (!$con) {
            die("Kết nối thất bại: " . mysqli_connect_error());
        }
        $con->set_charset("utf8");

        return $con;
    }

    public function dongketnoi($con) {
        $con->close();
    }
}
?>
