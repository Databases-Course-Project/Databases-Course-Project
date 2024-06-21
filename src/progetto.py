import pandas as pd
import numpy as np
from const import *
from matplotlib import pyplot as plt
import graphing


artist_df = pd.read_csv(ARTIST_DATA)
artwork_df = pd.read_csv(ARTWORK_DATA)


# Dataset artists
artist_df_nan = artist_df.copy()

artist_df_nan['gender'].fillna('Not specified', inplace=True)
artist_df_nan['yearOfBirth'] = artist_df_nan['yearOfBirth'].replace(np.nan, 0).astype(int)
artist_df_nan['yearOfDeath'] = artist_df_nan['yearOfDeath'].replace(np.nan, 0).astype(int)
artist_df_nan['placeOfBirth'].fillna('Unknown', inplace=True)
artist_df_nan['placeOfDeath'].fillna('Unknown', inplace=True)

artist_df_nan.drop(columns=['dates'], inplace=True)
# print(artist_df_nan.isnull().sum())

cleaned_artist = 'cleaned_artist_data.csv'
artist_df_nan.to_csv(cleaned_artist, index=False)


# Dataset artworks
artwork_df_nan = artwork_df.copy()
artwork_df_nan.drop(columns=['thumbnailCopyright'], inplace=True)
artwork_df_nan.drop(columns=['thumbnailUrl'], inplace=True)
artwork_df_nan['units'].fillna('mm', inplace=True)
artwork_df_nan['creditLine'].fillna('Unknown', inplace=True)
artwork_df_nan['depth'].fillna(0, inplace=True)
acquisitionYear = artwork_df_nan['creditLine'].str.extract(r'(\d{4})')
acquisitionYear_Series = acquisitionYear.iloc[:, 0]
artwork_df_nan['acquisitionYear'].fillna(acquisitionYear_Series, inplace=True)
first_number = artwork_df_nan['dimensions'].str.extract(r'(\d+)\s*[xX]\s*\d+').astype(float)
first_number_series = first_number.iloc[:, 0]
artwork_df_nan['width'].fillna(first_number_series, inplace=True)
second_number = artwork_df_nan['dimensions'].str.extract(r'\d+\s*[xX]\s*(\d+)').astype(float)
second_number_series = second_number.iloc[:, 0]
artwork_df_nan['height'].fillna(second_number_series, inplace=True)
artwork_df_nan['year'].fillna(0, inplace=True)
artwork_df_nan['inscription'].fillna('date inscribed', inplace=True)
artwork_df_nan['dimensions'].fillna('Unknown', inplace=True)
artwork_df_nan['width'].fillna(0, inplace=True)
artwork_df_nan['height'].fillna(0, inplace=True)
artwork_df_nan['medium'].fillna('Unknown', inplace=True)
artwork_df_nan['acquisitionYear'].fillna(0, inplace=True)

#print(artwork_df_nan.isnull().sum())

#print(artwork_df_nan.loc[artwork_df_nan['dimensions'].notnull() & artwork_df_nan['width'].isnull(), ['id', 'dimensions', 'width', 'height']])
#print(artwork_df_nan.loc[artwork_df_nan['dateText'].notnull() & artwork_df_nan['year'].isnull(), ['id', 'accession_number', 'dateText', 'year']].to_string())
#print(artwork_df_nan.loc[(artwork_df_nan['dateText'] != 'date not known') & artwork_df_nan['dateText'].isnull(), ['id', 'accession_number', 'dateText', 'year']])
#print(artwork_df_nan[artwork_df_nan['inscription'].notnull()].shape)
#print(artwork_df_nan[artwork_df_nan['inscription'] == 'date inscribed'].shape[0])

cleaned_artwork = 'cleaned_artwork_data.csv'
artwork_df_nan.to_csv(cleaned_artwork, index=False)