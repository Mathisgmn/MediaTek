<?php

include_once "./partials/top.php";

/**
 * ******************** [1] Get illustrations full list
 */
// FIXME: Export sensitive data elsewhere
$host = 'localhost';
$dbName = DB_CONNECT["dbName"];
$user = DB_CONNECT["user"]; // Your MySQL user username
$pass = DB_CONNECT["pass"]; // Your MySQL user password

$connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT COUNT(`id`) FROM `illustration`";

$statement = $connection->query($query);

if ($statement && $statement->fetchColumn() !== 0) { // At least illustration exists
    $query  = "SELECT `illustration`.`id`, `illustration`.`description`, `illustration`.`filename`, `illustration`.`is_cover` FROM `illustration` ";

    $statement = $connection->query($query);
    $illustrations = $statement->fetchAll(PDO::FETCH_ASSOC);

    $illustrationTRsTemplate = <<<TR
        <tr>
            <td>%s</td>
            <td style="max-width: 400px"><span class="text-truncate">%s</span></td>
            <td>%s</td>
            <td class="illustration-cover"><img src="../public/uploads/illustrations/%s" alt=""></td>
            <td>%s</td>
            <td><a href="illustration_show.php?id=%s" title="Voir le détail de cette illustration"><i role="button" class="light-icon-float-left"></i></a><a href="illustration_edit_form.php?id=%s" title="Modifier cette illustration" class="btn btn-secondary btn-sm me-1"><i role="button" class="light-icon-pencil"></i></a><a href="illustration_delete_form.php?id=%s" title="Supprimer cette illustration" class="btn btn-danger btn-sm"><i role="button" class="light-icon-trash"></i></a></td>
        </tr>
    TR;

    $illustrationTRs = '';
    foreach ($illustrations as $illustration) {
        $illustration = [
            $illustration['id'],
            $illustration['description'],
            $illustration['filename'],
            $illustration['filename'],
            $illustration['is_cover'] ? "Oui" : "Non",
        ];
        $illustration = array_merge($illustration, array_fill(count($illustration), 3, $illustration[0]));
        $illustrationTRs .= vsprintf($illustrationTRsTemplate, $illustration);
    }
} else {
    $illustrationTRs = '<tr><td colspan="5">Aucune illustration n\'a été trouvée.</td></tr>';
}

$connection = null;

?>
<div class="title-space-between">
    <h4>Liste des illustrations</h4>
    <a href="illustration_new_form.php" title="Ajouter une nouvelle illustration" role="button"><i class="light-icon-circle-plus"></i>Nouvelle illustration</a>
</div>
<table class="striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>Nom du fichier</th>
            <th>Visuel</th>
            <th>Couverture ?</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?= $illustrationTRs ?>
    </tbody>
</table>
<?php

include_once "./partials/bottom.php";

?>