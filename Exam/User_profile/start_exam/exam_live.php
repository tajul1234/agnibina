

<?php
// Include database connection
include '../../../admin/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_system/login.php");
    exit;
}

// Fetch the current status of the exam access
$sql = "SELECT status FROM exam_access_status WHERE id = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$status = $result->fetch_assoc()['status'];
$stmt->close();

// If the status is "Off", prevent the user from accessing the exam page
if ($status == 0) {
    echo "<script>alert('The exam is currently unavailable.See notification and know the exam time.Thank you!'); window.location.href = '../dashboard.php';</script>";
    exit;
}
?>

<!-- Your exam page HTML and PHP code goes here -->

<?php
 require_once __DIR__ . '/vendor/autoload.php';


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SignalingServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\App;

$app = new App('localhost', 8080, '0.0.0.0');
$app->route('/signaling', new SignalingServer, ['*']);
$app->run();
?>

















<?php
// Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_system/login.php");
    exit;
}

// Fetch the current exam settings from the database
$sql = "SELECT * FROM exam_settings WHERE id = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$exam_details = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get the subject, total marks, and time
$subject = $exam_details['subject'];
$total_marks = $exam_details['total_marks'];
$exam_time = $exam_details['exam_time'];
?>



<?php
// Include database connection
include '../../../admin/config.php';


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_system/login.php");
    exit;
}

// Get logged-in user's ID
$user_id = $_SESSION['user_id'];

// Handle Drop Exam Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['drop_exam'])) {
    $update_sql = "UPDATE dhumkhetu SET has_dropped = 1 WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('You have dropped the exam.');
                window.location.href = '../dashboard.php';
              </script>";
    } else {
        echo "<script>alert('Failed to drop the exam. Please try again.');</script>";
    }

    $stmt->close();
    $conn->close();
    exit;
}  

// Fetch user details
$sql = "SELECT * FROM dhumkhetu WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $has_dropped = $user['has_dropped'];
} else {
    echo "User not found!";
    exit;
}

$stmt->close();

// Fetch questions from the database
$question_sql = "SELECT * FROM questions";
$question_result = $conn->query($question_sql);
$questions = ($question_result->num_rows > 0) ? $question_result->fetch_all(MYSQLI_ASSOC) : [];

// Prevent duplicate submissions
$submitted_answers_sql = "SELECT question_id, answer FROM exam_answers WHERE user_id = ?";
$submitted_stmt = $conn->prepare($submitted_answers_sql);
$submitted_stmt->bind_param("i", $user_id);
$submitted_stmt->execute();
$submitted_result = $submitted_stmt->get_result();
$submitted_answers = $submitted_result->fetch_all(MYSQLI_ASSOC);

// Map submitted answers for easy lookup
$submitted_questions = [];
foreach ($submitted_answers as $submitted_answer) {
    $submitted_questions[$submitted_answer['question_id']] = $submitted_answer['answer'];
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="live_exam.css">
    <!-- Favicon -->
    <link rel="icon" href="https://www.agnibina.org/loggo.png" type="image/png">
    <title>Live Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header mb-4 text-center">
            <div class="school-info">
            <img src="logo.jpeg" alt="School Logo" class="school-logo">
                <h3>Agnibina Admission Coaching</h3>
                <p>Subject: <?php echo $subject; ?></p>
                <p>Total Marks: <?php echo $total_marks; ?></p>
            </div>
        </div>

        <div class="timer" id="timer"><?php echo str_pad($exam_time, 2, '0', STR_PAD_LEFT) . ":00"; ?></div>

        <div class="card mt-4">
            <div class="card-body">
                <form method="POST" action="submit_exam.php" id="examForm">
                    <?php if (!empty($questions)): ?>
                        <?php foreach ($questions as $index => $q): ?>
                            <div class="question-container">
                                <div class="question-card">
                                    <p class="question"><?php echo ($index + 1) . '. ' . htmlspecialchars($q['question']); ?></p>
                                    <div class="options">
                                        <?php
                                        $options = ['ক' => $q['option1'], 'খ' => $q['option2'], 'গ' => $q['option3'], 'ঘ' => $q['option4']];
                                        foreach ($options as $key => $option):
                                            $disabled = in_array($q['question_number'], $submitted_questions) ? 'disabled' : '';
                                        ?>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" name="answer<?php echo $q['question_number']; ?>" value="<?php echo $key; ?>" id="option<?php echo $q['question_number'] . $key; ?>" <?php echo $disabled; ?>>
                                                <label class="form-check-label" for="option<?php echo $q['question_number'] . $key; ?>"><?php echo $key . '. ' . htmlspecialchars($option); ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No questions available at the moment.</p>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary" id="submitBtn" <?php echo !empty($submitted_questions) ? 'disabled' : ''; ?>>Submit Exam</button>
                        <?php if (!$has_dropped): ?>
                            <button type="button" class="btn btn-danger" id="dropButton">Drop Exam</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary" disabled>Drop Exam</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    let timer = document.getElementById('timer');
    let totalTime = <?php echo $exam_time * 60; ?>; // Convert minutes to seconds

    let countdown = setInterval(function() {
        let hours = Math.floor(totalTime / 3600); // Calculate hours
        let minutes = Math.floor((totalTime % 3600) / 60); // Calculate minutes
        let seconds = totalTime % 60; // Calculate seconds

        // Display hours, minutes, and seconds
        timer.textContent = hours + ':' + (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds < 10 ? '0' + seconds : seconds);

        // Decrease the total time by 1 second
        if (--totalTime < 0) {
            clearInterval(countdown); // Stop the countdown
            alert('Time is up!');
            document.getElementById('examForm').submit(); // Submit the form
        }
    }, 1000);



        // Drop button functionality for 40 seconds
        let dropButton = document.getElementById('dropButton');
        let dropButtonTimeout = setTimeout(function() {
            dropButton.disabled = true;
        }, 10000);  // 40 seconds

        document.getElementById('dropButton').addEventListener('click', function() {
            if (confirm('Are you sure you want to drop the exam?')) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = '<input type="hidden" name="drop_exam" value="1">';
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Disable right-click and keyboard shortcuts
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'x')) || e.key === 'Meta') {
                e.preventDefault();
            }
        });

        // Prevent back navigation
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};

// Alert before leaving the page
window.onbeforeunload = function (e) {
    return "You cannot leave this page without submitting the exam.";
};

// Prevent navigating away without clicking submit
document.getElementById('examForm').addEventListener('submit', function () {
    window.onbeforeunload = null; // Allow leaving after form submission
});

    </script>

    <script>
    document.getElementById('examForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission until validation

        let questions = document.querySelectorAll('.question-container');
        let allAnswered = true; // Assume all questions are answered
        let firstUnanswered = null;

        questions.forEach((questionContainer) => {
            let options = questionContainer.querySelectorAll('input[type="radio"]');
            let questionAnswered = Array.from(options).some(option => option.checked);

            if (!questionAnswered) {
                allAnswered = false;

                // Highlight the question
                questionContainer.style.border = "2px solid red";
                questionContainer.style.padding = "10px";

                // Add message
                let alertMessage = questionContainer.querySelector('.alert-message');
                if (!alertMessage) {
                    let alertDiv = document.createElement('div');
                    alertDiv.className = "alert-message text-danger mt-2";
                    alertDiv.textContent = 
                        "Answer this question.If you do not want to answer this question,please wait after finish time your answer automatic submit and this question ans set to null.";
                    questionContainer.appendChild(alertDiv);
                }

                // Set first unanswered question for scrolling
                if (!firstUnanswered) {
                    firstUnanswered = questionContainer;
                }
            } else {
                // Remove alert if the question is answered
                questionContainer.style.border = "none";
                let alertMessage = questionContainer.querySelector('.alert-message');
                if (alertMessage) {
                    questionContainer.removeChild(alertMessage);
                }
            }
        });

        if (!allAnswered) {
            // Scroll to the first unanswered question
            if (firstUnanswered) {
                firstUnanswered.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        } else {
            // Allow submission if all questions are answered
            window.onbeforeunload = null; // Disable onbeforeunload alert
            this.submit();
        }
    });

    // Fetch submitted answers for the user

</script>


<video id="userVideo" autoplay playsinline></video>
<script>
navigator.mediaDevices.getUserMedia({ video: true, audio: true })
    .then(stream => {
        const video = document.getElementById('userVideo');
        video.srcObject = stream;

        // Connect to WebSocket signaling server
        const socket = new WebSocket('ws://localhost:8080/signaling');

        // Send video stream to signaling server
        const peer = new RTCPeerConnection();
        stream.getTracks().forEach(track => peer.addTrack(track, stream));

        peer.onicecandidate = event => {
            if (event.candidate) {
                socket.send(JSON.stringify({ candidate: event.candidate }));
            }
        };

        // Handle incoming signaling messages
        socket.onmessage = event => {
            const data = JSON.parse(event.data);
            if (data.answer) {
                peer.setRemoteDescription(new RTCSessionDescription(data.answer));
            }
        };

        // Send offer
        peer.createOffer().then(offer => {
            peer.setLocalDescription(offer);
            socket.send(JSON.stringify({ offer: offer }));
        });
    })
    .catch(error => console.error('Camera access denied:', error));
</script>


</body>
</html>
