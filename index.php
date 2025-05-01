<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIU Result Scraper</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="favicon.png">
    <link rel="stylesheet" href="/assets/css/style.css">  
</head>
<body>
    <div class="page-container">
        <div class="content-wrap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="header-logo text-center my-4">
                            <img src="DIU-logo.png" alt="DIU Logo" class="img-fluid" style="max-height: 80px;">
                        </div>
                        
                        <div class="card main-card">
                            <div class="card-header">
                                <h3 class="text-center mb-0">Daffodil International University</h3>
                                <h6 style="text-align: center;">Result</h6>
                            </div>
                            <div class="card-body"> 
                                <form id="resultForm">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="studentId" class="form-label">Student ID</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input type="text" class="form-control" id="studentId" name="studentId" placeholder="e.g. xxx-xx-xxxxx" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="semesterId" class="form-label">Select Semester</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                <select class="form-select" id="semesterId" name="semesterId" required>
                                                    <option value="">Select Semester</option>
                                                    <?php
                                                    $semesters = [
                                                        ["semesterId" => "251", "semesterYear" => 2025, "semesterName" => "Spring"],
                                                        ["semesterId" => "244", "semesterYear" => 2024, "semesterName" => "Short"],
                                                        ["semesterId" => "243", "semesterYear" => 2024, "semesterName" => "Fall"],
                                                        ["semesterId" => "242", "semesterYear" => 2024, "semesterName" => "Summer"],
                                                        ["semesterId" => "241", "semesterYear" => 2024, "semesterName" => "Spring"],
                                                        ["semesterId" => "233", "semesterYear" => 2023, "semesterName" => "Fall"],
                                                        ["semesterId" => "232", "semesterYear" => 2023, "semesterName" => "Summer"],
                                                        ["semesterId" => "231", "semesterYear" => 2023, "semesterName" => "Spring"],
                                                        ["semesterId" => "223", "semesterYear" => 2022, "semesterName" => "Fall"],
                                                        ["semesterId" => "222", "semesterYear" => 2022, "semesterName" => "Summer"],
                                                        ["semesterId" => "221", "semesterYear" => 2022, "semesterName" => "Spring"],
                                                        ["semesterId" => "213", "semesterYear" => 2021, "semesterName" => "Fall"],
                                                        ["semesterId" => "212", "semesterYear" => 2021, "semesterName" => "Summer"],
                                                        ["semesterId" => "211", "semesterYear" => 2021, "semesterName" => "Spring"],
                                                        ["semesterId" => "203", "semesterYear" => 2020, "semesterName" => "Fall"],
                                                        ["semesterId" => "202", "semesterYear" => 2020, "semesterName" => "Summer"],
                                                        ["semesterId" => "201", "semesterYear" => 2020, "semesterName" => "Spring"],
                                                        ["semesterId" => "193", "semesterYear" => 2019, "semesterName" => "Fall"],
                                                        ["semesterId" => "192", "semesterYear" => 2019, "semesterName" => "Summer"],
                                                        ["semesterId" => "191", "semesterYear" => 2019, "semesterName" => "Spring"],
                                                        ["semesterId" => "183", "semesterYear" => 2018, "semesterName" => "Fall"],
                                                        ["semesterId" => "182", "semesterYear" => 2018, "semesterName" => "Summer"],
                                                        ["semesterId" => "181", "semesterYear" => 2018, "semesterName" => "Spring"],
                                                        ["semesterId" => "173", "semesterYear" => 2017, "semesterName" => "Fall"],
                                                        ["semesterId" => "172", "semesterYear" => 2017, "semesterName" => "Summer"],
                                                        ["semesterId" => "171", "semesterYear" => 2017, "semesterName" => "Spring"],
                                                        ["semesterId" => "163", "semesterYear" => 2016, "semesterName" => "Fall"],
                                                        ["semesterId" => "162", "semesterYear" => 2016, "semesterName" => "Summer"],
                                                        ["semesterId" => "161", "semesterYear" => 2016, "semesterName" => "Spring"],
                                                        ["semesterId" => "153", "semesterYear" => 2015, "semesterName" => "Fall"],
                                                        ["semesterId" => "152", "semesterYear" => 2015, "semesterName" => "Summer"],
                                                        ["semesterId" => "151", "semesterYear" => 2015, "semesterName" => "Spring"],
                                                        ["semesterId" => "143", "semesterYear" => 2014, "semesterName" => "Fall"],
                                                        ["semesterId" => "142", "semesterYear" => 2014, "semesterName" => "Summer"],
                                                        ["semesterId" => "141", "semesterYear" => 2014, "semesterName" => "Spring"],
                                                        ["semesterId" => "133", "semesterYear" => 2013, "semesterName" => "Fall"],
                                                        ["semesterId" => "132", "semesterYear" => 2013, "semesterName" => "Summer"],
                                                        ["semesterId" => "131", "semesterYear" => 2013, "semesterName" => "Spring"],
                                                        ["semesterId" => "123", "semesterYear" => 2012, "semesterName" => "Fall"],
                                                        ["semesterId" => "122", "semesterYear" => 2012, "semesterName" => "Summer"],
                                                        ["semesterId" => "121", "semesterYear" => 2012, "semesterName" => "Spring"],
                                                        ["semesterId" => "113", "semesterYear" => 2011, "semesterName" => "Fall"],
                                                        ["semesterId" => "112", "semesterYear" => 2011, "semesterName" => "Summer"],
                                                        ["semesterId" => "111", "semesterYear" => 2011, "semesterName" => "Spring"],
                                                        ["semesterId" => "103", "semesterYear" => 2010, "semesterName" => "Fall"],
                                                        ["semesterId" => "102", "semesterYear" => 2010, "semesterName" => "Summer"],
                                                        ["semesterId" => "101", "semesterYear" => 2010, "semesterName" => "Spring"],
                                                        ["semesterId" => "093", "semesterYear" => 2009, "semesterName" => "Fall"],
                                                        ["semesterId" => "092", "semesterYear" => 2009, "semesterName" => "Summer"],
                                                        ["semesterId" => "091", "semesterYear" => 2009, "semesterName" => "Spring"],
                                                        ["semesterId" => "083", "semesterYear" => 2008, "semesterName" => "Fall"]
                                                    ];
                                                    
                                                    foreach ($semesters as $semester) {
                                                        echo '<option value="' . $semester["semesterId"] . '">' . $semester["semesterName"] . ' ' . $semester["semesterYear"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-primary search-btn" id="searchBtn">
                                            <i class="fas fa-search me-2"></i>Search Result
                                        </button>
                                    </div>
                                </form>
                                
                                <div id="loadingIndicator" class="text-center mt-4 d-none">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Searching for your result... Please wait.</p>
                                </div>
                                
                                <div id="resultContainer" class="mt-4 d-none">
                                    <!-- Results will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="footer">
            <div class="container">
                <div class="text-center py-3">
                    Created by 
                    <a href="https://github.com/thedeba" target="_blank" class="github-link">
                        <i class="fab fa-github"></i> Debashish Roy
                    </a> 
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
