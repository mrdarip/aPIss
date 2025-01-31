# aPIss

LAMP project that serves an API using PHP and MySQL.

Spain is known by tourists for having bathrooms that you have to pay to use, but what if you could find all the free bathrooms in Spain? This API will help you find the nearest free bathroom in Spain. and provide some feedback about it.

Endpoints:

- GET /crud/getTop.php  
    Get the top 10 bathrooms with the highest score.
- GET /crud/getWorse.php  
    Get the 10 bathrooms with the lowest score.
- GET /crud/getNearest.php
    Get the nearest bathroom to a given location.  
    Params:
    - latitude: float
    - longitude: float
    - distance: int
- GET /crud/getById.php
    Get a bathroom by its id.
    Params:
    - id: int
- POST /crud/create.php
    Create a new bathroom.
    Params:
    - name: string
    - description: string
    - latitude: float
    - longitude: float
- POST /crud/upvote.php
    Upvote a bathroom.
    Params:
    - id: int
- POST /crud/downvote.php
    Downvote a bathroom.
    Params:
    - id: int

## Installation
Just run `docker compose up`