<?= $this->extend($layout) ?>
<?= $this->section('main') ;?>
<div class="row">
	<!-- Card Example -->
	<?php foreach($Resume as $C){ ?>
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-<?=$C['class']?> shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-<?=$C['class']?> text-uppercase mb-1">
							<?=$C['title']?>
						</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?=$C['rdata']?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-<?=$C['icon']?> fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<div class="row">
	<!-- Area Chart -->
	<div class="col-xl-8 col-lg-7">
		<div class="card shadow mb-4">
			<!-- Card Header - Dropdown -->
			<div
				class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
						aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Dropdown Header:</div>
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<div class="chart-area">
					<canvas id="myAreaChart"></canvas>
				</div>
			</div>
		</div>
	</div>

	<!-- Pie Chart -->
	<div class="col-xl-4 col-lg-5">
		<div class="card shadow mb-4">
			<!-- Card Header - Dropdown -->
			<div
				class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
						aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Dropdown Header:</div>
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<div class="chart-pie pt-4 pb-2">
					<canvas id="myPieChart"></canvas>
				</div>
				<div class="mt-4 text-center small">
					<span class="mr-2">
						<i class="fas fa-circle text-primary"></i> Direct
					</span>
					<span class="mr-2">
						<i class="fas fa-circle text-success"></i> Social
					</span>
					<span class="mr-2">
						<i class="fas fa-circle text-info"></i> Referral
					</span>
				</div>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection() ?>

<?php $this->section('pageScripts'); ?>
<script src="<?=base_url('themes/sbadmin2/vendor/chart.js/Chart.min.js')?>"></script>
<script> 
	Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	Chart.defaults.global.defaultFontColor = '#858796';
	$(document).ready(function() {
		// Bar Chart Example
		var ctx = document.getElementById("myAreaChart");
		var myBarChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["January", "February", "March", "April", "May", "June"],
			datasets: [{
			label: "Revenue",
			backgroundColor: "#4e73df",
			hoverBackgroundColor: "#2e59d9",
			borderColor: "#4e73df",
			data: [4215, 5312, 6251, 7841, 9821, 14984],
			}],
		},
		options: {
			maintainAspectRatio: false,
			layout: {
			padding: {
				left: 10,
				right: 25,
				top: 25,
				bottom: 0
			}
			},
			scales: {
			xAxes: [{
				time: {
				unit: 'month'
				},
				gridLines: {
				display: false,
				drawBorder: false
				},
				ticks: {
				maxTicksLimit: 6
				},
				maxBarThickness: 25,
			}],
			yAxes: [{
				ticks: {
				min: 0,
				max: 15000,
				maxTicksLimit: 5,
				padding: 10,
				// Include a dollar sign in the ticks
				callback: function(value, index, values) {
					return '$' + number_format(value);
				}
				},
				gridLines: {
				color: "rgb(234, 236, 244)",
				zeroLineColor: "rgb(234, 236, 244)",
				drawBorder: false,
				borderDash: [2],
				zeroLineBorderDash: [2]
				}
			}],
			},
			legend: {
			display: false
			},
			tooltips: {
			titleMarginBottom: 10,
			titleFontColor: '#6e707e',
			titleFontSize: 14,
			backgroundColor: "rgb(255,255,255)",
			bodyFontColor: "#858796",
			borderColor: '#dddfeb',
			borderWidth: 1,
			xPadding: 15,
			yPadding: 15,
			displayColors: false,
			caretPadding: 10,
			callbacks: {
				label: function(tooltipItem, chart) {
				var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
				return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
				}
			}
			},
		}
		});

		
	});	
	function number_format(number, decimals, dec_point, thousands_sep) {
		// *     example: number_format(1234.56, 2, ',', ' ');
		// *     return: '1 234,56'
		number = (number + '').replace(',', '').replace(' ', '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function(n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}		
</script>
<?php
	$this->endSection();
?>

<script type="text/javascript">
    window.onload = function() {
        new Audio('Into the Wild - Red to Black.mp3').play();
    };
</script>