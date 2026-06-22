<h2>Register</h2>

<form method="POST" action="/register">
    <div>
        <label for="name">Name</label>
        <input id="name" name="name" type="text" required>
    </div>

    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" minlength="8" required>
    </div>

    <button type="submit">Register</button>
</form>

<p>
    Already have an account?
    <a href="/login">Log in</a>
</p>