-- delete data from tables
delete from aktionen;
delete from brutstaetten;
delete from fallen;
delete from personen;
delete from geodaten;
-- drop and recreate sequences
DROP SEQUENCE gebl_seq;
DROP SEQUENCE gebl_seq_p;
DROP SEQUENCE gebl_seq_b;
DROP SEQUENCE gebl_seq_f;
DROP SEQUENCE gebl_seq_a;
CREATE SEQUENCE gebl_seq
  INCREMENT BY 1
  START WITH 999
  MINVALUE 999
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
