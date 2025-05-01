<?php
header('Content-Type: application/json');

// Function to make API requests with retry mechanism
function makeApiRequest($url, $maxRetries = 5) {
    $retries = 0;
    $response = null;
    
    while ($retries < $maxRetries) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300 && $response) {
            return json_decode($response, true);
        }
        
        $retries++;
        sleep(1); // Wait 1 second before retrying
    }
    
    return null;
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get student ID and semester ID from the POST data
    $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
    $semesterId = isset($_POST['semesterId']) ? $_POST['semesterId'] : '';
    
    // Validate input
    if (empty($studentId) || empty($semesterId)) {
        echo json_encode([
            'success' => false,
            'message' => 'Student ID and Semester ID are required.'
        ]);
        exit;
    }
    
    // Fetch student information
    $studentInfoUrl = "http://peoplepulse.diu.edu.bd:8189/result/studentInfo?studentId=" . urlencode($studentId);
    $studentInfo = makeApiRequest($studentInfoUrl);
    
    if (!$studentInfo) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to fetch student information. Please check your Student ID and try again.'
        ]);
        exit;
    }
    
    // Fetch result information
    $resultUrl = "http://peoplepulse.diu.edu.bd:8189/result?grecaptcha=&semesterId=" . urlencode($semesterId) . "&studentId=" . urlencode($studentId);
    $resultInfo = makeApiRequest($resultUrl);
    
    if (!$resultInfo) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to fetch result information. The result may not be available yet or the teacher has not evaluated it.'
        ]);
        exit;
    }
    
    // Get semester name from the semester ID
    $semesters = [
        "251" => ["year" => 2025, "name" => "Spring"],
        "244" => ["year" => 2024, "name" => "Short"],
        "243" => ["year" => 2024, "name" => "Fall"],
        "242" => ["year" => 2024, "name" => "Summer"],
        "241" => ["year" => 2024, "name" => "Spring"],
        "233" => ["year" => 2023, "name" => "Fall"],
        "232" => ["year" => 2023, "name" => "Summer"],
        "231" => ["year" => 2023, "name" => "Spring"],
        "223" => ["year" => 2022, "name" => "Fall"],
        "222" => ["year" => 2022, "name" => "Summer"],
        "221" => ["year" => 2022, "name" => "Spring"],
        "213" => ["year" => 2021, "name" => "Fall"],
        "212" => ["year" => 2021, "name" => "Summer"],
        "211" => ["year" => 2021, "name" => "Spring"],
        "203" => ["year" => 2020, "name" => "Fall"],
        "202" => ["year" => 2020, "name" => "Summer"],
        "201" => ["year" => 2020, "name" => "Spring"]
    ];
    
    $semesterInfo = isset($semesters[$semesterId]) ? $semesters[$semesterId] : null;
    $semesterName = $semesterInfo ? $semesterInfo["name"] . " " . $semesterInfo["year"] : "Unknown Semester";
    
    // Calculate average SGPA if results are available
    $totalGradePoints = 0;
    $totalCredits = 0;
    $averageSGPA = 0;
    
    if (is_array($resultInfo)) {
        foreach ($resultInfo as $course) {
            if (isset($course['pointEquivalent']) && isset($course['totalCredit'])) {
                $totalGradePoints += ($course['pointEquivalent'] * $course['totalCredit']);
                $totalCredits += $course['totalCredit'];
            }
        }
        
        if ($totalCredits > 0) {
            $averageSGPA = round($totalGradePoints / $totalCredits, 2);
        }
    }
    
    // Combine all data and send the response
    echo json_encode([
        'success' => true,
        'studentInfo' => $studentInfo,
        'resultInfo' => [
            'resultList' => $resultInfo
        ],
        'semesterName' => $semesterName,
        'averageSGPA' => $averageSGPA
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST requests are allowed.'
    ]);
}
?>