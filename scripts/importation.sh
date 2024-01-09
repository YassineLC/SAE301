#!/bin/bash

PGUSER="yassine"
PGPASSWORD="toor"
PGHOST="localhost"
PGDATABASE="sae"

#Dossier contenant le script tables.sql
cd /home/yassine/MEGA/COURS/BUT2/SAE/scripts

PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -f "tables.sql"

#Dossier contenant les fichiers .tsv
cd /home/yassine/MEGA/COURS/BUT2/SAE/bdd

files=(*.tsv)

for file in "${files[@]}"; do
  table="${file%.tsv}"
  temp=$(echo "$table" | tr -d '.')
  commande="\COPY $temp FROM '$file' WITH DELIMITER E'\t' QUOTE E'\b' CSV HEADER NULL '\N';"
  PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -c "$commande"
done
