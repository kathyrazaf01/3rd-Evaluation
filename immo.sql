

--

CREATE OR viewlocationclientpaiement AS
 SELECT loc.idlocation,
    loc.idclient,
    loc.idbien,
    loc.datedebut,
    loc.datefin,
    p.idpaiement,
    p.datepaiement,
    p.loyer_a_paye,
    p.loyer_paye,
    c.nomclient,
    c.idtypep,
    tp.nomtypep,
    b.nombien,
    b.region,
    b.loyer,
    b.idtypeb,
    tb.nomtypeb
   FROM typepersonne tp
     JOIN client c ON c.idtypep = tp.idtypep
     JOIN locationclient loc ON loc.idclient = c.idclient
     JOIN paiement p ON p.idlocation = loc.idlocation
     JOIN bien b ON loc.idbien = b.idbien
     JOIN typebien tb ON b.idtypeb = tb.idtypeb;


-- Table: public.typebien

-- DROP TABLE IF EXISTS public.typebien;

ALTER SEQUENCE proprietaire_idprop_seq RESTART WITH 1;


CREATE TABLE IF NOT EXISTS public.typebien
(
    idtypeb integer NOT NULL DEFAULT nextval('typebien_idtypeb_seq'::regclass),
    nomtypeb character varying COLLATE pg_catalog."default",
    commission integer,
    CONSTRAINT typebien_pkey PRIMARY KEY (idtypeb)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.typebien
    OWNER to postgres;

    -- Table: public.typebien

-- DROP TABLE IF EXISTS public.typebien;

CREATE TABLE IF NOT EXISTS public.typebien
(
    idtypeb integer NOT NULL DEFAULT nextval('typebien_idtypeb_seq'::regclass),
    nomtypeb character varying COLLATE pg_catalog."default",
    commission integer,
    CONSTRAINT typebien_pkey PRIMARY KEY (idtypeb)
)

TABLESPACE pg_default;


-- Table: public.bien

-- DROP TABLE IF EXISTS public.bien;

CREATE TABLE IF NOT EXISTS public.bien
(
    idbien integer NOT NULL DEFAULT nextval('bien_idbien_seq'::regclass),
    nombien character varying COLLATE pg_catalog."default",
    region character varying COLLATE pg_catalog."default",
    loyer double precision,
    photo character varying COLLATE pg_catalog."default",
    idtypeb integer,
    CONSTRAINT bien_pkey PRIMARY KEY (idbien),
    CONSTRAINT bien_idtypeb_fkey FOREIGN KEY (idtypeb)
        REFERENCES public.typebien (idtypeb) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.bien
    OWNER to postgres;

ALTER TABLE IF EXISTS public.typebien
    OWNER to postgres;


-- Table: public.proprieteclient

-- DROP TABLE IF EXISTS public.proprieteclient;

CREATE TABLE IF NOT EXISTS public.proprieteclient
(
    idpropclient integer NOT NULL DEFAULT nextval('"propriété_idpropriete_seq"'::regclass),
    nompropclient character varying COLLATE pg_catalog."default",
    idtypep integer,
    telephone integer,
    email character varying COLLATE pg_catalog."default",
    CONSTRAINT "propriété_pkey" PRIMARY KEY (idpropclient),
    CONSTRAINT "propriété_idtypep_fkey" FOREIGN KEY (idtypep)
        REFERENCES public.typepersonne (idtypep) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.proprieteclient
    OWNER to postgres;

    -- Table: public.locationclient

-- DROP TABLE IF EXISTS public.locationclient;

CREATE TABLE IF NOT EXISTS public.locationclient
(
    idlocation integer NOT NULL DEFAULT nextval('locationclient_idlocation_seq'::regclass),
    idpropclient integer,
    idbien integer,
    datedebut date,
    datefin date,
    CONSTRAINT locationclient_pkey PRIMARY KEY (idlocation),
    CONSTRAINT locationclient_idbien_fkey FOREIGN KEY (idbien)
        REFERENCES public.bien (idbien) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT locationclient_idpropclient_fkey FOREIGN KEY (idpropclient)
        REFERENCES public.proprieteclient (idpropclient) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)

TABLESPACE pg_default;

-- Table: public.locationclient

-- DROP TABLE IF EXISTS public.locationclient;

CREATE TABLE IF NOT EXISTS public.locationclient
(
    idlocation integer NOT NULL DEFAULT nextval('locationclient_idlocation_seq'::regclass),
    idpropclient integer,
    idbien integer,
    datedebut date,
    datefin date,
    CONSTRAINT locationclient_pkey PRIMARY KEY (idlocation),
    CONSTRAINT locationclient_idbien_fkey FOREIGN KEY (idbien)
        REFERENCES public.bien (idbien) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT locationclient_idpropclient_fkey FOREIGN KEY (idpropclient)
        REFERENCES public.proprieteclient (idpropclient) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.locationclient
    OWNER to postgres;

ALTER TABLE IF EXISTS public.locationclient
    OWNER to postgres;

INSERT INTO public.typebien(
	nomtypeb, commission)
	VALUES ('maison', 10),
	('appartement', 15),
('villa', 20),
	('immeuble', 25)	
	;

    INSERT INTO public.typepersonne(
	nometypep)
	VALUES ('particulier'),
	('professionnel');


INSERT INTO public.photo(
    nomphoto, idbien)
VALUES 
    ('maison/exterieur maison 1.jpg', 1),
    ('maison/exterieur maison 2.jpg', 1),
    ('appartement/exterieur appart 1.jpg', 2),
    ('appartement/exterieur appart 2.jpg', 2),
    ('villa/exterieur villa 1.jpg', 3),
     ('villa/exterieur villa 2.jpg', 3),
    ('immeuble/exterieur immeuble 1.jpg', 4),
     ('immeuble/exterieur immeuble 2.jpg', 4),
    ('maison/interieur maison 1.jpg', 5),
     ('maison/interieur maison 2.jpg', 5),
    ('appartement/interieur appart 1.jpg', 6),
     ('appartement/interieur appart 2.jpg', 6),
    ('villa/interieur villa 1.jpg', 7),
    ('villa/interieur villa 2.jpg', 7),
    ('immeuble/interieur immeuble 1.jpg', 8),
    ('immeuble/interieur immeuble 2.jpg', 8);

-- Insertion des données dans la table paiement
INSERT INTO public.paiement(idlocation, datepaiement, loyer_paye)
VALUES 
    (1, '2023-01-05', 1500000),
    (1, '2023-02-05', 1500000),
    (2, '2023-02-05', 1000000),
    (2, '2023-03-05', 1000000),
    (3, '2023-03-05', 5000000),
    (3, '2023-04-05', 5000000),
    (4, '2023-04-05', 10000000),
    (4, '2023-05-05', 10000000);


--afficher paiement filtre date

SELECT COALESCE((SELECT loyer_paye
                 FROM viewlocationclientpaiement
                 WHERE datepaiement BETWEEN '2023-06-05' AND '2023-07-06'
                   AND idbien = 1
                 LIMIT 1), 0) AS loyer_paye;



--calcul de durée de mois entre deux dates
SELECT
    idlocation,
    datedebut,
    datefin,
    CASE 
        WHEN date_part('year', datefin) = date_part('year', datedebut) AND date_part('month', datefin) = date_part('month', datedebut) THEN 1
        ELSE (date_part('year', age(datefin, datedebut)) * 12 + date_part('month', age(datefin, datedebut)) + 
              CASE WHEN date_part('day', datefin) > date_part('day', datedebut) THEN 1 ELSE 0 END)
    END AS months_between from viewlocationclientpaiement


--calcul affichage enter deux date client (encore à corriger)
 
        WITH date_params AS (
                SELECT
                    '2023-04-01'::date AS date1,
                    '2023-07-01'::date AS date2
            ),
            loyer_per_month AS (
                SELECT
                    lc.idbien,
                    90 * b.loyer AS total_loyer_a_payer
                FROM
                    locationclient lc
                JOIN
                    bien b ON lc.idbien = b.idbien
                WHERE
                    lc.idbien = 1
            ),
            payments_in_interval AS (
                SELECT
                    p.idlocation,
                    COALESCE(SUM(p.loyer_paye), 0) AS total_loyer_paye
                FROM
                    paiement p
                JOIN
                    locationclient lc ON p.idlocation = lc.idlocation
                JOIN
                    date_params dp ON p.datepaiement BETWEEN dp.date1 AND dp.date2
                GROUP BY
                    p.idlocation
            ),
              payments_without_interval AS (
                SELECT
                    p.idlocation,
                    COALESCE(SUM(p.loyer_paye), 0) AS total_loyer_paye
                FROM
                    paiement p
                JOIN
                    locationclient lc ON p.idlocation = lc.idlocation
                GROUP BY
                    p.idlocation
            )
            SELECT
                lc.idbien,
                dp.date1,
                dp.date2,
                lp.total_loyer_a_payer,
                COALESCE(pi.total_loyer_paye, 0) AS total_loyer_paye,
                lp.total_loyer_a_payer - COALESCE(pw.total_loyer_paye, 0) AS reste_a_payer
            FROM
                locationclient lc
            JOIN
                loyer_per_month lp ON lc.idbien = lp.idbien
            JOIN
                date_params dp ON true
            LEFT JOIN
               payments_in_interval pi ON lc.idlocation = pi.idlocation
             LEFT JOIN
                 payments_without_interval pw ON lc.idlocation = pw.idlocation
            WHERE
                lc.idbien = 1
                AND lc.datedebut <= dp.date2


--différence datefin et date prédiction

WITH date_params AS (
    SELECT
        '2023-04-01'::date AS date1
)
SELECT
    CASE 
        WHEN date_part('year', datefin) = date_part('year', dp.date1) AND date_part('month', datefin) = date_part('month', dp.date1) THEN 1
        ELSE (date_part('year', age(datefin, dp.date1)) * 12 + date_part('month', age(datefin, dp.date1)) + 
              CASE WHEN date_part('day', datefin) > date_part('day', dp.date1) THEN 1 ELSE 0 END)
    END AS months_between
FROM
    locationclient lc
JOIN
    date_params dp ON true where lc.idbien = 1; 

--différence de date où deux dates dans le même mois compte 1 mois 

SELECT
    idlocation,
    datedebut,
    datefin,
    CASE 
        WHEN date_part('year', datefin) = date_part('year', datedebut) AND date_part('month', datefin) = date_part('month', datedebut) THEN 1
        ELSE (date_part('year', age(datefin, datedebut)) * 12 + date_part('month', age(datefin, datedebut)) + 
              CASE WHEN date_part('day', datefin) > date_part('day', datedebut) THEN 2 ELSE 1 END)
    END AS months_between
FROM
    locationclient;





WITH date_params AS (
    SELECT
        '2023-01-01'::date AS date1,
        '2023-12-31'::date AS date2
),
monthly_payments AS (
    SELECT
        lc.idbien,
        date_trunc('month', p.datepaiement) AS month,
        SUM(p.loyer_paye) AS total_loyer_paye
    FROM
        paiement p
    JOIN
        locationclient lc ON p.idlocation = lc.idlocation
    JOIN
        date_params dp ON p.datepaiement BETWEEN dp.date1 AND dp.date2
    GROUP BY
        lc.idbien,
        date_trunc('month', p.datepaiement)
),
commissions AS (
    SELECT
        mp.idbien,
        mp.month,
        mp.total_loyer_paye,
        tb.commission,
        (mp.total_loyer_paye * tb.commission / 100) AS gain
    FROM
        monthly_payments mp
    JOIN
        bien b ON mp.idbien = b.idbien
    JOIN
        typebien tb ON b.idtypeb = tb.idtypeb
)
SELECT
    month,
    SUM(total_loyer_paye) AS total_chiffre_affaire,
    SUM(gain) AS total_gains
FROM
    commissions
GROUP BY
    month
ORDER BY
    month;





--calcule date debut date fin filtre

     WITH date_params AS (
    SELECT
        '2023-07-30'::date AS date2
)
SELECT
    idlocation,
    datedebut,
    date2,
    CASE 
        WHEN date_part('year', d.date2) = date_part('year', datedebut) AND date_part('month', d.date2) = date_part('month', datedebut) THEN 1
        ELSE (date_part('year', age(d.date2, datedebut)) * 12 + date_part('month', age(d.date2, datedebut)) + 
              CASE WHEN date_part('day', d.date2) > date_part('day', datedebut) THEN 2 ELSE 1 END)
    END AS months_between 
FROM
    locationclient l
	join date_params d on l.datedebut <= d.date2;