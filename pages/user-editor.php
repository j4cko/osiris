<h1>
    <i class="fad fa-user-graduate"></i>
    <?= $data['name'] ?>
</h1>
<!-- 
<?php
dump($data, true);
?> -->


<form action="<?= ROOTPATH ?>/update-user/<?= $data['_id'] ?>" method="post">
    <input type="hidden" class="hidden" name="redirect" value="<?= $url ?? $_SERVER['REDIRECT_URL'] ?? $_SERVER['REQUEST_URI'] ?>">

    <p>
        <b>Username:</b> <?= $data['username'] ?? '' ?>
    </p>

    <div class="form-row row-eq-spacing-sm">
        <div class="col-sm-2">
            <label for="academic_title">Title</label>
            <select name="values[academic_title]" id="academic_title" class="form-control">
                <option value="" <?= $data['academic_title'] == '' ? 'selected' : '' ?>></option>
                <option value="Dr." <?= $data['academic_title'] == 'Dr.' ? 'selected' : '' ?>>Dr.</option>
                <option value="Prof. Dr." <?= $data['academic_title'] == 'Prof. Dr.' ? 'selected' : '' ?>>Prof. Dr.</option>
                <option value="PD Dr." <?= $data['academic_title'] == 'PD Dr.' ? 'selected' : '' ?>>PD Dr.</option>
                <option value="Prof." <?= $data['academic_title'] == 'Prof.' ? 'selected' : '' ?>>Prof.</option>
                <option value="PD" <?= $data['academic_title'] == 'PD' ? 'selected' : '' ?>>PD</option>
                <!-- <option value="Prof. Dr." <?= $data['academic_title'] == 'Prof. Dr.' ? 'selected' : '' ?>>Prof. Dr.</option> -->
            </select>
        </div>
        <div class="col-sm">
            <label for="first"><?= lang('First name', 'Vorname') ?></label>
            <input type="text" name="values[first]" id="first" class="form-control" value="<?= $data['first'] ?? '' ?>">
        </div>
        <div class="col-sm">
            <label for="last"><?= lang('Last name', 'Nachname') ?></label>
            <input type="text" name="values[last]" id="last" class="form-control" value="<?= $data['last'] ?? '' ?>">
        </div>
    </div>

    <div class="form-group">
        <span><?= lang('Gender', 'Geschlecht') ?>:</span>
        <?php
        $gender = $data['gender'] ?? 'n';
        ?>

        <div class="custom-radio d-inline-block ml-10">
            <input type="radio" name="values[gender]" id="gender-m" value="m" <?= $gender == 'm' ? 'checked' : '' ?>>
            <label for="gender-m"><?= lang('Male', 'Männlich') ?></label>
        </div>
        <div class="custom-radio d-inline-block ml-10">
            <input type="radio" name="values[gender]" id="gender-f" value="f" <?= $gender == 'f' ? 'checked' : '' ?>>
            <label for="gender-f"><?= lang('Female', 'Weiblich') ?></label>
        </div>
        <div class="custom-radio d-inline-block ml-10">
            <input type="radio" name="values[gender]" id="gender-d" value="d" <?= $gender == 'd' ? 'checked' : '' ?>>
            <label for="gender-d"><?= lang('Non-binary', 'Divers') ?></label>
        </div>
        <div class="custom-radio d-inline-block ml-10">
            <input type="radio" name="values[gender]" id="gender-n" value="n" <?= $gender == 'n' ? 'checked' : '' ?>>
            <label for="gender-n"><?= lang('Not specified', 'Nicht angegeben') ?></label>
        </div>

    </div>
    <div class="form-row row-eq-spacing-sm">
        <div class="col-sm">
            <label for="dept"><?= lang('Department', 'Abteilung') ?></label>
            <select name="values[dept]" id="dept" class="form-control">
                <option value="">Unknown</option>
                <?php
                foreach (deptInfo() as $d => $dept) { ?>
                    <option value="<?= $d ?>" <?= $data['dept'] == $d ? 'selected' : '' ?>><?= $dept['name'] != $d ? "$d: " : '' ?><?= $dept['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm">
            <label for="telephone"><?= lang('Telephone', 'Telefon') ?></label>
            <input type="text" name="values[telephone]" id="telephone" class="form-control" value="<?= $data['telephone'] ?? '' ?>">
        </div>
        <div class="col-sm">
            <label for="mail">Mail</label>
            <input type="text" name="values[mail]" id="mail" class="form-control" value="<?= $data['mail'] ?? '' ?>">
        </div>

    </div>

    <div class="form-row row-eq-spacing-sm">

        <div class="col-sm">
            <label for="orcid">ORCID</label>
            <input type="text" name="values[orcid]" id="orcid" class="form-control" value="<?= $data['orcid'] ?? '' ?>">
        </div>
        <div class="col-sm">
            <label for="twitter">Twitter</label>
            <input type="text" name="values[twitter]" id="twitter" class="form-control" value="<?= $data['twitter'] ?? '' ?>">
        </div>
    </div>

    <div class="form-row row-eq-spacing-sm">

        <div class="col-sm">
            <label for="researchgate">ResearchGate Handle</label>
            <input type="text" name="values[researchgate]" id="researchgate" class="form-control" value="<?= $data['researchgate'] ?? '' ?>">
        </div>
        <div class="col-sm">
            <label for="google_scholar">Google Scholar ID</label>
            <input type="text" name="values[google_scholar]" id="google_scholar" class="form-control" value="<?= $data['google_scholar'] ?? '' ?>">
        </div>
        <div class="col-sm">
            <label for="webpage">Personal web page</label>
            <input type="text" name="values[webpage]" id="webpage" class="form-control" value="<?= $data['webpage'] ?? '' ?>">
        </div>
    </div>
    <div>

        <div class="form-group custom-checkbox d-inline-block ml-10">
            <input type="checkbox" id="is_active" value="1" name="values[is_active]" <?= ($data['is_active'] ?? false) ? 'checked' : '' ?>>
            <label for="is_active">Is Active</label>
        </div>
        <div class="form-group custom-checkbox d-inline-block ml-10">
            <input type="checkbox" id="is_scientist" value="1" name="values[is_scientist]" <?= ($data['is_scientist'] ?? false) ? 'checked' : '' ?>>
            <label for="is_scientist">Is Scientist</label>
        </div>


        <div class="form-group custom-checkbox d-inline-block ml-10">
            <input type="checkbox" id="is_controlling" value="1" name="values[is_controlling]" <?= ($data['is_controlling'] ?? false) ? 'checked' : '' ?> <?= ($USER['is_admin'] || $USER['is_controlling']) ? '' : 'disabled' ?>>
            <label for="is_controlling">Is Controlling</label>
        </div>

        <div class="form-group custom-checkbox d-inline-block ml-10">
            <input type="checkbox" id="is_leader" value="1" name="values[is_leader]" <?= ($data['is_leader'] ?? false) ? 'checked' : '' ?> <?= ($USER['is_admin'] || $USER['is_controlling']) ? '' : 'disabled' ?>>
            <label for="is_leader">Is Leader</label>
        </div>

    </div>

    <?php if ($data['username'] == $_SESSION['username']) { ?>

        <div class="alert alert-signal mb-20">
            <div class="title">
                <?= lang('Profile preferences', 'Profil-Einstellungen') ?>
            </div>

            <div class="mt-10">
                <span><?= lang('Activity display', 'Aktivitäten-Anzeige') ?>:</span>
                <?php
                $display_activities = $data['display_activities'] ?? 'web';
                ?>

                <div class="custom-radio d-inline-block ml-10">
                    <input type="radio" name="values[display_activities]" id="display_activities-web" value="web" <?= $display_activities == 'web'? 'checked' : '' ?>>
                    <label for="display_activities-web"><?= lang('Web') ?></label>
                </div>
                <div class="custom-radio d-inline-block ml-10">
                    <input type="radio" name="values[display_activities]" id="display_activities-print" value="print" <?= $display_activities != 'web' ? 'checked' : '' ?>>
                    <label for="display_activities-print"><?= lang('Print', 'Druck') ?></label>
                </div>
            </div>



            <div class="mt-10">
                <span><?= lang('Show coins', 'Zeige Coins') ?>:</span>
                <?php
                $hide_coins = $data['hide_coins'] ?? false;
                ?>

                <div class="custom-radio d-inline-block ml-10">
                    <input type="radio" name="values[hide_coins]" id="hide_coins-false" value="false" <?= $hide_coins ? '' : 'checked' ?>>
                    <label for="hide_coins-false"><?= lang('Yes', 'Ja') ?></label>
                </div>
                <div class="custom-radio d-inline-block ml-10">
                    <input type="radio" name="values[hide_coins]" id="hide_coins-true" value="true" <?= $hide_coins ? 'checked' : '' ?>>
                    <label for="hide_coins-true"><?= lang('No', 'Nein') ?></label>
                </div>
            </div>


            <div class="mt-10">
                <span><?= lang('Show achievements', 'Zeige Errungenschaften') ?>:</span>
                <?php
                $hide_achievements = $data['hide_achievements'] ?? false;
                ?>

                <div class="custom-radio d-inline-block ml-10">
                    <input type="radio" name="values[hide_achievements]" id="hide_achievements-false" value="false" <?= $hide_achievements ? '' : 'checked' ?>>
                    <label for="hide_achievements-false"><?= lang('Yes', 'Ja') ?></label>
                </div>
                <div class="custom-radio d-inline-block ml-10">
                    <input type="radio" name="values[hide_achievements]" id="hide_achievements-true" value="true" <?= $hide_achievements ? 'checked' : '' ?>>
                    <label for="hide_achievements-true"><?= lang('No', 'Nein') ?></label>
                </div>
            </div>
        </div>
    <?php } ?>


    <button type="submit" class="btn btn-primary">
        Update
    </button>
</form>