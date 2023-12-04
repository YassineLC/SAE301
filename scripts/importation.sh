#!/bin/bash

PGUSER="yassine"
PGPASSWORD="toor"
PGHOST="localhost"
PGDATABASE="sae"


PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -c "\i tables.sql"

cd /home/yassine/MEGA/COURS/BUT2/SAE/bdd

sed -i 's/Rosenkavalier""/Rosenkavalier"/' title.akas.tsv
sed -i 's/"Thanatos Palace Hôtel/"Thanatos Palace Hôtel"/' title.principals.tsv
sed -i 's/"Lauzun)/"Lauzun)\"/' title.principals.tsv
sed -i -e '/tt0701219/d' ../bdd/title.basics.tsv

files=(*.tsv)

for file in "${files[@]}"; do
table="${file%.tsv}"
temp=$(echo $table | tr -d '.')
commande="\COPY $temp FROM '$file' WITH DELIMITER E'\t' QUOTE E'\b' CSV HEADER NULL '\N';"
PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -c "$commande"
done
