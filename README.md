# Assignment

## Objective:
Store personal information in an encrypted format using Eloquent.

## Parameters:
- Attributes that are to be encrypted should be definable
- Encrypted attributes should be accessible from the model in the same
way "normal" attributes are.
- Integrate this flow into a simple Request/Response cycle.
- Each record must have it's own encryption key

## Requisites
- You must use Laravel or Lumen

## Not allowed:
- You are not allowed to use third party packages that add this
functionality to Eloquent

---

# Solution

For these examples I'm using httpie, but curl or wget can be used as well.

I have left out validation and error handling.

## Start server

```bash
php -S localhost:8000 -t public
```

## Overview

```bash
http GET localhost:8000/products
```

This overview doesn't use the Eloquent model and therefore all the attributes are still encrypted

```bash
http GET localhost:8000/products?raw=true
```

## Create

```bash
http POST localhost:8000/products code=ABC123 title=Laptop price=599.99 description="lorum ipsum"
```

```bash
http POST localhost:8000/products code=XYZ789 title=Pen price=2.50 description="lorum ipsum"
```

## Read

```bash
http GET localhost:8000/products/1
```

## Update

```bash
http PUT localhost:8000/products/1 description="longer better faster stronger description"
```

## Delete

```bash
http DELETE localhost:8000/products/1
```