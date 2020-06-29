import Highcharts from 'highcharts';
import Exporting from 'highcharts/modules/exporting';
import moment from 'moment-timezone';
const $ = jQuery;

export default (firstDate, lastDate) => {

    const eventGraphicPie = () => {

        /**
         * Get values
         */
        var arr_question_pie = [];
        var arr_option_list = [];
        var is_legend = true;
        var title_char = "";
        if (charts) {
        charts.forEach(function (item, index_char, array) {
            if (item['type'] == 'pie') {
            arr_question_pie = item['questions'];
            arr_option_list = item['options_list'];
            title_char = item['title'];

            /**
             * Valid legend
             */
            if (item['legend'] == 'no') {
                is_legend = false;
            } else {
                is_legend = true;
            }

            /**
             * Create pie div
             */
            if ($("#dayli_form_graph_pie_" + index_char).length == 0) {
                var div_char = document.createElement("div");
                /*div_char.id = "dayli_form_graph_pie_" + index_char;
                var text = document.createTextNode("here char pie " + index_char);
                div_char.appendChild(text);*/
                div_char.innerHTML = "<div id='dayli_form_graph_pie_"+index_char+"' style='max-width:800px; min-width: 300px; margin: 0 auto'></div>";
                var element = document.getElementById("result_score_day");
                element.appendChild(div_char);
            }

            /**
             * Get week days
             */
            var arr_categories = [];
            var dateNow = '';
            for (var i = 0; i < 7; i++) {
                dateNow = moment(lastDate, "MM-DD-YYYY").subtract(i, 'd').format('MM-DD-YYYY');
                arr_categories[i] = dateNow;
            }

            /**
             * get value by day of week
             */
            var arr_option_answer = [];
            var suma_date = 0;
            arr_option_answer = [];
            for (const option in arr_option_list) {
                suma_date = 0;
                arr_option_answer[arr_option_list[option]] = [];
                for (const question in arr_question_pie) {
                for (var date in arr_categories.sort()) {
                    date = arr_categories[date];
                    for (const answer in user_responses['responses'][date]) {
                    if (answer == arr_question_pie[question]) {
                        if (user_responses['responses'][date][answer].toString() == option.toString()) {
                        suma_date++; // get count the times they appear
                        }
                    }
                    }
                }
                }
                arr_option_answer[arr_option_list[option]] = suma_date;
            }

            /**
             * Get array text highchart
             */
            var arr_option_text = "";
            var arr_option_series = "";
            var first_color = "#EC6666";
            var second_color = "#147AD6";
            var three_color = "#79D2DE";
            var empty = true;
            var count = 0;
            for (const answer in arr_option_answer) {
                if (count == 0) {
                arr_option_text = arr_option_text + "{name: '" + answer + "', y: " + arr_option_answer[answer] + ", color: '" + first_color + "'},";
                } else if (count == 1) {
                arr_option_text = arr_option_text + "{name: '" + answer + "', y: " + arr_option_answer[answer] + ", color: '" + second_color + "'},";
                } else if (count == 2) {
                arr_option_text = arr_option_text + "{name: '" + answer + "', y: " + arr_option_answer[answer] + ", color: '" + three_color + "'},";
                } else {
                arr_option_text = arr_option_text + "{name: '" + answer + "', y: " + arr_option_answer[answer] + "},";
                }
                if(arr_option_answer[answer] != 0){
                empty = false;
                }
                count++;
            }
            ;
            arr_option_text = "[" + arr_option_text + "]";
            
            if(!empty){
                arr_option_series = [{
                    name: 'Brands',
                    colorByPoint: true,
                    size: '80%',
                    innerSize: '45%',
                    data: eval(arr_option_text)
                }];
            }else{
                arr_option_series = [];
            }

            Highcharts.chart('dayli_form_graph_pie_' + index_char, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: "pie",
                    backgroundColor: "transparent",
                    height:300
                },
                title: {
                    text: '',
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        showInLegend: is_legend,
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        }
                    }
                },
                series: arr_option_series,
                legend: {
                    title:{ 
                        text: title_char,
                        style: {
                            fontSize: '18px',
                            color: '#165A6B',
                            fontWeight: '100'
                        }
                    },
                    align: 'right',
                    layout: 'horizontal',
                    verticalAlign: 'middle',
                },
                credits: {
                    enabled: false
                }
            });
            }
        });
        }
    };

    eventGraphicPie();

}