DROP TABLE IF EXISTS titleakas;
DROP TABLE IF EXISTS titlebasics;
DROP TABLE IF EXISTS titlecrew;
DROP TABLE IF EXISTS titleepisode;
DROP TABLE IF EXISTS titleprincipals;
DROP TABLE IF EXISTS titleratings;
DROP TABLE IF EXISTS namebasics;

CREATE TABLE titleakas (
	titleId varchar,
	ordering integer,
	title varchar,
	region varchar,
	language varchar,
	types varchar,
	attributes varchar,
	isOriginalTitle boolean DEFAULT NULL,
	PRIMARY KEY(titleId, ordering)
	);

CREATE TABLE titlebasics (
	tconst varchar,
	titleType varchar,
	primaryTitle varchar,
	originalTitle varchar,
	isAdult boolean,
	startYear integer,
	endYear integer,
	runtimeMinutes integer,
	genres varchar,
	PRIMARY KEY(tconst)
	);

CREATE TABLE titlecrew (
	tconst varchar,
	directors varchar,
	writers varchar,
	PRIMARY KEY(tconst)
	);

CREATE TABLE titleepisode (
	tconst varchar,
	parentTconst varchar,
	seasonNumber integer,
	episodeNumber integer,
	PRIMARY KEY(tconst)
	);

CREATE TABLE titleprincipals (
	tconst varchar,
	ordering integer,
	nconst varchar,
	category varchar,
	job varchar,
	characters varchar,
	PRIMARY KEY(tconst, ordering)
	);

CREATE TABLE titleratings (
	tconst varchar,
	averageRating numeric,
	numVotes integer,
	PRIMARY KEY(tconst)
	);

CREATE TABLE namebasics (
	nconst varchar,
	primaryName varchar,
	birthYear integer,
	deathYear integer,
	primaryProfession varchar,
	knownForTitles varchar,
	PRIMARY KEY(nconst)
	);
