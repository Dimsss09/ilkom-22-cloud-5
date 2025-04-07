<?php
require 'function.php';

// Function to call Gemini API
function callGeminiAPI($prompt) {
    $apiKey = "AIzaSyCB8FuEkyhi3EGF9MldM5WyIemYJglkcpE"; // Replace with your actual API key
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
    
    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];
    
    $options = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === FALSE) {
        return "Error: Unable to connect to Gemini API";
    }
    
    $result = json_decode($response, true);
    
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return $result['candidates'][0]['content']['parts'][0]['text'];
    } else {
        return "Error: Invalid response from Gemini API";
    }
}

// Handle form submission
$chatResponse = "";
if (isset($_POST['prompt']) && !empty($_POST['prompt'])) {
    $prompt = $_POST['prompt'];
    $chatResponse = callGeminiAPI($prompt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AI Assistant - e-Library BRIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="Icon" type="png" href="assets/img/instansi-logo.png">
    <style>
        .chat-container {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        
        .message-wrapper {
            display: flex;
            margin-bottom: 15px;
            width: 100%;
        }
        
        .user-wrapper {
            justify-content: flex-end;
        }
        
        .bot-wrapper {
            justify-content: flex-start;
        }
        
        .user-message, .bot-message {
            padding: 10px 15px;
            border-radius: 0.25rem;
            max-width: 80%;
            word-wrap: break-word;
            display: inline-block;
        }
        
        .user-message {
            background-color: #007bff;
            color: white;
            border-top-right-radius: 0;
        }
        
        .bot-message {
            background-color: #e9ecef;
            color: #212529;
            border-top-left-radius: 0;
        }
        
        .chat-input {
            display: flex;
            margin-bottom: 20px;
        }
        
        .chat-input input {
            flex-grow: 1;
            margin-right: 10px;
        }
        
        .chat-input button {
            min-width: 100px;
        }
        
        .typing-indicator {
            display: none;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            color: #6c757d;
            width: fit-content;
        }
        
        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #6c757d;
            border-radius: 50%;
            margin-right: 5px;
            animation: typing 1s infinite;
        }
        
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typing {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <img src="assets/img/instansi-logo.png" alt="Logo BRIDA" height="40" class="me-2">
                <h1>AI Assistant - e-Library BRIDA</h1>
            </div>
            <div>
                <a href="home.php" class="btn" style="background-color: #FFC107; color: black;">Home</a>
                <a href="login.php" class="btn" style="background-color: #FFC107; color: black;">Login</a>
            </div>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="depan.php">Home</a></li>
            <li class="breadcrumb-item active">AI Assistant</li>
        </ol>
        
        <div class="card mb-4">
            <div class="card-header text-center" style="background-color: #003366; color: white;">
                <i class="fas fa-robot me-1"></i>
                <span>Chat with AI Assistant</span>
                <i class="fas fa-robot ms-1"></i>
            </div>
            <div class="card-body">
                <div class="chat-container" id="chatContainer">
                    <div class="message-wrapper bot-wrapper">
                        <div class="bot-message">
                            Hello! I'm your AI Assistant. How can I help you today?
                        </div>
                    </div>
                    
                    <?php if (!empty($chatResponse)): ?>
                        <div class="message-wrapper user-wrapper">
                            <div class="user-message">
                                <?php echo htmlspecialchars($_POST['prompt']); ?>
                            </div>
                        </div>
                        <div class="message-wrapper bot-wrapper">
                            <div class="bot-message">
                                <?php echo nl2br(htmlspecialchars($chatResponse)); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="message-wrapper bot-wrapper">
                        <div class="typing-indicator" id="typingIndicator">
                            <span></span>
                            <span></span>
                            <span></span>
                            AI Assistant is typing...
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="" id="chatForm">
                    <div class="chat-input">
                        <input type="text" class="form-control" name="prompt" id="prompt" placeholder="Type your message here..." required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted"> &copy; KKP Ilmu Komputer UHO 2025</div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatContainer = document.getElementById('chatContainer');
            const chatForm = document.getElementById('chatForm');
            const promptInput = document.getElementById('prompt');
            const typingIndicator = document.getElementById('typingIndicator');
            
            // Scroll to bottom of chat container
            function scrollToBottom() {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
            
            // Initial scroll to bottom
            scrollToBottom();
            
            // Handle form submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const prompt = promptInput.value.trim();
                if (!prompt) return;
                
                // Add user message to chat
                const userWrapper = document.createElement('div');
                userWrapper.className = 'message-wrapper user-wrapper';
                
                const userMessageDiv = document.createElement('div');
                userMessageDiv.className = 'user-message';
                userMessageDiv.textContent = prompt;
                
                userWrapper.appendChild(userMessageDiv);
                chatContainer.appendChild(userWrapper);
                
                // Show typing indicator
                typingIndicator.style.display = 'block';
                
                // Clear input
                promptInput.value = '';
                
                // Scroll to bottom
                scrollToBottom();
                
                // Submit form via AJAX
                const formData = new FormData(chatForm);
                
                fetch('gemini-chat.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    // Hide typing indicator
                    typingIndicator.style.display = 'none';
                    
                    // Create a temporary container to parse the HTML
                    const tempContainer = document.createElement('div');
                    tempContainer.innerHTML = html;
                    
                    // Extract the bot response
                    const botResponses = tempContainer.querySelectorAll('.bot-message');
                    if (botResponses.length > 0) {
                        const lastBotResponse = botResponses[botResponses.length - 1];
                        
                        // Add bot response to chat
                        const botWrapper = document.createElement('div');
                        botWrapper.className = 'message-wrapper bot-wrapper';
                        
                        const botMessageDiv = document.createElement('div');
                        botMessageDiv.className = 'bot-message';
                        botMessageDiv.innerHTML = lastBotResponse.innerHTML;
                        
                        botWrapper.appendChild(botMessageDiv);
                        chatContainer.appendChild(botWrapper);
                        
                        // Scroll to bottom
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    typingIndicator.style.display = 'none';
                    
                    // Add error message
                    const botWrapper = document.createElement('div');
                    botWrapper.className = 'message-wrapper bot-wrapper';
                    
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'bot-message';
                    errorDiv.textContent = 'Sorry, there was an error processing your request.';
                    
                    botWrapper.appendChild(errorDiv);
                    chatContainer.appendChild(botWrapper);
                    
                    // Scroll to bottom
                    scrollToBottom();
                });
            });
        });
    </script>
</body>
</html>
