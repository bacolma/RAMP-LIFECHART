<div class="ramp_assessment_page">
    <div class="ramp_assessment_page__header">
        <span class="options__text">ASSESSMENT</span>
        <span class="last_completed__text">Last Completed</span>
    </div>
    <div class="ramp_assessment_page__list">
        <? foreach( $ramp_assessment as $ramp_assessment_item ): ?>
            <div class="ramp_assessment_page__list__item">
                <a class="symptom__text"
                   href="<?= get_permalink( $ramp_assessment_item['post']->ID ) ?>"><?= $ramp_assessment_item['post']->post_title ?></a>
                <span class="date__text"><?= $ramp_assessment_item['date'] ?></span>
            </div>
        <? endforeach ?>
    </div>
</div>

