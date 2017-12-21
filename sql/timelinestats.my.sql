CREATE TABLE /*$wgDBprefix*/timeline_stats (

  -- date of this record
  dt date NOT NULL,
  
  -- theese fields are copy of site_stats table
  total_edits bigint(20) unsigned DEFAULT '0',
  good_articles bigint(20) unsigned DEFAULT '0',
  total_pages bigint(20) DEFAULT '-1',
  users bigint(20) DEFAULT '-1',
  active_users bigint(20) DEFAULT '-1',
  images int(11) DEFAULT '0'
) /*$wgDBTableOptions*/;

ALTER TABLE /*$wgDBprefix*/timeline_stats ADD UNIQUE KEY /*$wgDBprefix*/ix_timeline_stats_1 (dt);