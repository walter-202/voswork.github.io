<?php

function build_calendar($offid, $month, $year) {
    include('includes/config.php');
    $mysqli = new mysqli('localhost', 'root', '', 'data');   
     // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
    
    $monthsOfYear = array('Enero', 'Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
     // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
    $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
    $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
    $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
    $dayOfWeek = $dateComponents['wday'];
    
     // Create the table tag opener and day headers

    $datetoday = date('Y-m-d');

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar.= "<button class='changemonth btn btn-xs btn-primary' data-offid='".($offid)."' data-month='".date('m', mktime(0, 0, 0, $month-1, 1, $year))."' data-year='".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Anterior Mes</button> ";
    
    $calendar.= " <button class='changemonth btn btn-xs btn-primary' data-offid='".($offid)."' data-month='".date('m')."' data-year='".date('Y')."'>Mes Actual</button> ";
    
    $calendar.= "<button class='changemonth btn btn-xs btn-primary' data-offid='".($offid)."' data-month='".date('m', mktime(0, 0, 0, $month+1, 1, $year))."' data-year='".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Siguiente mes</button></center><br>";
    
    
        
    $calendar .= "<tr>";

     // Create the calendar headers

    foreach($daysOfWeek as $day) {
    $calendar .= "<th  class='header'>$day</th>";
    } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

    $currentDay = 1;

    $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

    if ($dayOfWeek > 0) { 
        for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= "<td  class=' td Vacío'></td>"; 

    }
}
    
    
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

        if ($dayOfWeek == 7) {

        $dayOfWeek = 0;
        $calendar .= "</tr><tr>";

        }
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
$dayname = strtolower(date('l', strtotime($date)));
$eventNum = 0;
$today = $date==date('Y-m-d')? "today" : "";
if($dayname=='saturday' || $dayname=='sunday' ){
                $calendar.="<td class='td'><h4>$currentDay</h4> <button class='btn-danger'>Cerrado</button>";
}elseif($date<date('Y-m-d')){
                $calendar.="<td class='td'><h4>$currentDay</h4> <button class='btn-danger'>N/E</button>";
}else{
    $totalbookings=checkSlots($mysqli, $date, $offid);
    if($totalbookings==9){
        $calendar.="<td class='$today td'><h4>$currentDay</h4> <a href='#".$offid."".$date."' class='btn-danger'>Lleno</a>";
    }else{

        $avaliableslots = 9 - $totalbookings;
        $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='book.php?offid=".$offid."&date=".$date."' class='btn-padding btn-success btn-xs'>Reservar</a> <small><i>$avaliableslots disponibles </i></small>";
} 

}

        $calendar .="</td>";
         // Increment counters

$currentDay++;
$dayOfWeek++;

}


     // Complete the row of the last week in month, if necessary

if ($dayOfWeek != 7) { 
$remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty td'></td>"; 

}

}

$calendar .= "</tr>";

$calendar .= "</table>";

echo $calendar;

}
    

function checkSlots($mysqli, $date ,$offid){
    $stmt = $mysqli->prepare("SELECT * from tblbooking where date = ? and officeid = ? ");
$stmt->bind_param('ss', $date , $offid);
$totalbookings = 0;
if($stmt->execute()){
    $result = $stmt->get_result();
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            $totalbookings++;
        }
        $stmt->close();
    }
}
return $totalbookings;
}

$dateComponents = getdate();
if(isset($_POST['month']) && isset($_POST['year'])){
$month = $_POST['month']; 			     
$year = $_POST['year'];
}else{
$month = $dateComponents['mon']; 			     
$year = $dateComponents['year'];
}

if(isset($_POST['offid'])){
    $offid = $_POST['offid'];
}else{
    $offid=0;
}

echo build_calendar($offid,$month,$year);
?>

