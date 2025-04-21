<?php
    class ketnoi{
        public function connect(){
            mysql_query("set names utf8");
            return mysqli_connect("localhost","root","", "savoriarestaurant");
        }
        public function dongketnoi($con){
            $con->close();
        }
        
    }


?>
