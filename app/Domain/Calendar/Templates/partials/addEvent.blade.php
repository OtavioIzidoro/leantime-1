<x-global::content.modal.modal-buttons/>

<?php
$values = $tpl->get('values');
?>


@displayNotification()

<h4 class="widgettitle title-light">{{ __("subtitles.event") }}</h4>

<x-global::content.modal.form action="{{ BASE_URL }}/calendar/addEvent/">

    <?php $tpl->dispatchTplEvent('afterFormOpen'); ?>

    <x-global::forms.text-input
        inputType="text"
        id="description"
        name="description"
        size='md'
        placeholder=""
        labelText="{{__('label.title')}}"
        value="{{$values['description']}}"
    />

    <x-global::forms.text-input
        inputType="text"
        id="event_date_from"
        name="dateFrom"
        size='md'
        placeholder=""
        labelText="{{__('label.start_date')}}"
        value=""
    />

    <x-global::forms.text-input
        inputType="time"
        id="event_time_from"
        name="timeFrom"
        placeholder=""
        labelText="{{ __('label.start_time') }}"
        value=""
    />

    <x-global::forms.text-input
        inputType="text"
        id="event_date_to"
        name="dateFrom"
        size='md'
        placeholder=""
        labelText="{{__('label.end_date')}}"
        value=""
    />


    <x-global::forms.text-input
        inputType="time"
        id="event_time_to"
        name="timeTo"
        placeholder=""
        labelText="{{ __('label.end_time') }}"
        value=""
    />


    <x-global::forms.checkbox
        name="allDay"
        id="allDay"
        :checked="isset($values['allDay']) && $values['allDay']"
        labelText="{{ __('label.all_day') }}"
        labelPosition="left"
    />
    <br /><br />


    <?php $tpl->dispatchTplEvent('beforeSubmitButton'); ?>

    <p class="stdformbutton">
        <input type="hidden" value="1" name="save" />
        <x-global::forms.button type="submit" name="saveEvent" id="saveEvent" class="button">
            {{ __('buttons.save') }}
        </x-global::forms.button>
     </p>

    <?php $tpl->dispatchTplEvent('beforeFormClose'); ?>

</x-global::content.modal.form>

<script type="text/javascript">

    <?php $tpl->dispatchTplEvent('scripts.afterOpen'); ?>

    jQuery(document).ready(function() {
        leantime.calendarController.initEventDatepickers();
    });

    <?php $tpl->dispatchTplEvent('scripts.beforeClose'); ?>

</script>