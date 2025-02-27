<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/saad/logo1.png" type="image/png">
  <title>Exam Page</title>
  <!-- External CSS -->
  <link rel="stylesheet" href="condition.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="card w-50 mx-auto">
      <div class="card-header">Exam Rules and Conditions</div>
      <div class="card-body">
        <p class="mb-3">Before starting the exam, you must agree to the following conditions:</p>
        <ul class="conditions-list">
          <li>Ensure a stable internet connection throughout the exam.</li>
          <li>Do not refresh or leave the page during the exam.</li>
          <li>You can only one time chance to drop the exam.</li>
          <li>Answer all questions within the given time limit.If time is finish then the ans automatic submit.</li>
          <li>You can submit an answer one time.You can not submit answer same question again.</li>
         <li>Your answers must be original and not copied from others.</li>
        </ul>
        <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" id="agreeConditions">
          <label class="form-check-label" for="agreeConditions">I agree to the conditions above.</label>
        </div>
        <button id="startExamButton" class="btn btn-primary w-100 mt-4" disabled>Start Exam</button>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const agreeCheckbox = document.getElementById("agreeConditions");
      const startExamButton = document.getElementById("startExamButton");

      // Enable or disable the "Start Exam" button based on checkbox state
      agreeCheckbox.addEventListener("change", () => {
        if (agreeCheckbox.checked) {
          startExamButton.disabled = false;
          startExamButton.classList.remove("btn-primary");
          startExamButton.classList.add("btn-success"); // Change to green
          startExamButton.addEventListener("click", () => {
            window.location.href = "exam_live.php"; // Redirect to exam page
          });
        } else {
          startExamButton.disabled = true;
          startExamButton.classList.remove("btn-success");
          startExamButton.classList.add("btn-primary"); // Revert to original
        }
      });
    });
  </script>
</body>
</html>
