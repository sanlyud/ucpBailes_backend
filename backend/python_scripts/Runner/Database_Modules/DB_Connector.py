import mysql.connector

class Connector:

    dbName = ''

    def __init__(self, name):
        self.dbName = name

    # Returns True if the table exists and false otherwise
    def tableExists(self, tableName):
        # To see if the table exists, try to query the table with a simple test query
        try:
            self.query("SELECT * FROM {tableName}".format(tableName=tableName))
        # If the table does not exist, this exception is caught
        except mysql.connector.Error as temp:
            return False

        return True

    # Queries the database that is set for this object
    def query(self, query):
        result = []
        cnx = mysql.connector.connect(user='root', password='secret',
                                      host='127.0.0.1',
                                      database = self.dbName)
        cursor = cnx.cursor()
        cursor.execute(query)
        if cursor.with_rows:
            result = cursor.fetchall()
        cnx.commit()
        cursor.close()
        cnx.close()

        return result
