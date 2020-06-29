<div class="ramp_assessment_page">
    <div class="ramp_assessment_page__header">
        <span class="options__text"><?= get_the_title() ?></span>
        <span class="last_completed__text">Last Completed: <?= $this->get_last_completed_date_of_form( $user_responses_serialized, get_the_ID() ) ?></span>
    </div>
    <div class="ramp_assessment_page__content">
        <div class="ramp_assessment">
            <?= do_shortcode( "[quform id = \"$form_id\"]" ) ?>
        </div>
    </div>
</div>