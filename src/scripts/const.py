import os

from pymysql.cursors import DictCursor


SOURCE_PATH = os.path.dirname(os.path.dirname(__file__))
PROJECT_PATH = os.path.dirname(SOURCE_PATH)
COLLECTION_PATH = f'{PROJECT_PATH}/collection'

HOST = '127.0.0.1'
USER = 'root'
PASSWORD = 'mypassword'
DATABASE_NAME = 'museo'
CURSOR_CLASS = DictCursor

ARTISTS_DATA_CSV = f'{COLLECTION_PATH}/artists_data.csv'
ARTWORKS_DATA_CSV = f'{COLLECTION_PATH}/artworks_data.csv'
CLEANED_ARTISTS_DATA_CSV = f'{COLLECTION_PATH}/cleaned_artists_data.csv'
CLEANED_ARTWORKS_DATA_CSV = f'{COLLECTION_PATH}/cleaned_artworks_data.csv'

ARTISTS_TABLE_NAME = 'Artists'
ARTWORKS_TABLE_NAME = 'Artworks'

CREATE_ARTISTS_TABLE_QUERY = '''\
    CREATE TABLE `Artists` (\
        `id` INTEGER NOT NULL,\
        `name` VARCHAR(255) NOT NULL,\
        `gender` CHAR NOT NULL,\
        `year_of_birth` CHAR(4) NOT NULL,\
        `birth_city` VARCHAR(50) NOT NULL,\
        `birth_state` VARCHAR(50) NOT NULL,\
        `year_of_death` VARCHAR(4),\
        `death_city` VARCHAR(50),\
        `death_state` VARCHAR(50),\
        `url` VARCHAR(255) NOT NULL,\
        
        PRIMARY KEY (`id`),\
        FOREIGN KEY (`id`) REFERENCES Artworks(`artistId`)\
    )\
'''

CREATE_ARTWORKS_TABLE_QUERY = '''\
    CREATE TABLE `Artworks` (\
        `id` INTEGER NOT NULL,\
        `accession_number` CHAR(7) NOT NULL,\
        `artist` VARCHAR(255),\
        `artistRole` VARCHAR(100),\
        `artistId` INTEGER NOT NULL,\
        `title` VARCHAR(2047),\
        `dateText` VARCHAR(255),\
        `medium` VARCHAR(255),\
        `creditLine` VARCHAR(2047),\
        `year` INTEGER,\
        `acquisitionYear` INTEGER,\
        `types` VARCHAR(100),\
        `width` INTEGER,\
        `height` INTEGER,\
        `depth` INTEGER,\
        `units` CHAR(2),\
        `inscription` CHAR(15),\
        `thumbnailUrl` VARCHAR(255),\
        `url` VARCHAR(255),\
        
        PRIMARY KEY (`id`, `accession_number`),\
        UNIQUE (`id`)\
    )\
'''

ARTISTS_INSERT_QUERY = '''\
    INSERT INTO `Artists` VALUES (\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s
    )\
'''

ARTWORKS_INSERT_QUERY = '''\
    INSERT INTO `Artworks` VALUES (\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s,\
        %s\
    )\
'''

SHOW_TABLE_QUERY = 'SHOW TABLES LIKE %s'
