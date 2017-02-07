import csv
import sys
import re
import collections
from Database_Modules.DB_Connector import Connector

class GenericCSVParser:

    DB_NAME = 'test'
    CSV_FILE_PATH = '../Temp_Files/SpellingCityGradeBook-580e68ad98762.csv'
    tableName = ""

    def __init__(self, parserConfig):
        self.dbTest = Connector(self.DB_NAME)
        self.tableName = parserConfig.dataTableName

    # Use command line arguments to specify which columns should be longer fields in the database (length 100 instead of 20)
    # This indices are 0 based
    # Map the command line arguments to an int list
    # indicesOfLongFields = list(map(int, sys.argv[2:]))

    def parse(self):
        with open(self.CSV_FILE_PATH, newline='') as csvFile:

            csvReader = csv.reader(csvFile, delimiter=',')

            # Read in the header line (this will be used to map to the database)
            header = csvReader.__next__()
            # Use list comprehension to replace ' ' and '-' with '_' in header columns
            # Then remove all special characters
            # This allows us to maintain some readability in the database while keeping the syntax legal
            header[:] = [re.sub(' |-', '_', column) for column in header]
            header[:] = [re.sub('[^a-z|A-Z|0-9|_]', '', column) for column in header]

            # header[:] = [duplicate + str(count) for duplicate, count in collections.Counter(header).items() if count > 1]
            # print(collections.Counter(header).items())
            # for index, (item, count) in enumerate(collections.Counter(header).items()):
            #     if count > 1:
            #         header[index] += str(count)
            counts = collections.Counter(header)  # so we have: {'name':3, 'state':1, 'city':1, 'zip':2}
            for item, count in counts.items():
                if count > 1:  # ignore strings that only appear once
                    for suffix in range(1, count+1):  # suffix starts at 1 and increases by 1 each time
                        header[header.index(item)] += str(suffix)  # replace each appearance of s
            # Check if the table already exists
            # If it does not exist, create it
            if not self.dbTest.tableExists(self.tableName):
                # Create the database table for this file
                # Start by building the query that will be used to actually create the table
                createTableQuery = "CREATE TABLE {tableName} (".format(tableName=self.tableName)
                # The columns of the table are going to be the same as the columns of the header of the csv file (no whitespace)
                # This allows us to use the csv file header row to reference the database
                for index, column in enumerate(header):
                        createTableQuery += "{column} VARCHAR(100),".format(column=column)
                # Slice the string to remove the trailing ',' then add the ');' to finish the query
                createTableQuery = createTableQuery[:-1]
                createTableQuery += ');'
                self.dbTest.query(createTableQuery)

            # Now we need to figure out which column(s) of the header correspond to the students first and last name
            wholeNameIndex = firstNameIndex = lastNameIndex = -1
            for index, column in enumerate(header):
                # Look for 'name' in this column for it to be considered
                if re.search('name', column, re.IGNORECASE) is not None:
                    if re.search('first', column, re.IGNORECASE) is not None:
                        if re.search('last', column, re.IGNORECASE) is not None:
                            # If first and last both appear in this header column, then it is the whole name
                            wholeNameIndex = index
                        # If just first appears, then it is the first name
                        firstNameIndex = index
                    # If just last appears, then it is the last name
                    elif re.search('last', column, re.IGNORECASE) is not None:
                        lastNameIndex = index
                    # If just name appears, it could be the student's whole name
                    # It could also be referencing something else, such as 'Project Name' or something
                    # So, we are only going to set it as the student's whole name if it hasn't been set already
                    else:
                        if wholeNameIndex == -1 and firstNameIndex == -1 and lastNameIndex == -1:
                            # If we find a , in the name column, it is very likely in the format (lastName, firstName)
                            # Change the format to (firstName LastName)
                            if re.search(',', column) is not None:
                                column = [x.strip for x in column.split(',')]
                            wholeNameIndex = index

            if wholeNameIndex == -1 and (firstNameIndex == -1 and lastNameIndex == -1):
                # The script did not find the column(s) where the student's name listed
                sys.exit("Could not find the student's name column(s)")

            for student in csvReader:
                # Look for a particular student in the database
                # Look it up based on their full name in a single column or first and last name in separate columns
                if wholeNameIndex != -1:
                    wholeNameHeader = header[wholeNameIndex]
                    result = self.dbTest.query("SELECT {wholeNameHeader} FROM {tableName} "
                                          "WHERE {wholeNameHeader}='{wholeName}';"
                                          .format(wholeNameHeader=wholeNameHeader, tableName=self.tableName,
                                                  wholeName=student[wholeNameIndex]))
                else:
                    firstNameHeader = header[firstNameIndex]
                    lastNameHeader = header[lastNameIndex]
                    result = self.dbTest.query("SELECT {firstNameHeader}, {lastNameHeader} FROM {tableName} "
                                          "WHERE {firstNameHeader}='{firstName}' "
                                          "AND {lastNameHeader}='{lastName}';"
                                          .format(firstNameHeader=firstNameHeader, lastNameHeader=lastNameHeader, tableName=self.tableName,
                                                  firstName=student[firstNameIndex], lastName=student[lastNameIndex]))

                # If the student is not in the database yet, insert the student
                if len(result) == 0:
                    # Build the query statement to insert the student into the database
                    insertQuery = "INSERT INTO {tableName} (".format(tableName=self.tableName)
                    # Add the field names to the insert statement
                    for column in header:
                        insertQuery += "{column},".format(column=column)
                    # Remove the trailing ',' by slicing the string
                    insertQuery = insertQuery[:-1]
                    # Add the values of the fields to the insert statement
                    insertQuery += ") VALUES ("
                    for column in student:
                        # Add each value for the student
                        insertQuery += "'{column}',".format(column=column)
                    insertQuery = insertQuery[:-1]
                    insertQuery += ');'

                    self.dbTest.query(insertQuery)

                # If the student is already in the database, update their values
                else:
                    # Build the query statement to update the student in the database
                    updateQuery = "UPDATE {tableName} SET ".format(tableName=self.tableName)
                    # For each column in the student, we need to update their value
                    # Syntax for UPDATE is UPDATE table SET field=value WHERE key=value
                    # We use the header as the field name, so we set header = value
                    for index, column in enumerate(student):
                        updateQuery += "{header}='{column}',".format(header=header[index], column=column)
                    # Remove the trailing ',' by slicing the string
                    updateQuery = updateQuery[:-1]
                    updateQuery += " WHERE "
                    # Now we need to add the WHERE to specify which entry in the database we are updating
                    # We use the name of the student to specify who we are updating
                    if wholeNameIndex != -1:
                        # If the whole name (first and last) has been defined in a single column, query using that column
                        updateQuery += "{wholeNameHeader}='{wholeName}'".format(
                            wholeNameHeader=wholeNameHeader, wholeName=student[wholeNameIndex])
                    else:
                        updateQuery += "{firstNameHeader}='{firstName}' AND {lastNameHeader}='{lastName}'".format(
                            firstNameHeader=firstNameHeader, firstName=student[firstNameIndex],
                            lastNameHeader=lastNameHeader, lastName=student[lastNameIndex])
                    updateQuery += ';'

                    self.dbTest.query(updateQuery)
