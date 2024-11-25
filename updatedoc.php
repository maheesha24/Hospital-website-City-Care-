<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portfolio - Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/doctor-portfolio.css">
    
    <style>
        .doctor-profile img {
            width: 200px;
            height: 200px;
        }

        .add-remove-btns button {
            margin-right: 10px;
        }
    </style>
</head>

<body>
<?php include 'header.php';?>
    <section class="doctor-profile py-5">
        <div class="container">
            <div class="row">
                <!-- Doctor Image and Info -->
                <div class="col-lg-4 text-center">
                    <img src="https://via.placeholder.com/200" alt="Doctor Image" class="rounded-circle img-fluid mb-3" id="profile-image">
                    <h1 class="doctor-name" id="doctor-name">Dr. Sarah Johnson</h1>
                    <p class="specialization" id="doctor-specialization">Cardiologist</p>
                    <ul class="list-inline social-icons">
                        <li class="list-inline-item">
                            <a href="#" class="text-primary"><i class="fab fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-info"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-danger"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-dark"><i class="fab fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>

                <!-- Doctor's Bio -->
                <div class="col-lg-8">
                    <h2 class="mb-3">About Dr. Sarah Johnson</h2>
                    <p id="doctor-bio">Dr. Sarah Johnson is a leading cardiologist with over 15 years of experience in treating complex heart conditions.</p>
                    <p id="doctor-email">Email: sarah.johnson@example.com</p>

                    <h3>Key Achievements</h3>
                    <ul class="list-unstyled achievements" id="achievement-list">
                        <li><i class="fas fa-check-circle text-primary"></i> <span>Awarded "Best Cardiologist 2022"</span></li>
                    </ul>

                    <h3>Skills & Expertise</h3>
                    <ul class="list-unstyled skills" id="skill-list">
                        <li><i class="fas fa-check-circle text-primary"></i> <span>Heart Surgery</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Form -->
    <section class="edit-profile py-5">
        <div class="container">
            <h2 class="text-center mb-4">Edit Your Profile</h2>
            <form>
                <!-- Upload Image -->
                <div class="form-row mb-3">
                    <div class="form-group col-md-6">
                        <label for="profileImage">Upload New Profile Image</label>
                        <input type="file" class="form-control-file" id="profileImageInput" onchange="previewImage(event)">
                        <img id="profilePreview" class="mt-3 rounded-circle" width="150" height="150" src="https://via.placeholder.com/150" alt="Profile Preview">
                    </div>
                </div>

                <!-- Name and Specialization -->
                <div class="form-row mb-3">
                    <div class="form-group col-md-6">
                        <label for="doctorName">Name</label>
                        <input type="text" class="form-control" id="doctorName" placeholder="Enter your name" value="Dr. Sarah Johnson">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="specialization">Specialization</label>
                        <input type="text" class="form-control" id="specialization" placeholder="Enter specialization" value="Cardiologist">
                    </div>
                </div>

                <!-- Personal Email -->
                <div class="form-row mb-3">
                    <div class="form-group col-md-12">
                        <label for="personalEmail">Personal Email</label>
                        <input type="email" class="form-control" id="personalEmail" placeholder="Enter your personal email" value="sarah.johnson@example.com">
                    </div>
                </div>

                <!-- Bio -->
                <div class="form-group mb-3">
                    <label for="bio">Bio</label>
                    <textarea class="form-control" id="bio" rows="3">Dr. Sarah Johnson is a leading cardiologist with over 15 years of experience in treating complex heart conditions.</textarea>
                </div>

                <!-- Key Achievements -->
                <div class="form-group mb-3">
                    <label for="achievements">Key Achievements</label>
                    <div id="achievement-fields">
                        <input type="text" class="form-control mb-2" placeholder="Add a new achievement">
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addAchievement"><i class="fas fa-plus"></i> Add Achievement</button>
                </div>

                <!-- Skills & Expertise -->
                <div class="form-group mb-4">
                    <label for="skills">Skills & Expertise</label>
                    <div id="skill-fields">
                        <input type="text" class="form-control mb-2" placeholder="Add a new skill">
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addSkill"><i class="fas fa-plus"></i> Add Skill</button>
                </div>

                <button type="submit" class="btn btn-primary btn-block" onclick="updateProfile()">Save Changes</button>
            </form>
        </div>
    </section>
<?php include 'footer.php';?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Preview image before upload
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const profilePreview = document.getElementById('profilePreview');
                profilePreview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Add new Achievement field
        document.getElementById('addAchievement').addEventListener('click', function() {
            const achievementFields = document.getElementById('achievement-fields');
            const newField = document.createElement('input');
            newField.type = 'text';
            newField.className = 'form-control mb-2';
            newField.placeholder = 'Add a new achievement';
            achievementFields.appendChild(newField);
        });

        // Add new Skill field
        document.getElementById('addSkill').addEventListener('click', function() {
            const skillFields = document.getElementById('skill-fields');
            const newField = document.createElement('input');
            newField.type = 'text';
            newField.className = 'form-control mb-2';
            newField.placeholder = 'Add a new skill';
            skillFields.appendChild(newField);
        });

        // Update profile with new data
        function updateProfile() {
            const doctorName = document.getElementById('doctorName').value;
            const specialization = document.getElementById('specialization').value;
            const personalEmail = document.getElementById('personalEmail').value;
            const bio = document.getElementById('bio').value;

            document.getElementById('doctor-name').textContent = doctorName;
            document.getElementById('doctor-specialization').textContent = specialization;
            document.getElementById('doctor-email').textContent = "Email: " + personalEmail;
            document.getElementById('doctor-bio').textContent = bio;
        }
    </script>

</body>

</html>
