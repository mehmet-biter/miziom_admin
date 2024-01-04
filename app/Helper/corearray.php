<?php

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

function fiat_currency_array($input = null){

    // count 164
    $currency_list = array(
        array("name" => "Afghan Afghani", "code" => "AFA", "symbol" => "؋"),
        array("name" => "Albanian Lek", "code" => "ALL", "symbol" => "Lek"),
        array("name" => "Algerian Dinar", "code" => "DZD", "symbol" => "دج"),
        array("name" => "Angolan Kwanza", "code" => "AOA", "symbol" => "Kz"),
        array("name" => "Argentine Peso", "code" => "ARS", "symbol" => "$"),
        array("name" => "Armenian Dram", "code" => "AMD", "symbol" => "֏"),
        array("name" => "Aruban Florin", "code" => "AWG", "symbol" => "ƒ"),
        array("name" => "Australian Dollar", "code" => "AUD", "symbol" => "$"),
        array("name" => "Azerbaijani Manat", "code" => "AZN", "symbol" => "m"),
        array("name" => "Bahamian Dollar", "code" => "BSD", "symbol" => "B$"),
        array("name" => "Bahraini Dinar", "code" => "BHD", "symbol" => ".د.ب"),
        array("name" => "Bangladeshi Taka", "code" => "BDT", "symbol" => "৳"),
        array("name" => "Barbadian Dollar", "code" => "BBD", "symbol" => "Bds$"),
        array("name" => "Belarusian Ruble", "code" => "BYR", "symbol" => "Br"),
        array("name" => "Belgian Franc", "code" => "BEF", "symbol" => "fr"),
        array("name" => "Belize Dollar", "code" => "BZD", "symbol" => "$"),
        array("name" => "Bermudan Dollar", "code" => "BMD", "symbol" => "$"),
        array("name" => "Bhutanese Ngultrum", "code" => "BTN", "symbol" => "Nu."),
        array("name" => "Bolivian Boliviano", "code" => "BOB", "symbol" => "Bs."),
        array("name" => "Bosnia", "code" => "BAM", "symbol" => "KM"),
        array("name" => "Botswanan Pula", "code" => "BWP", "symbol" => "P"),
        array("name" => "Brazilian Real", "code" => "BRL", "symbol" => "R$"),
        array("name" => "British Pound Sterling", "code" => "GBP", "symbol" => "£"),
        array("name" => "Brunei Dollar", "code" => "BND", "symbol" => "B$"),
        array("name" => "Bulgarian Lev", "code" => "BGN", "symbol" => "Лв."),
        array("name" => "Burundian Franc", "code" => "BIF", "symbol" => "FBu"),
        array("name" => "Cambodian Riel", "code" => "KHR", "symbol" => "KHR"),
        array("name" => "Canadian Dollar", "code" => "CAD", "symbol" => "$"),
        array("name" => "Cape Verdean Escudo", "code" => "CVE", "symbol" => "$"),
        array("name" => "Cayman Islands Dollar", "code" => "KYD", "symbol" => "$"),
        array("name" => "CFA Franc BCEAO", "code" => "XOF", "symbol" => "CFA"),
        array("name" => "CFA Franc BEAC", "code" => "XAF", "symbol" => "FCFA"),
        array("name" => "CFP Franc", "code" => "XPF", "symbol" => "₣"),
        array("name" => "Chilean Peso", "code" => "CLP", "symbol" => "$"),
        array("name" => "Chinese Yuan", "code" => "CNY", "symbol" => "¥"),
        array("name" => "Colombian Peso", "code" => "COP", "symbol" => "$"),
        array("name" => "Comorian Franc", "code" => "KMF", "symbol" => "CF"),
        array("name" => "Congolese Franc", "code" => "CDF", "symbol" => "FC"),
        array("name" => "Costa Rican ColÃ³n", "code" => "CRC", "symbol" => "₡"),
        array("name" => "Croatian Kuna", "code" => "HRK", "symbol" => "kn"),
        array("name" => "Cuban Convertible Peso", "code" => "CUC", "symbol" => "$, CUC"),
        array("name" => "Czech Republic Koruna", "code" => "CZK", "symbol" => "Kč"),
        array("name" => "Danish Krone", "code" => "DKK", "symbol" => "Kr."),
        array("name" => "Djiboutian Franc", "code" => "DJF", "symbol" => "Fdj"),
        array("name" => "Dominican Peso", "code" => "DOP", "symbol" => "$"),
        array("name" => "East Caribbean Dollar", "code" => "XCD", "symbol" => "$"),
        array("name" => "Egyptian Pound", "code" => "EGP", "symbol" => "ج.م"),
        array("name" => "Eritrean Nakfa", "code" => "ERN", "symbol" => "Nfk"),
        array("name" => "Estonian Kroon", "code" => "EEK", "symbol" => "kr"),
        array("name" => "Ethiopian Birr", "code" => "ETB", "symbol" => "Nkf"),
        array("name" => "Euro", "code" => "EUR", "symbol" => "€"),
        array("name" => "Falkland Islands Pound", "code" => "FKP", "symbol" => "£"),
        array("name" => "Fijian Dollar", "code" => "FJD", "symbol" => "FJ$"),
        array("name" => "Gambian Dalasi", "code" => "GMD", "symbol" => "D"),
        array("name" => "Georgian Lari", "code" => "GEL", "symbol" => "ლ"),
        array("name" => "German Mark", "code" => "DEM", "symbol" => "DM"),
        array("name" => "Ghanaian Cedi", "code" => "GHS", "symbol" => "GH₵"),
        array("name" => "Gibraltar Pound", "code" => "GIP", "symbol" => "£"),
        array("name" => "Greek Drachma", "code" => "GRD", "symbol" => "₯, Δρχ, Δρ"),
        array("name" => "Guatemalan Quetzal", "code" => "GTQ", "symbol" => "Q"),
        array("name" => "Guinean Franc", "code" => "GNF", "symbol" => "FG"),
        array("name" => "Guyanaese Dollar", "code" => "GYD", "symbol" => "$"),
        array("name" => "Haitian Gourde", "code" => "HTG", "symbol" => "G"),
        array("name" => "Honduran Lempira", "code" => "HNL", "symbol" => "L"),
        array("name" => "Hong Kong Dollar", "code" => "HKD", "symbol" => "$"),
        array("name" => "Hungarian Forint", "code" => "HUF", "symbol" => "Ft"),
        array("name" => "Icelandic KrÃ³na", "code" => "ISK", "symbol" => "kr"),
        array("name" => "Indian Rupee", "code" => "INR", "symbol" => "₹"),
        array("name" => "Indonesian Rupiah", "code" => "IDR", "symbol" => "Rp"),
        array("name" => "Iranian Rial", "code" => "IRR", "symbol" => "﷼"),
        array("name" => "Iraqi Dinar", "code" => "IQD", "symbol" => "د.ع"),
        array("name" => "Israeli New Sheqel", "code" => "ILS", "symbol" => "₪"),
        array("name" => "Italian Lira", "code" => "ITL", "symbol" => "L,£"),
        array("name" => "Jamaican Dollar", "code" => "JMD", "symbol" => "J$"),
        array("name" => "Japanese Yen", "code" => "JPY", "symbol" => "¥"),
        array("name" => "Jordanian Dinar", "code" => "JOD", "symbol" => "ا.د"),
        array("name" => "Kazakhstani Tenge", "code" => "KZT", "symbol" => "лв"),
        array("name" => "Kenyan Shilling", "code" => "KES", "symbol" => "KSh"),
        array("name" => "Kuwaiti Dinar", "code" => "KWD", "symbol" => "ك.د"),
        array("name" => "Kyrgystani Som", "code" => "KGS", "symbol" => "лв"),
        array("name" => "Laotian Kip", "code" => "LAK", "symbol" => "₭"),
        array("name" => "Latvian Lats", "code" => "LVL", "symbol" => "Ls"),
        array("name" => "Lebanese Pound", "code" => "LBP", "symbol" => "£"),
        array("name" => "Lesotho Loti", "code" => "LSL", "symbol" => "L"),
        array("name" => "Liberian Dollar", "code" => "LRD", "symbol" => "$"),
        array("name" => "Libyan Dinar", "code" => "LYD", "symbol" => "د.ل"),
        array("name" => "Lithuanian Litas", "code" => "LTL", "symbol" => "Lt"),
        array("name" => "Macanese Pataca", "code" => "MOP", "symbol" => "$"),
        array("name" => "Macedonian Denar", "code" => "MKD", "symbol" => "ден"),
        array("name" => "Malagasy Ariary", "code" => "MGA", "symbol" => "Ar"),
        array("name" => "Malawian Kwacha", "code" => "MWK", "symbol" => "MK"),
        array("name" => "Malaysian Ringgit", "code" => "MYR", "symbol" => "RM"),
        array("name" => "Maldivian Rufiyaa", "code" => "MVR", "symbol" => "Rf"),
        array("name" => "Mauritanian Ouguiya", "code" => "MRO", "symbol" => "MRU"),
        array("name" => "Mauritian Rupee", "code" => "MUR", "symbol" => "₨"),
        array("name" => "Mexican Peso", "code" => "MXN", "symbol" => "$"),
        array("name" => "Moldovan Leu", "code" => "MDL", "symbol" => "L"),
        array("name" => "Mongolian Tugrik", "code" => "MNT", "symbol" => "₮"),
        array("name" => "Moroccan Dirham", "code" => "MAD", "symbol" => "MAD"),
        array("name" => "Mozambican Metical", "code" => "MZM", "symbol" => "MT"),
        array("name" => "Myanmar Kyat", "code" => "MMK", "symbol" => "K"),
        array("name" => "Namibian Dollar", "code" => "NAD", "symbol" => "$"),
        array("name" => "Nepalese Rupee", "code" => "NPR", "symbol" => "₨"),
        array("name" => "Netherlands Antillean Guilder", "code" => "ANG", "symbol" => "ƒ"),
        array("name" => "New Taiwan Dollar", "code" => "TWD", "symbol" => "$"),
        array("name" => "New Zealand Dollar", "code" => "NZD", "symbol" => "$"),
        array("name" => "Nicaraguan CÃ³rdoba", "code" => "NIO", "symbol" => "C$"),
        array("name" => "Nigerian Naira", "code" => "NGN", "symbol" => "₦"),
        array("name" => "North Korean Won", "code" => "KPW", "symbol" => "₩"),
        array("name" => "Norwegian Krone", "code" => "NOK", "symbol" => "kr"),
        array("name" => "Omani Rial", "code" => "OMR", "symbol" => ".ع.ر"),
        array("name" => "Pakistani Rupee", "code" => "PKR", "symbol" => "₨"),
        array("name" => "Panamanian Balboa", "code" => "PAB", "symbol" => "B/."),
        array("name" => "Papua New Guinean Kina", "code" => "PGK", "symbol" => "K"),
        array("name" => "Paraguayan Guarani", "code" => "PYG", "symbol" => "₲"),
        array("name" => "Peruvian Nuevo Sol", "code" => "PEN", "symbol" => "S/."),
        array("name" => "Philippine Peso", "code" => "PHP", "symbol" => "₱"),
        array("name" => "Polish Zloty", "code" => "PLN", "symbol" => "zł"),
        array("name" => "Qatari Rial", "code" => "QAR", "symbol" => "ق.ر"),
        array("name" => "Romanian Leu", "code" => "RON", "symbol" => "lei"),
        array("name" => "Russian Ruble", "code" => "RUB", "symbol" => "₽"),
        array("name" => "Rwandan Franc", "code" => "RWF", "symbol" => "FRw"),
        array("name" => "Salvadoran ColÃ³n", "code" => "SVC", "symbol" => "₡"),
        array("name" => "Samoan Tala", "code" => "WST", "symbol" => "SAT"),
        array("name" => "Saudi Riyal", "code" => "SAR", "symbol" => "﷼"),
        array("name" => "Serbian Dinar", "code" => "RSD", "symbol" => "din"),
        array("name" => "Seychellois Rupee", "code" => "SCR", "symbol" => "SRe"),
        array("name" => "Sierra Leonean Leone", "code" => "SLL", "symbol" => "Le"),
        array("name" => "Singapore Dollar", "code" => "SGD", "symbol" => "$"),
        array("name" => "Slovak Koruna", "code" => "SKK", "symbol" => "Sk"),
        array("name" => "Solomon Islands Dollar", "code" => "SBD", "symbol" => "Si$"),
        array("name" => "Somali Shilling", "code" => "SOS", "symbol" => "Sh.so."),
        array("name" => "South African Rand", "code" => "ZAR", "symbol" => "R"),
        array("name" => "South Korean Won", "code" => "KRW", "symbol" => "₩"),
        array("name" => "Special Drawing Rights", "code" => "XDR", "symbol" => "SDR"),
        array("name" => "Sri Lankan Rupee", "code" => "LKR", "symbol" => "Rs"),
        array("name" => "St. Helena Pound", "code" => "SHP", "symbol" => "£"),
        array("name" => "Sudanese Pound", "code" => "SDG", "symbol" => ".س.ج"),
        array("name" => "Surinamese Dollar", "code" => "SRD", "symbol" => "$"),
        array("name" => "Swazi Lilangeni", "code" => "SZL", "symbol" => "E"),
        array("name" => "Swedish Krona", "code" => "SEK", "symbol" => "kr"),
        array("name" => "Swiss Franc", "code" => "CHF", "symbol" => "CHf"),
        array("name" => "Syrian Pound", "code" => "SYP", "symbol" => "LS"),
        array("name" => "São Tomé and Príncipe Dobra", "code" => "STD", "symbol" => "Db"),
        array("name" => "Tajikistani Somoni", "code" => "TJS", "symbol" => "SM"),
        array("name" => "Tanzanian Shilling", "code" => "TZS", "symbol" => "TSh"),
        array("name" => "Thai Baht", "code" => "THB", "symbol" => "฿"),
        array("name" => "Tongan pa'anga", "code" => "TOP", "symbol" => "$"),
        array("name" => "Trinidad & Tobago Dollar", "code" => "TTD", "symbol" => "$"),
        array("name" => "Tunisian Dinar", "code" => "TND", "symbol" => "ت.د"),
        array("name" => "Turkish Lira", "code" => "TRY", "symbol" => "₺"),
        array("name" => "Turkmenistani Manat", "code" => "TMT", "symbol" => "T"),
        array("name" => "Ugandan Shilling", "code" => "UGX", "symbol" => "USh"),
        array("name" => "Ukrainian Hryvnia", "code" => "UAH", "symbol" => "₴"),
        array("name" => "United Arab Emirates Dirham", "code" => "AED", "symbol" => "إ.د"),
        array("name" => "Uruguayan Peso", "code" => "UYU", "symbol" => "$"),
        array("name" => "US Dollar", "code" => "USD", "symbol" => "$"),
        array("name" => "Uzbekistan Som", "code" => "UZS", "symbol" => "лв"),
        array("name" => "Vanuatu Vatu", "code" => "VUV", "symbol" => "VT"),
        array("name" => "Venezuelan BolÃvar", "code" => "VEF", "symbol" => "Bs"),
        array("name" => "Vietnamese Dong", "code" => "VND", "symbol" => "₫"),
        array("name" => "Yemeni Rial", "code" => "YER", "symbol" => "﷼"),
        array("name" => "Zambian Kwacha", "code" => "ZMK", "symbol" => "ZK")
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

function api_settings($input = null)
{
    $output = [
        COIN_PAYMENT => __('Coin Payment Api'),
        BITGO_API => __('Bitgo Api'),
    ];
    if (is_null($input)) return $output;
    return isset($output[$input]) ? $output[$input] : null;
}

function discount_type($input = null)
{
    $output = [
        DISCOUNT_TYPE_FIXED => __('Fixed'),
        DISCOUNT_TYPE_PERCENTAGE => __('Percentage')
    ];
    if (is_null($input)) return $output;
    return isset($output[$input]) ? $output[$input] : null;
}

function webhook_type($input = null)
{
    $output = [
//        WEBHOOK_TYPE_TRANSFER => __('Transfer'),
        WEBHOOK_TYPE_TRANSACTION => __('Transaction'),
//        WEBHOOK_TYPE_PENDING_APPROVAL => __('Pending Approval'),
//        WEBHOOK_TYPE_ADDRESS_CONFIRM => __('Address Confirmation'),
//        WEBHOOK_TYPE_LOW_FEE => __('Low Fee'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return isset($output[$input]) ? ($output[$input]) : null;
    }
}

function deposit_status($input = null)
{
    $output = [
        STATUS_ACCEPTED => __('Accepted'),
        STATUS_PENDING => __('Pending'),
        STATUS_REJECTED => __('Rejected'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input] ? $output[$input] : null;
    }
}

function getNetworkType($input = null)
{
    $output = [
        POLYGON_NETWORK => __('Polygon'),
        SOLANA_NETWORK => __('Solana'),
        BINANCE_MAINNET_NETWORK => __('Binance Mainnet'),
        TRON_MAINNET_NETWORK => __('Tron Mainnet'),
        ETHEREUM_MAINNET_NETWORK => __('Ethereum Mainnet'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return isset($output[$input]) ? $output[$input] : null;
    }
}

function getCoinByNetworkType($input = null)
{
    $output = [
        POLYGON_NETWORK => __('POLYGON'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return isset($output[$input]) ? $output[$input] : null;
    }
}