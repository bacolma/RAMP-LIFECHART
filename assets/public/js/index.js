import initGraphic from './graphic/index';
import initForms from './forms/index';

function init() {
  if (RAMP_ASSESSMENT.post_type === 'ramp_assessment') {
    console.log('ENTREEEEEEEEEEEE ASSESSMENT');
    try {
      initGraphic();
    } catch (error) {
      console.log('erroor', error);
    }
    try {
      initForms();
    } catch (error) {
      console.log('erroor', error);
    }
  }
}


function ready(fn) {
  if (
    document.attachEvent
      ? document.readyState === "complete"
      : document.readyState !== "loading"
  ) {
    fn();
  } else {
    document.addEventListener("DOMContentLoaded", fn);
  }
}

ready(() => {
  init();
});