/* Inclusão dos menus na base de dados
 insert into db_itensmenu values (nextval('db_itensmenu_id_item_seq'), 'Alteração (Natal)', 'Alteração de Orcprograma', 'orc1_orcprograma002_ppanatal.php', 1, 1, 'Alteração de Orcprograma', true);
 insert into db_menu values (3188, currval('db_itensmenu_id_item_seq'), 2, 116); 
 */

DROP TABLE plugins.orcprogramaeixo;

DROP TABLE plugins.orcprogramaindicadores;
DROP SEQUENCE plugins.orcprogramaindicadores_sequencial_seq;

DROP TABLE plugins.orcprojativprograma;
DROP SEQUENCE plugins.orcprojativprograma_sequencial_seq;

DROP TABLE plugins.orcprojativlog;
DROP SEQUENCE plugins.orcprojativlog;

DROP TABLE plugins.ppaabrangencia;
DROP SEQUENCE plugins.ppaabrangencia_sequencial_seq;

DROP TABLE plugins.orcprojativabrangencia;
DROP SEQUENCE plugins.orcprojativabrangencia_sequencial_seq;

DROP TABLE plugins.ppafontesrecurso;
DROP SEQUENCE plugins.ppafontesrecurso_sequencial_seq;

DROP TABLE plugins.orcprojativdetalhamentorecursos;
DROP SEQUENCE plugins.orcprojativdetalhamentorecursos_sequencial_seq;

DROP TABLE plugins.orcprojativmetas;
DROP SEQUENCE plugins.orcprojativmetas_sequencial_seq;

DROP TABLE plugins.orcprojativorcunidade;
DROP SEQUENCE plugins.orcprojativorcunidade_sequencial_seq;

DROP TABLE plugins.orcprojativdescricao;

