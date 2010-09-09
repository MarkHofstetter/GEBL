-- change from number to charakter
alter table fallen modify ( f_typ varchar2(100));
-- extend trigger for geodaten, create default names also for fallen and adressen
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
		:new.G_Name := 'Brutstaette '||to_char(b_nr);
	end if;
	if (:new.G_Name is null AND :new.G_Typ = 2) then
		SELECT gebl_seq_b_name.nextval
			INTO b_nr
			FROM dual;
		:new.G_Name := 'Falle '||to_char(b_nr);
	end if;
	if (:new.G_Name is null AND :new.G_Typ = 1) then
		SELECT gebl_seq_b_name.nextval
			INTO b_nr
			FROM dual;
		:new.G_Name := 'Adresse '||to_char(b_nr);
	end if;
END;
/
-- extend trigger for person, remove point (typ 1, adress) when removing corresponding person
CREATE OR REPLACE TRIGGER delete_bpid_fpid_apid
-- when deleting row from personen -> set corresponding ids in other tables to NULL and set g_name to unused
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
  UPDATE GEODATEN
  SET G_NAME = 'unused'
  WHERE G_ID = :old.P_G_ID;
END;
/
alter table personen rename column p_nachnahme to p_nachname;
alter table personen modify ( p_strasse varchar2(50));