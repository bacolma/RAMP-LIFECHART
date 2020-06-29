import pain_assessment_tool from "./pain_assessment_tool";

const $ = jQuery;

export default () => {

  function setCompleteTextInPercentage() {
    $('.quform-page-progress.quform-page-progress-type-percentage').append(
      `<div class="quform-page-progress-completed">
           COMPLETED       
        </div>  
      `);
  }

  function main() {
    pain_assessment_tool();
    setCompleteTextInPercentage();
  }

  main();
}