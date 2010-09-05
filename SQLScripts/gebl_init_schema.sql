-- sequence fuer tabellen ids
CREATE SEQUENCE gebl_seq
  INCREMENT BY 1
  START WITH 150000
  MINVALUE 150000
  MAXVALUE 999999999999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
-- sequence fuer tabelle personen p_nr
CREATE SEQUENCE gebl_seq_p
  INCREMENT BY 1
  START WITH 1
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
-- sequence fuer tabelle brutstaetten b_nr
CREATE SEQUENCE gebl_seq_b
  INCREMENT BY 1
  START WITH 1
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
-- sequence fuer tabelle geodaten default fuer g_name
CREATE SEQUENCE gebl_seq_b_name
  INCREMENT BY 1
  START WITH 1
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
-- sequence fuer tabelle fallen f_nr
CREATE SEQUENCE gebl_seq_f
  INCREMENT BY 1
  START WITH 1
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
-- sequence fuer tabelle aktionen a_nr
CREATE SEQUENCE gebl_seq_a
  INCREMENT BY 1
  START WITH 1
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
--create tables
CREATE TABLE aktionstyp
    (at_nr                         NUMBER ,
    at_name                        VARCHAR2(50 BYTE))
  PCTFREE     10
  INITRANS    1
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
  NOCACHE
  MONITORING
  NOPARALLEL
  LOGGING
;
ALTER TABLE aktionstyp
ADD CONSTRAINT at_nr_pk PRIMARY KEY (at_nr)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
;
COMMENT ON TABLE aktionstyp IS 'Enthält Zuordnung Aktionstyp zu Aktionsname'
;
COMMENT ON COLUMN aktionstyp.at_nr IS 'Numerischer Wert fuer Aktionstyp'
;
COMMENT ON COLUMN aktionstyp.at_name IS 'Beobachtung..1, Bekaempfung..2, Sonstiges..3'
;
CREATE TABLE aktionen
    (a_id                           NUMBER ,
    a_nr                           VARCHAR2(10 BYTE),
    a_typ                          NUMBER,
    a_betreff                      VARCHAR2(25 BYTE),
    a_datum                        DATE,
    a_p_id                         NUMBER,
    a_b_id                         NUMBER,
	a_f_id                         NUMBER,
    a_text                         VARCHAR2(1024 BYTE) NOT NULL)
  PCTFREE     10
  INITRANS    1
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
  NOCACHE
  MONITORING
  NOPARALLEL
  LOGGING
;
ALTER TABLE aktionen
ADD CONSTRAINT a_id_pk PRIMARY KEY (a_id)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
;
COMMENT ON TABLE aktionen IS 'Enthält Kommentare zu Fundstellen bzw. anderen Punkten
Kann einem Mitarbeiter und einer Fundstelle zugeordnet werden'
;
COMMENT ON COLUMN aktionen.a_b_id IS 'Bezug zu Brutstaetten'
;
COMMENT ON COLUMN aktionen.a_betreff IS 'Kurztitel'
;
COMMENT ON COLUMN aktionen.a_datum IS 'Timestamp'
;
COMMENT ON COLUMN aktionen.a_p_id IS 'Bezug zu Personen'
;
COMMENT ON COLUMN aktionen.a_b_id IS 'Bezug zu Brutstaetten'
;
COMMENT ON COLUMN aktionen.a_f_id IS 'Bezug zu Fallen'
;
COMMENT ON COLUMN aktionen.a_text IS 'Langtext'
;
COMMENT ON COLUMN aktionen.a_typ IS 'Art des Texts'
;
ALTER TABLE aktionen
ADD CONSTRAINT a_b_id_f_id_check CHECK (A_B_ID is not null or A_F_ID is not null)
;
CREATE OR REPLACE TRIGGER insert_aktionen_id_and_nr
 BEFORE
  INSERT
 ON aktionen
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  a_id number;
  a_nr number;
BEGIN
	if (:new.A_Id is null) then
		SELECT gebl_seq.nextval
			INTO a_id
			FROM dual;
		:new.A_Id := a_id;
	end if;
  SELECT gebl_seq_a.nextval
    INTO a_nr
    FROM dual;
  :new.A_nr := 'A-'||to_char(a_nr);
END;
/
CREATE TABLE brutstaetten
    (b_id                           NUMBER ,
    b_nr                           VARCHAR2(10 BYTE),
    b_groesse                      NUMBER,
    b_gewaesser_art                VARCHAR2(50 BYTE),
    b_zugang                       VARCHAR2(100 BYTE),
    b_p_id                         NUMBER,
    b_g_id                         NUMBER,
    b_bek_art                      VARCHAR2(50 BYTE),
    b_text                         VARCHAR2(1024 BYTE),
	b_checked					   NUMBER,
	b_kontaktdaten				   VARCHAR2(256 BYTE))
  PCTFREE     10
  INITRANS    1
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
  NOCACHE
  MONITORING
  NOPARALLEL
  LOGGING
;
ALTER TABLE brutstaetten
ADD CONSTRAINT b_id_pk PRIMARY KEY (b_id)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
;
CREATE OR REPLACE TRIGGER insert_brutstaetten_id_and_nr
 BEFORE
  INSERT
 ON brutstaetten
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  b_id number;
  b_nr number;
BEGIN
	if (:new.B_ID is NULL) then
		SELECT gebl_seq.nextval
			INTO b_id
			FROM dual;
		:new.B_Id := b_id;
	end if;
	SELECT gebl_seq_b.nextval
		INTO b_nr
		FROM dual;
	:new.B_nr := 'B-'||to_char(b_nr);
END;
/
COMMENT ON COLUMN brutstaetten.b_bek_art IS 'Bekämpfungsart'
;
COMMENT ON COLUMN brutstaetten.b_g_id IS 'Bezug zu Länge/Breite'
;
COMMENT ON COLUMN brutstaetten.b_gewaesser_art IS 'Klassifizierung der Fundstelle'
;
COMMENT ON COLUMN brutstaetten.b_groesse IS 'Ausdehnung der Fundstelle'
;
COMMENT ON COLUMN brutstaetten.b_p_id IS 'Bezug zu Personen'
;
COMMENT ON COLUMN brutstaetten.b_text IS 'optionaler Zusatztext'
;
COMMENT ON COLUMN brutstaetten.b_zugang IS 'Zugaenglichkeit;leicht,mittel,schwer'
;
COMMENT ON COLUMN brutstaetten.b_checked IS '0..unchecked/,1..checked'
;
COMMENT ON COLUMN brutstaetten.b_kontaktdaten IS 'optionaler Text fuer Kontakdaten des Melders'
;
CREATE TABLE geodaten
    (g_id                          NUMBER ,
    g_lat                          NUMBER(8,6) NOT NULL,
    g_lon                          NUMBER(8,6) NOT NULL,
    g_typ                          NUMBER NOT NULL,
    g_name                         VARCHAR2(50 BYTE))
  PCTFREE     10
  INITRANS    1
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
  NOCACHE
  MONITORING
  NOPARALLEL
  LOGGING
;
ALTER TABLE geodaten
ADD CONSTRAINT g_id_pk PRIMARY KEY (g_id)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
;
CREATE OR REPLACE TRIGGER insert_geodaten_id
 BEFORE
  INSERT
 ON geodaten
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  g_id number;
  b_nr number;
BEGIN
	if (:new.G_Id is null) then
		SELECT gebl_seq.nextval
			INTO g_id
			FROM dual;
		:new.G_Id := g_id;
	end if;
	if (:new.G_Name is null AND :new.G_Typ = 3) then
		SELECT gebl_seq_b_name.nextval
			INTO b_nr
			FROM dual;
		:new.G_Name := 'Brutstaette-'||to_char(b_nr);
	end if;
END;
/
COMMENT ON COLUMN geodaten.g_typ IS '1..Adresse/,2..Falle,3..Brutstaette'
;

CREATE TABLE fallen
    (f_id                           NUMBER ,
    f_nr                           VARCHAR2(10 BYTE),
    f_typ                          VARCHAR2(100 BYTE),
	f_p_id                         NUMBER,
    f_g_id                         NUMBER,
    f_text                         VARCHAR2(1024 BYTE))
  PCTFREE     10
  INITRANS    1
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
  NOCACHE
  MONITORING
  NOPARALLEL
  LOGGING
;
ALTER TABLE fallen
ADD CONSTRAINT f_id_pk PRIMARY KEY (f_id)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
;
COMMENT ON COLUMN fallen.f_g_id IS 'Bezug zu Geodaten'
;
COMMENT ON COLUMN fallen.f_p_id IS 'Bezug zu Personen'
;
COMMENT ON COLUMN fallen.f_text IS 'optionaler Zusatztext'
;
CREATE OR REPLACE TRIGGER insert_fallen_id_and_nr
 BEFORE
  INSERT
 ON fallen
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  f_id number;
  f_nr number;
BEGIN
	if (:new.F_Id is null) then
		SELECT gebl_seq.nextval
			INTO f_id
			FROM dual;
		:new.F_Id := f_id;
	end if;
	SELECT gebl_seq_f.nextval
		INTO f_nr
		FROM dual;
	:new.F_nr := 'F-'||to_char(f_nr);
END;
/
CREATE TABLE personen
    (p_id                           NUMBER ,
    p_nr                           VARCHAR2(10 BYTE) ,
    p_vorname                      VARCHAR2(50 BYTE),
    p_nachnahme                    VARCHAR2(50 BYTE),
    p_plz                          VARCHAR2(10 BYTE),
    p_ort                          VARCHAR2(20 BYTE),
    p_strasse                      VARCHAR2(30 BYTE),
    p_tel                          VARCHAR2(20 BYTE),
    p_email                        VARCHAR2(50 BYTE),
    p_logname                      VARCHAR2(20 BYTE) NOT NULL,
    p_passwort                     VARCHAR2(20 BYTE) NOT NULL,
    p_typ                          NUMBER NOT NULL,
    p_g_id                         NUMBER,
    p_text                         VARCHAR2(1024 BYTE))
  PCTFREE     10
  INITRANS    1
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
  NOCACHE
  MONITORING
  NOPARALLEL
  LOGGING
;
ALTER TABLE personen
ADD CONSTRAINT p_id_pk PRIMARY KEY (p_id)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
;
ALTER TABLE personen
ADD CONSTRAINT p_logname_uk UNIQUE (p_logname)
USING INDEX
  PCTFREE     10
  INITRANS    2
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
; 
COMMENT ON COLUMN personen.p_g_id IS 'Bezug auf Geodaten'
;
COMMENT ON COLUMN personen.p_logname IS 'Loginname'
;
COMMENT ON COLUMN personen.p_text IS 'optionaler Zusatztext'
;
COMMENT ON COLUMN personen.p_typ IS '1.. normal, 2.. expert, 3.. admin'
;
CREATE OR REPLACE TRIGGER insert_personen_id_and_nr
 BEFORE
  INSERT
 ON personen
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  p_id number;
  p_nr number;
BEGIN
	if (:new.P_Id is null) then
		SELECT gebl_seq.nextval
			INTO p_id
			FROM dual;
		:new.P_Id := p_id;
	end if;
	SELECT gebl_seq_p.nextval
    INTO p_nr
    FROM dual;
	:new.P_nr := 'P-'||to_char(p_nr);
END;
/
CREATE TRIGGER delete_p_g_id
-- when deleting row of typ 1 (adress) from geodaten -> set corresponding id in personen table to NULL 
 BEFORE 
 DELETE
 ON GEODATEN
 FOR EACH ROW 
 WHEN (old.G_TYP = 1)
DECLARE
BEGIN
  UPDATE PERSONEN
  SET P_G_ID = NULL
  WHERE P_G_ID = :old.G_ID;
END;
/
CREATE TRIGGER delete_bpid_fpid_apid
-- when deleting row from personen -> set corresponding ids in other tables to NULL 
 BEFORE 
 DELETE
 ON PERSONEN
 FOR EACH ROW 
DECLARE
BEGIN
  UPDATE BRUTSTAETTEN
  SET B_P_ID = NULL
  WHERE B_P_ID = :old.P_ID;
  UPDATE FALLEN
  SET F_P_ID = NULL
  WHERE F_P_ID = :old.P_ID;
  UPDATE AKTIONEN
  SET A_P_ID = NULL
  WHERE A_P_ID = :old.P_ID;
END;
/
ALTER TABLE aktionen
ADD CONSTRAINT a_typ_fk FOREIGN KEY (a_typ)
REFERENCES aktionstyp (at_nr)
;
ALTER TABLE aktionen
ADD CONSTRAINT a_p_id_fk FOREIGN KEY (a_p_id)
REFERENCES personen (p_id)
;
ALTER TABLE aktionen
ADD CONSTRAINT a_b_id_fk FOREIGN KEY (a_b_id)
REFERENCES brutstaetten (b_id)
ON DELETE CASCADE
;
ALTER TABLE aktionen
ADD CONSTRAINT a_f_id_fk FOREIGN KEY (a_f_id)
REFERENCES fallen (f_id)
ON DELETE CASCADE
;
ALTER TABLE brutstaetten
ADD CONSTRAINT b_g_id_fk FOREIGN KEY (b_g_id)
REFERENCES geodaten (g_id)
ON DELETE CASCADE
;
ALTER TABLE brutstaetten
ADD CONSTRAINT b_p_id_fk FOREIGN KEY (b_p_id)
REFERENCES personen (p_id)
;
ALTER TABLE fallen
ADD CONSTRAINT f_g_id_fk FOREIGN KEY (f_g_id)
REFERENCES geodaten (g_id)
ON DELETE CASCADE
;
ALTER TABLE fallen
ADD CONSTRAINT f_p_id_fk FOREIGN KEY (f_p_id)
REFERENCES personen (p_id)
;
ALTER TABLE personen
ADD CONSTRAINT p_g_id_fk FOREIGN KEY (p_g_id)
REFERENCES geodaten (g_id)
--ON DELETE CASCADE
;