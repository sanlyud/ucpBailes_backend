import csv
import sys

from Database_Modules.DB_Connector import Connector
from Structures.Student import Student
from Structures.ParserConfig import ParserConfig

class DreamboxParser:

    CSV_FILE_PATH = '../Temp_Files/dreambox.csv'
    DB_NAME = 'test'
    tableName = None
    studentList = None
    dbTest = None

    # Update the path to the input csv file with the program argument if provided
    # if len(sys.argv) > 1:
    #    CSV_FILE_PATH = sys.argv[1]

    def __init__(self, parserConfig):
        self.studentList = []
        self.dbTest = Connector(self.DB_NAME)
        self.tableName = parserConfig.dataTableName

    def parse(self):
        with open(self.CSV_FILE_PATH, newline='') as csvFile:

            csvReader = csv.reader(csvFile, delimiter=',')
            # Skip the header line
            row = csvReader.__next__()

            for row in csvReader:
                student = Student()

                student.firstName = row[0]
                student.lastName = row[1]
                student.daysInPeriod = row[2]
                student.lessonsCompleted = row[3]
                student.standardsMet = row[4]
                student.standardsProgessedIn = row[5]
                student.totalMinutes = row[6]
                student.minPerWeek = row[7]
                student.lessonsPerWeek = row[8]
                student.gradeLevel = row[9]
                student.curricularGradeLevel = row[10]

                self.studentList.append(student)


            for student in self.studentList:
                result = self.dbTest.query("SELECT firstName, lastName FROM {tableName} "
                                      "WHERE firstName='{student.firstName}' "
                                      "AND lastName='{student.lastName}';".format(tableName=self.tableName, student=student))
                if len(result) == 0:
                    # Insert
                    self.dbTest.query("INSERT INTO {tableName} (firstName, lastName, "
                                 "lessonsCompleted, standardsMet, standardsProgressedIn, "
                                 "totalMinutes, minPerWeek, lessonsPerWeek, "
                                 "gradeLevel, curricularGradeLevel) "
                                 "VALUES ('{student.firstName}', '{student.lastName}', "
                                 "{student.lessonsCompleted}, {student.standardsMet}, "
                                 "{student.standardsProgressedIn}, "
                                 "{student.totalMinutes}, {student.minPerWeek}, "
                                 "{student.lessonsPerWeek}, {student.gradeLevel}, "
                                 "{student.curricularGradeLevel});".format(tableName=self.tableName, student=student))
                else:
                    # Update
                    self.dbTest.query("UPDATE {tableName} "
                                 "SET lessonsCompleted = {student.lessonsCompleted}, "
                                 "standardsMet = {student.standardsMet}, "
                                 "standardsProgressedIn = {student.standardsProgressedIn}, "
                                 "totalMinutes = {student.totalMinutes}, "
                                 "minPerWeek = {student.minPerWeek}, "
                                 "lessonsPerWeek = {student.lessonsPerWeek}, "
                                 "gradeLevel = {student.gradeLevel}, "
                                 "curricularGradeLevel = {student.curricularGradeLevel} "
                                 "WHERE firstName = '{student.firstName}' "
                                 "AND lastName = '{student.lastName}';".format(tableName=self.tableName, student=student))
