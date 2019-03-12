<?php $this->layout('template', ['title' => 'Login Page']) ?>
<form action="/login" method="post">
    <p>
        <label>Username</label>
        <input type="text" name="Username" id="input-username">
    </p>
    <p>
        <label>Password</label>
        <input type="password" name="Password" id="input-password">
    </p>
    <button name="Login">Login</button>
</form>