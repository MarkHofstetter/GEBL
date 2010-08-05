-- table creation
CREATE TABLE punkte
    (p_id                           NUMBER ,
    p_nr                           NUMBER,
    p_name                         VARCHAR2(50 BYTE),
    p_typ                          NUMBER,
    p_groesse                      NUMBER,
    p_gewaesser_art                VARCHAR2(50 BYTE),
    p_zugang                       VARCHAR2(100 BYTE),
    p_g_id                         NUMBER,
    p_m_id                         NUMBER,
    p_bek_art                      VARCHAR2(50 BYTE))
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
ALTER TABLE punkte
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
COMMENT ON COLUMN punkte.p_bek_art IS 'Bekämpfungsart'
;
COMMENT ON COLUMN punkte.p_g_id IS 'Bezug zu Länge/Breite'
;
COMMENT ON COLUMN punkte.p_gewaesser_art IS 'Klassifizierung der Fundstelle'
;
COMMENT ON COLUMN punkte.p_groesse IS 'Ausdehnung der Fundstelle'
;
COMMENT ON COLUMN punkte.p_m_id IS 'Bezug auf Mitarbeiter'
;
COMMENT ON COLUMN punkte.p_typ IS 'Brutstätte, Falle,Adresse.Auslagern,Sonstige. Vorläufig fix !!!'
;
COMMENT ON COLUMN punkte.p_zugang IS 'Zugaenglichkeit;leicht,mittel,schwer'
;
CREATE TABLE kommentar
    (k_id                           NUMBER ,
    k_nr                           NUMBER NOT NULL,
    k_typ                          NUMBER,
    k_betreff                      VARCHAR2(25 BYTE),
    k_datum                        DATE,
    k_m_id                         NUMBER,
    k_p_id                         NUMBER,
    k_text                         VARCHAR2(250 BYTE) NOT NULL)
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
ALTER TABLE kommentar
ADD CONSTRAINT k_id_pk PRIMARY KEY (k_id)
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
COMMENT ON TABLE kommentar IS 'Enthält Kommentare zu Fundstellen bzw. anderen Punkten
Kann einem Mitarbeiter und einer Fundstelle zugeordnet werden'
;
COMMENT ON COLUMN kommentar.k_betreff IS 'Kurztitel'
;
COMMENT ON COLUMN kommentar.k_datum IS 'Timestamp'
;
COMMENT ON COLUMN kommentar.k_m_id IS 'FK zum Author'
;
COMMENT ON COLUMN kommentar.k_p_id IS 'FK zum Punkt'
;
COMMENT ON COLUMN kommentar.k_text IS 'Langtext'
;
COMMENT ON COLUMN kommentar.k_typ IS 'Art des Texts'
;
CREATE TABLE mitarbeiter
    (m_id                           NUMBER ,
    m_nr                           NUMBER NOT NULL,
    m_vorname                      VARCHAR2(50 BYTE),
    m_nachnahme                    VARCHAR2(50 BYTE),
    m_plz                          VARCHAR2(10 BYTE),
    m_ort                          VARCHAR2(20 BYTE),
    m_strasse                      VARCHAR2(30 BYTE),
    m_tel                          NUMBER,
    m_logname                      VARCHAR2(20 BYTE) NOT NULL,
    m_passwort                     VARCHAR2(20 BYTE) NOT NULL,
    m_typ                          NUMBER NOT NULL,
    m_g_id                         NUMBER,
    m_email                        VARCHAR2(50 BYTE))
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
ALTER TABLE mitarbeiter
ADD CONSTRAINT m_id_pk PRIMARY KEY (m_id)
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
ALTER TABLE mitarbeiter
ADD CONSTRAINT m_logname_uk UNIQUE (m_logname)
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
COMMENT ON COLUMN mitarbeiter.m_g_id IS 'Referenz auf Punkt'
;
COMMENT ON COLUMN mitarbeiter.m_logname IS 'Loginname'
;
COMMENT ON COLUMN mitarbeiter.m_typ IS 'normal, expert, admin'
;
CREATE TABLE punkt_typ
    (p_t_id                         NUMBER ,
    p_t_name                       VARCHAR2(50 BYTE))
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
ALTER TABLE punkt_typ
ADD CONSTRAINT p_t_id_pk PRIMARY KEY (p_t_id)
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
ALTER TABLE punkt_typ
ADD CONSTRAINT p_t_name_uk UNIQUE (p_t_name)
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
CREATE TABLE geodaten
    (g_id                           NUMBER ,
    g_lat                          VARCHAR2(25 BYTE),
    g_lon                          VARCHAR2(25 BYTE))
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
-- Foreign Keys
ALTER TABLE punkte
ADD CONSTRAINT p_typ_fk FOREIGN KEY (p_typ)
REFERENCES punkt_typ (p_t_id)
;
ALTER TABLE punkte
ADD CONSTRAINT p_m_id_fk FOREIGN KEY (p_m_id)
REFERENCES mitarbeiter (m_id)
;
ALTER TABLE punkte
ADD CONSTRAINT p_g_id_fk FOREIGN KEY (p_g_id)
REFERENCES geodaten (g_id)
;
ALTER TABLE kommentar
ADD CONSTRAINT k_m_id_fk FOREIGN KEY (k_m_id)
REFERENCES mitarbeiter (m_id)
;
ALTER TABLE kommentar
ADD CONSTRAINT k_p_id_fk FOREIGN KEY (k_p_id)
REFERENCES punkte (p_id)
;
ALTER TABLE mitarbeiter
ADD CONSTRAINT m_g_id_fk FOREIGN KEY (m_g_id)
REFERENCES geodaten (g_id)
;