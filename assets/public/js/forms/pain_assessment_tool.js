const $ = jQuery;

export default () => {

  function main() {
    range_slider();
    $.each($('.pain_range__labels img'), function () {
      $(this).attr('src', `${RAMP_DAILY_FORM.public_assets_url}${$(this).data('src')}`);
    });
  }

  function range_slider() {
    $.each(jQuery(".pain_range input[type=range]"), function () {
      var $inputRange = $(this);
      $inputRange.rangeslider({
        polyfill: false,
        onInit: function () {
        },
        onSlide: function (position, value) {
        },
        onSlideEnd: function (position, value) {
          var $inputToSave = jQuery(
            'input[name="quform_' + $inputRange.data("id") + '"]'
          );
          $inputToSave.val(value);
        }
      });
    });
  }

  main();
};
