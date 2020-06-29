<div class="ramp_assessment_page">
    <div class="ramp_assessment_page__header">
        <span class="options__text"><?= get_the_title() ?></span>
        <span class="last_completed__text">Last Completed: <?= $this->get_last_completed_date_of_form( $user_responses_serialized, get_the_ID() ) ?></span>
    </div>
    <div class="ramp_assessment_page__content">
        <div class="ramp_assessment_page__detail">
            <div class='entry-title' id='result_score_day'></div>
            <? if( $description != '' ): ?>
                <div class="detail__description"><?= $description ?></div>
            <? endif; ?>
            <? if( ! $has_response_today ): ?>
                <a href="<?= get_permalink() . '?start=now' ?>" class="detail__start">Start</a>
            <? endif; ?>
        </div>

    </div>
</div>

<script>
  var user_responses = <?=$response_json ?>;
  var charts = <?= $charts_json ?>;
  var data_form = <?= $data_forms_json ?>;
</script>
