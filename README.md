# Leaseweb - Backend PHP Assessment Test

This application consists in get and filter data from a _xlsx_ Excel sheet file using a _REST API_.
* An example of the file is versioned under `storage/app/servers/` directory for testing purpose.
* The application is working with a cache layer to reduce the response time;
* It's using the _Repository_ pattern to centralize and encapsulate the logic for accessing and manipulating data, promoting separation of concerns and enhancing the maintainability and testability of the codebase.
* It's also working with _Factory_ pattern for filters objects creation, and _traits_.
* There is a _docker-composer.yml_ file to facilitate the environment setup with _Docker_.

## Configuration:
1. Create the `.env` file based on `.env.example`:
```shell
cp .env.example .env
```

2. Since it's using _[Laravel Sail](https://laravel.com/docs/10.x/sail)_, you need to execute the following command to first install the dependencies and be able to run _Sail_ commands:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Create and run _Docker_ containers:
```shell
./vendor/bin/sail up -d
```

4. Generate the _application key_:
```shell
./vendor/bin/sail artisan key:generate
```

5. To run the tests routines _(optional)_:
```shell
./vendor/bin/sail artisan test
```

## Endpoints:

### GET api/v1/servers
- Description: List all servers based on filter criteria
- Parameters:
  - `storage`:
    - Description: Max size limit of the server storage
    - Type: `string`
    - Required: `false`
    - Possible values: `0`, `250GB`, `500GB`, `1TB`, `2TB`, `3TB`, `4TB`, `8TB`, `12TB`, `24TB`, `48TB`, `72TB`.
  - `ram`:
    - Description: Sizes of RAM memories
    - Type: `array`
    - Required: `false`
    - Possible values: `2`, `4`, `8`, `12`, `16`, `24`, `32`, `48`, `64`, `96`.
  - `harddisk_type`:
    - Description: Type of Hard-disk
    - Type: `string`
    - Required: `false`
    - Possible values: `SAS`. `SATA`, `SSD`.
  - `location`:
    - Description: Geographic location
    - Type: `string`
    - Required: `false`
    - Possible values: ` `


- Example:
  - Input:
    ```json
    {
        "storage": "72TB",
        "ram": ["4", "64"],
        "harddisk_type": "SATA",
        "location": "Amsterdam"
    }
    ```
  - Output:
    ```json
    {
        "15": [
            "HP DL180 G92x Intel Xeon E5-2620v3",
            "64GBDDR4",
            "1x72TBSATA2",
            "AmsterdamAMS-01",
            "€199.99"
        ],
        "18": [
            "Dell R9304x Intel Xeon E7-4850v3",
            "64GBDDR4",
            "2x32TBSATA2",
            "AmsterdamAMS-01",
            "€1044.99"
        ]
    }
    ```
