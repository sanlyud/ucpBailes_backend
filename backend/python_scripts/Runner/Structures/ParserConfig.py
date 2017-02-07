from enum import Enum
import time

class ParserType(Enum):
    dreambox = 1
    thinkCentral = 2
    spellingCity = 3
    spellingCityStudentActivity = 4
    genericCSV = 5

class ParserConfig:
    parserType = None
    dataTableName = None
    loginURL = None
    dataURL = None
    username = None
    password = None
    className = None
    subjectName = None
    startDate = '08/01/16'
    endDate = time.strftime("%x")