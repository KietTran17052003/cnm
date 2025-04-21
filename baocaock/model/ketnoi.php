<?php
    class ketnoi{
        public function connect(){
            return mysqli_connect("localhost","root","", "savoriarestaurant");
        }
        public function dongketnoi($con){
            $con->close();
        }
        
    }


?>
