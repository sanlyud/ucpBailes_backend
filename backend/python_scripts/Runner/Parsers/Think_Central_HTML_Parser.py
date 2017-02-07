from bs4 import BeautifulSoup
from lxml import html
import re
from Database_Modules.DB_Connector import Connector

class ThinkCentralParser:

    DB_NAME = 'test'
    studentIndex = -1
    subjectIndex = -1
    itemIndex = -1
    scoreIndex = -1
    assignmentTable = None
    database = None

    tableName = None

    # Looks for the score in the table from the think central html
    # Accepts a number 0-100 followed by a percent sign
    scoreRegex = re.compile('(?:100|[1-9]?[0-9])%')

    def __init__(self, parserConfig):
        self.database = Connector(self.DB_NAME)
        self.tableName = parserConfig.dataTableName

    def parse(self):

        soup = BeautifulSoup(open('../Temp_Files/think_central_assignments.html'), 'html.parser')
        print(soup.prettify())
        dataTables = soup.find_all('table', class_='dataTable')

        # Go through all of the data tables in the webpage and look for the assignments table
        # Use the table's header to determine if it is the assignments table (header values listed below)
        for table in dataTables:
            headers = table.find_all('th')
            if len(headers) > 3:
                # Look for the appropriate header values: 'Student', 'Item', and 'Score'
                for index, header in enumerate(headers):
                    # For each header value, search for one of the possible headers
                    # Keep track of the column (index) where that header is found
                    if str(header).find('Student') != -1:
                        studentIndex = index
                    # if str(header).find('Subject') != -1:
                    #     subjectIndex = index
                    if str(header).find('Item') != -1:
                        itemIndex = index
                    if str(header).find('Score') != -1:
                        scoreIndex = index

                # Make sure that the student, item, and score headers were found in the table
                if studentIndex != -1 and itemIndex != -1 and scoreIndex != -1:
                    assignmentTable = table
                    break

        if assignmentTable is not None:
            tableBody = assignmentTable.tbody
            tableRows = tableBody.find_all('tr')
            for row in tableRows:
                tableData = row.find_all('td')

                # Parse the student's name
                # On the webpage, the name is in the format "lastName, firstName(ID)"
                # Here we use "next" to get the entry for the student name within the column (tableData) of that row
                studentName = str(tableData[studentIndex].next)
                # Split at the ',' to separate the first name from the last name, then split at the '(' to ignore the ID
                # Then remove preceding whitespace in first name
                commaSplit = studentName.split(',')
                firstName = commaSplit[1].split('(')[0]
                firstName = firstName.lstrip(' ')
                lastName = commaSplit[0]

                # Parse the item
                item = str(tableData[itemIndex].next)

                # Parse the score
                score = str(tableData[scoreIndex].next)
                # Use the score regex to look for a value 0-100 followed by a '%'
                # If the regex patter is found, set the score equal to the value found without the % on the end
                score = self.scoreRegex.search(score)
                if score:
                    # Take off the % on the end and convert the score to an int
                    score = int(score.group()[:-1])
                else:
                    score = None

                # Update the database with the values parsed
                # If a student already has an assignment in the database, check if assignment grade has changed and update
                select = self.database.query("SELECT first_name, last_name, item, score FROM {tableName} "
                                      "WHERE first_name='{firstName}' "
                                      "AND last_name='{lastName}'"
                                      "AND item='{item}';".format(tableName=self.tableName, firstName=firstName, lastName=lastName, item=item))
                if len(select) > 0:
                    # If the student/item pair that we have parsed is already in the database, check if the score has changed
                    # If the score has changed, update it in the database
                    # The select statement returns a list of results (one for each row in the database)
                    # Get the first result returned (there really should only be one student/item instance in the db)
                    # The result (row) is a tuple of the values in that row of the db (so the score is the 4th value of the tuple)
                    row = select[0]
                    originalScore = row[3]
                    if score != originalScore:
                        if score is not None:
                            self.database.query('UPDATE {tableName} SET score={score} '
                                           'WHERE first_name="{firstName}" '
                                           'AND last_name="{lastName}" '
                                           'AND item="{item}";'.format(
                                            tableName=self.tableName, firstName=firstName, lastName=lastName, item=item, score=score))
                        else:
                            self.database.query('UPDATE {tableName} SET score=NULL '
                                           'WHERE first_name="{firstName}" '
                                           'AND last_name="{lastName}" '
                                           'AND item="{item}";'.format(
                                tableName=self.tableName, firstName=firstName, lastName=lastName, item=item))
                else:
                    if score is not None:
                        self.database.query('INSERT INTO {tableName} (first_name, last_name, item, score) '
                                   'VALUES ("{firstName}", "{lastName}", "{item}", {score});'.format(
                                    tableName=self.tableName, firstName=firstName, lastName=lastName, item=item, score=score))
                    else:
                        self.database.query('INSERT INTO {tableName} (first_name, last_name, item) '
                                       'VALUES ("{firstName}", "{lastName}", "{item}");'.format(
                            tableName=self.tableName, firstName=firstName, lastName=lastName, item=item))