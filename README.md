
# Car-parts-shop

It's a project made to pass my internet databases application classes.
I used HTML and modified some ready components in Bootstrap to 
achieve a desired effect. I used PHP to create queries and fetch
data from the MySQL database.

## Features of shop

- Show car parts
- Login/Register 
- Filter the car parts
- Add products to cart
- Show cart
- Make orders
- Show orders


## Tech Stack

**Frontend:** HTML with Boostrap 4

**Backend:** PHP latest version

**Database:** MySQL





## Database credentials

#### Database predefined users

| Login | Password     |
| :-------- | :------- |
| `iab` | `iab` |

#### Car-parts predefined users

| Login | Password     |
| :-------- | :------- |
| `randy123`      | `password` |
| `marcobag`      | `marco123` |



## Database relationship model

![database_relationship](https://github.com/Wojberni/car-parts-shop/blob/main/database_relationship.png?raw=true)
## Installation

To run this project you must have docker installed. It will download the lastest releases of PHP, MySQL and phpMyAdmin.


```bash
  docker-compose up
```
To access the database i set some credentials that are mentioned in section above.

#### Connect to database with phpMyAdmin

```http
  localhost:8080/
```

After connecting to database with phpMyAdmin you must import the database from the iab.sql.
After that you should be ready to go.

#### Launch the website

```http
  localhost:8000/
```
## 🚀 About Me
I'm a studying at the Technical University of Łódź in Poland. This is my last year and I am trying to learn as much as I can in many different programming languages. 


## Authors

- [@Wojberni](https://www.github.com/Wojberni)

