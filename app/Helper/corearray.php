<?php


function admitClass($index = null)
{
    $array = [
        ADMIT_CLASS_SIX => __("Six"),
        ADMIT_CLASS_SEVEN => __("Seven"),
        ADMIT_CLASS_EIGHT => __("Eight"),
        ADMIT_CLASS_NINE => __("Nine"),
    ];
    if(isset($array[$index])) return $array[$index];
    return $array;
}

function activationStatus($input = null)
{
    $output = [
        STATUS_ACTIVE => __('Active'),
        STATUS_DEACTIVE => __('Deactive'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function countryList($input=null) {
    $output = [
        "AF" => "Afghanistan",
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
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, the Democratic Republic of the",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote D'Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
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
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and Mcdonald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran, Islamic Republic of",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic of",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia, the Former Yugoslav Republic of",
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
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States of",
        "MD" => "Moldova, Republic of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territory, Occupied",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
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
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Province of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic of",
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
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands, British",
        "VI" => "Virgin Islands, U.s.",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"

    ];

    if (is_null($input)) {
        return $output;
    } else {

        return $output[$input];
    }
    
}

function gender($input = null)
{
    $output = [
        MALE => __('Male'),
        FEMALE => __('Female'),
        OTHER_GENDER => __('Other')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function roleActionArray($input = null){
        $currency_list = array(
            array("name"=>"Admin List View","code"=>USER_LIST,"group" =>"Admin","route" => "adminList","url" =>"admin/user"),
            array("name"=>"Admin Create View","code"=>USER_CREATE,"group" =>"Admin","route" => "adminAdd","url" =>"admin/user/add"),
            array("name"=>"Admin Update","code"=>USER_EDIT,"group" =>"Admin","route" => "adminEdit","url" =>"admin/user/edit"),
            array("name"=>"Admin Delete","code"=>USER_DESTROY,"group" =>"Admin","route" => "adminDelete","url" =>"admin/user/delete"),
            array("name"=>"Admin Preview","code"=>USER_PREVIEW,"group" =>"Admin","route" => "adminPreview","url" =>"admin/user/preview"),
            array("name"=>"Admin Store","code"=>USER_STORE,"group" =>"Admin","route" => "adminStoreProcess","url" =>"admin/user/store"),

            array("name"=>"Role List View","code"=>ROLE_LIST,"group" =>"Role","route" => "roleList","url" =>"admin/role"),
            array("name"=>"Role Create View","code"=>ROLE_CREATE,"group" =>"Role","route" => "roleAdd","url" =>"admin/role/add"),
            array("name"=>"Role Update","code"=>ROLE_EDIT,"group" =>"Role","route" => "roleEdit","url" =>"admin/role/edit"),
            array("name"=>"Role Delete","code"=>ROLE_DESTROY,"group" =>"Role","route" => "roleDelete","url" =>"admin/role/delete"),
            array("name"=>"Role Preview","code"=>ROLE_PREVIEW,"group" =>"Role","route" => "rolePreview","url" =>"admin/role/preview"),
            array("name"=>"Role Store","code"=>ROLE_STORE,"group" =>"Role","route" => "roleStoreProcess","url" =>"admin/role/store"),

            array("name"=>"Job Category List View","code"=>JOB_CATEGORY_LIST,"group" =>"Job","route" => "jobCategoryList","url" =>"admin/job/category"),
            array("name"=>"Job Category Create View","code"=>JOB_CATEGORY_CREATE,"group" =>"Job","route" => "jobCategoryAdd","url" =>"admin/job/category/add"),
            array("name"=>"Job Category Update","code"=>JOB_CATEGORY_EDIT,"group" =>"Job","route" => "jobCategoryEdit","url" =>"admin/job/category/edit"),
            array("name"=>"Job Category Delete","code"=>JOB_CATEGORY_DESTROY,"group" =>"Job","route" => "jobCategoryDelete","url" =>"admin/job/category/delete"),
            array("name"=>"Job Category Preview","code"=>JOB_CATEGORY_PREVIEW,"group" =>"Job","route" => "jobCategoryPreview","url" =>"admin/job/category/preview"),
            array("name"=>"Job Category Store","code"=>JOB_CATEGORY_STORE,"group" =>"Job","route" => "jobCategoryStoreProcess","url" =>"admin/job/category/store"),

            array("name"=>"Job Post List View","code"=>JOB_POST_LIST,"group" =>"Job","route" => "jobPostList","url" =>"admin/job/post"),
            array("name"=>"Job Post Create View","code"=>JOB_POST_CREATE,"group" =>"Job","route" => "jobPostAdd","url" =>"admin/job/post/add"),
            array("name"=>"Job Post Update","code"=>JOB_POST_EDIT,"group" =>"Job","route" => "jobPostEdit","url" =>"admin/job/post/edit"),
            array("name"=>"Job Post Delete","code"=>JOB_POST_DESTROY,"group" =>"Job","route" => "jobPostDelete","url" =>"admin/job/post/delete"),
            array("name"=>"Job Post Preview","code"=>JOB_POST_PREVIEW,"group" =>"Job","route" => "jobPostPreview","url" =>"admin/job/post/preview"),

            array("name"=>"Job Application List","code"=>JOB_APPLICATION_LIST,"group" =>"Job","route" => "jobApplicationList","url" =>"admin/job/application"),
            array("name"=>"Job Application Preview","code"=>JOB_APPLICATION_PREVIEW,"group" =>"Job","route" => "jobApplicationPreview","url" =>"admin/job/application/preview"),
            array("name"=>"Job Application Delete","code"=>JOB_APPLICATION_DESTROY,"group" =>"Job","route" => "jobApplicationDelete","url" =>"admin/job/application/delete"),

            array("name"=>"Service List View","code"=>SERVICE_LIST,"group" =>"Service","route" => "serviceList","url" =>"admin/service"),
            array("name"=>"Service Create View","code"=>SERVICE_CREATE,"group" =>"Service","route" => "serviceAdd","url" =>"admin/service/add"),
            array("name"=>"Service Update","code"=>SERVICE_EDIT,"group" =>"Service","route" => "serviceEdit","url" =>"admin/service/edit"),
            array("name"=>"Service Delete","code"=>SERVICE_DESTROY,"group" =>"Service","route" => "serviceDelete","url" =>"admin/service/delete"),
            array("name"=>"Service Preview","code"=>SERVICE_PREVIEW,"group" =>"Service","route" => "servicePreview","url" =>"admin/service/preview"),
            array("name"=>"Service Store","code"=>SERVICE_STORE,"group" =>"Service","route" => "serviceStoreProcess","url" =>"admin/service/store"),

            array("name"=>"Team List View","code"=>TEAM_LIST,"group" =>"Team","route" => "teamList","url" =>"admin/team"),
            array("name"=>"Team Create View","code"=>TEAM_CREATE,"group" =>"Team","route" => "teamAdd","url" =>"admin/team/add"),
            array("name"=>"Team Update","code"=>TEAM_EDIT,"group" =>"Team","route" => "teamEdit","url" =>"admin/team/edit"),
            array("name"=>"Team Delete","code"=>TEAM_DESTROY,"group" =>"Team","route" => "teamDelete","url" =>"admin/team/delete"),
            array("name"=>"Team Preview","code"=>TEAM_PREVIEW,"group" =>"Team","route" => "teamPreview","url" =>"admin/team/preview"),
            array("name"=>"Team Store","code"=>TEAM_STORE,"group" =>"Team","route" => "teamStoreProcess","url" =>"admin/team/store"),

            array("name"=>"Faq List View","code"=>FAQ_LIST,"group" =>"Faq","route" => "faqList","url" =>"admin/faq"),
            array("name"=>"Faq Create View","code"=>FAQ_CREATE,"group" =>"Faq","route" => "faqAdd","url" =>"admin/faq/add"),
            array("name"=>"Faq Update","code"=>FAQ_EDIT,"group" =>"Faq","route" => "faqEdit","url" =>"admin/faq/edit"),
            array("name"=>"Faq Delete","code"=>FAQ_DESTROY,"group" =>"Faq","route" => "faqDelete","url" =>"admin/faq/delete"),
            array("name"=>"Faq Preview","code"=>FAQ_PREVIEW,"group" =>"Faq","route" => "faqPreview","url" =>"admin/faq/preview"),
            array("name"=>"Faq Store","code"=>FAQ_STORE,"group" =>"Faq","route" => "faqStoreProcess","url" =>"admin/faq/store"),

            array("name"=>"Admin Setting","code"=>SETTING_VIEW,"group" =>"Setting","route" => "adminSetting","url" =>"admin/settings"),
            array("name"=>"Admin Setting Update","code"=>SETTING_UPDATE,"group" =>"Setting","route" => "updateGeneralSetting","url" =>"admin/update-generel-settings"),

        );
        if($input != null){
            foreach($currency_list as $item){
                if($item['code'] == $input){
                    return $item;
                }
            }
        }
        return $currency_list;
    }

function getTradeCurrencyType($index = null)
{
    $array = [
        CURRENCY_TYPE_CRYPTO => __("Crypto"),
        CURRENCY_TYPE_FIAT => __("Fiat"),
    ];
    if(isset($array[$index])) return $array[$index];
    return $array;
}
