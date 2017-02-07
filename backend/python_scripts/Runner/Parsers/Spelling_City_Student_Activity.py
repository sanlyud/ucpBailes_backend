import csv
import re

from Database_Modules.DB_Connector import Connector

class SpellingCityStudentActivity:

    CSV_FILE_PATH = '../Temp_Files/spelling_city_student_activity.csv'
    DB_NAME = 'test'
    tableName = None
    dbTest = None

    def __init__(self, parserConfig, studentNumber):
        self.dbTest = Connector(self.DB_NAME)
        self.tableName = parserConfig.dataTableName
        self.studentNumber = studentNumber
    def parse(self):
        with open(self.CSV_FILE_PATH, newline='') as csvFile:

            csvReader = csv.reader(csvFile, delimiter=',')
            # Skip the header line
            row = csvReader.__next__()

            for row in csvReader:
                # Read the values from the csv file
                list = row[0]
                activity = row[1]
                date = row[2]
                timeOnTask = row[3]
                score = row[4]
                missedWords = row[5]

                # Convert the values read to the proper format for inserting into the database
                # date is in the format mm/dd/yyyy hh:mm xm
                # It must be converted to an SQL DATETIME (YYYY-MM-DD hh:mm:ss)
                # Splitting on the slash will give us the list: [mm, dd, yyyy hh:mm xm]
                slashSplit = date.split('/')
                month = slashSplit[0]
                day = slashSplit[1]
                # Split the third part on the space to get the list: [yyyy, hh:mm:ss, xm]
                spaceSplit = slashSplit[2].split(' ')
                year = spaceSplit[0]
                ampm = spaceSplit[2]
                # Split hh:mm:ss on the colon to get the list: [hh, mm, ss]
                colonSplit = spaceSplit[1].split(':')
                hour = colonSplit[0]
                minute = colonSplit[1]
                # Convert from 12 hour date to 24 hour date using the am/pm designation
                if ampm == 'pm':
                    hour = str(int(hour) + 12)
                # Now that we have extracted all of the required date fields, put it in the correct format (YYYY-MM-DD hh:mm:ss)
                date = "{year}-{month}-{day} {hour}:{minute}:00".format(year=year, month=month, day=day, hour=hour, minute=minute)

                # score is in the format 0-100 %
                # Retrieve the number portion by grabbing everything in front of the % and removing whitespace
                score = score.rstrip('%').strip()
                # If there was not a score value in the csv file,
                if score == '': score = 'NULL'

                # timeOnTask is a string consisting of an integer number of minutes followed by ' mins'
                # We can extract out the integer portion by just accepting everything before the space
                timeOnTask = int(timeOnTask.rstrip(' mins'))

                # Check the database to see if this is activity is already there
                # The activity is unique based on its list, activity, and date fields
                # In other words, there can be mulitple entries in the database for an activity if its time or list is unique
                result = self.dbTest.query("SELECT list, activity, date FROM {tableName} "
                                           "WHERE list='{list}' "
                                           "AND activity='{activity}'"
                                           "AND date='{date}';"
                                           .format(tableName=self.tableName, list=list, activity=activity, date=date))

                # If there is not an existing entry in the database for the activity, insert it
                if len(result) == 0:
                    self.dbTest.query("INSERT INTO {tableName} (list, activity, date, time_on_task, score, studentNumber) "
                                      "VALUES ('{list}', '{activity}', '{date}', {timeOnTask}, {score}, {studentNumber});"
                                      .format(tableName=self.tableName, list=list, activity=activity, date=date,
                                              timeOnTask=timeOnTask, score=score, studentNumber=self.studentNumber))
                # If the activity is already in the database, update its values
                else:
                    # Update
                    self.dbTest.query("UPDATE {tableName} "
                                      "SET time_on_task = {timeOnTask}, "
                                      "score = {score} "
                                      "WHERE list = '{list}' "
                                      "AND activity = '{activity}' "
                                      "AND date = '{date}';"
                                      .format(tableName=self.tableName, list=list, activity=activity, date=date,
                                              timeOnTask=timeOnTask, score=score))

                # Convert the missed words string to a list of the missed words
                if missedWords == '':
                    missedWords = None
                else:
                    missedWords = re.sub(' ', '', missedWords)
                    missedWords = missedWords.lower()
                    missedWords = missedWords.split(',')

                # Insert the missed words for this activity into the missed_words table
                # To do this, we must get the student activity ID for the current activity
                result = self.dbTest.query("SELECT student_activity_id FROM {tableName} "
                                           "WHERE list='{list}' "
                                           "AND activity='{activity}'"
                                           "AND date='{date}';"
                                           .format(tableName=self.tableName, list=list, activity=activity,
                                                   date=date))
                # Since the list, activity, and date items make up a unique activity entry, there will only be one result from the database
                # Also, the select results are returned in a tuple
                # So, the ID is the first (and only) tuple value returned from the first (and only) row return from the database
                studentActivityID = result[0][0]

                # Get the missed words for this activity that is already in the missed_words table
                # We can use this to only insert words that are not already in the table
                result = self.dbTest.query("SELECT missed_word FROM missed_words "
                                           "WHERE student_activity_id={id};"
                                           .format(id=studentActivityID))
                # Convert the list of tuples from the result to just the list of words returned from the database
                wordsDB = []
                for element in result:
                    # Get the first value from the tuple (represents the missed_word selected from the database)
                    wordsDB.append(element[0])

                # Insert all of the missed words from the csv file that are not in the database already
                # Remove all of the words from the database that are not in the csv file
                # This is done this way to limit the number of db queries made and only update what needs to be updated
                if missedWords is not None and wordsDB is not None:
                    newWords = [value for value in missedWords if value not in wordsDB]
                    deletedWords = [value for value in wordsDB if value not in missedWords]

                    for word in newWords:
                        self.dbTest.query("INSERT INTO missed_words (student_activity_id, missed_word) "
                                          "VALUES ({studentActivityID}, '{word}');"
                                          .format(studentActivityID=studentActivityID, word=word))
                    for word in deletedWords:
                        self.dbTest.query("DELETE FROM missed_words "
                                          "WHERE student_activity_id={studentActivityID} "
                                          "AND missed_word='{word}';"
                                          .format(studentActivityID=studentActivityID, word=word))
