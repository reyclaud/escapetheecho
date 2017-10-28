<?php
defined('_JEXEC') or die('Restricted access');

$countries = $this->model->getCountries();

//$allCountriesCode = $this->model->getAllCountryCode();
//$allRespondents = $this->model->countSelectedRespondents($allCountriesCode);

$totalResponders = $this->model->getTotalRespondents();
?>

<div class="content-wrapper">
    <h1 class="content-title"></h1>
    <form action="<?php echo JURI::current(); ?>" id="emailBuilderForm" method="post">
        <table class="content-table">
            <col width="150px">
            <col />
            <col />
            <col />
            <thead>
                <tr>
                    <th colspan="4">Backend - Add Link</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="table-label"><strong>URL:</strong></td>
                </tr>
                <tr>                    
                    <td colspan="4">
                        <input type="text" name="briefing_link" class="briefing-input-fields" placeholder="http://www.url.com" />
                        <div class="error-msg">*Wrong url format. Please include http:// or https://.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="table-label"><strong>Introduction:</strong></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <textarea name="briefing_introduction" class="briefing-input-fields"></textarea>
                        <div class="error-msg">*Introduction can't be empty. Please check.</div>
                    </td>
                </tr> 
                <tr>
                    <td colspan="4" class="table-label"><strong>Nationality:</strong></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="country-list-wrap">
                            <div class="category-title"></div>
                            <ul class="country-list country-list-options" id="country-list-options">
                                <?php foreach ($countries as $key => $country): ?>
                                    <li data-value="<?php echo $key; ?>"><i class="fa fa-plus-square-o" aria-hidden="true" onclick="briefingBuilder.selectCountry(this.parentElement, 'country-list-options')"></i><i class="fa fa-minus-square-o" aria-hidden="true" onclick="briefingBuilder.removedSelectedCountry(this.parentElement, 'selected-countries')"></i><?php echo $country; ?></li>
                                <?php endforeach; ?> 
                            </ul>
                        </div>
                        <div class="select-button-wrapper">
                            <button type="button" class="select-all-nationality" onclick="briefingBuilder.selectAllCountry()"><span>Select All >></span></button>
                            <button type="button" class="remove-all-nationality" onclick="briefingBuilder.removeAllSelectedCountry()"><span><< Remove All</span></button>
                        </div>
                        <div class="selected-country-list-wrap">
                            <div class="category-title"></div>
                            <ul class="country-list selected-countries" id="selected-countries"></ul>
                        </div>
                        <div class="clearer"></div>

                        <select name="nationality" class="country-select" multiple>
                            <?php foreach ($countries as $key => $country): ?>
                                <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                            <?php endforeach; ?> 
                        </select>

                        <div class="error-msg">*Please select at least one.</div>
                    </td>                        
                </tr>
                <tr>
                    <td colspan="4">
                        <button type="button" id="send-to-all"><span>Send to all</span></button>
                        <button type="button" id="send-to-matching"><span>Send to matching</span></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><button type="button" id="search-answer"><span>Search Answer</span></button></td>            
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center; ">ANSWERS - Total IDs <span class="answers-count">0</span> of [<?php echo count($totalResponders); ?>]</td>            
                </tr>
                <tr class="after-selections">                    
                    <td colspan="4"><button type="button" id="start-new-link" onclick="briefingBuilder.save();"><span>SAVE [start new link]</span></button></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

<input type="hidden" name="allresp" value="<?php echo intval($allRespondents); ?>" />