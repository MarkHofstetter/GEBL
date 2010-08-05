-- sequences
CREATE SEQUENCE gebl_seq
  INCREMENT BY 1
  START WITH 355
  MINVALUE 1
  MAXVALUE 999999999999999999999999999
  NOCYCLE
  NOORDER
  CACHE 20
;
CREATE SEQUENCE gebl_seq_p
  INCREMENT BY 1
  START WITH 7
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
CREATE SEQUENCE gebl_seq_k
  INCREMENT BY 1
  START WITH 1
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
CREATE SEQUENCE gebl_seq_m
  INCREMENT BY 1
  START WITH 23
  MINVALUE 1
  MAXVALUE 9999999999999999999
  NOCYCLE
  NOORDER
  NOCACHE
;
-- triggers
CREATE OR REPLACE TRIGGER insert_punkt_id_and_nr
 BEFORE
  INSERT
 ON punkte
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
  :new.P_nr := p_nr;
END;
/
CREATE OR REPLACE TRIGGER insert_kommentar_id_and_nr
 BEFORE
  INSERT
 ON kommentar
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  k_id number;
  k_nr number;
BEGIN
  SELECT gebl_seq.nextval
    INTO k_id
    FROM dual;
  :new.K_Id := k_id;
  SELECT gebl_seq_k.nextval
    INTO k_nr
    FROM dual;
  :new.K_nr := k_nr;
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
CREATE OR REPLACE TRIGGER insert_mitarbeiter_id_and_nr
 BEFORE
  INSERT
 ON mitarbeiter
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
DECLARE
  m_id number;
  m_nr number;
BEGIN
  SELECT gebl_seq.nextval
    INTO m_id
    FROM dual;
  :new.M_Id := m_id;
  SELECT gebl_seq_m.nextval
    INTO m_nr
    FROM dual;
  :new.M_nr := m_nr;
END;
/