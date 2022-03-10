# payment-sense laravel integration

## First env file

in your .env file you need to add those values

    PAYMENTSENSE_PAC_ENDPOINT="" // You Endpoint without the https://
    PAYMENTSENSE_PAC_API="" // The Api key
    PAYMENTSENSE_HOUSE_ID="" // House id
    PAYMENTSENSE_PAC_USER="" // The User name can be anything

### Next setup publish the package config file

php artisan v:p --force // select the package number

Once live make sure to disable the demo mode in the configuration files
