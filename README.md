# Databases Course Project

## Introduction
Project for "Basi di Dati" course of Universitá di Ferrara by [Alessio Celentano](https://github.com/alessiocelentano) e [Thomas Cantuti](https://github.com/thomascantuti).
The goal is to develop a simple local web site which interfaces with a database of a gallery using HTML, PHP, Python and MySQL.

## Usage
### Step 1: ER Diagram
- We drew the following ER Diagram for this database
![](docs/diagrams/er.png)

### Step 2: Data Cleaning
- Raw data is stored in two files, `artists_data.csv` and `artworks_data.csv`
- We have to clean these files and we do it using Pandas

### Step 3: MySQL Database Creation
- We can create the database with MySQL Workbench or via the terminal
```zsh
$ mysql -u username -p
mysql> CREATE DATABASE museo;
mysql> USE museo;
mysql> exit;
```

### Step 4: Create and Initialize the Tables
- We have written a Python script to automatize the reading of every query contained in the `csv`s files and their writing in the database
- Tables creation:
 ```mysql
CREATE TABLE Artists (
    id int(6) NOT NULL,
    name varchar(255) COLLATE utf8_bin NOT NULL,
    gender varchar(6) COLLATE utf8_bin NOT NULL,
    dates varchar(255) COLLATE utf8_bin,
    year_of_birth varchar(255) COLLATE utf8_bin,
    year_of_death varchar(255) COLLATE utf8_bin,
    place_of_birth varchar(255) COLLATE utf8_bin,
    place_of_death varchar(255) COLLATE utf8_bin,
    url varchar(255) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
```
```mysql
CREATE TABLE Artworks (
    id int(8) NOT NULL,
    accession_number varchar(8) COLLATE utf8_bin NOT NULL,
    artist varchar(255) COLLATE utf8_bin,
    artistRole varchar(255) COLLATE utf8_bin,
    artistId int(8) NOT NULL,
    title varchar(2047) COLLATE utf8_bin,
    dateText varchar(255) COLLATE utf8_bin,
    medium varchar(255) COLLATE utf8_bin,
    creditLine varchar(2047) COLLATE utf8_bin,
    year varchar(255) COLLATE utf8_bin,
    acquisitionYear varchar(255) COLLATE utf8_bin,
    dimensions varchar(255) COLLATE utf8_bin,
    width varchar(255) COLLATE utf8_bin,
    height varchar(255) COLLATE utf8_bin,
    depth varchar(255) COLLATE utf8_bin,
    units varchar(255) COLLATE utf8_bin,
    inscription varchar(255) COLLATE utf8_bin,
    thumbnailCopyright varchar(2047) COLLATE utf8_bin,
    thumbnailUrl varchar(255) COLLATE utf8_bin,
    url varchar(255) COLLATE utf8_bin,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
```
- Entry insert
```mysql
INSERT INTO Artists (id, name, gender, dates, year_of_birth, year_of_death, place_of_birth, place_of_death, url)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
```
```mysql
INSERT INTO Artworks (id, accession_number, artist, artistRole, artistId, title, dateText, medium, creditLine, year, acquisitionYear, dimensions, width, height, depth, units, inscription, thumbnailCopyright, thumbnailUrl, url)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s)
```

