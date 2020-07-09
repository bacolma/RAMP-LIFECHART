import initLine from './line';
import initPie from './pie';
import initBar from './bar';
import initEmpty from './empty';
import moment from 'moment-timezone';
const $ = jQuery;

export default () => {
  //moment.tz.setDefault('America/Vancouver');

  /**
  * Calcute days week
  */
  var firstDate = moment().day(1).format('MM-DD-YYYY');
  var lastDate = moment().day(7).format('MM-DD-YYYY');
  var first = "";
  var second = "";
  var between_days = "";
  var firtload = true;
  var firstDateNew = "";
  var datepiker = "";
  const setDatePicker = () => {
    
    $("#weeklyDatePicker").val(firstDate + ' to ' +lastDate);

    function style_select(firstDateNew, i, j) { 
      if(i == 0){
        $('#weeklyDatePicker_' + firstDateNew).css('background','#44B4B8');
        $('#weeklyDatePicker_' + firstDateNew).css('border-radius', '20px');
        $('#weeklyDatePicker_' + firstDateNew).parent('td').css('background','#1B97A2');
        $('#weeklyDatePicker_' + firstDateNew).parent('td').css('border-radius', '20px 0px 0px 20px');
      }else if(i == j){
        $('#weeklyDatePicker_' + firstDateNew).css('background','#44B4B8');
        $('#weeklyDatePicker_' + firstDateNew).css('border-radius', '20px');
        $('#weeklyDatePicker_' + firstDateNew).parent('td').css('background','#1B97A2');
        $('#weeklyDatePicker_' + firstDateNew).parent('td').css('border-radius', '0px 20px 20px 0px');
      }else{
        $('#weeklyDatePicker_' + firstDateNew).parent('td').css('background','#1B97A2');
      }
    }

    function range_select(firstDate, firtload) {
      if(firtload){
        for(var i = 0; i < 7; i ++){
          var now = new Date(moment(firstDate, "MM-DD-YYYY").add(i,'d').format('YYYY'),(moment(firstDate, "MM-DD-YYYY").add(i,'d').format('MM') - 1),moment(firstDate, "MM-DD-YYYY").add(i,'d').format('DD'));
          firstDateNew = now.getTime();
          style_select(firstDateNew, i, 6);
        }
      }else{
        if(first == ""){
          first = firstDate;
          firstDateNew = moment(first, "MM-DD-YYYY").add(i,'d').format("x");
          $('#weeklyDatePicker_' + firstDateNew).css('background','#44B4B8');
          $('#weeklyDatePicker_' + firstDateNew).css('border-radius', '20px');
        }else{
          second = firstDate;
          between_days = second.diff(first, 'days');
          for(var i = 0; i <= between_days; i ++){
            firstDateNew = moment(first, "MM-DD-YYYY").add(i,'d').format("x");
            style_select(firstDateNew, i, between_days);
          }
          firstDate = moment(first).format("MM-DD-YYYY");
          lastDate = moment(second).format("MM-DD-YYYY");
          $('#weeklyDatePicker').val(firstDate+ " to " + lastDate);
          first = "";second = "";
        }
      }
    }

    $( '#weeklyDatePicker' ).pickadate({
        formatSubmit: 'yyyy/mm/dd',
        format: 'm-d-Y - m-d-Y',
        editable: true,
        closeOnSelect: false,
        closeOnClear: false,
        firstDay: 1,
        close:'SELECT',
        onOpen:function() {
          if(firtload){
            range_select(firstDate, true);
            firtload = false;
          }else{
            range_select("", false);
          }
        },
        onSet:function(context) {
          if(context.select){
            firstDate = moment(context.select);
            range_select(firstDate, false);
          }
        },
        onRender:function() {
          $('.picker__day').removeClass('picker__day--highlighted');
          $('.picker__day').removeClass('picker__day--selected');
        },
        onClose:function() {
          datepiker = $( '#weeklyDatePicker' ).val();
          firstDate = datepiker.split("to")[0];
          lastDate = datepiker.split("to")[1];
          initLine(firstDate, lastDate);
          initPie(firstDate, lastDate);
          initBar(firstDate, lastDate);
        }
    });
  }


  initLine(firstDate, lastDate);
  initPie(firstDate, lastDate);
  initBar(firstDate, lastDate);
  initEmpty(firstDate, lastDate);
  setDatePicker();
};