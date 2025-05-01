document.addEventListener("DOMContentLoaded", () => {
    const resultForm = document.getElementById("resultForm");
    const loadingIndicator = document.getElementById("loadingIndicator");
    const resultContainer = document.getElementById("resultContainer");
  
    if (!resultForm || !loadingIndicator || !resultContainer) {
      console.error("Required DOM elements not found");
      return;
    }
  
    resultForm.addEventListener("submit", (e) => {
      e.preventDefault();
  
      // Show loading indicator with animation
      loadingIndicator.classList.remove("d-none");
      resultContainer.classList.add("d-none");
      resultContainer.innerHTML = "";
  
      // Get form data
      const formData = new FormData(resultForm);
  
      // Send AJAX request
      fetch("fetch_result.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then((data) => {
          console.log("Response data:", data);
  
          // Hide loading indicator
          loadingIndicator.classList.add("d-none");
  
          if (data.success) {
            // Display the result
            displayResult(data);
            resultContainer.classList.remove("d-none");
  
            // Smooth scroll to results
            setTimeout(() => {
              resultContainer.scrollIntoView({ behavior: "smooth", block: "start" });
            }, 100);
          } else {
            // Display error message
            displayError(data.message);
            resultContainer.classList.remove("d-none");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
  
          // Hide loading indicator and display error
          loadingIndicator.classList.add("d-none");
          displayError("An error occurred while fetching the result. Please try again later.");
          resultContainer.classList.remove("d-none");
        });
    });
  
    function displayResult(data) {
      const studentInfo = data.studentInfo;
      const resultList = data.resultInfo.resultList;
      const semesterName = data.semesterName;
      const averageSGPA = data.averageSGPA;
  
      let html = `
        <div id="printableArea">
          <div class="student-info">
            <div class="text-center mb-4">
              <img src="DIU-logo.png" alt="DIU Logo" class="img-fluid mb-3" style="max-height: 60px;">
              <h4 class="mb-1">Daffodil International University</h4>
              <h5 class="text-muted">${semesterName} Semester Result</h5>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <p><strong><i class="fas fa-id-card me-2"></i>Student ID:</strong> ${studentInfo.studentId}</p>
                <p><strong><i class="fas fa-user me-2"></i>Name:</strong> ${studentInfo.studentName}</p>
                <p><strong><i class="fas fa-graduation-cap me-2"></i>Program:</strong> ${studentInfo.programName}</p>
              </div>
              <div class="col-md-6">
                <p><strong><i class="fas fa-users me-2"></i>Batch:</strong> ${studentInfo.batchNo}</p>
                <p><strong><i class="fas fa-building me-2"></i>Campus:</strong> ${studentInfo.campusName}</p>
                <p><strong><i class="fas fa-university me-2"></i>Faculty:</strong> ${studentInfo.facultyName}</p>
              </div>
            </div>
          </div>
          
          <div class="result-section">
            <h5><i class="fas fa-chart-bar me-2"></i>Course Results</h5>
            <div class="table-responsive">
              <table class="result-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credit</th>
                    <th>Grade</th>
                    <th>Grade Point</th>
                  </tr>
                </thead>
                <tbody>
      `;
  
      if (resultList && resultList.length > 0) {
        resultList.forEach((course) => {
          html += `
            <tr>
              <td>${course.customCourseId || "N/A"}</td>
              <td>${course.courseTitle || "N/A"}</td>
              <td>${course.totalCredit || "N/A"}</td>
              <td class="grade-${course.gradeLetter ? course.gradeLetter.replace("+", "\\+") : ""}">${course.gradeLetter || "N/A"}</td>
              <td>${course.pointEquivalent || "N/A"}</td>
            </tr>
          `;
        });
      } else {
        html += `
          <tr>
            <td colspan="5" class="text-center">No course results available</td>
          </tr>
        `;
      }
  
      html += `
                </tbody>
              </table>
            </div>
            
            <div class="summary-box">
              <div class="row">
                <div class="col-md-6">
                  <p><strong><i class="fas fa-book me-2"></i>Total Courses:</strong> ${resultList ? resultList.length : 0}</p>
                  <p><strong><i class="fas fa-award me-2"></i>Total Credits:</strong> ${calculateTotalCredits(resultList)}</p>
                </div>
                <div class="col-md-6">
                  <p><strong><i class="fas fa-star me-2"></i>Average SGPA:</strong> ${averageSGPA}</p>
                  <p><strong><i class="fas fa-check-circle me-2"></i>Result Status:</strong> 
                    <span class="badge ${averageSGPA >= 2.0 ? "bg-success" : "bg-danger"}">
                      ${averageSGPA >= 2.0 ? "Passed" : "Failed"}
                    </span>
                  </p>
                </div>
              </div>
            </div>
            
            <div class="pdf-footer" style="text-align: right; margin-top: 30px; font-size: 12px; color: #6c757d;">
              Created by <i class="fab fa-github"></i> shishirahm3d (60_A)
            </div>
          </div>
        </div>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 no-print">
          <button class="btn btn-success action-btn me-md-2" id="downloadPngBtn">
            <i class="fas fa-file-image me-2"></i>Download as PNG
          </button>
          <button class="btn btn-primary action-btn" id="printBtn">
            <i class="fas fa-print me-2"></i>Print Result
          </button>
        </div>
      `;
  
      resultContainer.innerHTML = html;
  
      // Add event listeners for download and print buttons with animation
      const downloadPngBtn = document.getElementById("downloadPngBtn");
      const printBtn = document.getElementById("printBtn");
  
      if (downloadPngBtn) {
        downloadPngBtn.addEventListener("click", () => {
          downloadPngBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating PNG...';
          downloadPngBtn.disabled = true;
  
          setTimeout(() => {
            generatePNG(data); // Call to generate PNG
            downloadPngBtn.innerHTML = '<i class="fas fa-file-image me-2"></i>Download as PNG';
            downloadPngBtn.disabled = false;
          }, 500);
        });
      }
  
      if (printBtn) {
        printBtn.addEventListener("click", () => {
          window.print();
        });
      }
    }
  
    function displayError(message) {
      resultContainer.innerHTML = `
        <div class="error-message">
          <h5><i class="fas fa-exclamation-triangle me-2"></i>Error</h5>
          <p>${message}</p>
        </div>
      `;
    }
  
    function calculateTotalCredits(resultList) {
      if (!resultList || !Array.isArray(resultList)) {
        return 0;
      }
  
      return resultList.reduce((total, course) => {
        return total + (Number.parseFloat(course.totalCredit) || 0);
      }, 0);
    }
  
    function generatePNG(data) {
      if (typeof window.html2canvas === "undefined") {
        alert("html2canvas library not loaded. Please try again later.");
        return;
      }
  
      const element = document.getElementById("printableArea");
      if (!element) {
        alert("Could not find the printable area.");
        return;
      }
  
      // Use html2canvas to capture the element as an image
      window
        .html2canvas(element, {
          scale: 2,
          useCORS: true,
          logging: false,
          allowTaint: true,
          backgroundColor: "#6c757d",
        })
        .then((canvas) => {
          const imgData = canvas.toDataURL("image/png");
  
          // Create a temporary link to download the image
          const link = document.createElement("a");
          link.href = imgData;
          link.download = `${data.studentInfo.studentId}_${data.semesterName.replace(/\s+/g, "_")}_Result.png`;
  
          // Trigger the download
          link.click();
        })
        .catch((error) => {
          console.error("Error generating PNG:", error);
          alert("Failed to generate PNG. Please try again later.");
        });
    }
  });