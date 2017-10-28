<?php
defined('_JEXEC') or die('Restricted access');

?>

<div class="briefing-link-wrapper">
    <div class="page-header-title">Attach link and Description to briefings</div>
    <div class="page-content">
        <div class="briefing-url-wrap"><label for="briefing-url">URL:</label><input type="text" id="briefing-url" /></div>
        <div class="briefing-description-wrap"><label for="briefing-description">Description:</label><textarea id="briefing-description" cols="100" rows="10"></textarea></div>
    </div>

    <div class="action-controls">
        <button type="button" class="next-button" title="Send to IDs (briefing sheets)" onclick="respondents.sendIds('briefing-url', 'briefing-description'); "><span>Send to IDs</span></button>
    </div>
</div>