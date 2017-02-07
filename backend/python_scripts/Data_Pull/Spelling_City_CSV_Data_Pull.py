import requests
from bs4 import BeautifulSoup
from lxml import html

class SpellingCityDataPull:

    loginURL = 'https://www.spellingcity.com/Log-yourself-in.html'
    csvURL = 'https://www.spellingcity.com/index.php?pa=gradebooktable&format=csv'
    userName = None
    password = None

    def __init__(self, parserConfig):
        self.loginURL = parserConfig.loginURL
        self.csvURL = parserConfig.dataURL
        self.userName = parserConfig.username
        self.password = parserConfig.password

    def gather(self):
        session = requests.Session()

        payload = {'username': self.userName,
                   'passwd': self.password}

        # response = session.get(loginURL)
        response = session.post(self.loginURL, payload)
        csvData = session.get(self.csvURL)
        # tablePage = session.get(tableURL)

        print(response.status_code)
        # print(response.text)

        with open('../Temp_Files/spelling_city_data_pull.csv', 'wb') as f:
             f.write(csvData.content)