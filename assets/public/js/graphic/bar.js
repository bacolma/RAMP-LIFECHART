import Highcharts from 'highcharts';
import Exporting from 'highcharts/modules/exporting';
import moment from 'moment-timezone';
const $ = jQuery;

export default (firstDate, lastDate) => {

    const eventGraphicColumn = () => {
        /**
         * Get values
         */
        var arr_question_bar = [];
        var arr_option_list = [];
        var is_legend = true;
        var title_char = "";
        if (charts) {
            charts.forEach(function (item, index_char, array) {
            if (item['type'] == 'bars') {
                arr_question_bar = item['questions'];
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
                if ($("#dayli_form_graph_column_" + index_char).length == 0) {
                    var div_char = document.createElement("div");
                    /*div_char.id = "dayli_form_graph_column_" + index_char;
                    var text = document.createTextNode("here char bar " + index_char);
                    div_char.appendChild(text);*/
                    div_char.innerHTML = "<div id='dayli_form_graph_column_" + index_char + "' style='max-width:800px; min-width: 300px; margin: 0 auto'></div>";
                    var element = document.getElementById("result_score_day");
                    element.appendChild(div_char);
                }

                /**
                 * Get week days, star first week Monday
                 */
                var arr_categories = [];
                var dateNow = '';
                var first = moment(firstDate);
                var second = moment(lastDate);
                var between_days = second.diff(first, 'days');
                for (var i = 0; i < between_days; i++) {
                    dateNow = moment(firstDate, "MM-DD-YYYY").add(i, 'd').format('MM-DD-YYYY');
                    arr_categories[i] = dateNow;
                }

                /**
                 * get value by day of week
                 */
                var arr_option_answer = [];
                var suma_date = 0;
                var count_semana = 0;
                arr_option_answer = [];
                var highest = 0; // max value
                var lowest = 0; // min value
                var latest  = 0; // last value answer

                if(arr_option_list.length == 0){
                    arr_option_list[0] = 'bar';
                }

                for (const option in arr_option_list) {
                    arr_option_answer[arr_option_list[option]] = [];
                    suma_date = 0;
                    count_semana = 0;
                    for (var date in arr_categories.sort()) {
                        suma_date = 0;
                        date = arr_categories[date];
                        for (const question in arr_question_bar) {
                            for (const answer in user_responses['responses'][date]) {
                                if (answer == arr_question_bar[question]) {
                                    if(arr_option_list[option] == 'bar'){
                                        suma_date = user_responses['responses'][date][answer].length;
                                    }else{
                                        if (user_responses['responses'][date][answer].toString() == option.toString()) {
                                            suma_date++; // get count the times they appear
                                        }
                                    }
                                }
                            }
                        }
                        arr_option_answer[arr_option_list[option]][count_semana] = suma_date;

                        // get highest
                        if(count_semana == 0){
                            highest = suma_date;
                        }else{
                            if(suma_date > highest){
                            highest = suma_date;
                            }
                        }
                        
                        // get lowest
                        if(count_semana == 0){
                            lowest = suma_date;
                        }else{
                            if(suma_date < lowest){
                            lowest = suma_date;
                            }
                        }

                        // get latest
                        if(suma_date != 0){
                            latest = suma_date;
                        }
                        
                        count_semana++;
                    }
                }

                /**
                 * Print result of highest, lowest and latest
                 */
                $('.highest').html(highest);
                $('.lowest').html(lowest);
                $('.latest').html(latest);

                /**
                 * Get array text highchart
                 */
                var arr_option_text = "";
                var first_color = "#44B4B8";
                var second_color = "#147AD6";
                var three_color = "#33939B";
                var count = 0;
                for (const answer in arr_option_answer) {
                if (count == 0) {
                    arr_option_text = arr_option_text + "{name: '" + answer + "', data: [" + arr_option_answer[answer] + "], color: '" + first_color + "'},";
                } else if (count == 1) {
                    arr_option_text = arr_option_text + "{name: '" + answer + "', data: [" + arr_option_answer[answer] + "], color: '" + second_color + "'},";
                } else if (count == 2) {
                    arr_option_text = arr_option_text + "{name: '" + answer + "', data: [" + arr_option_answer[answer] + "], color: '" + three_color + "'},";
                } else {
                    arr_option_text = arr_option_text + "{name: '" + answer + "', data: [" + arr_option_answer[answer] + "]},";
                }
                count++;
                }
                ;
                arr_option_text = "[" + arr_option_text + "]";

                Highcharts.chart('dayli_form_graph_column_' + index_char, {
                chart: {
                    type: 'column',
                    backgroundColor: "transparent",
                    height:400
                },
                title: {
                    text: title_char
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: arr_categories,
                    crosshair: true,
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
                        showInLegend: is_legend,
                        pointPadding: 0.1,
                        borderWidth: 0,
                        borderRadius: 5
                    }
                },
                series: eval(arr_option_text),
                credits: {
                    enabled: false
                },
                });
            }
            });
        }
    };

    eventGraphicColumn();
}