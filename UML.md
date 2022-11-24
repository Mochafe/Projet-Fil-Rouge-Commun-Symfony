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
quantity
carts
product
}

CartDetail -- Cart
class Category{
PK - id
Name
parent
childs
products
}

Category -- self
Category -- self
Category -- Product
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
discountRate
quantity
images
carts
cartDetails
category
}

Product -- Image
Product -- Cart
Product -- CartDetail
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