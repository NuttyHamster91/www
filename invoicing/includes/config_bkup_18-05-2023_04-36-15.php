<?php
// Debugging
ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);

// DATABASE INFORMATION
define('DATABASE_HOST', getenv('IP'));
define('DATABASE_NAME', 'invoicingsystem');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', 'password');

// COMPANY INFORMATION
define('COMPANY_FAVICON_NAME', 'favicon.png');
define('COMPANY_LOGO_NAME', 'logo.png');
define('COMPANY_FAVICON', 'theme-assets/images/ico/');
define('COMPANY_LOGO', 'theme-assets/images/logo/');
define('COMPANY_LOGO_WIDTH', '65');
define('COMPANY_LOGO_HEIGHT', '0');
define('COMPANY_NAME', 'Simon H Company');
define('COMPANY_ADDRESS_1', 'A L1');
define('COMPANY_ADDRESS_2', 'A L2');
define('COMPANY_ADDRESS_3', 'A L3');
define('COMPANY_COUNTY', 'Devon');
define('COMPANY_POSTCODE', 'TQ1 1QW');
define('COMPANY_CONTACT_1', '07123123456');
define('COMPANY_CONTACT_2', '');
define('COMPANY_EMAIL', 'info@simonh.online');
define('COMPANY_WEBSITE', 'www.simonh.online');
define('COMPANY_NUMBER', 'Reg1234');
define('COMPANY_VAT', 'VAT1010');
define('COMPANY_UTR', 'UTR2929');

// EMAIL DETAILS
define('EMAIL_FROM', 'info@simonh.online'); // Email address invoice emails will be sent from
define('SMTP_SERVER', 'smtp.hostinger.com'); // Email SMTP Server address
define('SMTP_USERNAME', 'info@simonh.online'); // Email SMTP Username
define('SMTP_PASSWORD', 'Smhche1sea91./'); // Email SMTP Password
define('SMTP_PORT', '465'); // Email SMTP Port
define('SMTP_USE_AUTH', 'ssl'); // Email SMTP Use Authorisation
define('EMAIL_NAME', 'Simon H Company Name'); // Email from
define('EMAIL_SUBJECT', 'Hello from Simon H Company Name'); // Invoice email subject
define('EMAIL_BODY_INVOICE', ''); // Invoice email body
define('EMAIL_BODY_QUOTE', ''); // Quote email body
define('EMAIL_BODY_RECEIPT', ''); // Receipt email Body

// Other Settings
define('INVOICE_PREFIX', 'INV-'); // Prefix at start of invoice - leave empty '' for no prefix
define('INVOICE_INITIAL_VALUE', '1501'); // Initial invoice order number (start of increment)
define('QUOTE_INITIAL_VALUE', '9001'); // Initial quote number (start of increment)
define('INVOICE_PAYMENT_TERM', '15'); // Invoice Payment Term (Days)
define('INVOICE_THEME', '#007373'); // Theme colour, this sets a colour theme for the PDF generate invoice
define('INVOICE_THEME_HF', '#353535'); // Theme colour, this sets a colour theme for the PDF generate invoice
define('TIMEZONE', ''); // Timezone - See for list of Timezone's http://php.net/manual/en/function.date-default-timezone-set.php
define('DATE_FORMAT', 'DD/MM/YYYY'); // DD/MM/YYYY or MM/DD/YYYY
define('CURRENCY', '£'); // Currency symbol
define('ENABLE_VAT', 'true'); // Enable TAX/VAT
define('VAT_INCLUDED', 'false'); // Is VAT included or excluded?
define('VAT_RATE', '20'); // This is the percentage value
define('PAYMENT_BANK', 'Lloyds'); // Bank
define('PAYMENT_SORT', '00-00-00'); // Sort Code
define('PAYMENT_ACCTNO', '12345678'); // Acct Number
define('PAYMENT_DETAILS', 'Simon H Company.<br>Bank: Lloyds<br>Sort Code: 00-00-00<br>Account Number: 12345678'); // Payment information
define('FOOTER_NOTE', 'Footer Note Text Here'); // 
define('TCDP', 'Health and Safety Policy.pdf'); // 

// CONNECT TO THE DATABASE
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);


//Define cipher
$cipher = 'aes-256-cbc';
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($cipher);
$options = 0;
//Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
