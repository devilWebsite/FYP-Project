<?php
 $servername = "localhost";
 $username = "root";
 $password = "";  
 $dbname = "project2";

 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

 if (isset($_GET['date'])) {
     $date = $_GET['date'];
     
     $sql = "SELECT appointmentTime FROM testdriveapp WHERE appointmentDate = ?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("s", $date);
     $stmt->execute();
     $result = $stmt->get_result();

     $bookedSlots = [];
     while ($row = $result->fetch_assoc()) {
         $bookedSlots[] = $row['appointmentTime'];
     }

     echo json_encode(['slots' => $bookedSlots]);

     $stmt->close();
 }

 $conn->close();
?>
