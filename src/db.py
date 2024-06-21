import csv
import pymysql.cursors

from const import ARTIST_DATA, ARTWORK_DATA, ARTIST_INSERT_QUERY


HOST = '127.0.0.1'
USER = 'root'
PASSWORD = 'mypassword'
DATABASE_NAME = 'museo'
CURSOR_CLASS = pymysql.cursors.DictCursor


def main():
    connection = connect_to_mysql_db()  
    insert_artists(connection)
        
        
def connect_to_mysql_db():
    return pymysql.connect(
        host=HOST,
        user=USER,
        password=PASSWORD,
        database=DATABASE_NAME,
        cursorclass=CURSOR_CLASS
    )


def insert_artists(connection):
    with connection:

        with open(ARTIST_DATA, mode='r', encoding='utf-8') as file:
            reader = csv.reader(file)
            next(reader)

            with connection.cursor() as cursor:
                for entry in reader:
                    cursor.execute(ARTIST_INSERT_QUERY, tuple(entry))
                connection.commit()
                    
                # entries = cursor.fetchall()


if __name__ == '__main__':
    main()