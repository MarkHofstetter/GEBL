-- sequences
-- sequence fuer tabellen ids
CREATE SEQUENCE gebl_seq
  INCREMENT BY 1
  START WITH 355
  MINVALUE 1
  MAXVALUE 999999999999999999999999999
  NOCYCLE
  NOORDER
  CACHE 20
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
 --triggers
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
  SELECT gebl_seq.nextval
    INTO b_id
    FROM dual;
  :new.B_Id := b_id;
  SELECT gebl_seq_b.nextval
   INTO b_nr
    FROM dual;
  :new.B_nr := 'B-'||to_char(b_nr);
END;
/
--CREATE OR REPLACE TRIGGER insert_fallen_id_and_nr
-- BEFORE
--  INSERT
-- ON fallen
--REFERENCING NEW AS NEW OLD AS OLD
-- FOR EACH ROW
--DECLARE
--  f_id number;
--  f_nr number;
--BEGIN
--  SELECT gebl_seq.nextval
--    INTO f_id
--    FROM dual;
--  :new.F_Id := f_id;
--  SELECT gebl_seq_f.nextval
--    INTO f_nr
--    FROM dual;
--  :new.F_nr := f_nr;
--END;
--/
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
  SELECT gebl_seq.nextval
    INTO a_id
    FROM dual;
  :new.A_Id := a_id;
  SELECT gebl_seq_a.nextval
    INTO a_nr
    FROM dual;
  :new.A_nr := 'A-'||to_char(a_nr);
END;
/
CREATE OR REPLACE TRIGGER insert_geodaten_id
 BEFORE
  INSERT
 ON geodaten
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  g_id number;
BEGIN
  SELECT gebl_seq.nextval
    INTO g_id
    FROM dual;
  :new.G_Id := g_id;
END;
/
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
  SELECT gebl_seq.nextval
    INTO p_id
    FROM dual;
  :new.P_Id := p_id;
  SELECT gebl_seq_p.nextval
    INTO p_nr
    FROM dual;
  :new.P_nr := 'P-'||to_char(p_nr);
END;
/