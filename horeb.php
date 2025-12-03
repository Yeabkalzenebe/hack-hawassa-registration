<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Collect form data
    $data = [
        "name" => $_POST["name"] ?? '',
        "department" => $_POST["department"] ?? '',
        "year" => $_POST["year"] ?? '',
        "role" => $_POST["role"] ?? '',
        "expectations" => $_POST["expectations"] ?? ''  // Added this line
    ];

    // Add role-specific data
    if (($data["role"] ?? '') == "student") {
        $data["category"] = $_POST["student_category"] ?? '';
    }

    if (($data["role"] ?? '') == "professional") {
        $data["profession"] = $_POST["profession_type"] ?? '';
    }

    // Load existing data
    $file = "registrations.json";
    $old = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    // Add new registration
    $old[] = $data;

    // Save to file
    file_put_contents($file, json_encode($old, JSON_PRETTY_PRINT));

    // Redirect to same page to clear form (POST-REDIRECT-GET pattern)
    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hack-Hawassa Registration</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3053f1ff 0%, #ddd2e8ff 100%);
            padding: 01px;
            min-height: 120vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            font-family: 'Times New Roman', Times, serif;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 30px;
        }

        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
            font-family: Arial, sans-serif;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #4867efff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .hidden {
            display: none;
        }

        .role-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #667eea;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
        }

        .optional {
            color: #666;
            font-size: 0.9em;
            font-weight: normal;
        }

        /* Animation for role sections */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .role-section:not(.hidden) {
            animation: fadeIn 0.3s ease;
        }

        /* Success flash message */
        .flash-message {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            display: none;
        }

        .flash-message.show {
            display: block;
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .expectations-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>

<div class="container">
    <h2> Hack-Hawassa Registration <br>
         HOREB DS <br>
        💻DIGITAL MISSION<BR>
        ♾️ETERNAL VISSON
    </h2>
    <!-- Flash message (hidden by default) -->
    <div id="flashMessage" class="flash-message">
        ✅ Registration submitted successfully!
    </div>

    <form method="POST" id="registrationForm">
        <div class="form-group">
            <label class="required">Full Name:</label>
            <input type="text" name="name" required placeholder="Enter your full name">
        </div>

        <div class="form-group">
            <label class="required">Department:</label>
            <input type="text" name="department" required placeholder="e.g., Computer Science">
        </div>

        <div class="form-group">
            <label class="required">Year:</label>
            <input type="text" name="year" required placeholder="e.g., 3rd year">
        </div>

         <div class="form-group">
            <label class="required">Team:</label>
            <input type="text" name="year" required placeholder="e.g., Horeb">
            </div>

        <div class="form-group">
            <label class="required">Register As:</label>
            <select name="role" id="role" onchange="showOptions()" required>
                <option value="">-- Select Your Role --</option>
                <option value="student">🎓 Student</option>
                <option value="professional">💼 Professional</option>
            </select>
        </div>

        <!-- STUDENT SECTION -->
        <div id="student_section" class="role-section hidden">
            <label class="required">Skill Category:</label>
            <select name="student_category">
                <option value="">-- Select Your Skill --</option>
                <option value="Video - Cinematography">🎥 Video - Cinematography</option>
                <option value="Video - Editing">✂️ Video - Editing</option>
                <option value="Video - Acting">🎭 Video - Acting</option>
                <option value="Video - Writing">✍️ Video - Writing</option>
                <option value="Song - Mixing">🎵 Song - Mixing</option>
                <option value="Song - Writing">📝 Song - Writing</option>
                <option value="Song - Melody">🎶 Song - Melody</option>
                <option value="Developing - Front-end">💻 Developing - Front-end</option>
                <option value="Developing - Back-end">⚙️ Developing - Back-end</option>
                <option value="Developing - Full stack">🚀 Developing - Full Stack</option>
            </select>
        </div>

        <!-- PROFESSIONAL SECTION -->
        <div id="professional_section" class="role-section hidden">
            <label class="required">Profession:</label>
            <select name="profession_type">
                <option value="">-- Select Your Profession --</option>
                <option value="Production">🎬 Production</option>
                <option value="Full Stack Developer">👨‍💻 Full Stack Developer</option>
                <option value="Song Maker">🎹 Song Maker</option>
            </select>
        </div>

        <!-- EXPECTATIONS SECTION -->
        <div class="expectations-section form-group">
            <label>What do you expect from this program? <span class="optional">(Optional)</span></label>
            <textarea 
                name="expectations" 
                placeholder="Please share your expectations, goals, or what you hope to learn from Hack-Hawassa..."
                maxlength="500"
            ></textarea>
            <small style="color: #666; display: block; text-align: right; margin-top: 5px;">Max 500 characters</small>
        </div>

        <button type="submit">📝 Register Now</button>
    </form>
</div>

<script>
function showOptions() {
    let role = document.getElementById("role").value;
    const studentSection = document.getElementById("student_section");
    const professionalSection = document.getElementById("professional_section");
    
    // Hide both sections first
    studentSection.classList.add('hidden');
    professionalSection.classList.add('hidden');
    
    // Remove required attributes initially
    document.querySelector("select[name='student_category']").required = false;
    document.querySelector("select[name='profession_type']").required = false;
    
    if (role === "student") {
        studentSection.classList.remove('hidden');
        document.querySelector("select[name='student_category']").required = true;
    }
    else if (role === "professional") {
        professionalSection.classList.remove('hidden');
        document.querySelector("select[name='profession_type']").required = true;
    }
}

// Check if form was just submitted
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        const flashMsg = document.getElementById('flashMessage');
        flashMsg.classList.add('show');
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            flashMsg.classList.remove('show');
        }, 3000);
        
        // Remove success parameter from URL
        history.replaceState({}, document.title, window.location.pathname);
    }
    
    // Clear form after successful submission
    const url = window.location.href;
    if (!url.includes('?')) {
        document.getElementById('registrationForm').reset();
    }
}
</script>

</body>
</html>
