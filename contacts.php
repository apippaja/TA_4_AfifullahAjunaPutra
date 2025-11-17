<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$login_time = $_SESSION['login_time'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .header-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 25px 0;
            margin-bottom: 30px;
        }
        
        .user-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .header-section h1 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 2.2rem;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            border: none;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .required:after {
            content: " *";
            color: #dc3545;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #e63946, #d00000);
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.4);
        }
        
        .contact-photo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .contact-photo:hover {
            border-color: var(--primary-color);
            transform: scale(1.1);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--primary-color);
            padding: 15px 12px;
            background-color: #f8f9fa;
        }
        
        .table td {
            padding: 15px 12px;
            vertical-align: middle;
            border-color: #f1f3f4;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
        }
        
        .search-box {
            position: relative;
            max-width: 300px;
        }
        
        .search-box .form-control {
            padding-left: 45px;
            border-radius: 25px;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 2;
        }
        
        .stats-card {
            text-align: center;
            padding: 20px;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #6c757d;
            font-weight: 500;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }
        
        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 1.8rem;
            }
            
            .card-header h5 {
                font-size: 1.1rem;
            }
            
            .btn-action {
                margin-bottom: 5px;
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bi bi-person-lines-fill"></i> Sistem Manajemen Kontak</h1>
                    <p class="lead mb-0">Kelola daftar kontak Anda dengan mudah dan efisien</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="user-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-person-circle me-2"></i>
                                <strong><?php echo htmlspecialchars($username); ?></strong>
                                <br>
                                <small>Login: <?php echo date('d/m/Y H:i', $login_time); ?></small>
                            </div>
                            <a href="?logout=true" class="btn btn-logout btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Alert untuk notifikasi -->
        <div id="alertContainer"></div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="stats-number" id="totalContacts">0</div>
                    <div class="stats-label">Total Kontak</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="stats-number" id="recentContacts">0</div>
                    <div class="stats-label">Kontak Baru</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon">
                                <i class="bi bi-lightning-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h5>
                                <p class="mb-0 text-muted">Anda login sejak <?php echo date('H:i', $login_time); ?> - Kelola kontak dengan aman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <!-- Form Tambah/Edit Kontak -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-person-plus" id="formIcon"></i> <span id="formTitle">Tambah Kontak Baru</span></h5>
                    </div>
                    <div class="card-body">
                        <form id="contactForm" novalidate>
                            <input type="hidden" id="contactId">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="name" class="form-label required">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" placeholder="Masukkan nama lengkap" required>
                                    <div class="invalid-feedback">
                                        Harap masukkan nama kontak.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label required">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Contoh: 08123456789" required>
                                    <div class="invalid-feedback">
                                        Harap masukkan nomor telepon yang valid.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="nama@email.com">
                                    <div class="invalid-feedback">
                                        Harap masukkan alamat email yang valid.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="photo" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control" id="photo" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF (Maks. 5MB)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="address" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" id="cancelBtn" class="btn btn-outline-secondary" style="display: none;">
                                    <i class="bi bi-x-circle"></i> Batal Edit
                                </button>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="bi bi-check-circle" id="submitIcon"></i> <span id="submitText">Simpan Kontak</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <!-- Daftar Kontak -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="bi bi-list-ul"></i> Daftar Kontak</h5>
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari kontak...">
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 500px;">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th width="80">Foto</th>
                                        <th>Nama</th>
                                        <th>Telepon</th>
                                        <th width="200">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="contactTableBody">
                                    <!-- Data kontak akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div id="emptyMessage" class="empty-state" style="display: none;">
                            <i class="bi bi-person-x"></i>
                            <h4>Belum Ada Kontak</h4>
                            <p class="text-muted">Mulai dengan menambahkan kontak pertama Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="bi bi-exclamation-triangle text-warning"></i> Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-person-x display-4 text-danger mb-3"></i>
                    <h5>Apakah Anda yakin?</h5>
                    <p class="text-muted">Kontak yang dihapus tidak dapat dikembalikan. Tindakan ini permanen.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="bi bi-trash"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let contacts = JSON.parse(sessionStorage.getItem('contacts')) || [];
        let currentEditId = null;
        let deleteId = null;

        const contactForm = document.getElementById('contactForm');
        const contactTableBody = document.getElementById('contactTableBody');
        const emptyMessage = document.getElementById('emptyMessage');
        const formTitle = document.getElementById('formTitle');
        const formIcon = document.getElementById('formIcon');
        const submitText = document.getElementById('submitText');
        const submitIcon = document.getElementById('submitIcon');
        const cancelBtn = document.getElementById('cancelBtn');
        const searchInput = document.getElementById('searchInput');
        const alertContainer = document.getElementById('alertContainer');
        const totalContacts = document.getElementById('totalContacts');
        const recentContacts = document.getElementById('recentContacts');

        document.addEventListener('DOMContentLoaded', function() {
            renderContacts();
            updateStats();
            
            contactForm.addEventListener('submit', handleFormSubmit);
            cancelBtn.addEventListener('click', resetForm);
            searchInput.addEventListener('input', handleSearch);
            
            const inputs = contactForm.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('blur', validateField);
                input.addEventListener('input', validateField);
            });
        });

        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : type === 'danger' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill'} me-2"></i>
                    <div>${message}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            alertContainer.appendChild(alert);
            
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 4000);
        }
        function updateStats() {
            totalContacts.textContent = contacts.length;
            
            
            const oneDayAgo = Date.now() - (24 * 60 * 60 * 1000);
            const recent = contacts.filter(contact => parseInt(contact.id) > oneDayAgo);
            recentContacts.textContent = recent.length;
        }

        function validateField(e) {
            const field = e.target;
            
            if (field.id === 'email' && field.value && !isValidEmail(field.value)) {
                field.classList.add('is-invalid');
                return false;
            }
            
            if (field.id === 'phone' && field.value && !isValidPhone(field.value)) {
                field.classList.add('is-invalid');
                return false;
            }
            
            if (field.hasAttribute('required') && !field.value.trim()) {
                field.classList.add('is-invalid');
                return false;
            }
            
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            return true;
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhone(phone) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
            return phoneRegex.test(phone);
        }

        function validateForm() {
            let isValid = true;
            
            const name = document.getElementById('name');
            const phone = document.getElementById('phone');
            const email = document.getElementById('email');
            
           
            if (!name.value.trim()) {
                name.classList.add('is-invalid');
                isValid = false;
            } else {
                name.classList.remove('is-invalid');
            }
            
            if (!phone.value.trim()) {
                phone.classList.add('is-invalid');
                isValid = false;
            } else if (!isValidPhone(phone.value)) {
                phone.classList.add('is-invalid');
                isValid = false;
            } else {
                phone.classList.remove('is-invalid');
            }
            
        
            if (email.value && !isValidEmail(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            } else {
                email.classList.remove('is-invalid');
            }
            
            return isValid;
        }

    
        function handleFormSubmit(e) {
            e.preventDefault();
            
            if (!validateForm()) {
                showAlert('Harap periksa kembali data yang Anda masukkan.', 'danger');
                return;
            }
            
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
            const address = document.getElementById('address').value.trim();
            const photoInput = document.getElementById('photo');
            
            // Handle foto profil
            let photo = '';
            if (photoInput.files && photoInput.files[0]) {
            
                if (photoInput.files[0].size > 5 * 1024 * 1024) {
                    showAlert('Ukuran file terlalu besar. Maksimal 5MB.', 'danger');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    photo = e.target.result;
                    saveContact(name, phone, email, address, photo);
                };
                reader.readAsDataURL(photoInput.files[0]);
            } else {
                saveContact(name, phone, email, address, photo);
            }
        }

    
        function saveContact(name, phone, email, address, photo) {
            if (currentEditId) {
            
                const index = contacts.findIndex(contact => contact.id === currentEditId);
                if (index !== -1) {
                    contacts[index] = {
                        ...contacts[index],
                        name,
                        phone,
                        email,
                        address,
                        photo: photo || contacts[index].photo
                    };
                    
                    showAlert('Kontak berhasil diperbarui!', 'success');
                }
            } else {
        
                const newContact = {
                    id: Date.now().toString(),
                    name,
                    phone,
                    email,
                    address,
                    photo,
                    createdAt: new Date().toISOString()
                };
                
                contacts.push(newContact);
                showAlert('Kontak berhasil ditambahkan!', 'success');
            }
            
    
            sessionStorage.setItem('contacts', JSON.stringify(contacts));
            
        
            resetForm();
            renderContacts();
            updateStats();
        }

    
        function resetForm() {
            contactForm.reset();
            currentEditId = null;
            formTitle.textContent = 'Tambah Kontak Baru';
            formIcon.className = 'bi bi-person-plus';
            submitText.textContent = 'Simpan Kontak';
            submitIcon.className = 'bi bi-check-circle';
            cancelBtn.style.display = 'none';
            
        
            const inputs = contactForm.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });
        }


        function editContact(id) {
            const contact = contacts.find(contact => contact.id === id);
            if (!contact) return;
            
            document.getElementById('contactId').value = contact.id;
            document.getElementById('name').value = contact.name;
            document.getElementById('phone').value = contact.phone;
            document.getElementById('email').value = contact.email || '';
            document.getElementById('address').value = contact.address || '';
            
            currentEditId = id;
            formTitle.textContent = 'Edit Kontak';
            formIcon.className = 'bi bi-pencil-square';
            submitText.textContent = 'Update Kontak';
            submitIcon.className = 'bi bi-arrow-clockwise';
            cancelBtn.style.display = 'block';
            

            contactForm.scrollIntoView({ behavior: 'smooth' });
        }

    
        function deleteContact(id) {
            deleteId = id;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

       
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteId) {
                contacts = contacts.filter(contact => contact.id !== deleteId);
                sessionStorage.setItem('contacts', JSON.stringify(contacts));
                renderContacts();
                updateStats();
                showAlert('Kontak berhasil dihapus!', 'success');
                
                
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                deleteModal.hide();
                
                deleteId = null;
            }
        });


        function renderContacts(filteredContacts = null) {
            const contactsToRender = filteredContacts || contacts;
            
            if (contactsToRender.length === 0) {
                contactTableBody.innerHTML = '';
                emptyMessage.style.display = 'block';
                return;
            }
            
            emptyMessage.style.display = 'none';
            
            let tableHTML = '';
            contactsToRender.forEach(contact => {
                tableHTML += `
                    <tr>
                        <td>
                            ${contact.photo 
                                ? `<img src="${contact.photo}" class="contact-photo" alt="${contact.name}" title="${contact.name}">`
                                : `<div class="contact-photo bg-gradient-primary d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                      <i class="bi bi-person-fill"></i>
                                   </div>`
                            }
                        </td>
                        <td>
                            <div class="fw-semibold">${contact.name}</div>
                            ${contact.email ? `<small class="text-muted">${contact.email}</small>` : ''}
                        </td>
                        <td>
                            <div class="fw-medium">${contact.phone}</div>
                            ${contact.address ? `<small class="text-muted">${contact.address.substring(0, 30)}${contact.address.length > 30 ? '...' : ''}</small>` : ''}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary btn-action" onclick="editContact('${contact.id}')" title="Edit Kontak">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-action" onclick="deleteContact('${contact.id}')" title="Hapus Kontak">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            contactTableBody.innerHTML = tableHTML;
        }

        function handleSearch(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            if (!searchTerm) {
                renderContacts();
                return;
            }
            
            const filteredContacts = contacts.filter(contact => 
                contact.name.toLowerCase().includes(searchTerm) ||
                contact.phone.toLowerCase().includes(searchTerm) ||
                (contact.email && contact.email.toLowerCase().includes(searchTerm)) ||
                (contact.address && contact.address.toLowerCase().includes(searchTerm))
            );
            
            renderContacts(filteredContacts);
        }
    </script>
</body>
</html>
