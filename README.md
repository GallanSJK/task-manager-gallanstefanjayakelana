# TASK MANAGER - Gallan Stefan Jayakelana

## Kebutuhan Aplikasi

1. Minimun PHP Version 7.4
2. Download dan Install xampp https://www.apachefriends.org/download.html
3. Download dan Install Composer https://getcomposer.org/

4. Buka command prompt di dalam directory htdocs pada folder xampp lalu jalankan baris berikut:

```
git clone https://github.com/GallanSJK/task-manager-gallanstefanjayakelana.git
```

5. Buka command prompt di dalam directory aplikasi task manager lalu jalankan baris berikut:

```
composer update
```

6. Rename atau copy `.env.example` file menjadi `.env`

7. Set database credentials kedalam `.env` file

8. Generate key dengan mengetik perintah berikut:

```
php artisan key:generate
```

9. Run migrasi database dengan mengetik perintah berikut:

```
php artisan migrate
```

10. Run seeder database dengan mengetik perintah berikut:

```
php artisan db:seed
```

11. Jalankan Aplikasi dengan mengetik perintah berikut:

```
php artisan serve
```

12. Berikut untuk akun yang telah digenerate menggunakan db:seed :
    - Email = gallan@gmail.com, Password = gallan
    - Email = stefan@gmail.com, Password = stefan
    - Email = jaya@gmail.com, Password = jaya
    - Email = kelana@gmail.com, Password = kelana