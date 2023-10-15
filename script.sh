#!/bin/bash

mkdir ./bdd
cd ./bdd

wget -O - https://datasets.imdbws.com/name.basics.tsv.gz | zcat > name.basics.tsv
wget -O - https://datasets.imdbws.com/title.akas.tsv.gz | zcat > title.akas.tsv
wget -O - https://datasets.imdbws.com/title.basics.tsv.gz | zcat > title.basics.tsv
wget -O - https://datasets.imdbws.com/title.crew.tsv.gz | zcat > title.crew.tsv
wget -O - https://datasets.imdbws.com/title.episode.tsv.gz | zcat > title.episode.tsv
wget -O - https://datasets.imdbws.com/title.principals.tsv.gz | zcat > title.principals.tsv
wget -O - https://datasets.imdbws.com/title.ratings.tsv.gz | zcat > title.ratings.tsv

sed -i 's/Rosenkavalier""/Rosenkavalier"/' title.akas.tsv
PGPASSWORD="toor" psql -h localhost -d yassine -U yassine -c "DROP TABLE IF EXISTS test; create table test (titleId varchar, ordering integer, title varchar, region varchar, language varchar, types varchar, attributes varchar, isOriginalTitle varchar);"
PGPASSWORD="toor" psql -h localhost -d yassine -U yassine -c "\COPY test FROM './title.akas.tsv' DELIMITER E'\t' CSV HEADER;"
