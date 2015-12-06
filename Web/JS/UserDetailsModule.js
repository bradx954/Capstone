//requires byte string functions.
$(document).ready(function () {
    //Converts data to human readable
    $('#UserDetailsQuota').html(getByteString($('#UserDetailsQuota').html()));
    $('#UserDetailsUsedSpace').html(getByteString($('#UserDetailsUsedSpace').html()));
    $('#UserDetailsFreeSpace').html(getByteString($('#UserDetailsFreeSpace').html()));
	//Adds chart with data.    
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
