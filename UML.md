```mermaid
classDiagram

class Cart{
PK - id
user
cartDetails
}

Cart -- CartDetail
class CartDetail{
PK - id
product
quantity
carts
}

CartDetail -- Cart
class Image{
PK - id
title
path
product
}

class Product{
PK - id
name
description
reference
price
discount
discountRate
quantity
images
carts
}

Product -- Image
Product -- Cart
class ResetPasswordRequest{
PK - id
user
}

class User{
PK - id
email
roles
password
name
lastName
birthdate
signinDate
phoneNumber
isVerified
vat
pro
proCompanyName
proDuns
cart
}


```