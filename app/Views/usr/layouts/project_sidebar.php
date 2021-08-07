<div class="border-end-0 bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading bg-purp border-bottom"><?= SITE_NAME ?></div>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url().'/project' ?>"> <span style="font-size: 12px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> BACK TO PROJECT LIST</span></a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3 nav-name-project" href="<?= base_url('/dasboard').'/'.$project['IDproject']; ?>"><?= $project['name']; ?></a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/task-list/<?= $project['IDproject']; ?>">Task List</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/team/<?= $project['IDproject']; ?>">Team</a>
    </div>
</div>