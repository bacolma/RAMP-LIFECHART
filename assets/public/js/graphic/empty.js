import Highcharts from 'highcharts';
import moment from 'moment-timezone';
const $ = jQuery;

export default (firstDate, lastDate) => {

    const eventGraphicEmpty = () => {

        if(charts.length == 0){
            console.log('this empty');
            var div_char = document.createElement("div");
            div_char.id = "dayli_form_graph_column_empty";
            var text = document.createTextNode("here char pie empty");
            div_char.appendChild(text);
            var element = document.getElementById("result_score_day");
            element.appendChild(div_char);


            /**
             * Get week days, star first week Monday
             */
            var arr_categories = [];
            var arr_categories_char = [];
            var dateNow = '';
            var dateNowChar = '';
            for (var i = 0; i < 7; i++) {
            dateNow = moment(firstDate, "MM-DD-YYYY").add(i, 'd').format('MM-DD-YYYY');
            arr_categories[i] = dateNow;
            dateNowChar = moment(firstDate, "MM-DD-YYYY").add(i, 'd').format('dddd');
            arr_categories_char[i] = '';
            }
            

            Highcharts.chart('dayli_form_graph_column_empty', {
            chart: {
                type: 'column',
                backgroundColor: "transparent" 
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: arr_categories_char,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'score'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    showInLegend: false,
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Score',
                data: [0, 0, 0, 0, 0, 0, 0]

            }],
            credits: {
                enabled: false
            },
            });
        }
    }

    eventGraphicEmpty();
}