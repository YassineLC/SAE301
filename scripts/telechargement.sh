#!/bin/bash

mkdir -p ./bdd
cd ./bdd

files=(
  "name.basics.tsv.gz"
  "title.akas.tsv.gz"
  "title.basics.tsv.gz"
  "title.crew.tsv.gz"
  "title.episode.tsv.gz"
  "title.principals.tsv.gz"
  "title.ratings.tsv.gz"
)

for file in "${files[@]}"; do
  url="https://datasets.imdbws.com/$file"
  filename="${file%.gz}"
  wget "$url"
  gzip -d "$file"
done

rm -f *.gz
