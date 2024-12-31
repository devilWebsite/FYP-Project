<section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Edit Profile
          </p>
        </header>


        <div class="card-content">
        <form id="avatar-form" enctype="multipart/form-data">
            <div class="field">
            <label class="label">Avatar</label>
            <div class="field-body">
                <div class="field file">
                <label class="upload control">
                    <input type="file" id="avatar-input" accept="image/*">
                    <a class="button blue" id="upload-button">
                    Upload
                    </a>
                </label>
                </div>
            </div>
            </div>
            <hr>
            <div class="field">
              <label class="label">Name</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="on" name="name" value="" class="input" required>
                  </div>
                  <p class="help">Required. Your name</p>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">E-mail</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="email" autocomplete="on" name="email" value="" class="input" required>
                  </div>
                  <p class="help">Required. Your e-mail</p>
                </div>
              </div>
            </div>
            <hr>
            <div class="field">
              <div class="control">
                <button type="submit" class="button green">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>


      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Profile
          </p>
        </header>
        <div class="card-content">
        <div class="image w-48 h-48 mx-auto" id="avatar-preview">
            <img src="assets/images1/avatar.jpg" alt="Avatar" class="rounded-full" id="avatar-image">
        </div>
        <button class="button red" id="remove-button">Remove Picture</button>
        <input type="file" id="avatar-input" style="display: none;" accept="image/*">
        </div>

          <hr>
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input type="text" readonly value="" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
              <input type="text" readonly value="" class="input is-static">
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-lock"></i></span>
          Change Password
        </p>
      </header>
      <div class="card-content">
        <form>
          <div class="field">
            <label class="label">Current password</label>
            <div class="control">
              <input type="password" name="password_current" autocomplete="current-password" class="input" required>
            </div>
            <p class="help">Required. Your current password</p>
          </div>
          <hr>
          <div class="field">
            <label class="label">New password</label>
            <div class="control">
              <input type="password" autocomplete="new-password" name="password" class="input" required>
            </div>
            <p class="help">Required. New password</p>
          </div>
          <div class="field">
            <label class="label">Confirm password</label>
            <div class="control">
              <input type="password" autocomplete="new-password" name="password_confirmation" class="input" required>
            </div>
            <p class="help">Required. New password one more time</p>
          </div>
          <hr>
          <div class="field">
            <div class="control">
              <button type="submit" class="button green">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
// Function to handle file upload
function handleFileUpload(event) {
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onload = function(e) {
    const previewImage = document.createElement('img');
    previewImage.src = e.target.result;
    previewImage.alt = 'Avatar';
    previewImage.className = 'rounded-full';
    previewImage.id = 'avatar-image'; // Assigning an ID for easy reference
    
    const avatarPreview = document.getElementById('avatar-preview');
    avatarPreview.innerHTML = ''; // Clear previous preview
    avatarPreview.appendChild(previewImage);
  }

  if (file) {
    reader.readAsDataURL(file);
  }
}

// Event listener for file input change
const fileInput = document.getElementById('avatar-input');
fileInput.addEventListener('change', handleFileUpload);

// Event listener for upload button (optional, can be used for UX purposes)
const uploadButton = document.getElementById('upload-button');
uploadButton.addEventListener('click', function() {
  fileInput.click(); // Trigger file input click when upload button is clicked
});

// Event listener for remove button
const removeButton = document.getElementById('remove-button');
removeButton.addEventListener('click', function() {
  const avatarPreview = document.getElementById('avatar-preview');
  avatarPreview.innerHTML = '<img src="assets/images1/avatar.jpg" alt="Avatar" class="rounded-full" id="avatar-image">';
});



  </script>

  <style>
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f6;
    margin: 0;
    padding: 20px;
}

.section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Grid Layout */
.grid {
    display: grid;
    gap: 20px;
}

.grid-cols-1 {
    grid-template-columns: 1fr;
}

@media (min-width: 1024px) {
    .lg\:grid-cols-2 {
        grid-template-columns: 1fr 1fr;
    }
}

/* Card Styles */
.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background: #f5f5f5;
    padding: 16px;
    border-bottom: 1px solid #e5e5e5;
}

.card-header-title {
    font-size: 18px;
    font-weight: bold;
    display: flex;
    align-items: center;
}

.card-header-title .icon {
    margin-right: 10px;
}

.card-content {
    padding: 20px;
}

/* Form Styles */
.field {
    margin-bottom: 20px;
}

.label {
    font-weight: bold;
    margin-bottom: 5px;
}

.control {
    display: flex;
    align-items: center;
}

.input {
    width: 100%;
    padding: 10px;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
}

.input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.input.is-static {
    background-color: #f5f5f5;
    cursor: not-allowed;
}

.button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.button.blue {
    background-color: #007bff;
}

.button.green {
    background-color: #28a745;
}

.button:focus,
.button:hover {
    background-color: #0056b3;
}

.button.green:focus,
.button.green:hover {
    background-color: #218838;
}

/* Image Styles */
.image {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.image img {
    border-radius: 50%;
}

/* Helpers */
.help {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.hr {
    margin: 20px 0;
    border: 0;
    border-top: 1px solid #e5e5e5;
}

  </style>
