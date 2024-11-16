$(document).ready(function () {
    function updatePlot(data) {
        var graph = JSON.parse(data.graph);
        Plotly.newPlot('plot', graph.data, graph.layout);
    }

    $('#range-button').click(function () {
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        $.ajax({
            url: '/get_plot',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ start_date: startDate, end_date: endDate, action: "range" }),
            success: updatePlot
        });
    });

    $('#predict-button').click(function () {
        $.ajax({
            url: '/get_plot',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: "predict" }),
            success: updatePlot
        });
    });
});
