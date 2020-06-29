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

    function style_init() {
      $(".picker__button--today").css('display','none');
      $(".picker__button--clear").css('display','none');
      $(".picker__button--close").css('width','100%');
      $(".picker__button--close").css('background','#EB4745');
      $(".picker__button--close").css('color','white');
      $(".picker__button--close").css('border-radius','20px');
      $(".picker__button--close").css('border-color','#EB4745');
      $(".picker__button--close").css('margin-bottom','15px');
      $(".picker__box").css('background','#25335A');
      $(".picker__box").css('color','white');
    }

    function style_select(firstDate) {
      for(var i = 0; i < 7; i ++){
        var now = new Date(moment(firstDate, "MM-DD-YYYY").add(i,'d').format('YYYY'),(moment(firstDate, "MM-DD-YYYY").add(i,'d').format('MM') - 1),moment(firstDate, "MM-DD-YYYY").add(i,'d').format('DD'));
        var firstDateNew = now.getTime();
        if(i == 0){
          $('#weeklyDatePicker_' + firstDateNew).css('background','#44B4B8');
          $('#weeklyDatePicker_' + firstDateNew).css('border-radius', '10px 0px 0px 10px');
        }else if(i == 6){
          $('#weeklyDatePicker_' + firstDateNew).css('background','#44B4B8');
          $('#weeklyDatePicker_' + firstDateNew).css('border-radius', '0px 10px 10px 0px');
        }else{
          $('#weeklyDatePicker_' + firstDateNew).css('background','rgba(48, 180, 184, 0.78)');
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
        close:'Select',
        onStart:function() {
          style_init();
        },
        onOpen:function() {
          style_select(firstDate);
          
        },
        onSet:function(context) {
          firstDate = moment(context.select).day(1).format("MM-DD-YYYY");
          lastDate = moment(context.select).day(7).format("MM-DD-YYYY");
          $('#weeklyDatePicker').val(firstDate+ " - " + lastDate);
          style_init();
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

  const setDateRange = () => {
    $('#result_score_day__date').remove();
    $(`#result_score_day`).append(`<div id="result_score_day__date">
      <span class="dashicons dashicons-calendar-alt"></span>
      <input type="text" id="weeklyDatePicker" style="width:242px" placeholder="Select Week"/>
    </div>`);
  }

  initLine(firstDate, lastDate);
  initPie(firstDate, lastDate);
  initBar(firstDate, lastDate);
  setDateRange();
  setDatePicker();
};