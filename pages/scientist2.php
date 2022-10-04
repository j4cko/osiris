
<?php

$currentuser = $user == $_SESSION['username'];
$q = SELECTEDYEAR . "Q" . SELECTEDQUARTER;

include_once BASEPATH . "/php/_lom.php";
$LOM = new LOM($user, $osiris);

$_lom = 0;

// gravatar
$email = $user . "@dsmz.de";
$default = ROOTPATH . "/img/person.jpg";
$size = 100;

$gravatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size;
?>

<div class="row align-items-center">
    <div class="col flex-grow-0">
        <img src="<?= $gravatar ?>" alt="">
    </div>
    <div class="col ml-20">
        <h1><?= $name ?></h1>
        <p class="lead">
            <i class="fad fa-lg fa-coin text-signal"></i>
            <b id="lom-points"></b>
            Credits
        </p>
    </div>
</div>


<?php
if ($currentuser) {

    $approved = isset($USER['approved']) && in_array($q, $USER['approved']->bsonSerialize());
    $approval_needed = array();
?>


    <p class="row-muted">
        <?= lang(
            'This is your personal page. Please review your recent research activities carefully and add new activities.',
            'Dies ist deine persönliche Seite. Bitte überprüfe deine letzten Aktivitäten sorgfältig und füge neue hinzu, falls angebracht.'
        ) ?>
    </p>
    <?php if ($approved) { ?>
        <a href="#" class="btn disabled">
            <i class="fas fa-check mr-5"></i>
            <?= lang('You have already approved the currently selected quarter.', 'Du hast das aktuelle Quartal bereits bestätigt.') ?>
        </a>
    <?php } else { ?>
        <a class="btn btn-success" href="#approve">
            <i class="fas fa-question mr-5"></i>
            <?= lang('Approve current quarter', 'Aktuelles Quartal freigeben') ?>
        </a>
    <?php } ?>

<?php } ?>
<!-- 
<div class="lead my-20">
    <?= lang('In ' . SELECTEDYEAR . ' achieved LOM points: ', 'Im Jahr ' . SELECTEDYEAR . ' erreichte LOM-Punkte: ') ?>
    <i class="fad fa-lg fa-coin text-signal"></i>
    <b id="lom-points"></b>
</div> -->



<h3>
    <?php
    echo lang('Research activities in ', 'Forschungsaktivitäten in ') . SELECTEDYEAR;
    ?>
</h3>

<?php

$queries = array(
    "publication" => [
        "filter" => ['$or' => [['authors.user' => $user], ['editors.user' => $user]], 'year' => SELECTEDYEAR],
        "options" => ['sort' => ["year" => -1, "month" => -1]],
        "title" => lang('Publications', 'Publikationen'),
        "icon" => 'book-bookmark',
        "color" => "primary",
        "show-quarter" => true
    ],
    "poster" => [
        "filter" => [
            'authors.user' => $user,
            "start.year" => SELECTEDYEAR
        ],
        "options" => array(),
        "title" => lang('Poster'),
        "icon" => 'presentation-screen',
        "color" => "danger",
        "show-quarter" => true
    ],
    "lecture" => [
        "filter" =>  [
            'authors.user' => $user,
            "start.year" => SELECTEDYEAR
        ],
        "options" => array(),
        "title" => lang('Lectures', 'Vorträge'),
        "icon" => 'keynote',
        "color" => "signal",
        "show-quarter" => true
    ],
    "review" => [
        "filter" => [
            'user' => $user,
            // "role" => "Editor",
            // "start.year" => array('$lte' => SELECTEDYEAR),
            '$or' => array(
                ['end.year' => array('$gte' => SELECTEDYEAR)],
                ['end' => null],
                ['dates.year' => SELECTEDYEAR]
            )
        ],
        "options" => array(),
        "title" => lang('Reviews &amp; Editorial boards'),
        "icon" => 'book-open-cover',
        "color" => "success",
        "show-quarter" => false
    ],
    "misc" => [
        "filter" => [
            'authors.user' => $user,
            "dates.start.year" => array('$lte' => SELECTEDYEAR),
            '$or' => array(
                ['dates.end.year' => array('$gte' => SELECTEDYEAR)],
                ['dates.end' => null]
            )
        ],
        "options" => array(),
        "title" => lang('Other activities', 'Sonstige Aktivitäten'),
        "icon" => 'icons',
        "color" => "none",
        "show-quarter" => false
    ],
    "teaching" => [
        "filter" => [
            'authors.user' => $user,
            "start.year" => array('$lte' => SELECTEDYEAR),
            '$or' => array(
                ['end.year' => array('$gte' => SELECTEDYEAR)],
                ['end' => null]
            )
        ],
        "options" => array(),
        "title" => lang('Teaching &amp; Guests', 'Abschlussarbeiten und Gäste'),
        "icon" => 'people',
        "color" => "none",
        "show-quarter" => false
    ]
);

foreach ($queries as $col => $val) {
    // $collection = get_collection($col);
    $collection = $osiris->activities;

?>


    <div class="box box-<?= $val['color'] ?>">
        <div class="content">
            <h4 class="title text-<?= $val['color'] ?>"><i class="far fa-<?= $val['icon'] ?> mr-5"></i> <?= $val['title'] ?></h4>
        </div>
        <table class="table table-simple">
            <tbody>
                <?php
                $filter = $val['filter'];
                $filter['type'] = $col; 
                $cursor = $collection->find($filter, $val['options']);
                // dump($cursor);
                foreach ($cursor as $document) {
                    $id = $document['_id'];
                    $l = $LOM->lom($col, $document);
                    $_lom += $l['lom'];

                    $a = is_approved($document, $user);
                    if (!$a) {
                        $approval_needed[] = array(
                            'type' => $col,
                            'id' => $document['_id'],
                            'title' => $document['title']
                        );
                    }

                    if ($val["show-quarter"]) {
                        $q = getQuarter($document);
                        $in_quarter = $q == SELECTEDQUARTER;
                    } else {
                        $in_quarter = true;
                    }


                    echo "<tr class='" . (!$in_quarter ? 'row-muted' : '') . "' id='tr-$col-$id'>";
                    if ($val['show-quarter']) echo "<td class='quarter'>Q$q</td>";
                    echo "<td>";
                    echo $Format->format($col, $document);

                    // show error messages, warnings and todos
                    if ($currentuser) {
                        if (!$a) { ?>
                            <div class='alert alert-signal' id="approve-<?= $col ?>-<?= $id ?>">
                                <?= lang('Is this your activity?', 'Ist dies deine Aktivität?') ?>
                                <!-- <br> -->
                                <button class="btn btn-sm text-success ml-20" onclick="_approve('<?= $col ?>', '<?= $id ?>', 1)">
                                    <i class="fas fa-check"></i>
                                    <?= lang('Yes, this is me and I was affiliated to the' . AFFILIATION, 'Ja, das bin ich und ich war der ' . AFFILIATION . ' angehörig') ?>
                                </button>
                                <button class="btn btn-sm text-danger" onclick="_approve('<?= $col ?>', '<?= $id ?>', 2)">
                                    <i class="fas fa-handshake-slash"></i>
                                    <?= lang('Yes, but I was not affiliated to the ' . AFFILIATION, 'Ja, aber ich war nicht der ' . AFFILIATION . ' angehörig') ?>
                                </button>
                                <button class="btn btn-sm text-danger" onclick="_approve('<?= $col ?>', '<?= $id ?>', 3)">
                                    <i class="fas fa-xmark"></i>
                                    <?= lang('No, this is not me', 'Nein, das bin ich nicht') ?>
                                </button>
                            </div>
                            <?php }
                        if ($col == "teaching") {
                            if ($document['status'] == 'in progress' && new DateTime() > getDateTime($document['end'])) {

                                $approval_needed[] = array(
                                    'type' => 'teaching',
                                    'id' => $document['_id'],
                                    'title' => $document['title']
                                );
                            ?>
                                <div class='alert alert-signal' id="approve-<?= $col ?>-<?= $id ?>">
                                    <?= lang(
                                        "<b>Attention</b>: the Thesis of $document[name] has ended. Please confirm if the work has been successfully completed or not or extend the time frame.",
                                        "<b>Achtung</b>: die Abschlussarbeit von $document[name] ist zu Ende. Bitte bestätige den Erfolg/Misserfolg der Arbeit oder verlängere den Zeitraum."
                                    )  ?>
                                    <form action="update/teaching/<?= $id ?>" method="post" class="form-inline mt-5">
                                        <input type="hidden" class="hidden" name="redirect" value="<?= $_SERVER['REDIRECT_URL'] ?? $_SERVER['REQUEST_URI'] ?>">

                                        <label class="required" for="end"><?= lang('Ended at / Extend until', 'Geendet am / Verlängern bis') ?>:</label>
                                        <input type="date" class="form-control w-200" name="values[end]" id="date_end" value="<?= valueFromDateArray($document['end'] ?? '') ?>" required>
                                        <div>
                                            <div class="custom-radio d-inline">
                                                <input type="radio" name="values[status]" id="status-in-progress-<?= $id ?>" value="in progress" checked="checked">
                                                <label for="status-in-progress-<?= $id ?>"><?= lang('In progress', 'In Arbeit') ?></label>
                                            </div>

                                            <div class="custom-radio d-inline">
                                                <input type="radio" name="values[status]" id="status-completed-<?= $id ?>" value="completed">
                                                <label for="status-completed-<?= $id ?>"><?= lang('Completed', 'Abgeschlossen') ?></label>
                                            </div>

                                            <div class="custom-radio mr-10 d-inline">
                                                <input type="radio" name="values[status]" id="status-aborted-<?= $id ?>" value="aborted">
                                                <label for="status-aborted-<?= $id ?>"><?= lang('Aborted', 'Abgebrochen') ?></label>
                                            </div>
                                        </div>
                                        <button class="btn" type="submit"><?= lang('Submit', 'Bestätigen') ?></button>
                                    </form>
                                </div>
                <?php

                            }
                        }
                    }

                    echo "</td>";
                    // lom points
                    echo "<td class='lom' >$l[lom]</td>
                    <!-- data-toggle='tooltip' data-title='$l[points]'-->
                </tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="content mt-0">
            <?php if ($currentuser) { ?>
                <a href="<?= ROOTPATH ?>/<?= $col ?>" class="btn text-<?= $val['color'] ?>">
                    <i class="far fa-book-bookmark mr-5"></i> <?= lang('My ', 'Meine ') ?><?= $val['title'] ?>
                </a>
            <?php } ?>

            <?php if ($col == "publication") {
                $link = ROOTPATH . "/activities/new?type=".$col;
            // } else {
            //     $link = "#add-$col";
            } ?>

            <a href="<?= $link ?>" class="btn"><i class="fas fa-plus"></i></a>
        </div>

    </div>
    <!-- <div class="modal" id="add-<?= $col ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a data-dismiss="modal" class="close" role="button" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
                <h5 class="title"><?= lang('Add activity:', 'Aktivität hinzufügen:') ?> <?= $val['title'] ?></h5>
                <?php
                // include BASEPATH . "/components/form-$col.php"
                ?>

            </div>
        </div>
    </div> -->


<?php }
?>




<?php if ($currentuser) { ?>


    <div class="modal modal-lg" id="approve" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content w-400 mw-full">
                <a href="#" class="btn float-right" role="button" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
                <h5 class="modal-title"><?= lang('Approve', 'Freigeben') ?></h5>

                <?php
                if ($approved) {
                    echo "<p>" . lang('You have already approved the currently selected quarter.', 'Du hast das aktuelle Quartal bereits bestätigt.') . "</p>";
                } else if (!empty($approval_needed)) {
                    echo "<p>" . lang(
                        "The following activities need your confirmation before you can approve the current quarter. Please scroll through your feed and confirm/reject your activities.",
                        "Die folgenden Aktivitäten müssen von Ihnen bestätigt werden, bevor Sie das laufende Quartal freigeben können. Bitte scrollen Sie durch Ihren Feed und bestätigen/ablehnen Sie Ihre Aktivitäten."
                    ) . "</p>";
                    echo "<ul class='list'>";
                    foreach ($approval_needed as $item) {
                        $type = ucfirst($item['type']);
                        echo "<li><b>$type</b>: $item[title]</li>";
                    }
                    echo "</ul>";
                } else { ?>
                    <form action="<?= ROOTPATH ?>/approve" method="post">
                        <input type="hidden" class="hidden" name="redirect" value="<?= $_SERVER['REDIRECT_URL'] ?? $_SERVER['REQUEST_URI'] ?>">
                        <button class="btn"><?= lang('Approve', 'Freigeben') ?></button>
                    </form>
                <?php } ?>

            </div>
        </div>
    </div>
<?php } ?>

<script>
    $('#lom-points').html('<?= round($_lom) ?>');
</script>