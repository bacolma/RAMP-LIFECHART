import initLine from './line';
import initPie from './pie';
import initBar from './bar';
import moment from 'moment-timezone';
const $ = jQuery;

export default () => {
  moment.tz.setDefault('America/Vancouver');

  /**
    * Calcute days week
  */
  var firstDate = moment().day(1).format('MM-DD-YYYY');
  var lastDate = moment().day(7).format('MM-DD-YYYY');

  const setDatePicker = () => {
    
    $("#weeklyDatePicker").val(firstDate + ' - ' +lastDate);

    function style_select(firstDate) {
      for(var i = 0; i < 7; i ++){
        var now = new Date(moment(firstDate, "MM-DD-YYYY").add(i,'d').format('YYYY'),(moment(firstDate, "MM-DD-YYYY").add(i,'d').format('MM') - 1),moment(firstDate, "MM-DD-YYYY").add(i,'d').format('DD'));
        var firstDateNew = now.getTime();
        if(i == 0){
          $('#weeklyDatePicker_' + firstDateNew).css('background','#44B4B8');
          $('#weeklyDatePicker_' + firstDateNew).css('border-radius', '20px');
          $('#weeklyDatePicker_' + firstDateNew).parent('td').css('background','#1B97A2');
          $('#weeklyDatePicker_' + firstDateNew).parent('td').css('border-radius', '20px 0px 0px 20px');
        }else if(i == 6){
          $('#weeklyDatePicker_' + firstDateNew).css('background','#44B4B8');
          $('#weeklyDatePicker_' + firstDateNew).css('border-radius', '20px');
          $('#weeklyDatePicker_' + firstDateNew).parent('td').css('background','#1B97A2');
          $('#weeklyDatePicker_' + firstDateNew).parent('td').css('border-radius', '0px 20px 20px 0px');
        }else{
          $('#weeklyDatePicker_' + firstDateNew).parent('td').css('background','#1B97A2');
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
          style_select(firstDate);
        },
        onSet:function(context) {
          firstDate = moment(context.select).day(1).format("MM-DD-YYYY");
          lastDate = moment(context.select).day(7).format("MM-DD-YYYY");
          $('#weeklyDatePicker').val(firstDate+ " - " + lastDate);
          style_select(firstDate);
        },
        onRender:function() {
          $('.picker__day').removeClass('picker__day--highlighted');
          $('.picker__day').removeClass('picker__day--selected');
        },
        onClose:function() {
            initLine(firstDate, lastDate);
            initPie(firstDate, lastDate);
            initBar(firstDate, lastDate);
        }
    });
  }


  initLine(firstDate, lastDate);
  initPie(firstDate, lastDate);
  initBar(firstDate, lastDate);
  setDatePicker();
};