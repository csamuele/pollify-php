<h2>Login</h2>

<form method="POST" action="/login">
    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>

    <button type="submit">Log in</button>
</form>

<p>
    Need an account?
    <a href="/register">Register</a>
</p>