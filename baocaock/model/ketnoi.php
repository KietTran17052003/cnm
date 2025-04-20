<?php
    class ketnoi{
        public function connect(){
            return mysqli_connect("localhost","root","", "savoriarestaurant");
        }
        public function dongKetNoi($con){
            $con->close();
        }
        
    }




?>
