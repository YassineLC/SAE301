#!/bin/bash

echo "Importation des tables dans la base de données"
PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -f "tables.sql"

echo "Importation des données dans la base de données"
#Dossier contenant les fichiers .tsv
cd ./bdd

files=(*.tsv)

for file in "${files[@]}"; do
  table="${file%.tsv}"
  temp=$(echo "$table" | tr -d '.')
  commande="\COPY $temp FROM '$file' WITH DELIMITER E'\t' QUOTE E'\b' CSV HEADER NULL '\N';"
  PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -c "$commande"
done
