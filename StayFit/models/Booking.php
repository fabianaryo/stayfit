<?php
    class Booking {
        protected $conn;

        private $table = 'booking';

        public $Booking_ID;
        public $Client_ID;
        public $Date;
        public $Start_time;
        public $End_time;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        public function add(){
            //Create query
            $query = "INSERT INTO " . $table . "(
                Booking_ID, 
                Client_ID, 
                Date, 
                Start_time, 
                End_time) 
                VALUES ('" . $Booking_ID . "', " 
                . $Client_ID ."', '" 
                . $Date . "', '" 
                . $Start_time . "', '" 
                . $End_time . ")";
        }
    }

    class Equipment_booking extends Booking{
        private $table = 'equipment_booking';

        //Equipment booking properties
        // public $Client_ID;
        // public $Booking_ID;
        public $Equipment_ID;
        public $Quantity_booked;

        //(GET) View Equipment bookings
        public function view() {
            //Create query
            $query = 'SELECT 
            E.Booking_ID,
            E.Client_ID,
            B.Date,
            B.Start_time,
            B.End_time,
            E.Equipment_ID,
            E.Quantity_booked
              FROM ' . $this->table . ' as E
            INNER JOIN booking as B ON E.Booking_ID=B.Booking_ID';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute
            $stmt->execute();
            
            return $stmt;
        }

        public function select(){
            //Create query
            $query = "SELECT 
            E.Booking_ID,
            E.Client_ID,
            B.Date,
            B.Start_time,
            B.End_time,
            E.Equipment_ID,
            E.Quantity_booked
              FROM " . $this->table . " as E
            INNER JOIN booking as B ON E.Booking_ID=B.Booking_ID
             WHERE
             E.Booking_ID= '" . $this->Booking_ID . "'";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute
            $stmt->execute();
            
            return $stmt;
        }

        public function make() {
            //Clean data
            $this->Client_ID = htmlspecialchars(strip_tags($this->Client_ID));
            $this->Booking_ID = htmlspecialchars(strip_tags($this->Booking_ID));
            $this->Date = htmlspecialchars(strip_tags($this->Date));
            $this->Start_time = htmlspecialchars(strip_tags($this->Start_time));
            $this->End_time = htmlspecialchars(strip_tags($this->End_time));
            $this->Equipment_ID = htmlspecialchars(strip_tags($this->Equipment_ID));
            $this->Quantity_booked = htmlspecialchars(strip_tags($this->Quantity_booked));

            //create queries
            //query to adds to the booking table
            $query1 = "INSERT INTO booking (Booking_ID, Client_ID, Date, Start_time, End_time) VALUES ('" . $this->Booking_ID . "', '" 
                . $this->Client_ID ."', '" 
                . $this->Date . "', '" 
                . $this->Start_time . "', '" 
                . $this->End_time . "')";
            
            //query that adds to the equipment booking table
            $query2 = "INSERT INTO " . $this->table . " (
                Client_ID, 
                Booking_ID, 
                Equipment_ID, 
                Quantity_booked) 
                VALUES ('" . $this->Client_ID . "', '" 
                . $this->Booking_ID ."', '" 
                . $this->Equipment_ID . "', '" 
                . $this->Quantity_booked . "')";
            
            $stmt1 = $this->conn->prepare($query1);

            $stmt2 = $this->conn->prepare($query2);
            
            //execute queries
            if($stmt1->execute()){
                if($stmt2->execute()){
                    return true;
                }
            }

            //Print error if something goes wrong
            if($stmt1 != NULL){
                printf("Error: %s.\n", $stmt1->error);
            }
            else{
                printf("Error: %s.\n", $stmt2->error);
            }
            
            return false;

        }

    }
?>