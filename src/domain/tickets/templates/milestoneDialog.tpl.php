<?php
$currentMilestone = $this->get('milestone');
$milestones = $this->get('milestones');


?>

<script type="text/javascript">
    window.onload = function() {
        if (!window.jQuery) {
            //It's not a modal
            location.href="<?=BASE_URL ?>/tickets/roadmap&showMilestoneModal=<?php echo $currentMilestone->id; ?>";

        }
    }
</script>

<div class="showDialogOnLoad" style="display:none;">

    <h4 class="widgettitle title-light"><?=$this->__("headline.milestone"); ?> </h4>

    <?php echo $this->displayNotification(); ?>

    <form class="formModal" method="post" action="<?=BASE_URL ?>/tickets/editMilestone/<?php echo $currentMilestone->id ?>" style="min-width: 250px;">

        <label><?=$this->__("label.milestone_title"); ?></label>
        <input type="text" name="headline" value="<?php echo $currentMilestone->headline?>" placeholder="<?=$this->__("label.milestone_title"); ?>"/><br />

        <label><?=$this->__("label.dependent_on"); ?></label>
        <select name="dependentMilestone"  class="span11">
            <option value=""><?=$this->__("label.no_dependency"); ?></option>
            <?php foreach ($this->get('milestones') as $milestoneRow) {
                if($milestoneRow->id !== $currentMilestone->id) {
                    echo "<option value='" . $milestoneRow->id . "'";

                    if ($currentMilestone->dependingTicketId == $milestoneRow->id) { echo " selected='selected' ";
                    }

                    echo ">" . $milestoneRow->headline . " </option>";

                }
            }
            ?>

        </select>

        <label><?=$this->__("label.owner"); ?></label>
        <select data-placeholder="<?php echo $this->__('input.placeholders.filter_by_user'); ?>"
                name="editorId" class="user-select span11">
            <option value=""><?=$this->__("dropdown.not_assigned"); ?></option>
            <?php foreach ($this->get('users') as $userRow) { ?>

                <?php echo "<option value='" . $userRow["id"] . "'";

                if ($currentMilestone->editorId == $userRow["id"]) { echo " selected='selected' ";
                }

                echo ">" . $userRow["firstname"] . " " . $userRow["lastname"] . "</option>"; ?>

            <?php } ?>
        </select>

        <label><?=$this->__("label.color"); ?></label>
        <input type="text" name="tags" value="<?php echo $currentMilestone->tags?>" placeholder="<?=$this->__("input.placeholders.pick_a_color"); ?>" class="simpleColorPicker"/><br />

        <label><?=$this->__("label.planned_start_date"); ?></label>
        <input type="text" name="editFrom" value="<?php echo $currentMilestone->editFrom?>" placeholder="<?=$this->__("language.dateformat"); ?>" id="milestoneEditFrom" /><br />

        <label><?=$this->__("label.planned_end_date"); ?></label>
        <input type="text" name="editTo" value="<?php echo $currentMilestone->editTo ?>"  placeholder="<?=$this->__("language.dateformat"); ?>" id="milestoneEditTo" /><br />

        <div class="row">
            <div class="col-md-6">
                <input type="submit" value="<?=$this->__("buttons.save"); ?>"/>
            </div>
            <div class="col-md-6 align-right padding-top-sm">
                <?php if (isset($currentMilestone->id) && $currentMilestone->id != '' && ($_SESSION['userdata']['role'] == 'admin' || $_SESSION['userdata']['role'] == 'manager')) { ?>
                    <a href="<?=BASE_URL ?>/tickets/delMilestone/<?php echo $currentMilestone->id; ?>" class="delete formModal milestoneModal"><i class="fa fa-trash"></i> <?=$this->__("buttons.delete"); ?></a>
                <?php } ?>
            </div>
        </div>

    </form>

        <?php
            if(isset($currentMilestone->id) && $currentMilestone->id !== '') {
        ?>
        <br />
        <input type="hidden" name="comment" value="1" />

        <?php
        $this->assign("formUrl", "/tickets/editMilestone/".$currentMilestone->id."");
        $this->displaySubmodule('comments-generalComment');?>
    <?php } ?>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            leantime.ticketsController.initModals();
        })
    </script>

</div>