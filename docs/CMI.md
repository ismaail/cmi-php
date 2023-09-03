# CMI

## Attributes


| Name | Description| Format | Constraint |
| --- | --- | --- | --- |
| clientid | Merchant’s id assigned by CMI. | AlphaNum | required |
| storetype | Merchant payment model: `3D_PAY_HOSTING` | AlphaNum | required |
| trantype | Transaction type<br>Set to `PreAuth` for preauthorization. | AlphaNum | required |
| amount | Transaction amount<br>Amount value without currency symbol.<br>Use "." or "," as decimal separator. Example: 29.95 | AlphaNum | required |
| currency | ISO code of the transaction currency<br>ISO 4217 numeric code.<br>ISO code for MAD: 504 | Numeric | required |
| oid | Unique Order/Cart identifier in the merchant application | AlphaNum | required |
| okUrl | The URL used to redirect the customer back to the merchant’s web site in case of accepted payment authorization. | URL | required |
| failUrl | The URL used to redirect the customer back to the merchant’s web site in case of failed/rejected payment authorization. | URL | required |
| lang | The language used to display the payment screens.<br>Possible values: ar, fr, en<br>Default: fr | AlphaNum(2) | required |
| email | Customer's email | Email | required |
| BillToName | Customer’s name (first name and last name) | AlphaNum | required |
| rnd | Random string, will be used for hash comparison | AlphaNum(20) | required |
| hash | Control hash code | AlphaNum | required |
| hashAlgorithm | Hash version | AlphaNum | required |
