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
-e PG_HOST=db \
-e PG_PORT=5432 \
-e PG_DATABASE=box_db \
-e PG_USER=user \
-e PG_PASSWORD=password \
-d perfumerlabs/box:v2.0.0
```

Database must be created before container startup.

Environment variables
=====================

- BOX_FETCH_LIMIT - a maximum number of documents to return in "/documents" API method. Default value is 100.
- PG_HOST - PostgreSQL host. Required.
- PG_PORT - PostgreSQL port. Default value is 5432.
- PG_DATABASE - PostgreSQL database name. Required.
- PG_USER - PostgreSQL user name. Required.
- PG_PASSWORD - PostgreSQL user password. Required.
- PHP_PM_MAX_CHILDREN - number of FPM workers. Default value is 10.
- PHP_PM_MAX_REQUESTS - number of FPM max requests. Default value is 500.

Volumes
=======

This image has no volumes.

If you want to make any additional configuration of container, mount your bash script to /opt/setup.sh. This script will be executed on container setup.

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
- event [string,required] - category of content.
- code [string,required] - unique key of the document. Another document with same code will be ignored.
- data [mixed,required] - any JSON-serializable content.

Request example:

```json
{
    "collection": "foobar",
    "event": "my_event",
    "code": "unique_code",
    "data": "Lorem ipsum dolor sit amet"
}
```

Response parameters (json):
- id [integer] - unique identity of inserted document.

Response example:

```json
{
    "status": true,
    "content": {
        "id": 100
    }
}
```

### List documents

`GET /documents`

Access: read access to collection.

Request parameters (json):
- collection [string,required] - name of the collection.
- id [integer,optional] - the id of document to start from.
- limit [integer,optional] - number of documents to return. Limited with BOX_FETCH_LIMIT option.

Request example:

```json
{
    "collection": "foobar",
    "id": 100
}
```

Response parameters (json):
- event [string] - category of content.
- code [string] - unique key of the document.
- id [integer] - unique identity of inserted document.
- data [mixed] - content of inserted document.

Response example:
```json
{
    "status": true,
    "content": {
        "documents": [
            {
                "id": 101,
                "event": "my_event",
                "code": "unique_code",
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
- id [integer,optional] - the id of document to start from.

Request example:

```json
{
    "collection": "foobar",
    "id": 100
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

Software
========

1. Ubuntu 16.04 Xenial
1. Nginx 1.16
1. PHP 7.4