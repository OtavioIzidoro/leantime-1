<x-global::content.modal.modal-buttons/>

<?php
$url = $tpl->get('url');
?>

<h4 class="widgettitle title-light"><i class="fa fa-file-export"></i> <?=$tpl->__('label.ical_export'); ?></h4>

@displayNotification()

<x-global::content.modal.form action="{{ BASE_URL }}/calendar/export">

    <?php $tpl->dispatchTplEvent('afterFormOpen'); ?>

    <?php
    echo $tpl->__('text.ical_export_description');
    echo "<br />";
    ?>

    <?php
    if ($url) {
        echo $tpl->__('text.you_ical_url');
        echo "<br /><input type='text' value='" . $url . "' style='width:100%;'/>";
    } else {
        echo $tpl->__('text.no_url');
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" value="1" name="generateUrl" />

            <?php $tpl->dispatchTplEvent('beforeSubmitButton'); ?>

            <br />
            <x-global::forms.button type="submit">
                {{ __('buttons.generate_ical_url') }}
            </x-global::forms.button>

        </div>
        <div class="col-md-6 align-right">
            <?php  if ($url) { ?>
                 <a href="{{ BASE_URL }}/calendar/export?remove=1" class="delete formModal"><i class="fa fa-trash"></i> <?=$tpl->__('links.remove_access') ?></a>
            <?php } ?>
        </div>
    </div>

    <?php $tpl->dispatchTplEvent('beforeFormClose'); ?>

</x-global::content.modal.form>
