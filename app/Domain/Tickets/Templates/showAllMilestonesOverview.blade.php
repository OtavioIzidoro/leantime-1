@extends($layout)

@section('content')
    <?php
    $sprints = $tpl->get('sprints');
    $searchCriteria = $tpl->get('searchCriteria');
    $currentSprint = $tpl->get('currentSprint');
    
    $todoTypeIcons = $tpl->get('ticketTypeIcons');
    
    $efforts = $tpl->get('efforts');
    $statusLabels = $tpl->get('allTicketStates');
    $allTickets = $tpl->get('allTickets');
    
    //All states >0 (<1 is archive)
    $numberofColumns = count($tpl->get('allTicketStates')) - 1;
    $size = floor(100 / $numberofColumns);
    
    ?>

    @include('tickets::includes.portfolioHeader')

    <div class="maincontent">
        {{-- @include('tickets::includes.portfolioTabs') --}}

        <div class="maincontentinner">

            @displayNotification()

            <form action="" method="get" id="ticketSearch">

                <?php $tpl->dispatchTplEvent('filters.afterFormOpen'); ?>

                <input type="hidden" value="1" name="search" />
                <div class="row">
                    <div class="col-md-5">
                        <?php
                        $tpl->dispatchTplEvent('filters.afterLefthandSectionOpen');
                        $tpl->dispatchTplEvent('filters.beforeLefthandSectionClose');
                        ?>
                    </div>

                    <div class="col-md-2 center">
                        <?php
                        $tpl->dispatchTplEvent('filters.afterCenterSectionOpen');
                        $tpl->dispatchTplEvent('filters.beforeCenterSectionClose');
                        ?>
                    </div>
                    <div class="col-md-5">
                        <div class="pull-right">

                            <?php $tpl->dispatchTplEvent('filters.afterRighthandSectionOpen'); ?>

                            <div id="tableButtons" style="display:inline-block"></div>

                            <?php $tpl->dispatchTplEvent('filters.beforeRighthandSectionClose'); ?>

                        </div>
                    </div>

                </div>

                <?php $tpl->dispatchTplEvent('filters.beforeFormClose'); ?>

                <div class="clearfix"></div>

            </form>

            <?php $tpl->dispatchTplEvent('allTicketsTable.before', ['tickets' => $allTickets]); ?>

            <table id="allTicketsTable" class="table table-bordered display" style="width:100%">
                <colgroup>
                    <col class="con1">
                    <col class="con0">
                    <col class="con1">
                    <col class="con0">
                    <col class="con1">
                    <col class="con0">
                    <col class="con1">
                    <col class="con0">
                    <col class="con1">
                    <col class="con0">
                    <col class="con1">
                    <col class="con0">


                </colgroup>
                <?php $tpl->dispatchTplEvent('allTicketsTable.beforeHead', ['tickets' => $allTickets]); ?>
                <thead>
                    <?php $tpl->dispatchTplEvent('allTicketsTable.beforeHeadRow', ['tickets' => $allTickets]); ?>
                    <tr>
                        <th><?= $tpl->__('label.project_name') ?></th>
                        <th><?= $tpl->__('label.title') ?></th>

                        <th class="milestone-col"><?= $tpl->__('label.dependent_on') ?></th>

                        <th><?= $tpl->__('label.todo_status') ?></th>

                        <th class="user-col"><?= $tpl->__('label.owner') ?></th>
                        <th><?= $tpl->__('label.planned_start_date') ?></th>
                        <th><?= $tpl->__('label.planned_end_date') ?></th>
                        <th><?= $tpl->__('label.planned_hours') ?></th>
                        <th><?= $tpl->__('label.estimated_hours_remaining') ?></th>
                        <th><?= $tpl->__('label.booked_hours') ?></th>
                        <th><?= $tpl->__('label.progress') ?></th>
                        <th class="no-sort"></th>

                    </tr>
                    <?php $tpl->dispatchTplEvent('allTicketsTable.afterHeadRow', ['tickets' => $allTickets]); ?>
                </thead>
                <?php $tpl->dispatchTplEvent('allTicketsTable.afterHead', ['tickets' => $allTickets]); ?>
                <tbody>
                    <?php $tpl->dispatchTplEvent('allTicketsTable.beforeFirstRow', ['tickets' => $allTickets]); ?>
                    <?php foreach ($allTickets as $rowNum => $row) {?>
                    <tr>
                        <td>
                            <h4><?= $row->projectName ?> </h4>
                        </td>
                        <?php $tpl->dispatchTplEvent('allTicketsTable.afterRowStart', ['rowNum' => $rowNum, 'tickets' => $allTickets]); ?>
                        <td data-order="<?= $tpl->e($row->headline) ?>"><a
                                href="#/tickets/editMilestone/<?= $tpl->e($row->id) ?>"><?= $tpl->e($row->headline) ?></a>
                        </td>
                        <?php
                        if ($row->milestoneid != '' && $row->milestoneid != 0) {
                            $milestoneHeadline = $tpl->escape($row->milestoneHeadline);
                            $selectedKey = $row->milestoneid; // The selected milestone ID
                        } else {
                            $milestoneHeadline = $tpl->__('label.no_milestone');
                        }
                        
                        $milestoneColor = $tpl->escape($row->milestoneColor);
                        $dropdownId = 'milestoneDropdownMenuLink' . $row->id;
                        ?>

                        <td class="dropdown-cell" data-order="{{ $milestoneHeadline }}">
                            <x-global::forms._archive.dropdownPill
                                class="ticketDropdown milestoneDropdown colorized show label-default milestone"
                                id="{{ $dropdownId }}" :style="'background-color:' . $milestoneColor" :labelText="$milestoneHeadline" type="milestone"
                                :parentId="$row->id">
                                <x-slot name="buttonText">
                                    {{ $milestoneHeadline }} <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </x-slot>

                                <x-global::actions.dropdown.item class="nav-header border">
                                    {{ __('dropdown.choose_milestone') }}
                                </x-global::actions.dropdown.item>

                                <x-global::actions.dropdown.item href="javascript:void(0);" style="background-color:#b0b0b0"
                                    :data-label="$tpl->__('label.no_milestone')" :data-value="$row->id . '_0_#b0b0b0'">
                                    {{ $tpl->__('label.no_milestone') }}
                                </x-global::actions.dropdown.item>

                                @foreach ($tpl->get('milestones') as $milestone)
                                    @if ($milestone->id != $row->id)
                                        <x-global::actions.dropdown.item href="javascript:void(0);" :data-label="$tpl->escape($milestone->headline)"
                                            :data-value="$row->id .
                                                '_' .
                                                $milestone->id .
                                                '_' .
                                                $tpl->escape($milestone->tags)" :id="'ticketMilestoneChange' . $row->id . $milestone->id" :style="'background-color:' . $tpl->escape($milestone->tags)">
                                            {{ $tpl->escape($milestone->headline) }}
                                        </x-global::actions.dropdown.item>
                                    @endif
                                @endforeach
                            </x-global::forms._archive.dropdownPill>
                        </td>


                        <?php
                        if (isset($statusLabels[$row->status])) {
                            $class = $statusLabels[$row->status]['class'];
                            $name = $statusLabels[$row->status]['name'];
                            $selectedKey = $row->status; // Set the selected key for the dropdown
                        } else {
                            $class = 'label-important';
                            $name = 'new';
                            $selectedKey = null; // No selected status
                        }
                        ?>

                        <td class="dropdown-cell" data-order="{{ $name }}">
                            <x-global::forms._archive.dropdownPill
                                class="ticketDropdown statusDropdown colorized show {{ $class }}"
                                id="statusDropdownMenuLink{{ $row->id }}" :labelText="$name" type="status"
                                :parentId="$row->id" :selectedKey="$selectedKey" :options="$statusLabels">
                                <x-slot name="buttonText">
                                    {{ $name }} <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </x-slot>

                                <x-global::actions.dropdown.item class="nav-header border">
                                    {{ __('dropdown.choose_status') }}
                                </x-global::actions.dropdown.item>

                                @foreach ($statusLabels as $key => $label)
                                    <x-global::actions.dropdown.item href="javascript:void(0);"
                                        class="{{ $label['class'] }}" :data-label="$tpl->escape($label['name'])" :data-value="$row->id . '_' . $key . '_' . $label['class']"
                                        :id="'ticketStatusChange' . $row->id . $key">
                                        {{ $tpl->escape($label['name']) }}
                                    </x-global::actions.dropdown.item>
                                @endforeach
                            </x-global::forms._archive.dropdownPill>
                        </td>


                        <?php
                        // Determine user text and image to display
                        if ($row->editorFirstname != '') {
                            $userText = "<span id='userImage" . $row->id . "'><img src='" . BASE_URL . '/api/users?profileImage=' . $row->editorId . "' width='25' style='vertical-align: middle; margin-right:5px;'/></span><span id='user" . $row->id . "'> " . $tpl->escape($row->editorFirstname) . '</span>';
                            $selectedKey = $row->editorId; // The selected user's ID
                        } else {
                            $userText = "<span id='userImage" . $row->id . "'><img src='" . BASE_URL . "/api/users?profileImage=false' width='25' style='vertical-align: middle; margin-right:5px;'/></span><span id='user" . $row->id . "'>" . $tpl->__('dropdown.not_assigned') . '</span>';
                            $selectedKey = null; // No user selected
                        }
                        
                        $dropdownId = 'userDropdownMenuLink' . $row->id;
                        $notAssignedLabel = $tpl->__('dropdown.not_assigned');
                        $users = $tpl->get('users'); // Fetch the list of users
                        ?>

                        <td class="dropdown-cell"
                            data-order="{{ $row->editorFirstname != '' ? $tpl->escape($row->editorFirstname) : $tpl->__('dropdown.not_assigned') }}">
                            <x-global::forms._archive.dropdownPill class="ticketDropdown userDropdown noBg show"
                                id="{{ $dropdownId }}" :labelText="html_entity_decode($userText)" type="user" :parentId="$row->id"
                                :selectedKey="$selectedKey" :options="$users">
                                <x-slot name="buttonText">
                                    {!! $userText !!} <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </x-slot>

                                <x-global::actions.dropdown.item class="nav-header border">
                                    {{ __('dropdown.choose_user') }}
                                </x-global::actions.dropdown.item>

                                @foreach ($tpl->get('users') as $user)
                                    <x-global::actions.dropdown.item href="javascript:void(0);" :data-label="sprintf(
                                        $tpl->__('text.full_name'),
                                        $tpl->escape($user['firstname']),
                                        $tpl->escape($user['lastname']),
                                    )"
                                        :data-value="$row->id . '_' . $user['id'] . '_' . $user['profileId']" :id="'userStatusChange' . $row->id . $user['id']">
                                        <img src="{{ BASE_URL . '/api/users?profileImage=' . $user['id'] }}" width="25"
                                            style="vertical-align: middle; margin-right:5px;" />
                                        {{ sprintf($tpl->__('text.full_name'), $tpl->escape($user['firstname']), $tpl->escape($user['lastname'])) }}
                                    </x-global::actions.dropdown.item>
                                @endforeach
                            </x-global::forms._archive.dropdownPill>
                        </td>


                        <td data-order="{!! $row->editFrom !!}">
                            <x-global::forms.text-input type="text" name="editFrom" value="{!! format($row->editFrom)->date() !!}"
                                title="{!! __('label.planned_start_date') !!}"
                                class="editFromDate secretInput milestoneEditFromAsync fromDateTicket-{!! $row->id !!}"
                                data-id="{!! $row->id !!}" leadingVisual="{!! __('label.due_icon') !!}" />
                        </td>

                        <td data-order="{!! $row->editTo !!}">
                            <x-global::forms.text-input type="text" name="editTo" value="{!! format($row->editTo)->date() !!}"
                                title="{!! __('label.planned_end_date') !!}"
                                class="editToDate secretInput milestoneEditToAsync toDateTicket-{!! $row->id !!}"
                                data-id="{!! $row->id !!}" leadingVisual="{!! __('label.due_icon') !!}" />
                        </td>


                        <td data-order="<?= $row->planHours ?>">
                            <?php echo $row->planHours; ?>
                        </td>
                        <td data-order="<?= $row->hourRemaining ?>">
                            <?php echo $row->hourRemaining; ?>
                        </td>
                        <td data-order="<?= $row->bookedHours ?>">
                            <?php echo $row->bookedHours; ?>
                        </td>

                        <td data-order="<?= $row->percentDone ?>">

                            <div class="progress " style="width: 100%;">

                                <div class="progress-bar progress-bar-success " role="progressbar"
                                    aria-valuenow="<?php echo $row->percentDone; ?>" aria-valuemin="0" aria-valuemax="100"
                                    style="width: <?php echo $row->percentDone; ?>%">
                                    <span
                                        class="sr-only"><?= sprintf($tpl->__('text.percent_complete'), $row->percentDone) ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if ($login::userIsAtLeast($roles::$editor)) { ?>
                            <div class="inlineDropDownContainer">

                                <!-- Determine Label Text for the Dropdown -->
                                @php
                                    $labelText = '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                                @endphp

                                <!-- Context Menu Component -->
                                <x-global::content.context-menu :label-text="$labelText" contentRole="link" position="bottom"
                                    align="start">
                                    <!-- Menu Header -->
                                    <li class="nav-header">{{ $tpl->__('subtitles.todo') }}</li>

                                    <!-- Dropdown Items -->
                                    <x-global::actions.dropdown.item href="#/tickets/editMilestone/{{ $row->id }}"
                                        class="ticketModal">
                                        <i class="fa fa-edit"></i> {{ $tpl->__('links.edit_milestone') }}
                                    </x-global::actions.dropdown.item>
                                    <x-global::actions.dropdown.item href="#/tickets/moveTicket/{{ $row->id }}"
                                        class="moveTicketModal sprintModal">
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                        {{ $tpl->__('links.move_milestone') }}
                                    </x-global::actions.dropdown.item>
                                    <x-global::actions.dropdown.item href="#/tickets/delMilestone/{{ $row->id }}"
                                        class="delete">
                                        <i class="fa fa-trash"></i> {{ $tpl->__('links.delete') }}
                                    </x-global::actions.dropdown.item>

                                    <!-- Divider -->
                                    <li class="nav-header border"></li>

                                    <!-- Additional Menu Item -->
                                    <x-global::actions.dropdown.item
                                        href="{{ BASE_URL }}/tickets/showAll?search=true&milestone={{ $row->id }}">
                                        {{ $tpl->__('links.view_todos') }}
                                    </x-global::actions.dropdown.item>
                                </x-global::content.context-menu>

                            </div>
                            <?php } ?>


                        </td>
                        <?php $tpl->dispatchTplEvent('allTicketsTable.beforeRowEnd', ['tickets' => $allTickets, 'rowNum' => $rowNum]); ?>
                    </tr>
                    <?php } ?>
                    <?php $tpl->dispatchTplEvent('allTicketsTable.afterLastRow', ['tickets' => $allTickets]); ?>
                </tbody>
                <?php $tpl->dispatchTplEvent('allTicketsTable.afterBody', ['tickets' => $allTickets]); ?>
            </table>
            <?php $tpl->dispatchTplEvent('allTicketsTable.afterClose', ['tickets' => $allTickets]); ?>

        </div>
    </div>

    <script type="text/javascript">
        <?php $tpl->dispatchTplEvent('scripts.afterOpen'); ?>

        jQuery(document).ready(function() {});

        leantime.ticketsController.initTicketSearchSubmit("{{ BASE_URL }}/tickets/showAll");

        <?php if ($login::userIsAtLeast($roles::$editor)) { ?>
        leantime.ticketsController.initUserDropdown();
        leantime.ticketsController.initMilestoneDropdown();
        leantime.ticketsController.initEffortDropdown();
        leantime.ticketsController.initStatusDropdown();
        leantime.ticketsController.initSprintDropdown();
        leantime.ticketsController.initMilestoneDatesAsyncUpdate();

        <?php } else { ?>
        leantime.authController.makeInputReadonly(".maincontentinner");
        <?php } ?>

        leantime.ticketsController.initMilestoneTable("<?= $searchCriteria['groupBy'] ?>");

        <?php $tpl->dispatchTplEvent('scripts.beforeClose'); ?>
        <?php $tpl->dispatchTplEvent('scripts.beforeClose'); ?>

        <?php $tpl->dispatchTplEvent('scripts.beforeClose'); ?>
    </script>
@endsection