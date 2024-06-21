import pandas as pd
import numpy as np
from const import *


artist_df = pd.read_csv(ARTIST_DATA)
artwork_df = pd.read_csv(ARTWORK_DATA)

artist_df_nan = artist_df.copy()

artist_df_nan['gender'].fillna('Not specified', inplace=True)
artist_df_nan['yearOfBirth'] = artist_df_nan['yearOfBirth'].replace(np.nan, 0).astype(int)
artist_df_nan['yearOfDeath'] = artist_df_nan['yearOfDeath'].replace(np.nan, 0).astype(int)
artist_df_nan['placeOfBirth'].fillna('Unknown', inplace=True)
artist_df_nan['placeOfDeath'].fillna('Unknown', inplace=True)

artist_df_nan.drop(columns=['dates'], inplace=True)
print(artist_df_nan.isnull().sum())


cleaned_file_path = 'cleaned_artist_data.csv'
artist_df_nan.to_csv(cleaned_file_path, index=False)

'''
# Step 1: Gestione dei valori mancanti
artist_df_nan['gender'].fillna('Not specified', inplace=True)
artist_df_nan['placeOfBirth'].fillna('Unknown', inplace=True)
artist_df_nan['placeOfDeath'].fillna('Unknown', inplace=True)

# Step 2: Normalizzazione dei dati (placeOfBirth e placeOfDeath)
artist_df_nan['placeOfBirth'] = artist_df_nan['placeOfBirth'].str.title()
artist_df_nan['placeOfDeath'] = artist_df_nan['placeOfDeath'].str.title()

# Step 3: Rimozione delle colonne irrilevanti
artist_df_nan.drop(columns=['dates'], inplace=True)

# Step 4: Conversione dei tipi di dati (le colonne yearOfBirth e yearOfDeath rimangono float)

# Step 5: Rimozione dei duplicati
artist_df_nan.drop_duplicates(inplace=True)

# Salva il dataset pulito in un nuovo file CSV
cleaned_file_path = 'cleaned_artist_data.csv'
artist_df_nan.to_csv(cleaned_file_path, index=False)

print(artist_df_nan.isnull().sum())
'''