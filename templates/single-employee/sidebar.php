<?php
    $info = get_field('info');
    $position = $info['position'];
    $education = $info['education'];
    $date_string = $info['start_date'];
    $date = DateTime::createFromFormat('Ymd', $date_string);
    $office = $info['office'];

    $contact = get_field('contact');
    $email = $contact['email'];
    $phone = $contact['phone'];

    $social = get_field('social');
    $linkedin = $social['linkedin'];
?>

<div class="sidebar copy-2">
    <?php if($position): ?>
        <div class="vital position">
            <h4>Current Role</h4>
            <p><?php echo $position; ?></p>
        </div>
    <?php endif; ?>

    <?php if($education): ?>
        <div class="vital education">
            <h4>Education</h4>
            <p><?php echo $education; ?></p>
        </div>
    <?php endif; ?>

    <?php if($date_string): ?>
        <div class="vital tenure">
            <h4>Employee-Owner Since</h4>
            <p><?php echo $date->format('Y'); ?></p>
        </div>
    <?php endif; ?>

</div>