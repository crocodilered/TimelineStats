'use strict';

$(function () {

	Highcharts.wrap(Highcharts.Chart.prototype, 'getContainer', function (proceed) {
		proceed.call(this);
		this.container.style.background = 'url(http://www.highcharts.com/samples/graphics/sand.png)';
	});

	Highcharts.theme = {
		colors: ['#f45b5b', '#8085e9', '#8d4654', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
		chart: { backgroundColor: null, style: { fontFamily: 'b52' } },
		title: { style: { color: 'black', fontSize: '18px' } },
		background2: '#E0E0E8'
	};

	Highcharts.setOptions(Highcharts.theme);

	var plotChart = function(container, title, x, y) {
		Highcharts.chart(container, {
			chart: { type: 'spline' },
			title: { text: title, y: 24 },
			subtitle: { enabled: false },
			xAxis: { categories: x },
			yAxis: {
				title: { enabled: false },
				plotLines: [{ value:0, width:1, color:'#808080' }]
		  	},
			tooltip: { valueSuffix: '', pointFormat: '<b>{point.y}</b>' },
		 	legend: { enabled: false },
		 	series: [{data: y}]
		});
	};

	plotChart( 'chart-users-total', mw.message('timelinestats-users-total').text(), TIMELINE, USERS_TOTAL );
	plotChart( 'chart-users-active', mw.message('timelinestats-users-active').text(), TIMELINE, USERS_ACTIVE );
	plotChart( 'chart-pages-total', mw.message('timelinestats-pages-total').text(), TIMELINE, PAGES_TOTAL );
	plotChart( 'chart-images-total', mw.message('timelinestats-images-total').text(), TIMELINE, IMAGES_TOTAL );
	plotChart( 'chart-edits-total', mw.message('timelinestats-edits-total').text(), TIMELINE, EDITS_TOTAL );

});
