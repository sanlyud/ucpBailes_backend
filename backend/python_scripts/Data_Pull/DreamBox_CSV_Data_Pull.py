import requests
from requests.auth import HTTPBasicAuth

loginURL = 'https://play.dreambox.com/play/login?back=%2Flogin%2Flist_home_students'
csvURL = 'https://insight.dreambox.com/r/districts/20563/classrooms/467735/overview?sort=name&order=asc&by=month&sy=2016&ast=ccss&format=csv'

session = requests.Session()

payload = {'email_address': 'dlawson@ucpcfl.org',
           'password': '407ucpcfl',
           'utf8': '✓',
           'authenticity_token': '+36n6/v0uvo5bB5TUcVmsdAh/hxSpxNclHE04RfZRSAoW+QiboFBiH0IhTwi1peBQPP30XskThc4M2nvFmUm3A==',
           'play': 'submit'}

response = session.post(loginURL, data=payload)
# csvData = session.get(csvURL)
print(response.status_code)
print(response.text)


# If you want to try and get auth working for a more robust login (This is currently not working.  I think it may be because we need to pass the HTML element name as a header)
# Could possibly use a different python script with beautiful soup to figure out name of username and password fields
# session.auth = ('dlawson@ucpcfl.org', '407ucpcfl')
# response = session.get(loginURL, auth=HTTPBasicAuth('dlawson@ucpcfl.org', '407ucpcfl'))

# with open('Temp_Files/test.csv', 'wb') as f:
#      f.write(csvData.content)
