<?php include 'view/layout/header.php' ?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Zones</h2>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($zones as $zone) : ?>
            <tr>
                <td class="align-middle"><?= $zone['id'] ?></td>
                <td class="align-middle"><?= $zone['name'] ?></td>
                <td>
                    <a class="btn btn-primary" href="?action=zone_view&name=<?= $zone['name'] ?>">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'view/layout/footer.php' ?>
