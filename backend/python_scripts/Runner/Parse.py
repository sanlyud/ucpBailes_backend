from Database_Modules.DB_Connector import Connector
from Structures.ParserConfig import ParserConfig
from Structures.ParserConfig import ParserType
from Parsers import DreamBox_CSV_Parser
from Parsers import Think_Central_HTML_Parser
from Data_Pull import Think_Central_Data_Pull
from Parsers import Generic_CSV_Parser
from Data_Pull import Spelling_City_CSV_Data_Pull
from Parsers import Spelling_City_Student_Activity
import sys
import uuid

# This script is the interface to the server backend
# This script is called directly from the backend with the parser ID as the command line argument
# The ID will be used to look up the entry in the configuration database table which has the fields needed to execute a parse
DB_NAME = 'test'
CONFIG_TABLE_NAME = 'parser_config'
#addding studentNumber to the command line
#if len(sys.argv) < 2:
if len(sys.argv) < 3:
    exit("Please provide an ID as a command line argument")

# The ID should be passed in as a command-line argument
# Take the string representation of the ID and convert it to an int (it is stored as an auto increment int in the db)
# If the ID passed in could not be converted, exit the script and pass the error message back
try:
    configID = int(sys.argv[1])
    studentNumber = sys.argv[2]
except ValueError as error:
    exit('The ID command line argument must be an integer:\n{error}'.format(error=error))

configDB = Connector(DB_NAME)

# Query the database to get the row corresponding to the ID we were given (row contains configuration data)
dbReturn = configDB.query("SELECT * FROM {table} "
                                     "WHERE ID={configID};".format(configID=configID, table=CONFIG_TABLE_NAME))

if (len(dbReturn) < 1):
    exit('Could not find ID={configID} in {table} table'.format(configID=configID, table=CONFIG_TABLE_NAME))

# dbReturn is the list of rows returned from the select statement
# Since we used the ID to query for a specific row, we only care about the first row returned: dbReturn[0]
# Since the ID is auto increment, there really should only be one row returned no matter what
dbReturn = dbReturn[0]

# Now that we got the data from the database, we are going to store it in a ParserConfig object to pass to the other scripts
parserConfig = ParserConfig()

# Fill out the parserConfig object from the fields in the database return
if dbReturn[1] is not None: parserConfig.parserType = dbReturn[1]
if dbReturn[2] is not None: parserConfig.dataTableName = dbReturn[2]
if dbReturn[3] is not None: parserConfig.loginURL = dbReturn[3]
if dbReturn[4] is not None: parserConfig.dataURL = dbReturn[4]
if dbReturn[5] is not None: parserConfig.username = dbReturn[5]
if dbReturn[6] is not None: parserConfig.password = dbReturn[6]
if dbReturn[7] is not None: parserConfig.className = dbReturn[7]
if dbReturn[8] is not None: parserConfig.subjectName = dbReturn[8]
if dbReturn[9] is not None: parserConfig.startDate = dbReturn[9]
if dbReturn[10] is not None: parserConfig.endDate = dbReturn[10]

# Run the Dreambox parser
if parserConfig.parserType == ParserType.dreambox.value:
    dreamBoxParser = DreamBox_CSV_Parser.DreamboxParser(parserConfig)
    dreamBoxParser.parse()

# Run the Think Central parser
if parserConfig.parserType == ParserType.thinkCentral.value:
    if (parserConfig.loginURL is not None and
            parserConfig.dataURL is not None and
            parserConfig.username is not None and
            parserConfig.password is not None and
            parserConfig.className is not None and
            parserConfig.subjectName is not None):
        thinkCentralDataGather = Think_Central_Data_Pull.ThinkCentralDataPull(parserConfig)
        thinkCentralDataGather.gather()

    thinkCentralParser = Think_Central_HTML_Parser.ThinkCentralParser(parserConfig)
    # thinkCentralParser.parse()

# Run the Spelling City parser
if parserConfig.parserType == ParserType.spellingCity.value:
    if (parserConfig.loginURL is not None and
        parserConfig.dataURL is not None and
        parserConfig.username is not None and
        parserConfig.password is not None):
        spellingCityDataGather = Spelling_City_CSV_Data_Pull.SpellingCityDataPull(parserConfig)
        spellingCityDataGather.gather()

    spellingCityParser = Generic_CSV_Parser.GenericCSVParser(parserConfig)
    spellingCityParser.parse()

# Run the Spelling City Student Activity parser
if parserConfig.parserType == ParserType.spellingCityStudentActivity.value:
    studentActivityParser = Spelling_City_Student_Activity.SpellingCityStudentActivity(parserConfig, studentNumber)
    studentActivityParser.parse()

if parserConfig.parserType == ParserType.genericCSV.value:
    print()

exit()
