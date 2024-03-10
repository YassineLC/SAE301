--table intermediaire 
CREATE TABLE resultats_intermediaires AS
SELECT tb.tconst, tb.originaltitle, tp.nconst, nb.primaryname
FROM titlebasics tb
JOIN titleprincipals tp ON tb.tconst = tp.tconst
JOIN namebasics nb ON tp.nconst = nb.nconst
WHERE tb.titletype IN ('movie', 'tvSeries', 'tvMovie')
  AND NOT EXISTS (
    SELECT 1
    FROM UNNEST(STRING_TO_ARRAY(tb.genres, ',')) AS genre
    WHERE genre = ANY (ARRAY['Adult', 'Game-Show', 'News', 'Reality-TV', 'Talk-Show', 'Short'])
  );

-- acteurs
CREATE OR REPLACE FUNCTION get_popular_actor(expression TEXT)
RETURNS TABLE(nconst TEXT, primaryname TEXT, popularity_score INT) AS $$
BEGIN
    -- Compter le nombre d'acteurs correspondant à l'expression
    IF (SELECT COUNT(*) FROM namebasics nb WHERE nb.primaryname = expression) > 1 THEN
        RETURN QUERY
        SELECT 
            CAST(nb.nconst AS TEXT), 
            CAST(nb.primaryname AS TEXT), 
            CAST(SUM(tr.numvotes) AS INTEGER) AS popularity_score -- Convertir SUM(tr.numvotes) en INTEGER
        FROM namebasics nb
        CROSS JOIN LATERAL UNNEST(string_to_array(nb.knownfortitles, ',')) AS kft(tconst)
        JOIN titleratings tr ON kft.tconst = tr.tconst
        WHERE nb.primaryname = expression
              AND cardinality(string_to_array(nb.knownfortitles, ',')) > 2
              AND ('actor' = ANY(string_to_array(nb.primaryprofession, ','))
                   OR 'actress' = ANY(string_to_array(nb.primaryprofession, ',')))
        GROUP BY nb.nconst, nb.primaryname
        ORDER BY popularity_score DESC
        LIMIT 1;
    ELSE
        RETURN QUERY
        SELECT 
            CAST(nb.nconst AS TEXT), 
            CAST(nb.primaryname AS TEXT), 
            NULL::INT AS popularity_score
        FROM namebasics nb
        WHERE nb.primaryname = expression;
    END IF;
END;
$$ LANGUAGE plpgsql;


--films
CREATE OR REPLACE FUNCTION get_unique_titles(expression TEXT)
RETURNS TABLE(effective_tconst TEXT, title TEXT, genres TEXT) AS $$
BEGIN
    RETURN QUERY WITH UniqueTitles AS (
        SELECT
            CAST(COALESCE(te.parenttconst, tb.tconst) AS TEXT) AS effective_tconst,
            CAST(CASE
                WHEN te.parenttconst IS NOT NULL THEN (SELECT tb_inner.originaltitle FROM titlebasics tb_inner WHERE tb_inner.tconst = te.parenttconst AND tb_inner.titletype = 'movie')
                ELSE tb.originaltitle
            END AS TEXT) AS title,
            CAST(tb.genres AS TEXT)
        FROM titlebasics tb
        LEFT JOIN titleepisode te ON tb.tconst = te.tconst
        JOIN titleprincipals tp ON tb.tconst = tp.tconst
        WHERE tp.nconst = expression AND tb.titletype = 'movie'
    )
    SELECT DISTINCT
        UT.effective_tconst,
        UT.title,
        UT.genres
    FROM UniqueTitles UT
    ORDER BY UT.effective_tconst;
END;
$$ LANGUAGE plpgsql;



