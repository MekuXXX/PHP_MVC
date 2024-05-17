<h1 class="text-2xl font-bold mb-6">Register</h1>
<form action="/register" class="space-y-4" method="post">
  <div>
    <label>Firstname: </label>
    <input type="text" name="first_name">
  </div>

  <div>
    <label>Lastname: </label>
    <input type="text" name="last_name">
  </div>

  <div>
    <label>Email: </label>
    <input type="email" name="email">
  </div>

  <div>
    <label>Password: </label>
    <input type="password" name="password">
  </div>
  

  <div>
    <label>Repeat password: </label>
    <input type="password" name="repeat_password">
  </div>

  <div>
    <button type="submit" class="bg-blue-600 p-2 rounded-lg text-white hover:bg-blue-600/75 transition">Submit</button>
  </div>

</form>