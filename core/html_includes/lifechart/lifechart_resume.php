<div class="ramp_assessment_page">
    <div class="ramp_assessment_page__header">
        <span class="options__text"><?= get_the_title() ?></span>
        <span class="last_completed__text">Last Completed: <?= $date_last_completed ?></span>
    </div>
    <div class="ramp_assessment_page__content">
    <a class="printPage">Print Page</a>
        <? if( $show_results == 'yes' ): ?>
        <div id="show-results">
        </div>
        <? endif; ?>
        <div class="ramp_assessment_page__detail">
            <div class='entry-title' id='result_score_day'></div>
            <? if( $description != '' ): ?>
                <div class="detail__description"><?= $description ?></div>
            <? endif; ?>
            <div class="chart-stats">
                <div><span class="highest">-</span><span>HIGHEST</span></div>
                <div><span class="lowest">-</span><span>LOWEST</span></div>
                <div><span class="latest">-</span><span>LATEST</span></div>
            </div>
            <div id="result_score_day__date">
                <span class="dashicons dashicons-calendar-alt"></span>
                <input type="text" id="weeklyDatePicker" style="width:242px" placeholder="Select Week"/>
            </div>
            <? if( ! $has_response_today ): ?>
                <a href="<?= get_permalink() . '?start=now' ?>" class="detail__start">Start Assessment</a>
            <? endif; ?>
        </div>

    </div>
</div>
<script>
  var score_levels = <?= isset( $score_levels ) ? $score_levels : '[]' ?>;
  var user_responses = <?=! is_null( $response_json ) ? $response_json : '[]' ?>;
  var charts = <?= ! is_null( $charts_json ) ? $charts_json : '[]' ?>;
  var data_form = <?= ! is_null( $data_forms_json ) ? $data_forms_json : '[]' ?>;
  
</script>
