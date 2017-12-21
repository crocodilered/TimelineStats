<?php

class TimelineStatsHooks {

	// Do database update for install
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		$updater->addExtensionUpdate( array( array( __CLASS__, 'runSchemaUpdates' ) ) );
		return true;
	}

	public static function runSchemaUpdates( $updater ) {
		$db = $updater->getDB();
		if( $db->tableExists( 'timeline_stats' ) ) {
			$updater->output( "...timeline_stats table already exists.\n" );
		} else {
			$updater->output( "Creating timeline_stats table..." );
			$sourcefile = $db->getType() == 'postgres' ? '/sql/timelinestats.pg.sql' : '/sql/timelinestats.my.sql';
			$err = $db->sourceFile( dirname( __FILE__ ) . $sourcefile );
			if( $err !== true ) throw new Exception( $err );
			$updater->output( "ok.\n" );

			// Put current stats data to created database table
			$task = $updater->maintenance->runChild('TimelineStatsUpdateMaintenance');
			$task->execute();
		}
	}

}
