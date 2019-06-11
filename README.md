![Capture](https://user-images.githubusercontent.com/22125914/59299870-53db4800-8cc0-11e9-91cd-4bf5a96b0dde.PNG)

## Symfony and Vue JS CRUD Sample

### Server Side

Database Setup:

Go to .env file and Set database connection ( user: root, password: , host: 127.0.0.1:3306, dbname: ripeexam )

```DATABASE_URL=mysql://root:@127.0.0.1:3306/ripeexam```

Run Server:

```cd server```

```php -S 127.0.0.1:4444 -t public```

#### create database
```php bin/console doctrine:database:create```

#### generate new migration
```php bin/console doctrine:migrations:diff```

#### database migration
```php bin/console doctrine:migrations:migrate```


---

### Client Side


RUN APP: 

```cd frontend```

```npm run serve```


frontend server base url in 

```src/api.js```
