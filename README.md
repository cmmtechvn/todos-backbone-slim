todos-backbone-slim
===================
This is one example about using Backbone.js combine with a PHP server and MySQL database
Install steps:
- Download source code to root folder of apache server
- Run 'todo.sql' file in MySQL server
- Change config of MySQL server in file : todos-backbone-slim/slimsv/index.php
	R::setup('mysql:host=localhost;dbname=todo', 'root', ''); => your own config
- Enter server path : http://localhost/todos-backbone-slim/index.html

Done! :)