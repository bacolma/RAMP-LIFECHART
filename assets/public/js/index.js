import initGraphic from './graphic/index';
import initForms from './forms/index';

function init() {
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