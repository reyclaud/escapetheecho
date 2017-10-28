<?php

defined('_JEXEC') or die('Restricted access');

class EteModelBackend extends JModelItem {

    protected $quizId;
    protected $questionName;

    public function __construct() {
        parent::__construct();

        $this->quizId = JRequest::getVar('quizId');
    }

    public function getForm() {

        if (!$this->quizId && JRequest::getVar('quizId')) {
            $this->quizId = JRequest::getVar('quizId');
        }

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__rsform_forms');
        $query->where($db->quoteName('FormId') . ' = ' . $this->quizId);
        $db->setQuery((string) $query);

        $form = $db->loadObject();

        return $form;
    }

    public function getSubmissions() {

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
//        $query->select('*, COUNT(`FieldName`) as times');
        $query->select('*');
        $query->from('#__rsform_submission_values');
        $query->where($db->quoteName('FormId') . ' = ' . $this->quizId);
//        $query->order($db->quoteName('FieldName') . ' ASC');
        $query->group($db->quoteName('FieldName'));
        $db->setQuery((string) $query);

        $selections = $db->loadObjectList();

        return $selections;
    }

    public function getSubmissionsIp() {

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('UserIp, UserId');
        $query->from('#__rsform_submissions');
        $db->setQuery((string) $query);

        $user_ips = $db->loadObjectList();

        return $user_ips;
    }

    private function _getSubmissions() {

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('a.*, b.Username, b.UserId');
        $query->from('#__rsform_submission_values AS a');
        $query->join('LEFT', '#__rsform_submissions AS b ON b.SubmissionId = a.SubmissionId');
        $query->where($db->quoteName('a.FormId') . ' = ' . $this->quizId);
        $query->order($db->quoteName('FieldName') . ' ASC');
        $db->setQuery((string) $query);

        $selections = $db->loadObjectList();

        return $selections;
    }

    private function getSubmissions_() {

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('a.*, b.Username, b.UserId');
        $query->from('#__rsform_submission_values AS a');
        $query->join('LEFT', '#__rsform_submissions AS b ON b.SubmissionId = a.SubmissionId');
        $query->order($db->quoteName('FieldName') . ' ASC');
        $db->setQuery((string) $query);

        $selections = $db->loadObjectList();

        return $selections;
    }

    public function _getQuestionName() {
        return JRequest::getVar('question');
    }

    public function _getQuestionSubmissions() {

        $this->questionName = JRequest::getVar('question');

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('a.*, b.Username, b.UserId');
        $query->from('#__rsform_submission_values AS a');
        $query->join('LEFT', '#__rsform_submissions AS b ON b.SubmissionId = a.SubmissionId');
        $query->where($db->quoteName('a.FormId') . ' = ' . $this->quizId . ' AND ' . 'a.FieldName' . ' = ' . $db->quote($this->questionName));
        $query->order($db->quoteName('FieldName') . ' ASC');
        $db->setQuery((string) $query);

        $selections = $db->loadObjectList();

        return $selections;
    }

    public function getSubmissionAnswers() {

        $fieldNames = array();
        $submissions = $this->_getSubmissions();

        foreach ($submissions as $submission) {
            foreach (explode("\n", $submission->FieldValue) as $value) {
                if (isset($fieldNames[trim($submission->FieldName)][$value])) {
                    $fieldNames[trim($submission->FieldName)][$value] += 1;
                    $fieldNames['username'][trim($submission->FieldName)][$value][] = $submission->Username;
                    $fieldNames['userid'][trim($submission->FieldName)][$value][] = $submission->UserId;
                } else {
                    $fieldNames['userid'][trim($submission->FieldName)][$value][] = $submission->UserId;
                    $fieldNames['username'][trim($submission->FieldName)][$value][] = $submission->Username;
                    $fieldNames[trim($submission->FieldName)][$value] = 1;
                }
            }
        }

        return $fieldNames;
    }

    public function getQuestionAnswers() {

        $fieldNames = array();
//        $submissions = $this->_getQuestionSubmissions();
        $submissions = $this->_getSubmissions();

        foreach ($submissions as $submission) {
            foreach (explode("\n", $submission->FieldValue) as $value) {
                if (isset($fieldNames[trim($submission->FieldName)][$value])) {
                    $fieldNames[trim($submission->FieldName)][$value] += 1;
                    $fieldNames['username'][trim($submission->FieldName)][$value][] = $submission->Username;
                    $fieldNames['userid'][trim($submission->FieldName)][$value][] = $submission->UserId;
                } else {
                    $fieldNames['username'][trim($submission->FieldName)][$value][] = $submission->Username;
                    $fieldNames['userid'][trim($submission->FieldName)][$value][] = $submission->UserId;
                    $fieldNames[trim($submission->FieldName)][$value] = 1;
                }
            }
        }

        return $fieldNames;
    }

    public function getQuestionAnswer($fieldname) {

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('#__rsform_submission_values AS a');
//        $query->join('LEFT', '#__rsform_submissions AS b ON b.SubmissionId = a.SubmissionId');
        $query->where('TRIM(LOWER(' . $db->quoteName('a.FieldName') . '))' . " = '" . strtolower($fieldname) . "'");
//        $query->order($db->quoteName('FieldName') . ' ASC');
        $db->setQuery((string) $query);

        $selections = $db->loadObjectList();

        return $selections;
    }

    public function getFormProperties() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('ComponentId, PropertyName, PropertyValue');
        $query->from('#__rsform_properties');
        $query->where($db->quoteName('ComponentId') . ' IN (' . implode(',', $this->getFormComponentIds()) . ')');
        $query->order('ComponentId ASC');
        $db->setQuery((string) $query);

        $properties = $db->loadObjectList();

        $_properties = array();
        $_propertiesArr = array();

        foreach ($properties as $property) {
            $_properties[$property->ComponentId][$property->PropertyName] = $property->PropertyValue;
        }

        foreach ($properties as $_property) {
            if ($_property->PropertyName === 'NAME') {
                $_propertiesArr[trim($_property->PropertyValue)] = $_properties[$_property->ComponentId];
            }
        }

        return $_propertiesArr;
    }

    private function getFormComponents() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__rsform_components');
        $query->where($db->quoteName('published') . ' = ' . 1 . ' AND ' . $db->quoteName('FormId') . ' = ' . $this->quizId);
        $query->order($db->quoteName('Order') . ' ASC');

        $db->setQuery((string) $query);

        $components = $db->loadObjectList();

        return $components;
    }

    private function getFormComponentIds() {
        $componentIds = array();
        $components = $this->getFormComponents();

        foreach ($components as $component) {
            array_push($componentIds, $component->ComponentId);
        }

        return $componentIds;
    }

    public function getRespondents() {
        $session = JFactory::getSession();
        $jinput = JFactory::getApplication()->input;

        if ($jinput->post->get('br_url', null, 'raw')) {
            $session->set('br_url', $jinput->post->get('br_url', null, 'raw'));
        }

        if ($jinput->post->get('br_description', null, 'raw')) {
            $session->set('br_description', $jinput->post->get('br_description', null, 'raw'));
        }

        if ($jinput->post->get('ids', array(), 'raw')) {
            $ids = json_decode($jinput->post->get('ids', array(), 'raw'), true);

            $session->set('ids', $ids);
            $respondents = array();

            foreach ($ids as $username) {
                $respondents[] = JFactory::getUser($username);
            }
        } else {
            $respondents = array();

            foreach ($session->get('ids') as $username) {
                $respondents[] = JFactory::getUser($username);
            }
        }

        return $respondents;
    }

    public function getLinkReviews() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings');
        $query->where($db->quoteName('respondents') . ' !=  ""');
        $query->order($db->quoteName('id') . ' ASC');

        $db->setQuery((string) $query);

        $links = $db->loadObjectList();

        return $links;
    }

    public function getArchives() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings');
        $query->where($db->quoteName('respondents') . ' !=  ""');
        $query->order($db->quoteName('id') . ' ASC');

        $db->setQuery((string) $query);

        $links = $db->loadObjectList();

        return $links;
    }

    public function getLinkReview($bid=null) {
        if($bid){
            $id = $bid;
        }else{
            $id = JRequest::getVar('bid', null);
            
        }

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings');
        $query->where($db->quoteName('respondents') . ' !=  "" AND `id` = "' . $id . '"');

        $db->setQuery((string) $query);

        $links = $db->loadObject();

        return $links;
    }

    public function _getBriefing() {
        $id = JRequest::getVar('bid', null);

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings');
        $query->where($db->quoteName('respondents') . ' !=  "" AND `id` = "' . $id . '"');

        $db->setQuery((string) $query);

        $briefing = $db->loadObject();

        return $briefing;
    }

    public function getBriefingForms() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings_form');

        $db->setQuery((string) $query);

        $briefingForms = $db->loadObjectList();

        return $briefingForms;
    }

    public function getBriefingFormDetails($bid) {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings_form');
        $query->where($db->quoteName('id') . ' = ' . $bid);

        $db->setQuery((string) $query);

        $briefingForms = $db->loadObject();

        return $briefingForms;
    }

    public function getTotalRegisteredUsers() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('COUNT(a.`id`)');
        $query->from($db->quoteName('#__users', 'a'));
        $query->join('LEFT', $db->quoteName('#__user_usergroup_map', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.user_id') . ')');
        $query->where($db->quoteName('b.group_id') . ' !=  "8"');

        $db->setQuery((string) $query);

        $userCount = $db->loadResult();

        return $userCount;
    }

    public function getTotalRespondents() {
        $respondents = array();

        foreach ($this->getSubmissions_() as $respondent) {
            if ($respondent->UserId) {
                $respondents[$respondent->UserId] = $respondent->Username;
            }
        }

        return $respondents;
    }

    public function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }


        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );

        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "country" => @$ipdat->geoplugin_countryName,
                            "country_code" => @$ipdat->geoplugin_countryCode,
                            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }

        return $output;
    }

    public function getCountries() {
        $country_array = array(
            "AF" => "Afghanistan",
            "AX" => "Aland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "BQ" => "British Antarctic Territory",
            "IO" => "British Indian Ocean Territory",
            "VG" => "British Virgin Islands",
            "BN" => "Brunei",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CT" => "Canton and Enderbury Islands",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos [Keeling] Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo - Brazzaville",
            "CD" => "Congo - Kinshasa",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "CI" => "Cote d'Ivoire",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "NQ" => "Dronning Maud Land",
            "DD" => "East Germany",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "FQ" => "French Southern and Antarctic Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and McDonald Islands",
            "HN" => "Honduras",
            "HK" => "Hong Kong SAR China",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JT" => "Johnston Island",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Laos",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau SAR China",
            "MK" => "Macedonia",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "FX" => "Metropolitan France",
            "MX" => "Mexico",
            "FM" => "Micronesia",
            "MI" => "Midway Islands",
            "MD" => "Moldova",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar [Burma]",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NT" => "Neutral Zone",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "KP" => "North Korea",
            "VD" => "North Vietnam",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PC" => "Pacific Islands Trust Territory",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territories",
            "PA" => "Panama",
            "PZ" => "Panama Canal Zone",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "YD" => "People's Democratic Republic of Yemen",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn Islands",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RO" => "Romania",
            "RU" => "Russia",
            "RW" => "Rwanda",
            "RE" => "Reunion",
            "BL" => "Saint Barthelemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "KR" => "South Korea",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syria",
            "ST" => "Sao Tome and Príncipe",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UM" => "U.S. Minor Outlying Islands",
            "PU" => "U.S. Miscellaneous Pacific Islands",
            "VI" => "U.S. Virgin Islands",
            "UG" => "Uganda",
            "UA" => "Ukraine",
//            "SU" => "Union of Soviet Socialist Republics",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "ZZ" => "Unknown or Invalid Region",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VA" => "Vatican City",
            "VE" => "Venezuela",
            "VN" => "Vietnam",
            "WK" => "Wake Island",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        );

        return $country_array;
    }

    public function getAllCountryCode() {
        $ccodes = array();

        foreach ($this->getCountries() as $key => $country) {
            array_push($ccodes, $key);
        }

        return $ccodes;
    }

    public function getCountryNameByCode($codes) {
        $names = array();                

        foreach ($this->getCountries() as $key => $country) {
            if (in_array($key, $codes)) {
                array_push($names, $country);
            }
        }

        return $names;
    }
    
    public function getSelectedCountries($briefing_id) {
        
        $selected_countries = $this->getLinkReview($briefing_id);
        
        $countries = unserialize($selected_countries->countries);
        
        $names = array();                

        foreach ($countries as $key => $country) {
            if (in_array($key, $codes)) {
                array_push($names, $country);
            }
        }

        return $names;
    }

    public function countSelectedRespondents($country_code) {
        $count = 0;

//        foreach ($countries as $country_code) {            
        $_ips = $this->getSubmissionsIp();
        $ips = array();

        foreach ($_ips as $ip) {
            $ccode = $this->getIpInfo($ip->UserIp);

            if (in_array(strtolower($ccode), array_map('strtolower', $country_code)) && !isset($ips[$ip->UserIp])) {
                $ips[$ip->UserIp] = $ccode;

                $count++;
            }
        }
//        }                

        return count($ips);
    }

    public function getBriefingRespondents() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('ip_address');
        $query->from('#__briefings_form');
        $query->where($db->quoteName('ip_address') . ' !=  ""');
        $db->setQuery((string) $query);
        $respondents = $db->loadRowList();

        $resp = array();

        foreach ($respondents[0] as $_respondent) {
            $respondent_ = unserialize($_respondent);
            $resp = array_merge($resp, $respondent_);
        }

        return $resp;
    }

    public function getIpInfo($ip) {
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        return $details->country;
    }

    public function getEmailContent($bid, $respondents) {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings_form');
        $query->where($db->quoteName('id') . ' = ' . $bid);
        $db->setQuery((string) $query);
        $briefing = $db->loadObject();

        $_query = $db->getQuery(true);
        $_query->select('*');
        $_query->from('#__briefings');
//        $_query->where($db->quoteName('id') . ' = 42');
        $db->setQuery((string) $_query);
        $briefings = $db->loadObjectList();



        foreach ($respondents as $respondent) {

            $html = "";
            $html .= '<strong>' . str_replace('*', $respondent['name'], $briefing->intro) . '</strong>' . '<br/><br/>';

            foreach ($briefings as $_briefing) {
                $html .= $_briefing->intro . '<br/><br/>';
                $html .= $_briefing->url . '<br/><br/>';
            }

            $html .= '<br/><br/><br/><br/>' . str_replace('*', $respondent['name'], $briefing->signoff);

            $subject = str_replace('*', $respondent['name'], $briefing->title);
            $from = array("noreply@escapetheecho.com", "EscapeTheEcho");

            $mailer = JFactory::getMailer();
            $mailer->setSender($from);
            $mailer->addRecipient($respondent['email']);
            $mailer->setSubject($subject);
            $mailer->setBody($html);
            $mailer->isHTML();
            $mailer->send();
        }

        return 1;
    }

}
