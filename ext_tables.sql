#
# Table structure for table 'tx_books_domain_model_book'
#
CREATE TABLE tx_books_domain_model_book (
    sku varchar(255) DEFAULT '' NOT NULL,

    price double(11,2) DEFAULT '0.00' NOT NULL,
    tax_class_id int(11) unsigned DEFAULT '1' NOT NULL,
    special_prices int(11) unsigned DEFAULT '0' NOT NULL,

    handle_stock tinyint(4) unsigned DEFAULT '0' NOT NULL,
    stock int(11) unsigned DEFAULT '0' NOT NULL,

    tags int(11) DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_cartbooks_domain_model_specialprice'
#
CREATE TABLE tx_cartbooks_domain_model_specialprice (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    book int(11) unsigned DEFAULT '0' NOT NULL,

    title varchar(255) DEFAULT '' NOT NULL,

    frontend_user_group int(11) unsigned DEFAULT '0' NOT NULL,

    price double(11,2) DEFAULT '0.00' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_cartbooks_domain_model_book_related_mm'
#
CREATE TABLE tx_cartbooks_domain_model_book_related_mm (
    uid_local int(11) DEFAULT '0' NOT NULL,
    uid_foreign int(11) DEFAULT '0' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) DEFAULT '0' NOT NULL,
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_cartbooks_domain_model_book_tag_mm'
#
CREATE TABLE tx_cartbooks_domain_model_book_tag_mm (
    uid_local int(11) DEFAULT '0' NOT NULL,
    uid_foreign int(11) DEFAULT '0' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) DEFAULT '0' NOT NULL,
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Extend table structure of table 'sys_category'
#
CREATE TABLE sys_category (
    cart_book_list_pid int(11) unsigned DEFAULT '0' NOT NULL,
    cart_book_show_pid int(11) unsigned DEFAULT '0' NOT NULL
);
