<div class="container">
  <h1 class="center">Log In</h1>
  <div class="box">
    <p class="center"><font color="red"><?php if (isset($message)) echo $message; ?></font></p>
    <table class="center">
        <form method="POST" action="login" onSubmit="">
          <input type="hidden" name="submitted" value="true"/>
          <tr>
            <td>Username</td>
            <td><input type="text" maxlength="32" name="username"/></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="password" maxlength="32" name="password"/></td>
          </tr>
          <tr>
            <td><input class="button" type="submit" value="Login"/></td>
          </tr>
        </form>
      </table>

      <div class="center"><span >No Account? <a href="register">Register Now</a></span></div>
  </div>
</div>
