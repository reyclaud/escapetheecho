<?php
defined('_JEXEC') or die('Restricted access');
?>

<div class="briefing-builder-wrap content-wrapper">
    <div class="briefing-builder-part1-wrap">
        <table class="briefing-part1-tbl">
            <thead>
                <tr>
                    <th colspan="2">Backend - Briefing Builder</th>
                </tr>
            </thead>
            <tr>
                <td>Form</td>
                <td>
                    <select name="briefing_form" id="briefing_form" onchange="briefingForm.loadForm(this.value);">
                        <option value="0">- Select a Form -</option>
                        <?php foreach ($this->briefingForms as $form): ?>
                            <option value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>IPs</td>                
                <td>
                    <select name="nationality" class="country-select" multiple>
                        <option value="AF">Afghanistan</option>
                        <option value="AX">Aland Islands</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AQ">Antarctica</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia, Plurinational State of</option>
                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BV">Bouvet Island</option>
                        <option value="BR">Brazil</option>
                        <option value="IO">British Indian Ocean Territory</option>
                        <option value="BN">Brunei Darussalam</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CX">Christmas Island</option>
                        <option value="CC">Cocos (Keeling) Islands</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CG">Congo</option>
                        <option value="CD">Congo, the Democratic Republic of the</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="CI">Côte d'Ivoire</option>
                        <option value="HR">Croatia</option>
                        <option value="CU">Cuba</option>
                        <option value="CW">Curaçao</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands (Malvinas)</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="TF">French Southern Territories</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GG">Guernsey</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea-Bissau</option>
                        <option value="GY">Guyana</option>
                        <option value="HT">Haiti</option>
                        <option value="HM">Heard Island and McDonald Islands</option>
                        <option value="VA">Holy See (Vatican City State)</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IR">Iran, Islamic Republic of</option>
                        <option value="IQ">Iraq</option>
                        <option value="IE">Ireland</option>
                        <option value="IM">Isle of Man</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JE">Jersey</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KP">Korea, Democratic People's Republic of</option>
                        <option value="KR">Korea, Republic of</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Lao People's Democratic Republic</option>
                        <option value="LV">Latvia</option>
                        <option value="LB">Lebanon</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libya</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MO">Macao</option>
                        <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia, Federated States of</option>
                        <option value="MD">Moldova, Republic of</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolia</option>
                        <option value="ME">Montenegro</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="MP">Northern Mariana Islands</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palau</option>
                        <option value="PS">Palestinian Territory, Occupied</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PN">Pitcairn</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="QA">Qatar</option>
                        <option value="RE">Reunion</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russian Federation</option>
                        <option value="RW">Rwanda</option>
                        <option value="BL">Saint Barthelemy</option>
                        <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                        <option value="KN">Saint Kitts and Nevis</option>
                        <option value="LC">Saint Lucia</option>
                        <option value="MF">Saint Martin (French part)</option>
                        <option value="PM">Saint Pierre and Miquelon</option>
                        <option value="VC">Saint Vincent and the Grenadines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">Sao Tome and Principe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="RS">Serbia</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SX">Sint Maarten (Dutch part)</option>
                        <option value="SK">Slovakia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                        <option value="SS">South Sudan</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SD">Sudan</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard and Jan Mayen</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="SY">Syrian Arab Republic</option>
                        <option value="TW">Taiwan, Province of China</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania, United Republic of</option>
                        <option value="TH">Thailand</option>
                        <option value="TL">Timor-Leste</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option value="US">United States</option>
                        <option value="UM">United States Minor Outlying Islands</option>
                        <option value="UY">Uruguay</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                        <option value="VN">Vietnam</option>
                        <option value="VG">Virgin Islands, British</option>
                        <option value="VI">Virgin Islands, U.S.</option>
                        <option value="WF">Wallis and Futuna</option>
                        <option value="EH">Western Sahara</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                        <option value="ZW">Zimbabwe</option>
                    </select>
                    <div class="error-msg">*Please select at least one.</div>
                </td>                
            </tr>
            <tr>
                <td>TITLE</td>
                <td>
                    <input type="text" placeholder="[Text here ...]" name="briefing-title" value="" />
                    <div class="error-msg">*Title can't be empty.</div>
                </td>
            </tr>
            <tr>
                <td>INTRO</td>
                <td>
                    <textarea type="text" placeholder="[Text here ...]" name="briefing-intro" class="briefing-input-fields"></textarea>
                    <div class="error-msg">*Intro can't be empty.</div>
                </td>
            </tr>
            <tr>
                <td>SIGN OFF</td>
                <td>
                    <input type="text" placeholder="[Text here ...]" name="briefing-sign-off" value="" />
                    <div class="error-msg">*Sign off can't be empty.</div>
                </td>
            </tr>
            <tr>
                <td class="align-center" colspan="2">
                    <button type="button" id="briefing-form-save" class="briefings-save" onclick="briefingForm.save();"><span>Save</span></button>
                    <button type="button" id="briefing-form-edit" class="briefings-edit"><span>Edit</span></button>
                    <input type="hidden" name="form_id" value="0" />
                </td>
            </tr>
            <tr>
                <td colspan="2" class="align-center"><button type="button" class="briefings-add-new-form" onclick="briefingForm.addNew();"><span>Add New Form</span></button></td>                
            </tr>
        </table>
    </div>
    <div class="briefing-builder-part2-wrap">
        <table class="briefing-part1-tb2">
            <col />
            <col />
            <col width="60px" />
            <col width="140px" />
            <thead>
                <tr>
                    <th>IDs (100)</th>
                    <th>Message</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <?php
            foreach ($this->LinkReviews as $link) {
                $respondents = explode(",", $link->respondents);
                ?>
                <tr>
                    <td>                        
                        <?php
                        $_usernames = array();

                        foreach ($respondents as $_respondent):
                            $_respondents = explode("|", $_respondent);

                            if (isset($_respondents[1]) && trim($_respondents[1]) != '') {
                                foreach (explode(";", $_respondents[1]) as $key => $respondent_) {
                                    $user = JFactory::getUser($respondent_);

                                    if (!in_array($user->name, $_usernames)) {
                                        array_push($_usernames, $user->name);

                                        echo '<p>' . $user->name . '</p>';
                                    }
                                }
                            }
                        endforeach;
                        ?>
                    </td>
                    <td>
                        {SignOff},<br/>
                        <p id="briefing_intro_<?php echo $link->id; ?>"><?php echo $link->intro; ?></p>
                        <p id="briefing_url_<?php echo $link->id; ?>"><?php echo $link->url; ?></p>
                    </td>
                    <td><a href="?briefing=<?php echo $link->id; ?>" onclick="briefingForm.editBriefing(event, '<?php echo $link->id; ?>')">Edit</a></td>
                    <td><a href="#" class="briefing-send-to-archive" onclick="briefingForm.sendToArchive(event, '<?php echo $link->id; ?>');">Send to Archive</a></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" class="align-center"><button type="button" class="briefings-send-all" onclick="briefingForm.sendAll()"><span>Send All</span></button></td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        briefingForm = {
            sendToArchive: function(event, bid){
                event.preventDefault();
            },
            save: function () {

                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        ips: jQuery("select[name=nationality]").val(),
                        title: jQuery("input[name=briefing-title]").val(),
                        intro: jQuery("textarea[name=briefing-intro]").val(),
                        signoff: jQuery("input[name=briefing-sign-off]").val(),
                        fid: jQuery("input[name=form_id]").val(),
                        task: 'backend.saveBriefing'
                    },
                    type: "post",
                    beforeSend: function () {

                        var hasErrors = false;

                        if (jQuery("textarea[name=briefing-intro]").val() == '') {
                            jQuery("textarea[name=briefing-intro]").siblings("div.error-msg").slideDown("fast");
                            jQuery("textarea[name=briefing-intro]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("textarea[name=briefing-intro]").siblings("div.error-msg").slideUp("fast");
                        }

                        console.log(jQuery("select[name=nationality]").val());

                        if (jQuery("select[name=nationality]").val() == '' || jQuery("select[name=nationality]").val() == null) {
                            jQuery("select[name=nationality]").siblings("div.error-msg").slideDown("fast");
                            jQuery("select[name=nationality]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("select[name=nationality]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("input[name=briefing-title]").val() == '') {
                            jQuery("input[name=briefing-title]").siblings("div.error-msg").slideDown("fast");
//                            jQuery("input[name=briefing-title]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("textarea[name=briefing-title]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("input[name=briefing-sign-off]").val() == '') {
                            jQuery("input[name=briefing-sign-off]").siblings("div.error-msg").slideDown("fast");
//                            jQuery("input[name=briefing-sign-off]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("textarea[name=briefing-sign-off]").siblings("div.error-msg").slideUp("fast");
                        }

                        return !hasErrors;


                    },
                    success: function (resp) {
                        if (resp == 1) {
                            alert("Briefing form saved successfully!");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                    }
                });
            },
            addNew: function () {
                jQuery("select[name=nationality]").val('');
                jQuery("input[name=briefing-title]").val('');
                jQuery("textarea[name=briefing-intro]").val('');
                jQuery("input[name=briefing-sign-off]").val('');
            },
            editBriefing: function (event, bid) {
                event.preventDefault();

                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        bid: bid,
                        task: 'backend.getBriefingDetails'
                    },
                    type: "post",
                    beforeSend: function () {
                        briefingForm.overlay();
                    },
                    success: function (resp) {
                        jQuery("#overlay-content-wrap").html('');
                        jQuery("#overlay-content-wrap").append('<div class=\"close-overlay\" onclick=\"briefingForm.closeOverlay();\">[x]close</div>');
                        jQuery("#overlay-content-wrap").append(resp);
                    }
                });
            },
            overlay: function () {
                if (jQuery("#overlay-bg").length < 1) {
                    jQuery("body").append("<div id=\"overlay-bg\" />");
                    jQuery("body").append("<div id=\"overlay-content-wrap\" class=\"overlay-edit-content\" />");
                } else {
                    jQuery("#overlay-bg").fadeIn("fast");
                    jQuery("#overlay-content-wrap").fadeIn("fast");
                }
            },
            closeOverlay: function () {
                jQuery("#overlay-content-wrap").fadeOut("fast");
                jQuery("#overlay-bg").fadeOut("fast");
            },
            loadForm: function (fid) {

                if (fid < 1) {
                    jQuery("select[name=nationality]").children("option").attr("selected", false);
                    jQuery("input[name=\"briefing-title\"]").val('');
                    jQuery("textarea[name=\"briefing-intro\"]").val('');
                    jQuery("input[name=\"briefing-sign-off\"]").val('');
                    jQuery("input[name=\"form_id\"]").val(0);
                } else {
                    jQuery.ajax({
                        url: "<?php echo JURI::current(); ?>",
                        data: {
                            fid: fid,
                            task: 'backend.getFormDetails'
                        },
                        type: "post",
                        dataType: "json",
                        beforeSend: function () {},
                        success: function (resp) {
                            var ips = resp.ipaddress;
                            var _ips = [];

                            jQuery.each(ips, function (index, value) {
                                jQuery("select[name=nationality]").children("option[value=" + value + "]").attr("selected", true);
                            });

                            jQuery("input[name=\"briefing-title\"]").val(resp.title);
                            jQuery("textarea[name=\"briefing-intro\"]").val(resp.intro);
                            jQuery("input[name=\"briefing-sign-off\"]").val(resp.signoff);
                            jQuery("input[name=\"form_id\"]").val(resp.id);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                        }
                    });
                }

            },
            sendAll: function () {
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {                        
                        task: 'backend.sendAll'
                    },
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {},
                    success: function (resp) {
                        
                        jQuery("table.briefing-part1-tb2").find("tbody tr").not("tbody tr:last-child").remove();                        
                        jQuery("table.briefing-part1-tb2").find("tbody tr:last-child").slideUp("fast");                        
                        
                        alert('Successfully sent to All!');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }
        };
    });
</script>