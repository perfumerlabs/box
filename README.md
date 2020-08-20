What is it
==========

Docker container for simple intermediate storage implementation with API.
The purpose is to have a database which allows several services to exchange data between each other.

It is not as powerful as [ESB systems](https://en.wikipedia.org/wiki/Enterprise_service_bus), 
but reasonable if there is no need to exchange data with high speed and availability or between different data formats.

The typical workflow can be: suppose we have 2 services which have to synchronize data between each other.
When some event appears in Service 1, it does JSON-message and pushes it to Box via Rest API. 
Service 2 repeatedly checks updates in Box via cron or other tools, and if there is new data, fetches it and stores it in its database. 

Installation
============

```bash
docker run \
-p 80:80/tcp \
-e BOX_HOST=box \
-e PG_HOST=db \
-e PG_PORT=5432 \
-e PG_DATABASE=box_db \
-e PG_USER=user \
-e PG_PASSWORD=password \
-d perfumerlabs/box:v1.0.0
```

Database must be created before container startup.

Environment variables
=====================

- BOX_HOST - server domain (without http://). Required.
- BOX_FETCH_LIMIT - a fixed number of documents to return in "/documents" API method. Default value is 100.
- PHP_PM_MAX_CHILDREN - number of FPM workers. Default value is 10.
- PHP_PM_MAX_REQUESTS - number of FPM max requests. Default value is 500.
- PG_HOST - PostgreSQL host. Required.
- PG_PORT - PostgreSQL port. Default value is 5432.
- PG_DATABASE - PostgreSQL database name. Required.
- PG_USER - PostgreSQL user name. Required.
- PG_PASSWORD - PostgreSQL user password. Required.

Volumes
=======

This image has no volumes.

If you want to make any additional configuration of container, mount your bash script to /opt/setup.sh. This script will be executed on container setup.

Software
========

1. Ubuntu 16.04 Xenial
1. Nginx 1.16
1. PHP 7.4

Database tables
===============

After setup there are 3 predefined tables in database:

### _client

User credentials registry. Fields:

- name [string] - Name of application
- secret [string] - Unique string for access to API
- is_admin [bool] - Defines if client has superuser privileges, required for some endpoints

### _coll

Registry of collections. Fields:

- name [string] - Name of collection

### _access

Permissions of clients to manage collections. Fields:

- collection_id [int] - ID of collection
- client_id [int] - ID of client
- level [int] - Level of access: 0 - read access, 1 - read and write access

There is no means to manage clients and access for now, so it has to be done manually in the database.

Authorization and Access
========================

Any requests to API should be added with a header Box-Secret. Example:

```
Box-Secret: my_secret
```

where `my_secret` is a string from `secret` field of table `_client`.

API Reference
=============

### Create collection

`POST /collection`

Access: Admin only.

Parameters (json):
- name [string,required] - name of the collection.

Request example:

```json
{
    "name": "foobar"
}
```

Response example:

```json
{
    "status": true
}
```

### Create document

`POST /document`

Access: write access to collection.

Request parameters (json):
- collection [string,required] - name of the collection.
- data [mixed,required] - any JSON-serializable content.

Request example:

```json
{
    "collection": "foobar",
    "data": "Lorem ipsum dolor sit amet"
}
```

Response parameters (json):
- key [string] - unique identity of inserted document.

Response example:

```json
{
    "status": true,
    "content": {
        "key": "qwerty"
    }
}
```

### Get documents (returns maximum of BOX_FETCH_LIMIT documents)

`GET /documents`

Access: read access to collection.

Request parameters (json):
- collection [string,required] - name of the collection.
- key [string,optional] - the key of document to start from.

Request example:

```json
{
    "collection": "foobar",
    "key": "qwerty"
}
```

Response parameters (json):
- key [string] - unique identity of inserted document.
- data [mixed] - content of inserted document.

Response example:

```json
{
    "status": true,
    "content": {
        "documents": [
            {
                "key": "foo",
                "data": [1, 2, 3]
            }
        ]
    }
}
```

### Get documents number

`GET /documents/count`

Access: read access to collection.

Request parameters (json):
- collection [string,required] - name of the collection.
- key [string,optional] - the key of document to start from.

Request example:

```json
{
    "collection": "foobar",
    "key": "qwerty"
}
```

Response parameters (json):
- documents [int] - the number of documents.

Response example:

```json
{
    "status": true,
    "content": {
        "documents": 5
    }
}
```