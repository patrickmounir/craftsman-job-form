# craftsman-job-form

Firstly, in order to run this project you will need:
* PHP 7.1
* MySQL
* Composer

To download composer go to this website [get Composer](https://getcomposer.org/)

## After Cloning
1. Copy .env.example into .env
1. Create a database named `testing_craftsman` by running this command `create database testing_craftsman`
1. Change the `DB_USERNAME` and `DB_PASSWORD` to your own
1. Run the following commands:
    1. `composer install`
    1. `php artisan key:generate`
    1. `php artisan migrate`
    1. `php artisan passport:install`
    1. `php artisan db:seed`
    
To start the server run the following command `php artisan serve`.

## APIs

For authorization, I used `laravel/passport` which comes with ready routes for authorization and token requests please follow that guide [Here](https://laravel.com/docs/5.6/passport).
 As for the api I built, here they are with the expected input and output.
 
### ```post api/job-requests```

  * **Name**: Create Job Request
  * **Request Body**: 
    ```
    {
        "service_id" : 1
        "title" : "Five Letters"
        "description" : "Quaerat debitis enim ipsa quam ea."
        "zip" : 10115
        "city" : "Berlin"
        "deadline" : "2018-08-12"
    }
    ``` 
  * **Success Status**: ```201``` 
  * **Response Body**: 
    ```
    {
      "data": {
        "id": 1
        "title": "Five Letters"
        "description": "Velit aut commodi harum qui."
        "zip": 10115
        "city": "Berlin"
        "deadline": "2018-08-27"
        "created_at": "2018-08-10 15:14:44"
        "updated_at": "2018-08-10 15:14:44"
        "service": {
          "data": {
            "id": 1
            "name": "quis"
          }
        }
      }
    }
    ``` 
  * **Forbidden Status**: ```401```
  * **Forbidden Response**:
      ```
      {
        "error": {
          "message": "Forbidden!"
          "status_code": 401
        }
      }
    ```

  * **Validation Error Status**: ```422```
  * **Validation Error Response**:
      ```
      {
        "error": {
          "message": {
            "title": [
              0 => "The title must be a string."
              1 => "The title must be at least 5 characters."
            ]
          }
          "status_code": 422
        }
      }
    
    ```
### ```get api/job-requests```
  * **Name**: List Available job requests
  * **Success Status**: ```200``` 
  * **Response Body**: 
    ```
    {
      "data": [
        0 => {
          "id": 2
          "title": "Five Letters"
          "description": "Enim deleniti est quia placeat."
          "zip": "10115"
          "city": "New Emmahaven"
          "deadline": "2018-08-21"
          "created_at": "2018-08-10 15:30:28"
          "updated_at": "2018-08-10 15:30:28"
          "service": {
            "data": {
              "id": 24
              "name": "mollitia"
            }
          }
          "user": {
            "data": {
              "name": "Lucius Lockman"
              "email": "aurelio.halvorson@example.org"
              "username": "reece.considine"
            }
          }
        }
        1 => {
          "id": 3
          "title": "Five Letters"
          "description": "Esse non possimus vel ea sed aut consequatur."
          "zip": "10115"
          "city": "East Madilyn"
          "deadline": "2018-08-22"
          "created_at": "2018-08-10 15:30:28"
          "updated_at": "2018-08-10 15:30:28"
          "service": {
            "data": {
              "id": 25
              "name": "eum"
            }
          }
          "user": {
            "data": {
              "name": "Gabe Kreiger"
              "email": "levi90@example.org"
              "username": "rmosciski"
            }
          }
        }
      ]
      "paginator": {
        "current_page": 1
        "per_page": 25
        "prev_page": null
        "prev_page_url": null
        "next_page": null
        "next_page_url": null
        "total": 2
      }
      "code": 200
    }

    ``` 
  * **Forbidden Status**: ```401```
  * **Forbidden Response**:
      ```
      {
        "error": {
          "message": "Forbidden!"
          "status_code": 401
        }
      }
    ```
### ```get api/job-requests/mine```
  * **Name**: List the logged in user's job requests
  * **Success Status**: ```200``` 
  * **Response Body**: 
    ```
       {
         "data": [
           0 => {
             "id": 13
             "title": "UsersLogged In"
             "description": "Iusto nesciunt rerum ipsam fugiat ipsa natus corporis earum."
             "zip": "10115"
             "city": "Bergeville"
             "deadline": "2018-08-14"
             "created_at": "2018-08-10 15:31:53"
             "updated_at": "2018-08-10 15:31:53"
             "service": {#3126
               "data": {#3560
                 "id": 34
                 "name": "iure"
               }
             }
           }
           1 => {
             "id": 14
             "title": "UsersLogged In"
             "description": "Voluptas quo libero voluptates corrupti."
             "zip": "10115"
             "city": "Priscillaland"
             "deadline": "2018-09-06"
             "created_at": "2018-08-10 15:31:53"
             "updated_at": "2018-08-10 15:31:53"
             "service": {#3346
               "data": {#3564
                 "id": 35
                 "name": "neque"
               }
             }
           }
         ]
         "paginator": {
           "current_page": 1
           "per_page": 25
           "prev_page": null
           "prev_page_url": null
           "next_page": null
           "next_page_url": null
           "total": 2
         }
         "code": 200
       }
    ``` 
  * **Forbidden Status**: ```401```
  * **Forbidden Response**:
      ```
      {
        "error": {
          "message": "Forbidden!"
          "status_code": 401
        }
      }
    ```
### ```get api/job-requests/{jobRequest}```
  * **Name**: Shows a single job request.
  * **Parameter**: ```jobRequest: 1```: *The id of the job request you want to view*
  * **Success Status**: ```200``` 
  * **Response Body**: 
    ```
   {
     "data": {
       "id": 15
       "title": "Five Letters"
       "description": "Vitae vel ea sit reprehenderit placeat quo consequatur."
       "zip": "10115"
       "city": "Nayeliside"
       "deadline": "2018-09-08"
       "created_at": "2018-08-10 15:33:16"
       "updated_at": "2018-08-10 15:33:16"
       "service": {
         "data": {
           "id": 36
           "name": "voluptate"
         }
       }
       "user": {
         "data": {
           "name": "Fatima Veum"
           "email": "alek16@example.org"
           "username": "leora.mcglynn"
         }
       }
     }
   }

    ``` 
  * **Forbidden Status**: ```401```
  * **Forbidden Response**:
      ```
      {
        "error": {
          "message": "Forbidden!"
          "status_code": 401
        }
      }
    ```
### ```get api/services```

  * **Name**: List Available job requests
  * **Success Status**: ```200``` 
  * **Response Body**: 
    ```
    {
      "data": [
        0 => {
          "id": 804040
          "name": "Sonstige Umzugsleistungen"
        }
        1 => {
          "id": 802030
          "name": "Abtransport, Entsorgung und Entrümpelung"
        }
        .
        .
        .
      ]
    }
    ``` 
  * **Forbidden Status**: ```401```
  * **Forbidden Response**:
      ```
      {
        "error": {
          "message": "Forbidden!"
          "status_code": 401
        }
      }
    ```
## Running Tests

Before running the tests you will need to change the `DB_USERNAME` and `DB_PASSWORD` to your own and then run the command `vendor/bin/phpunit`