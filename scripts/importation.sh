#!/bin/bash

PGUSER="yassine"
PGPASSWORD="toor"
PGHOST="localhost"
PGDATABASE="sae"


PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -c "\i tables.sql"

cd /home/yassine/MEGA/COURS/BUT2/SAE/bdd

files=(*.tsv)

for file in "${files[@]}"; do
sed -i 's/\\N//g' "$file"
table="${file%.tsv}"
temp=$(echo $table | tr -d '.')
commande="\COPY $temp FROM '$file' DELIMITER E'\t' CSV HEADER;"
PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -c "$commande"
done
