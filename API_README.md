## About API

The project comes packed with reseller side API enabled for external use. There are six endpoints that are readily available.

## Endpoints

- Get Token (`/api/get_token`) 
- Get Countries (`/api/countries`)
- Get Operators (`/api/operators`)
- Get Operators By Country id (`/api/countries/{countryId}/operators`)
- Get Single Operator (`/api/operators/{operatorId}`)
- Send Topup (`/api/topup`)
- Get Transactions (`/api/transactions`)
- Get Transaction By Ref (`/api/transactions/reference/{refNo}`)
- Get Transaction By Id (`/api/transactions/id/{id}`)

- Get Gift Card Products (`gift_cards/products`)
- Get Gift Card Product By Id (`gift_cards/products/{id}`)
- Order Gift Card (`gift_cards/order`)

## Get Token

The api works on OAuth 2.0 Protocol and thus requires a token for all calls. To get this token user calls the `POST` api route (`/api/get_token`) with their email and password.

Fields Supported

- email
- password

Sample Request

```
curl --location --request POST 'http://localhost/api/get_token' \
   --form 'email="user@abc.com"' \
   --form 'password="user"'
```

Sample Response

```json
{
    "accessToken": "ACCESS_TOKEN_COMES_HERE",
    "token": {
        "id": "SOME_ID_FOR_TOKEN",
        "user_id": 1,
        "client_id": 1,
        "name": "USER_EMAIL_NAME",
        "scopes": [],
        "revoked": false,
        "created_at": "2020-12-17 07:57:04",
        "updated_at": "2020-12-17 07:57:04",
        "expires_at": "2021-12-17T07:57:04.000000Z"
    }
}
```


## Get Countries

To get All countries a user sends `GET` request to the `/api/countries` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/countries' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
[
    {
        "id": 1,
        "iso": "AF",
        "name": "Afghanistan",
        "currency_code": "AFN",
        "currency_name": "Afghan Afghani",
        "currency_symbol": "؋",
        "flag": "https://s3.amazonaws.com/rld-flags/af.svg"
    },
    {
        "id": 2,
        "iso": "AL",
        "name": "Albania",
        "currency_code": "ALL",
        "currency_name": "Albanian Lek",
        "currency_symbol": "Lek",
        "flag": "https://s3.amazonaws.com/rld-flags/al.svg"
    },
    {
        "id": 3,
        "iso": "DZ",
        "name": "Algeria",
        "currency_code": "DZD",
        "currency_name": "Algerian Dinar",
        "currency_symbol": "د.ج.‏",
        "flag": "https://s3.amazonaws.com/rld-flags/dz.svg"
    }
]
```

## Get Operators

To get All operators a user sends `GET` request to the `/api/operators` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/operators' \
--header 'Authorization: Bearer TOKEN_GOES_HERE' 
```

Sample Response

```json
[
  {
          "id": 1,
          "country_id": 119,
          "name": "168 Thailand",
          "bundle": "0",
          "data": 0,
          "pin": 0,
          "supports_local_amounts": 0,
          "denomination_type": "FIXED",
          "sender_currency_code": "CAD",
          "sender_currency_symbol": "$",
          "destination_currency_code": "THB",
          "destination_currency_symbol": "฿",
          "most_popular_amount": 26.34,
          "min_amount": null,
          "local_min_amount": null,
          "max_amount": null,
          "local_max_amount": null,
          "fx_rate": 18.80,
          "logo_urls": [
              "https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-1.png",
              "https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-3.png",
              "https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-2.png"
          ],
          "fixed_amounts": [
              0.53,
              1.06,
              2.65,
              5.28,
              10.54,
              15.81,
              26.33
          ],
          "fixed_amounts_descriptions": [],
          "local_fixed_amounts": [],
          "local_fixed_amounts_descriptions": [],
          "suggested_amounts": [],
          "suggested_amounts_map": {
              "0.53": 10,
              "1.06": 20,
              "2.65": 50,
              "5.28": 100,
              "10.54": 200,
              "15.81": 300,
              "26.34": 500
          },
          "created_at": "2020-11-17T07:25:30.000000Z",
          "updated_at": "2020-12-17T00:00:09.000000Z",
          "select_amounts": [
              0.53,
              1.06,
              2.64,
              5.28,
              10.54,
              15.81,
              26.34
          ],
          "rates": {
              "international_discount": 1,
              "local_discount": 0
          }
      },
      {
          "id": 2,
          "country_id": 88,
          "name": "9Mobile (Etisalat) Nigeria",
          "bundle": "0",
          "data": 0,
          "pin": 0,
          "supports_local_amounts": 1,
          "denomination_type": "RANGE",
          "sender_currency_code": "CAD",
          "sender_currency_symbol": "$",
          "destination_currency_code": "NGN",
          "destination_currency_symbol": "₦",
          "most_popular_amount": 19,
          "min_amount": 0.029,
          "local_min_amount": 5,
          "max_amount": 179,
          "local_max_amount": 50000,
          "fx_rate": 246.745,
          "logo_urls": [
              "https://s3.amazonaws.com/rld-operator/a6c9c490-39fa-47c0-a63a-b4a4d1d4dbe5-size-3.png",
              "https://s3.amazonaws.com/rld-operator/a6c9c490-39fa-47c0-a63a-b4a4d1d4dbe5-size-2.png",
              "https://s3.amazonaws.com/rld-operator/a6c9c490-39fa-47c0-a63a-b4a4d1d4dbe5-size-1.png"
          ],
          "fixed_amounts": [],
          "fixed_amounts_descriptions": [],
          "local_fixed_amounts": [],
          "local_fixed_amounts_descriptions": [],
          "suggested_amounts": [
              1,
              6,
              12,
              19,
              25,
              32,
              38,
              45,
              51,
              58,
              64,
              71,
              77,
              84,
              90,
              97,
              103,
              110,
              116,
              123,
              129,
              136,
              142,
              149,
              155,
              162,
              168,
              175
          ],
          "suggested_amounts_map": {
              "1": 246.75,
              "6": 1480.48000000000001818989403545856475830078125,
              "12": 2960.9600000000000363797880709171295166015625,
              "19": 4688.1800000000002910383045673370361328125,
              "25": 6168.65999999999985448084771633148193359375,
              "32": 7895.8800000000001091393642127513885498046875,
              "38": 9376.360000000000582076609134674072265625,
              "45": 11103.59000000000014551915228366851806640625,
              "51": 12584.059999999999490682967007160186767578125,
              "58": 14311.2900000000008731149137020111083984375,
              "64": 15791.760000000000218278728425502777099609375,
              "71": 17518.99000000000160071067512035369873046875,
              "77": 18999.4599999999991268850862979888916015625,
              "84": 20726.68999999999869032762944698333740234375,
              "90": 22207.169999999998253770172595977783203125,
              "97": 23934.389999999999417923390865325927734375,
              "103": 25414.86999999999898136593401432037353515625,
              "110": 27142.09000000000014551915228366851806640625,
              "116": 28622.5699999999997089616954326629638671875,
              "123": 30349.7900000000008731149137020111083984375,
              "129": 31830.27000000000043655745685100555419921875,
              "136": 33557.4899999999979627318680286407470703125,
              "142": 35037.97000000000116415321826934814453125,
              "149": 36765.1900000000023283064365386962890625,
              "155": 38245.669999999998253770172595977783203125,
              "162": 39972.889999999999417923390865325927734375,
              "168": 41453.3700000000026193447411060333251953125,
              "175": 43180.58999999999650754034519195556640625
          },
          "created_at": "2020-11-17T07:25:30.000000Z",
          "updated_at": "2020-12-17T00:00:09.000000Z",
          "select_amounts": [
              1,
              6,
              12,
              19,
              25,
              32,
              38,
              45,
              51,
              58,
              64,
              71,
              77,
              84,
              90,
              97,
              103,
              110,
              116,
              123,
              129,
              136,
              142,
              149,
              155,
              162,
              168,
              175
          ],
          "rates": {
              "international_discount": 4.5,
              "local_discount": 0
          }
      }
]
```

## Get Operators By Country id

To get All Operators By Country id a user sends `GET` request to the `/api/countries/{countryId}/operators` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/countries/1/operators' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
[
    {
        "id": 5,
        "country_id": 1,
        "name": "Afghan Wireless Afghanistan",
        "bundle": "0",
        "data": 0,
        "pin": 0,
        "supports_local_amounts": 1,
        "denomination_type": "RANGE",
        "sender_currency_code": "CAD",
        "sender_currency_symbol": "$",
        "destination_currency_code": "AFN",
        "destination_currency_symbol": "؋",
        "most_popular_amount": 19,
        "min_amount": 0.65000000000000002220446049250313080847263336181640625,
        "local_min_amount": 38,
        "max_amount": 42,
        "local_max_amount": 2500,
        "fx_rate": 50.1201999999999969759301166050136089324951171875,
        "logo_urls": [
            "https://s3.amazonaws.com/rld-operator/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-2.png",
            "https://s3.amazonaws.com/rld-operator/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-3.png",
            "https://s3.amazonaws.com/rld-operator/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-1.png"
        ],
        "fixed_amounts": [],
        "fixed_amounts_descriptions": [],
        "local_fixed_amounts": [],
        "local_fixed_amounts_descriptions": [],
        "suggested_amounts": [
            1,
            6,
            12,
            19,
            25,
            32,
            38
        ],
        "suggested_amounts_map": {
            "1": 50.13000000000000255795384873636066913604736328125,
            "6": 300.73000000000001818989403545856475830078125,
            "12": 601.450000000000045474735088646411895751953125,
            "19": 952.2899999999999636202119290828704833984375,
            "25": 1253.009999999999990905052982270717620849609375,
            "32": 1603.859999999999899955582804977893829345703125,
            "38": 1904.579999999999927240423858165740966796875
        },
        "created_at": "2020-11-17T07:25:30.000000Z",
        "updated_at": "2020-12-17T00:00:09.000000Z",
        "select_amounts": [
            1,
            6,
            12,
            19,
            25,
            32,
            38
        ],
        "rates": {
            "international_discount": 5,
            "local_discount": 0.5
        }
    }
]
```

## Get Operators By id

To get Operator By its id a user sends `GET` request to the `/api/operators/{operatorId}` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/operators/1' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
{
    "id": 1,
    "country_id": 119,
    "name": "168 Thailand",
    "bundle": "0",
    "data": 0,
    "pin": 0,
    "supports_local_amounts": 0,
    "denomination_type": "FIXED",
    "sender_currency_code": "CAD",
    "sender_currency_symbol": "$",
    "destination_currency_code": "THB",
    "destination_currency_symbol": "฿",
    "most_popular_amount": 26.339999999999999857891452847979962825775146484375,
    "min_amount": null,
    "local_min_amount": null,
    "max_amount": null,
    "local_max_amount": null,
    "fx_rate": 18.8066400000000015779733075760304927825927734375,
    "logo_urls": [
        "https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-1.png",
        "https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-3.png",
        "https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-2.png"
    ],
    "fixed_amounts": [
        0.5300000000000000266453525910037569701671600341796875,
        1.060000000000000053290705182007513940334320068359375,
        2.649999999999999911182158029987476766109466552734375,
        5.28000000000000024868995751603506505489349365234375,
        10.53999999999999914734871708787977695465087890625,
        15.8100000000000004973799150320701301097869873046875,
        26.339999999999999857891452847979962825775146484375
    ],
    "fixed_amounts_descriptions": [],
    "local_fixed_amounts": [],
    "local_fixed_amounts_descriptions": [],
    "suggested_amounts": [],
    "suggested_amounts_map": {
        "0.53": 10,
        "1.06": 20,
        "2.65": 50,
        "5.28": 100,
        "10.54": 200,
        "15.81": 300,
        "26.34": 500
    },
    "created_at": "2020-11-17T07:25:30.000000Z",
    "updated_at": "2020-12-17T00:00:09.000000Z",
    "select_amounts": [
        0.5300000000000000266453525910037569701671600341796875,
        1.060000000000000053290705182007513940334320068359375,
        2.649999999999999911182158029987476766109466552734375,
        5.28000000000000024868995751603506505489349365234375,
        10.53999999999999914734871708787977695465087890625,
        15.8100000000000004973799150320701301097869873046875,
        26.339999999999999857891452847979962825775146484375
    ],
    "rates": {
        "international_discount": 1,
        "local_discount": 0
    }
}
```

## Send Topup

To send topup a user is required to send a `POST` call to `/api/topup` route. This is protected via OAuth 2.0 so requires token to be sent in the header.

Fields Supported

- operator
- number
- amount

Sample Request

```json
curl --location --request POST 'https://reloadly.otifcrew.com/api/topup' \
--header 'Authorization: Bearer TOKEN_GOES_HERE' \
--form 'operator="555"' \
--form 'number="0923333333333"' \
--form 'amount="2"' \
--form 'ref=ABC123'
```

Sample Response

```json
{
    "success": {
        "message": "Transaction created. It will be processed in a few minutes",
        "transaction": {
            "ref_no": null,
            "operator_id": 793,
            "invoice_id": 4,
            "topup": 116.4314187,
            "amount": 1.07,
            "number": "123123123",
            "sender_currency": "CAD",
            "receiver_currency": "PKR",
            "is_local": false,
            "updated_at": "2021-10-23T10:18:48.000000Z",
            "created_at": "2021-10-23T10:18:47.000000Z",
            "id": 3,
            "status": "PENDING",
            "message": "Transaction is paid. But its pending topup. Please wait a few minuites for the status to update."
        }
    }
}
```

## Get Transactions

To get All transctions a user sends `GET` request to the `/api/transactions` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/transactions' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
[
    {
        "id": 2,
        "ref_no": null,
        "operator_id": 20,
        "invoice_id": 3,
        "is_local": 0,
        "topup": 9.70746,
        "amount": 0.21,
        "number": 123123123,
        "sender_currency": "CAD",
        "receiver_currency": "INR",
        "status": "FAIL",
        "timezone_id": null,
        "scheduled_datetime": null,
        "type": "USER_INITIATED",
        "subscription_date": null,
        "system_initiated_logs": null,
        "pin": null,
        "created_at": "2021-10-23T10:08:32.000000Z",
        "updated_at": "2021-10-23T10:09:09.000000Z",
        "message": "Insufficient funds in the wallet to complete this transaction"
    }
]
```

## Get Transactions By Ref No

To get All transctions by a reference no a user sends `GET` request to the `/api/transactions/reference/{refNo}` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/transactions/reference/{refNo}' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
    {
        "id": 2,
        "ref_no": null,
        "operator_id": 20,
        "invoice_id": 3,
        "is_local": 0,
        "topup": 9.70746,
        "amount": 0.21,
        "number": 123123123,
        "sender_currency": "CAD",
        "receiver_currency": "INR",
        "status": "FAIL",
        "timezone_id": null,
        "scheduled_datetime": null,
        "type": "USER_INITIATED",
        "subscription_date": null,
        "system_initiated_logs": null,
        "pin": null,
        "created_at": "2021-10-23T10:08:32.000000Z",
        "updated_at": "2021-10-23T10:09:09.000000Z",
        "message": "Insufficient funds in the wallet to complete this transaction"
    }
```

## Get Transactions By Id

To get All transctions by id a user sends `GET` request to the `/api/transactions/id/{id}` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/transactions/id/{id}' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
    {
        "id": 2,
        "ref_no": null,
        "operator_id": 20,
        "invoice_id": 3,
        "is_local": 0,
        "topup": 9.70746,
        "amount": 0.21,
        "number": 123123123,
        "sender_currency": "CAD",
        "receiver_currency": "INR",
        "status": "FAIL",
        "timezone_id": null,
        "scheduled_datetime": null,
        "type": "USER_INITIATED",
        "subscription_date": null,
        "system_initiated_logs": null,
        "pin": null,
        "created_at": "2021-10-23T10:08:32.000000Z",
        "updated_at": "2021-10-23T10:09:09.000000Z",
        "message": "Insufficient funds in the wallet to complete this transaction"
    }
```

## Get Gift Card Products

To get All gift card products  a user sends `GET` request to the `/api/gift_cards/products` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/gift_cards/products' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
[
    {
        "id": 1,
        "title": "1-800-PetSupplies",
        "is_global": 0,
        "recipient_currency_code": "USD",
        "sender_currency_code": "CAD",
        "fixed_sender_denominations": [
            31,
            62
        ],
        "logo_urls": [
            "https://cdn.reloadly.com/giftcards/5daa2b8b-b1ad-4ca6-a34d-a7ce3c14dfaf.jpg"
        ],
        "country": {
            "id": 131,
            "iso": "US",
            "name": "United States",
            "currency_code": "USD",
            "currency_name": "US Dollar",
            "currency_symbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/us.svg"
        },
        "redeem_instruction": {
            "concise": "This card is redeemable for merchandise on www.1-800-petsupplies.com",
            "verbose": "Your acceptance of this eCertificate constitutes your agreement to these terms and conditions. This card is redeemable in U.S. only for merchandise on www.1-800-petsupplies.com . Only two eCertificates are redeemable per order. eCertificates cannot be redeemed for cash, except as required by law. Void if altered or reproduced. This gift card is issued in U.S. funds by Tabcom, LLC. When Redeeming online please be sure to enter the entire gift card number including preceding zeros. The maximum number of eCertificates that can be used for phone is nine. By accepting these Terms and Conditions through your use of this Site, you certify that you reside in the United States and are 18 years of age or older. If you are under the age of 18 but at least 14 years of age you may use this Site only under the supervision of a parent or legal guardian who agrees to be bound by these Terms and Conditions."
        },
        "amounts": {
            "25.00": 31.38,
            "50.00": 62.15
        }
    }
]
```

## Get Gift Card By Id

To get gift card by id a user sends `GET` request to the `/api/gift_cards/products/{id}` route. This is protected via OAuth 2.0 so requires token to be sent in the header. 

Sample Request

```json
curl --location --request GET 'http://localhost/api/gift_cards/products/{id}' \
--header 'Authorization: Bearer TOKEN_GOES_HERE'
```

Sample Response

```json
    {
        "id": 1,
        "title": "1-800-PetSupplies",
        "is_global": 0,
        "recipient_currency_code": "USD",
        "sender_currency_code": "CAD",
        "fixed_sender_denominations": [
            31,
            62
        ],
        "logo_urls": [
            "https://cdn.reloadly.com/giftcards/5daa2b8b-b1ad-4ca6-a34d-a7ce3c14dfaf.jpg"
        ],
        "country": {
            "id": 131,
            "iso": "US",
            "name": "United States",
            "currency_code": "USD",
            "currency_name": "US Dollar",
            "currency_symbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/us.svg"
        },
        "redeem_instruction": {
            "concise": "This card is redeemable for merchandise on www.1-800-petsupplies.com",
            "verbose": "Your acceptance of this eCertificate constitutes your agreement to these terms and conditions. This card is redeemable in U.S. only for merchandise on www.1-800-petsupplies.com . Only two eCertificates are redeemable per order. eCertificates cannot be redeemed for cash, except as required by law. Void if altered or reproduced. This gift card is issued in U.S. funds by Tabcom, LLC. When Redeeming online please be sure to enter the entire gift card number including preceding zeros. The maximum number of eCertificates that can be used for phone is nine. By accepting these Terms and Conditions through your use of this Site, you certify that you reside in the United States and are 18 years of age or older. If you are under the age of 18 but at least 14 years of age you may use this Site only under the supervision of a parent or legal guardian who agrees to be bound by these Terms and Conditions."
        },
        "amounts": {
            "25.00": 31.38,
            "50.00": 62.15
        }
    }
```

## Order Gift Card

To order gift card a user is required to send a `POST` call to `/api/gift_cards/order` route. This is protected via OAuth 2.0 so requires token to be sent in the header.

Fields Supported

- operator
- number
- amount

Sample Request

```json
curl --location --request POST 'https://reloadly.otifcrew.com/api/gift_cards/order' \
--header 'Authorization: Bearer TOKEN_GOES_HERE' \
--form 'product_id=1' \
--form 'recipient_email="abc@email.com"' \
--form 'amount=31.38' \
--form 'ref=ABC123'
```

Sample Response

```json
{
    "success": {
        "message": "Transaction created. It will be processed in a few minutes",
        "transaction": {
            "email": "abc@email.com",
            "invoice_id": 32,
            "product_id": 1,
            "sender_amount": 31.38,
            "recipient_amount": "25.00",
            "reference": "some_reference_to_Track",
            "updated_at": "2021-11-12T08:51:52.000000Z",
            "created_at": "2021-11-12T08:51:51.000000Z",
            "id": 8,
            "status": "PENDING"
        }
    }
}
```
