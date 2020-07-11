
 <?php 
$employee = array(
 "employee_id" => 10011,
   "Name" => "Nathan",
   "Skills" =>
    array(
           "analyzing",
           "documentation" =>
            array(
              "desktop",
                "mobile"
             )
        )
);

echo json_encode($employee);

 ?>

