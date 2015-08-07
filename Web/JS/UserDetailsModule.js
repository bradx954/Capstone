//requires byte string functions.
$(document).ready(function () {

    var freespace = $('#UserDetailsFreeSpace').html();
    var usedspace = $('#UserDetailsUsedSpace').html();

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
				{ y: usedspace, indexLabel: "Used Space" },
				{ y: freespace, indexLabel: "Free Space" }
		    ]
		}
	    ]
	});
    chart.render();
});