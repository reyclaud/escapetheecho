<?php
defined('_JEXEC') or die('Restricted access');

$respondents = $this->respondents;
?>

<div class="total-bank-wrapper">
    <table class="total-banks-table">
        <thead>
            <tr><th colspan="3">Total bank of IDs for attachment</th></tr>
        </thead>
        <tbody>
            <?php
            foreach ($respondents as $respondent):
                if ($respondent->name) {
                    ?>
                    <tr>
                        <td><input type="hidden" name="respondent_id[]" value="<?php echo $respondent->id; ?>" /><?php echo $respondent->name; ?></td>
                        <td><?php echo $respondent->email; ?></td>
                        <td><a href="#" class="delete-from-bank" title="Delete ID from Bank">Delete</a></td>
                    </tr>
                    <?php
                }
            endforeach;
            ?>            
        </tbody>
    </table>

    <div class="action-controls">
        <button type="button" class="next-button" title="Next to Attach link and Description to Briefings" onclick="respondents.nextAttachLink()"><span>Next</span></button>
    </div>
</div>