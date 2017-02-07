import requests
from bs4 import BeautifulSoup
from lxml import html

loginURL = 'https://www.spellingcity.com/Log-yourself-in.html'
tableURL = 'https://www.spellingcity.com/index.php?option=com_route&route=gradebook'

session = requests.Session()

payload = {'username': 'bailesrobots@gmail.com',
           'passwd': 'bailesbears'}

response = session.get(loginURL)
# response = session.post(loginURL, payload)
# tablePage = session.get(tableURL)

# soup = BeautifulSoup(tablePage.text, 'html.parser')
soup = BeautifulSoup(response.text, 'html.parser')
print(len(soup.find_all(type="password")))
# print(response.status_code)
# print(response.text)
