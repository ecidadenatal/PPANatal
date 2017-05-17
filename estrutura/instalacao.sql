/* Inclusão dos menus na base de dados
 insert into db_itensmenu values (nextval('db_itensmenu_id_item_seq'), 'Alteração (Natal)', 'Alteração de Orcprograma', 'orc1_orcprograma002_ppanatal.php', 1, 1, 'Alteração de Orcprograma', true);
 insert into db_menu values (3188, currval('db_itensmenu_id_item_seq'), 2, 116); 
 */

CREATE TABLE plugins.orcprogramaeixo (anousu integer, orcprograma integer, eixo text, PRIMARY KEY (anousu,orcprograma));

CREATE TABLE plugins.orcprogramaindicadores (sequencial integer, orcindicaprograma integer, usuario integer, departamento integer, acao varchar(1), data date, PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.orcprogramaindicadores_sequencial_seq;

CREATE TABLE plugins.orcprojativprograma (sequencial integer, anousu integer, orcprojativ integer, orcprograma integer, PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.orcprojativprograma_sequencial_seq;

CREATE TABLE plugins.orcprojativlog (sequencial integer, anousu integer, orcprojativ integer, usuario integer, departamento integer, data date, acao varchar(1), PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.orcprojativlog_sequencial_seq;

CREATE TABLE plugins.ppaabrangencia (sequencial integer, descricao varchar(50), PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.ppaabrangencia_sequencial_seq;
CREATE UNIQUE INDEX ppaabrangencia_abrangencia_unique_in on plugins.ppaabrangencia(descricao);

CREATE TABLE plugins.orcprojativabrangencia (sequencial integer, anousu integer, orcprojativ integer, ppaabrangencia integer, PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.orcprojativabrangencia_sequencial_seq;

CREATE TABLE plugins.ppafontesrecurso (sequencial integer, descricao varchar(50), PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.ppafontesrecurso_sequencial_seq;

CREATE TABLE plugins.orcprojativdetalhamentorecursos (sequencial integer, anousu integer, orcprojativ integer, ppafonterecurso integer, valor numeric(15,2), PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.orcprojativdetalhamentorecursos_sequencial_seq;
CREATE UNIQUE INDEX orcprojativdetalhamentorecursos_orcprojativ_anousu_ppafonterecurso_in on plugins.orcprojativdetalhamentorecursos(orcprojativ,anousu,ppafonterecurso);

CREATE TABLE plugins.orcprojativmetas (sequencial integer, anousu integer, orcprojativ integer, meta text, unidademedida text, usuario integer, departamento integer, data date, PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.orcprojativmetas_sequencial_seq;

CREATE TABLE plugins.orcprojativorcunidade (sequencial integer, anousu integer, orcprojativ integer, orcorgao integer, orcunidade integer, PRIMARY KEY (sequencial));
CREATE SEQUENCE plugins.orcprojativorcunidade_sequencial_seq;

CREATE TABLE plugins.orcprojativdescricao (anousu integer, orcprojativ integer, descricao varchar(250), PRIMARY KEY (anousu,orcprojativ));

CREATE TABLE plugins.orcprojativorigem (anousu integer, orcprojativ integer, origem varchar(100), PRIMARY KEY (anousu,orcprojativ));

CREATE TABLE plugins.orcindicadados (sequencial integer, orcindica integer, anousu integer, dataapuracao date);
CREATE SEQUENCE plugins.orcindicadados_sequencial_seq;