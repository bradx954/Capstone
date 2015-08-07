//requires byte string functions.
$(document).ready(function () {
    $('#UserDetailsQuota').html(getByteString($('#UserDetailsQuota').html()));
    $('#UserDetailsUsedSpace').html(getByteString($('#UserDetailsUsedSpace').html()));
    $('#UserDetailsFreeSpace').html(getByteString($('#UserDetailsFreeSpace').html()));
    var chart = new CanvasJS.Chart("UserDetailsChart",
	{
	    title: {
	        text: "Storage Chart"
	    },
	    legend: {
	        maxWidth: 350,
	        itemWidth: 120
	    },
	    data: [
		{
		    type: "pie",
		    showInLegend: true,
		    legendText: "{indexLabel}",
		    dataPoints: [
				{ y: 4181563, indexLabel: "Used Space" },
				{ y: 2175498, indexLabel: "Free Space" }
		    ]
		}
	    ]
	});
    chart.render();
});