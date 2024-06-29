#
# Table structure for table 'tx_dummyextension_domain_model_modelname'
#
CREATE TABLE tx_dummyextension_domain_model_modelname
(
    strings      varchar(255) DEFAULT '' NOT NULL,
    irreRelation varchar(255) DEFAULT '' NOT NULL,
    sometext     text,
    relations    int(11) DEFAULT '0' NOT NULL,
    checkboxes   tinyint(1) DEFAULT '0' NOT NULL,
    slug         varchar(2048)
);