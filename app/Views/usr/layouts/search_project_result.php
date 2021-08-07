<div class="search-result">
    <div class="desc">
        <p class="project-name"><?= $search_result['pname']; ?></p>
        <p class="author">author : <?= $search_result['uname']; ?></p>
    </div>
    <div class="req">
        <a href="/request/<?= $search_result['IDproject']; ?>" class="btn btn-green">Request Join</a>
    </div>
</div>