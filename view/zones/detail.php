<?php include 'view/layout/header.php' ?>

<div class="container">
    <?php if (isset($zone['id'])): ?>
        <div class="row mb-4">
            <div class="col">
                <h2>Zone <?= $zone['name'] ?> #<?= $zone['id'] ?> (<?= date('d.m.Y H:i:s', $zone['updateTime']) ?>)</h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <h3>Records</h3>
            </div>
            <div class="col text-right">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Create new record
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php foreach ($types as $type) : ?>
                            <a class="dropdown-item"
                               href="?action=record_new&type=<?= $type ?>&name=<?= $zone['name'] ?>">
                                <?= $type ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Type</th>
                    <th scope="col">Name</th>
                    <th scope="col">Content</th>
                    <th scope="col">TTL</th>
                    <th scope="col">Prio</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Port</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($records as $record) : ?>
                <tr>
                    <td class="align-middle"><?= $record['id'] ?></td>
                    <td class="align-middle"><?= $record['type'] ?></td>
                    <td class="align-middle"><?= $record['name'] ?></td>
                    <td class="align-middle"><?= $record['content'] ?></td>
                    <td class="align-middle"><?= $record['ttl'] ?? '' ?></td>
                    <td class="align-middle"><?= $record['prio'] ?? '' ?></td>
                    <td class="align-middle"><?= $record['weight'] ?? '' ?></td>
                    <td class="align-middle"><?= $record['port'] ?? '' ?></td>
                    <td>
                        <a class="btn btn-primary" href="?action=record_delete&id=<?= $record['id'] ?>&name=<?= $zone['name'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($zone['message'])) : ?>
        <h2><?= $zone['message'] ?></h2>
    <?php endif; ?>
</div>

<?php include 'view/layout/footer.php' ?>
