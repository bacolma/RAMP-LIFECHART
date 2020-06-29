import Highcharts from 'highcharts';
import Exporting from 'highcharts/modules/exporting';
import moment from 'moment-timezone';

const $ = jQuery;

export default (firstDate, lastDate) => {

  const eventGraphicLine = () => {

    /**
     * Get values
     * check if the options are numeric to show a single option,
     * if it is not numeric it shows all the options
     */
    var arr_question_line = [];
    var arr_option_list = [];
    var is_lineal_number = false;
    var is_legend = true;
    var title_char = "";
    if (charts) {
      charts.forEach(function (item, index_char, array) {
        if (item['type'] == 'line') {
          arr_question_line = item['questions'];
          arr_option_list = item['options_list'];
          is_lineal_number = false;
          title_char = item['title'];
          for (const option in arr_option_list) {
            if (parseInt(arr_option_list[option]) > 0) {
              is_lineal_number = true;
              break;
            }
          }

          /**
           * Valid legend
           */
          if (item['legend'] == 'no') {
            is_legend = false;
          } else {
            is_legend = true;
          }

          /**
           * Valid only or all options
           */
          if (is_lineal_number || arr_option_list.length == 0) {
            arr_option_list = [];
            arr_option_list[0] = 'line';//add only option in char
          }

          /**
           * Create pie div
           */
          if ($("#dayli_form_graph_line_" + index_char).length == 0) {
            var div_char = document.createElement("div");
            /*div_char.id = "dayli_form_graph_line_" + index_char;
            var text = document.createTextNode("here char line " + index_char);
            div_char.appendChild(text);*/
            div_char.innerHTML = "<div id='dayli_form_graph_line_" + index_char + "' style='max-width:800px; min-width: 300px; margin: 0 auto'></div>";
            var element = document.getElementById("result_score_day");
            element.appendChild(div_char);
          }

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
            arr_categories_char[i] = dateNowChar;
          }

          /**
           * get value by day of week
           */
          var arr_option_answer = [];
          var suma_date = 0;
          var count_semana = 0;
          arr_option_answer = [];

          if (arr_option_list.length == 0) {
            arr_option_list[0] = 'line';
          }

          for (const option in arr_option_list) {
            arr_option_answer[arr_option_list[option]] = [];
            count_semana = 0;
            suma_date = 0;
            for (var date in arr_categories.sort()) {
              suma_date = 0;
              date = arr_categories[date];
              for (const question in arr_question_line) {
                for (const answer in user_responses['responses'][date]) {
                  if (answer == arr_question_line[question]) {
                    if (arr_option_list[option] == 'line') {
                      suma_date = user_responses['responses'][date][answer].length;
                    } else {
                      if (is_lineal_number || arr_option_list.length == 1) {
                        suma_date = suma_date + Number(user_responses['responses'][date][answer]); // get max value
                      } else {
                        if (user_responses['responses'][date][answer].toString() == option.toString()) {
                          suma_date++; // get count the times they appear
                        }
                      }
                    }

                  }
                }
              }
              arr_option_answer[arr_option_list[option]][count_semana] = suma_date;
              count_semana++;
            }
          }

          /**
           * Get array text highchart
           */
          var arr_option_text = "";
          var first_color = "#90ed7d";
          var second_color = "#14827a";
          var three_color = "#434348";
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

          Exporting(Highcharts);

          Highcharts.chart('dayli_form_graph_line_' + index_char, {
            chart: {
              backgroundColor: "transparent",
              height: 400,
              type: 'spline',
            },
            title: {
              text: title_char
            },
            yAxis: {
              title: {
                text: 'Score'
              }
            },
            xAxis: {
              accessibility: {
                rangeDescription: ''
              },
              categories: arr_categories_char
            },
            legend: {
              layout: 'vertical',
              align: 'right',
              verticalAlign: 'middle'
            },
            plotOptions: {
              line: {
                showInLegend: is_legend
              },
              series: {
                label: {
                  connectorAllowed: false
                }
              },
              spline: {
                marker: {
                  radius: 4,
                  lineColor: '#666666',
                  lineWidth: 1
                }
              },
            },
            series: eval(arr_option_text),
            responsive: {
              rules: [{
                condition: {
                  maxWidth: 500
                },
                chartOptions: {
                  legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                  }
                }
              }]
            },
            credits: {
              enabled: false
            },

          });
        }
      });
    }
  };

  eventGraphicLine();

}