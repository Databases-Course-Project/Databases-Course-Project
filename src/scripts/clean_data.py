import pandas as pd
import numpy as np
from const import *
#import requests
import re

#API_KEY = 'a5335462b7494af9a5e6355993aa2168'

def clean_artist_data(df):
    df['gender'] = df['gender'].fillna('-').replace({'Male': 'M', 'Female': 'F'})
    df['placeOfBirth'] = df['placeOfBirth'].fillna('Unknown')
    df['placeOfDeath'] = df['placeOfDeath'].fillna('Unknown')
    
    # Separare 'birthCity' e 'birthState' basandosi sulla presenza di una virgola
    birth_split = df['placeOfBirth'].str.split(', ', expand=True)
    df['birthCity'] = birth_split[0]
    df['birthState'] = birth_split[1].fillna('Unknown')

    # Separare 'deathCity' e 'deathState' basandosi sulla presenza di una virgola
    death_split = df['placeOfDeath'].str.split(', ', expand=True)
    df['deathCity'] = death_split[0]
    df['deathState'] = death_split[1].fillna('Unknown')

    # Conversione delle colonne yearOfBirth e yearOfDeath in interi
    df['yearOfBirth'] = df['yearOfBirth'].replace(np.nan, 0).astype(int)
    df['yearOfDeath'] = df['yearOfDeath'].replace(np.nan, 0).astype(int)

    # Sostituire i valori mancanti per le nuove colonne
    df['birthCity'] = df['birthCity'].fillna('Unknown')
    df['birthState'] = df['birthState'].fillna('Unknown')
    df['deathCity'] = df['deathCity'].fillna('Unknown')
    df['deathState'] = df['deathState'].fillna('Unknown')
    
    #df['birthState'] = df.apply(lambda row: get_state_from_city(row['birthCity']) if row['birthCity'] != 'Unknown' and row['birthState'] == 'Unknown' else row['birthState'], axis=1)
    #df['deathState'] = df.apply(lambda row: get_state_from_city(row['deathCity']) if row['deathCity'] != 'Unknown' and row['deathState'] == 'Unknown' else row['deathState'], axis=1)
    #print(df.apply(lambda row: get_state_from_city(row['birthCity']) if row['birthCity'] != 'Unknown' and row['birthState'] == 'Unknown' else row['birthState'], axis=1))
    
    df.drop(columns=['placeOfBirth', 'placeOfDeath', 'dates'], inplace=True)
    columns_to_keep = ['id', 'name', 'gender', 'yearOfBirth', 'birthCity', 'birthState',
                       'yearOfDeath', 'deathCity', 'deathState', 'url']
    
    return df[columns_to_keep]

def clean_artwork_data(df):
    df.drop(columns=['thumbnailCopyright'], inplace=True)
    df = check_fk_integrity(df)
    df['units'] = df['units'].fillna('mm')
    df['creditLine'] = df['creditLine'].fillna('Unknown')
    df['depth'] = df['depth'].fillna(0)
    
    df['acquisitionYear'] = df['creditLine'].str.extract(r'(\d{4})').iloc[:, 0]
    df['width'] = df['dimensions'].str.extract(r'(\d+)\s*[xX]\s*\d+').astype(float).iloc[:, 0]
    df['height'] = df['dimensions'].str.extract(r'\d+\s*[xX]\s*(\d+)').astype(float).iloc[:, 0]
    
    df['year'] = df['year'].fillna(0)
    df['inscription'] = df['inscription'].fillna('date inscribed')
    df['dimensions'] = df['dimensions'].fillna('Unknown')
    df['medium'] = df['medium'].fillna('Unknown')
    df['acquisitionYear'] = df['acquisitionYear'].fillna(0)
    
    df['year'] = pd.to_numeric(df['year'].replace('no date', np.nan), errors='coerce').fillna(0).astype(int)
    df['acquisitionYear'] = pd.to_numeric(df['acquisitionYear'], errors='coerce').fillna(0).astype(int)
    df['width'] = pd.to_numeric(df['width'], errors='coerce').fillna(0).astype(int)
    df['height'] = pd.to_numeric(df['height'], errors='coerce').fillna(0).astype(int)
    df['depth'] = df['depth'].astype(int)
    
    df['thumbnailUrl'] = df['thumbnailUrl'].str.replace("/www.", "/media.")
    df['thumbnailUrl'] = df['thumbnailUrl'].fillna('Unknown')
    df['types'] = df['dimensions'].apply(extract_type_without_dimensions)
    df['types'] = df['types'].fillna('Unknown')
    
    columns_to_keep = ['id', 'accession_number', 'artist', 'artistRole', 'artistId', 'title', 'dateText', 
                       'medium', 'creditLine', 'year', 'acquisitionYear', 'types', 'width', 'height', 
                       'depth', 'units', 'inscription', 'thumbnailUrl', 'url']
    return df[columns_to_keep]

'''
def get_state_from_city(city):
    url = f'https://api.opencagedata.com/geocode/v1/json?q={city}&key={API_KEY}'
    response = requests.get(url)
    data = response.json()
    
    if response.status_code == 200 and data['results']:
        # Prendi la componente amministrativa dello stato (in base alla struttura della risposta dell'API)
        for component in data['results'][0]['components'].values():
            if isinstance(component, dict) and component.get('_type') == 'state':
                return component['name']
    return 'Unknown'
'''

def extract_type_without_dimensions(dimension_str):
    match = re.search(r'\d', dimension_str) if any(char.isdigit() for char in dimension_str) else None
    text_part = dimension_str[:match.start()].strip() if match else dimension_str.strip()
    return text_part.replace(':', '').strip() or None

def check_fk_integrity(df):
  artist_df = pd.read_csv(ARTISTS_DATA_CSV)
  return df[df['artistId'].isin(artist_df['id'])]

def main():
    # Load data
    artist_df = pd.read_csv(ARTISTS_DATA_CSV)
    artwork_df = pd.read_csv(ARTWORKS_DATA_CSV, low_memory=False)

    # Clean and save artist data
    cleaned_artist_df = clean_artist_data(artist_df.copy())
    cleaned_artist_df = cleaned_artist_df.astype({
        'id': int,
        'name': str,
        'gender': str,
        'yearOfBirth': int,
        'birthCity': str,
        'birthState': str,
        'yearOfDeath': int,
        'deathCity': str,
        'deathState': str,
        'url': str
    })
    cleaned_artist_df.to_csv(CLEANED_ARTISTS_DATA_CSV, index=False)

    # Clean and save artwork data
    cleaned_artwork_df = clean_artwork_data(artwork_df.copy())
    cleaned_artwork_df = cleaned_artwork_df.astype({
        'id': int,
        'accession_number': str,
        'artist': str,
        'artistRole': str,
        'artistId': int,
        'title': str,
        'dateText': str,
        'medium': str,
        'creditLine': str,
        'year': int,
        'acquisitionYear': int,
        'types': str,
        'width': int,
        'height': int,
        'depth': int,
        'units': str,
        'inscription': str,
        'thumbnailUrl': str,
        'url': str
    })
    cleaned_artwork_df.to_csv(CLEANED_ARTWORKS_DATA_CSV, index=False)

if __name__ == "__main__":
    main()