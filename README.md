Sistem Informasi Pelayanan Administrasi Pemerintah
==================================================

Installation steps:
<ol>
    <li>Pull from git, or download package as zip.</li>
    <li>Copy .env.example as .env and config database connection, etc.</li>
    <li>Set directory permission of <i>storage</i> and <i>bootstrap/cache</i> to writeable (chmod 775)</li>
    <li>Open console, and type <i>composer install</i></li>
    <li>run command <i>php artisan key:generate</i> to create Application Secret Key</li>
    <li>run command <i>php artisan migrate</i></li>
    <li>run command <i>php artisan db:seed</i></li> 
    <li>run command <i>php artisan storage:link</i></li>
    <li>Last steps, to run application. Run command on console by typing <i>php artisan serve</i></li>
</ol>