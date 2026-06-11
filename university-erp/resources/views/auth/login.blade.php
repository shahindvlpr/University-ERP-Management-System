<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>UniERP | Secure Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: radial-gradient(circle at 10% 20%, rgb(10, 20, 45) 0%, rgb(5, 10, 25) 90%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            position: relative;
            padding: 1.5rem;
        }

        /* Animated gradient orb */
        .orb {
            position: fixed;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: floatOrb 18s infinite ease-in-out;
        }

        .orb-1 { top: -20%; left: -20%; background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, rgba(0,0,0,0) 70%); }
        .orb-2 { bottom: -20%; right: -20%; background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, rgba(0,0,0,0) 70%); animation-delay: -5s; }
        .orb-3 { top: 40%; right: 10%; width: 30vw; height: 30vw; background: radial-gradient(circle, rgba(236,72,153,0.12) 0%, rgba(0,0,0,0) 70%); animation-delay: -10s; }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.6; }
            50% { transform: translate(5%, 5%) scale(1.05); opacity: 0.8; }
        }

        /* Premium Glass Card - Wider & Balanced */
        .premium-card {
            background: rgba(15, 25, 45, 0.75);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.5), 0 0 0 0.5px rgba(255, 255, 255, 0.05);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        @media (min-width: 640px) {
            .premium-card {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .premium-card {
                max-width: 580px;
            }
        }

        .premium-card:hover {
            transform: translateY(-6px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 35px 55px -15px rgba(0, 0, 0, 0.6);
        }

        /* Header with minimal gradient */
        .card-header-premium {
            background: linear-gradient(105deg, rgba(59,130,246,0.15) 0%, rgba(139,92,246,0.08) 100%);
            padding: 1.8rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-icon {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            width: 60px;
            height: 60px;
            border-radius: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 10px 20px -5px rgba(59,130,246,0.4);
        }

        .brand-icon i {
            font-size: 2rem;
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .card-header-premium h3 {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff, #94a3b8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
            margin-bottom: 0.25rem;
        }

        .card-header-premium p {
            color: #94a3b8;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        /* Card body - compact yet spacious */
        .card-body-premium {
            padding: 2rem 2rem 2rem 2rem;
        }

        /* Form groups with modern spacing */
        .form-group-premium {
            margin-bottom: 1.5rem;
        }

        .form-label-premium {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #4b5563;
            font-size: 1rem;
            z-index: 2;
            transition: color 0.2s;
        }

        .premium-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1rem;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            font-size: 0.95rem;
            color: #f1f5f9;
            transition: all 0.2s ease;
            font-weight: 450;
        }

        .premium-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(0, 0, 0, 0.6);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .premium-input::placeholder {
            color: #4b5563;
            font-size: 0.85rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            z-index: 2;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #3b82f6;
        }

        /* Checkbox & Links row - cleaner */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
            font-size: 0.8rem;
        }

        .custom-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: #cbd5e1;
        }

        .custom-check input {
            width: 1rem;
            height: 1rem;
            accent-color: #3b82f6;
            cursor: pointer;
        }

        .forgot-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
            font-size: 0.8rem;
        }

        .forgot-link:hover {
            color: #60a5fa;
            text-decoration: underline;
        }

        /* Premium Button */
        .btn-premium {
            background: linear-gradient(95deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 1rem;
            padding: 0.85rem;
            font-weight: 700;
            font-size: 0.95rem;
            width: 100%;
            color: white;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 5px 15px -3px rgba(59,130,246,0.3);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(59,130,246,0.5);
            background: linear-gradient(95deg, #2563eb, #7c3aed);
        }

        .btn-premium:active {
            transform: translateY(1px);
        }

        /* Alert custom */
        .alert-premium {
            background: rgba(220, 38, 38, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 1rem;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            color: #fecaca;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeSlide 0.3s ease;
        }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer links */
        .footer-links-premium {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.7rem;
            color: #5b6e8c;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 1.5rem;
        }

        .footer-links-premium a {
            color: #94a3b8;
            text-decoration: none;
            margin: 0 0.75rem;
            transition: color 0.2s;
        }

        .footer-links-premium a:hover {
            color: #3b82f6;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(0,0,0,0.3);
            padding: 5px 12px;
            border-radius: 40px;
            font-size: 0.65rem;
            color: #7e8ba3;
        }

        /* Loading state */
        .btn-premium.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 560px) {
            .card-body-premium {
                padding: 1.5rem;
            }
            .card-header-premium {
                padding: 1.4rem 1.5rem;
            }
            .brand-icon {
                width: 50px;
                height: 50px;
            }
            .options-row {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="premium-card">
        <div class="card-header-premium">
            <div class="brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h3>UniERP</h3>
            <p>University Management System · Secure Access</p>
        </div>

        <div class="card-body-premium">
            <h5 style="font-weight: 600; margin-bottom: 1.5rem; color: #e2e8f0; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-right-to-bracket" style="color: #3b82f6; font-size: 0.9rem;"></i> 
                Welcome Back
            </h5>

            @if($errors->any())
                <div class="alert-premium">
                    <i class="fas fa-shield-alt"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="/login" id="premiumLoginForm">
                @csrf
                <div class="form-group-premium">
                    <label class="form-label-premium">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="premium-input" value="{{ old('email') }}" 
                               placeholder="professor@university.edu" required autofocus>
                    </div>
                </div>

                <div class="form-group-premium">
                    <label class="form-label-premium">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="premiumPassword" class="premium-input" 
                               placeholder="········" required>
                        <button type="button" class="password-toggle" id="togglePassBtn" aria-label="Show password">
                            <i class="fas fa-eye-slash" id="togglePassIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="options-row">
                    <label class="custom-check">
                        <input type="checkbox" name="remember"> 
                        <span>Keep me signed in</span>
                    </label>
                    <a href="#" class="forgot-link">
                        <i class="fas fa-key me-1"></i> Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn-premium" id="loginPremiumBtn">
                    <i class="fas fa-arrow-right-to-bracket"></i> Sign In
                </button>
            </form>

            <div class="footer-links-premium">
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <a href="#">Contact Support</a>
                    <span class="text-muted">•</span>
                    <a href="#">IT Helpdesk</a>
                    <span class="text-muted">•</span>
                    <a href="#">Privacy</a>
                </div>
                <div class="security-badge mx-auto" style="width: fit-content;">
                    <i class="fas fa-shield-alt"></i> Encrypted Connection · AES-256
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Password Visibility
    const toggleBtn = document.getElementById('togglePassBtn');
    const passwordField = document.getElementById('premiumPassword');
    const toggleIcon = document.getElementById('togglePassIcon');

    if (toggleBtn && passwordField) {
        toggleBtn.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    }

    // Form submit with loading state & inline validation
    const loginForm = document.getElementById('premiumLoginForm');
    const loginBtn = document.getElementById('loginPremiumBtn');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]').value.trim();
            const password = document.querySelector('input[name="password"]').value;

            if (!email || !password) {
                e.preventDefault();
                let errorMsg = !email ? 'Please enter your email address.' : 'Please enter your password.';
                showPremiumAlert(errorMsg);
                return;
            }

            // Show loading state
            loginBtn.classList.add('loading');
            const originalHTML = loginBtn.innerHTML;
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Authenticating...';

            // Allow form to submit, but in case of any client-side issues, reset after timeout (optional)
            // Note: Form will submit to server, we don't reset to avoid double submission.
            // The loading stays.
        });
    }

    function showPremiumAlert(message) {
        // Remove any existing alert
        const existingAlert = document.querySelector('.alert-premium');
        if(existingAlert) existingAlert.remove();

        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert-premium';
        alertDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i><span>${message}</span>`;
        
        const formContainer = document.querySelector('.card-body-premium form');
        if (formContainer) {
            formContainer.insertBefore(alertDiv, formContainer.firstChild);
        } else {
            document.querySelector('.card-body-premium')?.insertBefore(alertDiv, document.querySelector('.card-body-premium form'));
        }

        setTimeout(() => {
            alertDiv.style.opacity = '0';
            alertDiv.style.transform = 'translateY(-10px)';
            setTimeout(() => alertDiv.remove(), 300);
        }, 3500);
    }

    // Add ripple effect to button (soft premium feel)
    const btns = document.querySelectorAll('.btn-premium');
    btns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            let ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Additional style for ripple
    const style = document.createElement('style');
    style.textContent = 
        .btn-premium {
            position: relative;
            overflow: hidden;
        }
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transform: scale(0);
            animation: rippleAnim 0.6s linear;
            pointer-events: none;
            width: 100px;
            height: 100px;
            margin-top: -50px;
            margin-left: -50px;
        }
        @keyframes rippleAnim {
            100% {
                transform: scale(4);
                opacity: 0;
            }
        }
    ;
    document.head.appendChild(style);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>