<?php
defined('_JEXEC') or die('Restricted access');
$session = JFactory::getSession();
$respondents = $this->respondents;
?>

<div class="briefing-sheets-wrapper">
    <table class="total-banks-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Edit/Send</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($respondents as $respondent):
                if ($respondent->name) {
                    ?>
                    <tr>
                        <td><input type="hidden" name="respondent_id[]" value="<?php echo $respondent->id; ?>" /><?php echo $respondent->username; ?></td>
                        <td>Dear <strong><?php echo $respondent->name; ?></strong>, <br/><?php echo nl2br($session->get('br_description')); ?><br/><a href="<?php echo $session->get('br_url'); ?>"><?php echo $session->get('br_url'); ?></a></td>
                        <td><a href="#" class="delete-from-bank" title="Edit">Edit</a>/<a href="#" class="delete-from-bank" title="Send">Send</a></td>
                    </tr>
                    <?php
                }
            endforeach;
            ?>            
        </tbody>
    </table>

    <div class="action-controls">
        <button type="button" class="next-button" title="Send All" onclick=""><span>Send All</span></button>
    </div>
</div>