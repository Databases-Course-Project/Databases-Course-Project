import csv

import pymysql.cursors

from const import *


def main():
    connection = connect_to_mysql_db()
    
    if (not table_exists(connection, ARTISTS_TABLE_NAME)):
        create_table(connection, ARTISTS_TABLE_NAME, CREATE_ARTISTS_TABLE_QUERY)
    insert_from_csv(connection, CLEANED_ARTISTS_DATA_CSV, ARTISTS_TABLE_NAME, ARTISTS_INSERT_QUERY)

    if (not table_exists(connection, ARTWORKS_TABLE_NAME)):
        create_table(connection, ARTWORKS_TABLE_NAME, CREATE_ARTWORKS_TABLE_QUERY)
    insert_from_csv(connection, CLEANED_ARTWORKS_DATA_CSV, ARTWORKS_TABLE_NAME, ARTWORKS_INSERT_QUERY)

        
def connect_to_mysql_db():
    print(f'Connessione ad database "{DATABASE_NAME}"')

    try:
        connection = pymysql.connect(
            host=HOST,
            user=USER,
            password=PASSWORD,
            database=DATABASE_NAME,
            cursorclass=CURSOR_CLASS
        )
        print(f'> Connessione all\'host {HOST} stabilita con successo')
        return connection

    except pymysql.err.OperationalError:
        print(f'> Impossibile connettersi all\'host {HOST}. Controllare le credenziale e riprovare')
        exit(2)
    
    
def table_exists(connection, table_name):
    print(f'\nCreazione tabella \"{table_name}"')
    with connection.cursor() as cursor:
        cursor.execute(SHOW_TABLE_QUERY, table_name)
        if cursor.fetchone():
            print(f'> Tabella "{table_name}" giá esistente')
            return True
        return False
    
    
def create_table(connection, table_name, query):
    with connection.cursor() as cursor:
        cursor.execute(query)
        connection.commit()
    print(f'> Tabella "{table_name}" creata con successo')


def insert_from_csv(connection, csv_file, table_name, query):
    print(f'\nInserimento delle entries nella tabella "{table_name}"')

    with open(csv_file, mode='r', encoding='utf-8') as file:
        reader = csv.reader(file)
        next(reader)

        with connection.cursor() as cursor:
            added = duplicates = 0
            for entry in reader:
                try:
                    cursor.execute(query, tuple(entry))
                    added += 1
                except pymysql.err.IntegrityError:
                    duplicates += 1
            connection.commit()
            
        print(f'> Aggiunte con successo {added} entries')
        print(f'> Trovati {duplicates} duplicati')


if __name__ == '__main__':
    main()