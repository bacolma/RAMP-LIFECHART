<div class="ramp_assessment_page">
    <div class="ramp_assessment_page__header">
        <span class="options__text">OPTIONS</span>
        <span class="last_completed__text">Last Completed</span>
    </div>
    <div class="ramp_assessment_page__list">
        <? foreach( $ramp_dayli_forms as $ramp_dayli_form ): ?>
            <div class="ramp_assessment_page__list__item">
                <a class="symptom__text"
                   href="<?= get_permalink( $ramp_dayli_form['post']->ID ) ?>"><?= $ramp_dayli_form['post']->post_title ?></a>
                <span class="date__text"><?= $ramp_dayli_form['date'] ?></span>
            </div>
        <? endforeach ?>
    </div>
</div>

