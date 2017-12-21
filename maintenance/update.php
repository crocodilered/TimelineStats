<?php

require_once __DIR__ . '/../../../maintenance/Maintenance.php';

class TimelineStatsUpdateMaintenance extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update TimelineStats extension data.";
	}

	public function execute() {
		$db = wfGetDB(DB_SLAVE);
		$row = $db->selectRow(
			'site_stats',
			array('ss_total_pages', 'ss_total_edits', 'ss_good_articles', 'ss_users', 'ss_active_users', 'ss_images'),
			null,
			__METHOD__,
			array('LIMIT' => 1)
		);

		$today = date('Y-m-d');

		$this->output("Updated for ${today}.\n");

		$db->insert('timeline_stats', array(
			'dt' => $today,
			'total_edits' => $row->ss_total_edits,
			'good_articles' => $row->ss_good_articles,
			'total_pages' => $row->ss_total_pages,
			'users' => $row->ss_users,
			'active_users' => $row->ss_active_users,
			'images' => $row->ss_images
		), __METHOD__);
	}

}

$maintClass = "TimelineStatsUpdateMaintenance";
require_once RUN_MAINTENANCE_IF_MAIN;
