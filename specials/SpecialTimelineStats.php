<?php

class SpecialTimelineStats extends SpecialPage {

	public function __construct() {
		parent::__construct('TimelineStats');
	}
	
	public function execute( $params ) {

		global $wgTimelineStatsWeeks;

		$this->setHeaders();
		$this->outputHeader();
		$out = $this->getOutput();

		$out->addModuleStyles( array('ext.TimelineStats.css') );

		$out->addHtml( '<div class="chart" id="chart-pages-total" ></div>' );
		$out->addHtml( '<div class="chart" id="chart-images-total"></div>' );
		$out->addHtml( '<div class="chart" id="chart-edits-total" ></div>' );
		$out->addHtml( '<div class="chart" id="chart-users-total" ></div>' );
		$out->addHtml( '<div class="chart" id="chart-users-active"></div>' );

		// Need to fetch data now
		
		$timeline = array();
		$usersTotal = array();
		$usersActive = array();
		$pagesTotal = array();
		$imagesTotal = array();
		$editsTotal = array();
		
		$db = wfGetDB(DB_SLAVE);
		$rows = $db->select(
			'timeline_stats', 
			array('TIMESTAMP(dt) AS dtf', 'users', 'active_users', 'good_articles', 'images', 'total_edits'), 
			null, 
			__METHOD__, 
			array( 'ORDER BY' => 'dt DESC', 'LIMIT' => $wgTimelineStatsWeeks ? $wgTimelineStatsWeeks : 12 )
		);

		foreach( $rows as $row ) {
			array_unshift($timeline, $this->getLanguage()->userDate( $row->dtf, $this->getUser() ) );
			array_unshift($usersTotal, $row->users);
			array_unshift($usersActive, $row->active_users);
			array_unshift($pagesTotal, $row->good_articles);
			array_unshift($imagesTotal, $row->images);
			array_unshift($editsTotal, $row->total_edits);
		}

		// Generate javascript with data (weird!)

		$out->addHtml("<script>");
		$out->addHtml( "var TIMELINE = ['" . join("', '", $timeline) . "'];" );
		$out->addHtml( "var USERS_TOTAL = [" . join(", ", $usersTotal) . "];" );
		$out->addHtml( "var USERS_ACTIVE = [" . join(", ", $usersActive) . "];" );
		$out->addHtml( "var PAGES_TOTAL = [" . join(", ", $pagesTotal) . "];" );
		$out->addHtml( "var IMAGES_TOTAL = [" . join(", ", $imagesTotal) . "];" );
		$out->addHtml( "var EDITS_TOTAL = [" . join(", ", $editsTotal) . "];" );
		$out->addHtml('</script>');

		// Append true libraries

		$out->addHtml('<script src="https://code.highcharts.com/highcharts.js"></script>');
		$out->addHtml('<script src="https://code.highcharts.com/modules/exporting.js"></script>');
		$out->addModules('ext.TimelineStats.js');
	}
	
	protected function getGroupName() {
		return 'wiki';
	}
}
