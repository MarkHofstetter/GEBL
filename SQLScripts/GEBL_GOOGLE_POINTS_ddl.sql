-- Start of DDL Script for Table GEBL.GOOGLE_POINTS
-- Generated 4-Aug-2010 11:40:45 from GEBL@ORCL

CREATE TABLE google_points
    (g_p_id                         NUMBER ,
    g_p_cat                        VARCHAR2(20 BYTE),
    g_p_name                       VARCHAR2(50 BYTE),
    g_p_lat                        VARCHAR2(50 BYTE),
    g_p_lng                        VARCHAR2(50 BYTE))
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





-- Constraints for GOOGLE_POINTS

ALTER TABLE google_points
ADD CONSTRAINT g_p_pk PRIMARY KEY (g_p_id)
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


-- Triggers for GOOGLE_POINTS

CREATE OR REPLACE TRIGGER google_point_id
 BEFORE
  INSERT
 ON google_points
REFERENCING NEW AS NEW OLD AS OLD
 FOR EACH ROW
begin
:new."G_P_ID" := gebl_seq.nextval;
end;
;


-- End of DDL Script for Table GEBL.GOOGLE_POINTS

