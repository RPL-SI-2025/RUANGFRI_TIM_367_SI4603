document.addEventListener('DOMContentLoaded', function() {
    
    const tabBtns = document.querySelectorAll('.tab-btn');
    const authForms = document.querySelectorAll('.auth-form');
    const formsContainer = document.querySelector('.forms-container');
    
    
    function adjustFormHeight() {
        const activeForm = document.querySelector('.auth-form.active');
        if (activeForm) {
            
            const formHeight = activeForm.scrollHeight;
            
            const minHeight = Math.max(formHeight + 40, 600);
            formsContainer.style.minHeight = minHeight + 'px';
        }
    }
    
    
    setTimeout(adjustFormHeight, 100);
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            
            authForms.forEach(form => {
                form.classList.remove('active');
                if (form.id === targetTab + '-form') {
                    setTimeout(() => {
                        form.classList.add('active');
                        
                        setTimeout(adjustFormHeight, 450);
                    }, 150);
                }
            });
        });
    });
    
    
    window.addEventListener('resize', function() {
        setTimeout(adjustFormHeight, 100);
    });
    
    
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('login-email');
            const password = document.getElementById('login-password');
            let isValid = true;
            
            
            loginBtn.classList.add('loading');
            
            
            if (!email.value.trim()) {
                showFieldError(email, 'Email harus diisi');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showFieldError(email, 'Format email tidak valid');
                isValid = false;
            } else {
                clearFieldError(email);
            }
            
            
            if (!password.value.trim()) {
                showFieldError(password, 'Password harus diisi');
                isValid = false;
            } else if (password.value.length < 6) {
                showFieldError(password, 'Password minimal 6 karakter');
                isValid = false;
            } else {
                clearFieldError(password);
            }
            
            if (!isValid) {
                e.preventDefault();
                loginBtn.classList.remove('loading');
                loginForm.classList.add('shake');
                setTimeout(() => {
                    loginForm.classList.remove('shake');
                }, 500);
            }
        });
    }
    
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const nim = document.getElementById('nim');
            const nama = document.getElementById('nama_mahasiswa');
            const email = document.getElementById('register-email');
            const password = document.getElementById('register-password');
            const confirmPassword = document.getElementById('password_confirmation');
            const terms = document.getElementById('terms');
            let isValid = true;
            
            
            registerBtn.classList.add('loading');
            
            
            if (!nim.value.trim()) {
                showFieldError(nim, 'NIM harus diisi');
                isValid = false;
            } else if (nim.value.length < 8) {
                showFieldError(nim, 'NIM minimal 8 karakter');
                isValid = false;
            } else {
                clearFieldError(nim);
            }
            
            if (!nama.value.trim()) {
                showFieldError(nama, 'Nama harus diisi');
                isValid = false;
            } else if (nama.value.length < 3) {
                showFieldError(nama, 'Nama minimal 3 karakter');
                isValid = false;
            } else {
                clearFieldError(nama);
            }
            
            if (!email.value.trim()) {
                showFieldError(email, 'Email harus diisi');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showFieldError(email, 'Format email tidak valid');
                isValid = false;
            } else {
                clearFieldError(email);
            }
            
            if (!password.value.trim()) {
                showFieldError(password, 'Password harus diisi');
                isValid = false;
            } else if (password.value.length < 8) {
                showFieldError(password, 'Password minimal 8 karakter');
                isValid = false;
            } else {
                clearFieldError(password);
            }
            
            if (!confirmPassword.value.trim()) {
                showFieldError(confirmPassword, 'Konfirmasi password harus diisi');
                isValid = false;
            } else if (password.value !== confirmPassword.value) {
                showFieldError(confirmPassword, 'Password tidak cocok');
                isValid = false;
            } else {
                clearFieldError(confirmPassword);
            }
            
            if (!terms.checked) {
                
                showCustomAlert('Anda harus menyetujui syarat dan ketentuan', 'warning');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                registerBtn.classList.remove('loading');
                registerForm.classList.add('shake');
                setTimeout(() => {
                    registerForm.classList.remove('shake');
                    
                    adjustFormHeight();
                }, 500);
            }
        });
    }
    
    
    const registerPassword = document.getElementById('register-password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const passwordMatch = document.getElementById('passwordMatch');
    
    if (registerPassword) {
        registerPassword.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            
            if (strengthBar) {
                strengthBar.className = 'strength-fill ' + strength.class;
            }
            if (strengthText) {
                strengthText.textContent = strength.text;
            }
            
            
            setTimeout(adjustFormHeight, 50);
        });
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const password = registerPassword ? registerPassword.value : '';
            const confirm = this.value;
            
            if (passwordMatch) {
                if (confirm) {
                    if (password === confirm) {
                        passwordMatch.textContent = '✓ Password cocok';
                        passwordMatch.className = 'password-match match';
                    } else {
                        passwordMatch.textContent = '✗ Password tidak cocok';
                        passwordMatch.className = 'password-match no-match';
                    }
                } else {
                    passwordMatch.textContent = '';
                    passwordMatch.className = 'password-match';
                }
            }
            
            
            setTimeout(adjustFormHeight, 50);
        });
    }
    
    
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            if (this.value.trim() !== '') {
                clearFieldError(this);
            }
        });
        
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                clearFieldError(this);
                
                setTimeout(adjustFormHeight, 50);
            }
        });
    });
    
    
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
                
                adjustFormHeight();
            }, 300);
        }, 5000);
    });
    
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            
            const focusableElements = document.querySelectorAll(
                'input, button, select, textarea, a[href], [tabindex]:not([tabindex="-1"])'
            );
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            
            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            } else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
        
        if (e.key === 'Enter' && document.activeElement.type !== 'submit') {
            const inputs = Array.from(document.querySelectorAll('input:not([type="submit"]):not([type="checkbox"])'));
            const currentIndex = inputs.indexOf(document.activeElement);
            
            if (currentIndex > -1 && currentIndex < inputs.length - 1) {
                inputs[currentIndex + 1].focus();
            }
        }
    });
    
    
    const socialBtns = document.querySelectorAll('.btn-social');
    socialBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            
            this.classList.add('loading');
            this.innerHTML = '<div class="spinner"></div> Connecting...';
            
            
            setTimeout(() => {
                this.classList.remove('loading');
                this.innerHTML = '<i class="fab fa-google"></i> Masuk dengan Google';
                showCustomAlert('Fitur login sosial akan segera tersedia!', 'info');
            }, 2000);
        });
    });
    
    
    const observer = new MutationObserver(function(mutations) {
        let shouldAdjust = false;
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' || mutation.type === 'attributes') {
                shouldAdjust = true;
            }
        });
        
        if (shouldAdjust) {
            setTimeout(adjustFormHeight, 50);
        }
    });
    
    
    if (formsContainer) {
        observer.observe(formsContainer, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['class', 'style']
        });
    }
    
    
    initializeTooltips();
    
    
    const urlParams = new URLSearchParams(window.location.search);
    const initialTab = urlParams.get('tab');
    if (initialTab && (initialTab === 'login' || initialTab === 'register')) {
        const targetBtn = document.querySelector(`[data-tab="${initialTab}"]`);
        if (targetBtn) {
            targetBtn.click();
        }
    }
});


function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    const toggle = input.nextElementSibling;
    if (!toggle) return;
    
    const icon = toggle.querySelector('i');
    if (!icon) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        toggle.setAttribute('title', 'Sembunyikan password');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        toggle.setAttribute('title', 'Tampilkan password');
    }
}


function showFieldError(field, message) {
    if (!field) return;
    
    field.classList.add('is-invalid');
    
    let feedback = field.parentElement.parentElement.querySelector('.invalid-feedback');
    if (!feedback) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        field.parentElement.parentElement.appendChild(feedback);
    }
    feedback.textContent = message;
    
    
    field.classList.add('shake');
    setTimeout(() => {
        field.classList.remove('shake');
    }, 500);
}

function clearFieldError(field) {
    if (!field) return;
    
    field.classList.remove('is-invalid');
    const feedback = field.parentElement.parentElement.querySelector('.invalid-feedback');
    if (feedback && !feedback.id) {
        feedback.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function checkPasswordStrength(password) {
    let score = 0;
    
    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[a-z]/.test(password)) score++;
    if (/\d/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    switch (score) {
        case 0:
        case 1:
            return { class: 'weak', text: 'Password lemah' };
        case 2:
            return { class: 'fair', text: 'Password sedang' };
        case 3:
        case 4:
            return { class: 'good', text: 'Password baik' };
        case 5:
            return { class: 'strong', text: 'Password kuat' };
        default:
            return { class: '', text: 'Masukkan password' };
    }
}

function showCustomAlert(message, type = 'info') {
    
    const existingAlerts = document.querySelectorAll('.custom-alert');
    existingAlerts.forEach(alert => alert.remove());
    
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} custom-alert fade show`;
    alert.style.position = 'fixed';
    alert.style.top = '20px';
    alert.style.left = '50%';
    alert.style.transform = 'translateX(-50%)';
    alert.style.zIndex = '9999';
    alert.style.minWidth = '300px';
    alert.style.maxWidth = '500px';
    
    let icon = 'fa-info-circle';
    if (type === 'warning') icon = 'fa-exclamation-triangle';
    if (type === 'danger') icon = 'fa-exclamation-circle';
    if (type === 'success') icon = 'fa-check-circle';
    
    alert.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas ${icon} me-2"></i>
            <span>${message}</span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.appendChild(alert);
    
    
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

function initializeTooltips() {
    
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.setAttribute('title', 'Tampilkan password');
        toggle.setAttribute('data-bs-toggle', 'tooltip');
        toggle.setAttribute('data-bs-placement', 'top');
    });
    
    
    const socialBtns = document.querySelectorAll('.btn-social');
    socialBtns.forEach(btn => {
        btn.setAttribute('title', 'Login dengan akun Google Anda');
        btn.setAttribute('data-bs-toggle', 'tooltip');
        btn.setAttribute('data-bs-placement', 'bottom');
    });
    
    
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
}


function validateNIM(nim) {
    
    const nimPattern = /^[0-9]{8,12}$/;
    return nimPattern.test(nim);
}

function validateIndonesianName(name) {
    
    const namePattern = /^[a-zA-Z\s\u00C0-\u017F\u1EA0-\u1EF9]+$/;
    return namePattern.test(name) && name.length >= 3;
}


function getPasswordSuggestions(password) {
    const suggestions = [];
    
    if (password.length < 8) {
        suggestions.push('Gunakan minimal 8 karakter');
    }
    if (!/[A-Z]/.test(password)) {
        suggestions.push('Tambahkan huruf besar');
    }
    if (!/[a-z]/.test(password)) {
        suggestions.push('Tambahkan huruf kecil');
    }
    if (!/\d/.test(password)) {
        suggestions.push('Tambahkan angka');
    }
    if (!/[^A-Za-z0-9]/.test(password)) {
        suggestions.push('Tambahkan karakter khusus (!@#$%^&*)');
    }
    
    return suggestions;
}


window.addEventListener('load', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    
    document.body.classList.add('loaded');
});


window.addEventListener('popstate', function(e) {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab) {
        const targetBtn = document.querySelector(`[data-tab="${tab}"]`);
        if (targetBtn) {
            targetBtn.click();
        }
    }
});


window.togglePassword = togglePassword;
window.showCustomAlert = showCustomAlert;