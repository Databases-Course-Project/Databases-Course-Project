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

ARTISTS_TABLE_NAME = 'Artists'
ARTWORKS_TABLE_NAME = 'Artworks'

CREATE_ARTISTS_TABLE_QUERY = '''\
    CREATE TABLE `Artists` (\
        `id` int(6) NOT NULL,\
        `name` varchar(255) COLLATE utf8_bin NOT NULL,\
        `gender` varchar(6) COLLATE utf8_bin NOT NULL,\
        `dates` varchar(255) COLLATE utf8_bin,\
        `year_of_birth` varchar(255) COLLATE utf8_bin,\
        `year_of_death` varchar(255) COLLATE utf8_bin,\
        `place_of_birth` varchar(255) COLLATE utf8_bin,\
        `place_of_death` varchar(255) COLLATE utf8_bin,\
        `url` varchar(255) COLLATE utf8_bin NOT NULL,\
        PRIMARY KEY (`id`)\
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin\
'''

CREATE_ARTWORKS_TABLE_QUERY = '''\
    CREATE TABLE `Artworks` (\
        `id` int(8) NOT NULL,\
        `accession_number` varchar(8) COLLATE utf8_bin NOT NULL,\
        `artist` varchar(255) COLLATE utf8_bin,\
        `artistRole` varchar(255) COLLATE utf8_bin,\
        `artistId` int(8) NOT NULL,\
        `title` varchar(2047) COLLATE utf8_bin,\
        `dateText` varchar(255) COLLATE utf8_bin,\
        `medium` varchar(255) COLLATE utf8_bin,\
        `creditLine` varchar(2047) COLLATE utf8_bin,\
        `year` varchar(255) COLLATE utf8_bin,\
        `acquisitionYear` varchar(255) COLLATE utf8_bin,\
        `dimensions` varchar(255) COLLATE utf8_bin,\
        `width` varchar(255) COLLATE utf8_bin,\
        `height` varchar(255) COLLATE utf8_bin,\
        `depth` varchar(255) COLLATE utf8_bin,\
        `units` varchar(255) COLLATE utf8_bin,\
        `inscription` varchar(255) COLLATE utf8_bin,\
        `thumbnailCopyright` varchar(2047) COLLATE utf8_bin,\
        `thumbnailUrl` varchar(255) COLLATE utf8_bin,\
        `url` varchar(255) COLLATE utf8_bin,\
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin\
'''

ARTISTS_INSERT_QUERY = '''\
    INSERT INTO `Artists` (\
        `id`,\
        `name`,\
        `gender`,\
        `dates`,\
        `year_of_birth`,\
        `year_of_death`,\
        `place_of_birth`,\
        `place_of_death`,\
        `url`\
    ) VALUES (\
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

ARTWORKS_INSERT_QUERY = '''\
    INSERT INTO `Artworks` (\
        `id`,\
        `accession_number`,\
        `artist`,\
        `artistRole`,\
        `artistId`,\
        `title`,\
        `dateText`,\
        `medium`,\
        `creditLine`,\
        `year`,\
        `acquisitionYear`,\
        `dimensions`,\
        `width`,\
        `height`,\
        `depth`,\
        `units`,\
        `inscription`,\
        `thumbnailCopyright`,\
        `thumbnailUrl`,\
        `url`\
    ) VALUES (\
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
        %s,\
        %s\
    )\
'''

SHOW_TABLE_QUERY = 'SHOW TABLES LIKE %s'