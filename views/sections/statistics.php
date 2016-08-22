<div class="row">
	<div class="col-sm-2">
		<div class="btn-group-vertical">
			<div class="btn-group btn-group-lg" data-type="asterisk">
				<button type="button" class="btn btn-default dropdown-toggle btn-stats" data-toggle="dropdown">
					Asterisk <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#" class="graph-button" data-period="hour"><?php echo _("Hour")?></a></li>
					<li><a href="#" class="graph-button" data-period="day"><?php echo _("Day")?></a></li>
					<li><a href="#" class="graph-button" data-period="week"><?php echo _("Week")?></a></li>
					<li><a href="#" class="graph-button" data-period="month"><?php echo _("Month")?></a></li>
				</ul>
			</div>
			<div class="btn-group btn-group-lg" data-type="uptime">
				<button type="button" class="btn btn-default dropdown-toggle btn-stats" data-toggle="dropdown">
					<?php echo _("Uptime")?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#" class="graph-button" data-period="hour"><?php echo _("Hour")?></a></li>
					<li><a href="#" class="graph-button" data-period="day"><?php echo _("Day")?></a></li>
					<li><a href="#" class="graph-button" data-period="week"><?php echo _("Week")?></a></li>
					<li><a href="#" class="graph-button" data-period="month"><?php echo _("Month")?></a></li>
				</ul>
			</div>
			<div class="btn-group btn-group-lg" data-type="cpuusage">
				<button type="button" class="btn btn-default dropdown-toggle btn-stats" data-toggle="dropdown">
					CPU <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#" class="graph-button" data-period="hour"><?php echo _("Hour")?></a></li>
					<li><a href="#" class="graph-button" data-period="day"><?php echo _("Day")?></a></li>
					<li><a href="#" class="graph-button" data-period="week"><?php echo _("Week")?></a></li>
					<li><a href="#" class="graph-button" data-period="month"><?php echo _("Month")?></a></li>
				</ul>
			</div>
			<div class="btn-group btn-group-lg" data-type="memusage">
				<button type="button" class="btn btn-default dropdown-toggle btn-stats" data-toggle="dropdown">
					<?php echo _("Memory")?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#" class="graph-button" data-period="hour"><?php echo _("Hour")?></a></li>
					<li><a href="#" class="graph-button" data-period="day"><?php echo _("Day")?></a></li>
					<li><a href="#" class="graph-button" data-period="week"><?php echo _("Week")?></a></li>
					<li><a href="#" class="graph-button" data-period="month"><?php echo _("Month")?></a></li>
				</ul>
			</div>
			<div class="btn-group btn-group-lg" data-type="diskusage">
				<button type="button" class="btn btn-default dropdown-toggle btn-stats" data-toggle="dropdown">
					<?php echo _("Disk")?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#" class="graph-button" data-period="hour"><?php echo _("Hour")?></a></li>
					<li><a href="#" class="graph-button" data-period="day"><?php echo _("Day")?></a></li>
					<li><a href="#" class="graph-button" data-period="week"><?php echo _("Week")?></a></li>
					<li><a href="#" class="graph-button" data-period="month"><?php echo _("Month")?></a></li>
				</ul>
			</div>
			<div class="btn-group btn-group-lg" data-type="networking">
				<button type="button" class="btn btn-default dropdown-toggle btn-stats" data-toggle="dropdown">
					<?php echo _("Network")?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#" class="graph-button" data-period="hour"><?php echo _("Hour")?></a></li>
					<li><a href="#" class="graph-button" data-period="day"><?php echo _("Day")?></a></li>
					<li><a href="#" class="graph-button" data-period="week"><?php echo _("Week")?></a></li>
					<li><a href="#" class="graph-button" data-period="month"><?php echo _("Month")?></a></li>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
		$(".graph-button").click(function(event) {
			event.preventDefault();
			var target = $(this);
			Dashboard.sysstatAjax.period = target.data("period");
			Dashboard.sysstatAjax.target = target.parents(".btn-group").data("type")
			window.observers["builtin_aststat"]();
		})
		</script>
		<style>
		#page_Main_Statistics_statistics .btn-group {
			width: 90px;
		}
		</style>
	</div>
	<div id="builtin_aststat" class="col-sm-10" style="height: 200px">
		<canvas id="dashboardchart"></canvas>
	</div>
</div>
<script type="text/javascript">

function generateTitle(i, d) {
	var myindex = i[0].index;
	if (typeof d.datasets[0].timestamps === "undefined" || typeof d.datasets[0].timestamps[myindex] === "undefined") {
		return '';
	}
	// convert that timestamp to local time
	var localdate = new Date(0);
	localdate.setUTCSeconds(d.datasets[0].timestamps[myindex]);
	return localdate;

}

	// This is our default view
	Dashboard.sysstatAjax = {
		command: 'sysstat',
		target: 'uptime',
		period: 'hour',
		module: 'dashboard'
	};

	window.currentchart = false;

	window.observers['builtin_aststat'] = function() {
		if (typeof window.currentchart !== "boolean") {
			window.currentchart.destroy();
		}
		// console.log('Running', Dashboard.sysstatAjax);
		$.ajax({
			url: window.ajaxurl,
			data: Dashboard.sysstatAjax,
			success: function(data) {
				$('#page_Main_Statistics_uptime .shadow').fadeOut('fast');
				data.options.tooltips = { callbacks: { title: function(x,y) { return generateTitle(x, y); } }}; 
				console.log("Data", data);
				window.currentchart = new Chart($("#dashboardchart"), data);
			},
		});
	};
	Dashboard.sysstatAjax = {command: "sysstat", target: "asterisk", period: "Hour", module: "dashboard"};
	// window.observers["builtin_aststat"]();
</script>
