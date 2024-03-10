---------------------index---------------------
CREATE EXTENSION IF NOT EXISTS pg_trgm;

---------------------index---------------------

------namebacis------
CREATE INDEX IF NOT EXISTS idx_namebasics_primaryname   ON namebasics(primaryname);
CREATE INDEX IF NOT EXISTS idx_namebasics_nconst        ON namebasics(nconst);

------titlebasics------
CREATE INDEX IF NOT EXISTS idx_titlebasics_tconst       ON titlebasics(tconst);
CREATE INDEX IF NOT EXISTS idx_titlebasics_titletype    ON titlebasics(titletype);
CREATE INDEX IF NOT EXISTS idx_titlebasics_genres       ON titlebasics USING GIN (STRING_TO_ARRAY(genres, ','));
CREATE INDEX IF NOT EXISTS idx_titlebasics_originaltitle ON titlebasics USING GIN (originaltitle gin_trgm_ops);

------titleepisode------
CREATE INDEX IF NOT EXISTS idx_titleepisode_tconst      ON titleepisode(tconst);
CREATE INDEX IF NOT EXISTS idx_titleepisode_parenttconst ON titleepisode(parenttconst);

------titleprincipals------
CREATE INDEX IF NOT EXISTS idx_titleprincipals_tconst   ON titleprincipals(tconst);
CREATE INDEX IF NOT EXISTS idx_titleprincipals_nconst   ON titleprincipals(nconst);

------titleratings------
CREATE INDEX IF NOT EXISTS idx_titleratings_tconst      ON titleratings(tconst);

------resultats_intermediaires------
CREATE INDEX IF NOT EXISTS idx_resultats_intermediaires_tconst ON resultats_intermediaires(tconst);
CREATE INDEX IF NOT EXISTS idx_resultats_intermediaires_nconst ON resultats_intermediaires(nconst);



