<?php
//newly added
function insertMonthlyLeaveCredits($conn) {
    $currentYear = date("Y");
    $currentMonth = date("m");
    $checkQuery = $conn->prepare("SELECT COUNT(*) AS count FROM pelc WHERE YEAR(p_date) = ? AND MONTH(p_date) = ?");
    if ($checkQuery) {
        $checkQuery->bind_param("ii", $currentYear, $currentMonth);
        $checkQuery->execute();
        $result = $checkQuery->get_result();
        
        $row = $result->fetch_assoc();
        $count = $row['count'];

        $checkQuery->close();
    } else {
        $_SESSION['error'] = "Query preparation failed: " . $conn->error;
        return;
    }

    if ($count == 0) {
        $employeeQuery = $conn->query("SELECT id FROM employees");
        $employees = $employeeQuery->fetch_all(MYSQLI_ASSOC);

        $insertedCount = 0;

        foreach ($employees as $employee) {
            $employee_id = $employee['id'];
            $startDate = date('M d');  
            $endDate = date('M d/Y', strtotime('+1 month')); 
            $from_to = "CR.FR $startDate/$endDate";

            $balanceQuery = $conn->prepare("
                SELECT b_vac, b_sck FROM pelc WHERE employee_id = ? ORDER BY p_date DESC LIMIT 1
            ");
            
            if ($balanceQuery) {
                $balanceQuery->bind_param("i", $employee_id);
                $balanceQuery->execute();
                $balanceResult = $balanceQuery->get_result();
                $previousBalance = $balanceResult->fetch_assoc();

                $balanceQuery->close();
            } else {
                $_SESSION['error'] = "Balance query failed: " . $conn->error;
                return;
            }

           
            $prev_b_vac = $previousBalance ? $previousBalance['b_vac'] : 0;
            $prev_b_sck = $previousBalance ? $previousBalance['b_sck'] : 0;
            $new_b_vac = $prev_b_vac + 1.25;
            $new_b_sck = $prev_b_sck + 1.25;

            $insertQuery = $conn->prepare("
            INSERT INTO pelc (employee_id, year, le_vac, le_sck, from_to, lt_wp_vac, lt_wp_sck, lt_np_vac, lt_np_sck, u_vac, u_sck, b_vac, b_sck, p_initial, p_date)
            VALUES (?, ?, 1.25, 1.25, ?, 0, 0, 0, 0, 0, 0, ?, ?, 'None', NOW())
        ");
        
        if ($insertQuery) {
            $insertQuery->bind_param("iissd", $employee_id, $currentYear, $from_to, $new_b_vac, $new_b_sck);
            if ($insertQuery->execute()) {
                $insertedCount++;
            }
            $insertQuery->close();
        } else {
            $_SESSION['error'] = "Insert query failed! " . $conn->error;
            return;
        }
        
            
        }

        if ($insertedCount > 0) {
            $_SESSION['success'] = "Leave credits for this month successfully added.";
        } else {
            $_SESSION['error'] = "No leave credits were inserted.";
        }
    } else {
        $_SESSION['warning'] = "Leave credits already exist for this month.";
    }
}
?>
