<div class="container">
  <h1 class="center">Register</h1>
  <!-- main content output -->
  <div class="box">
    <table class="center">
        <?php
        if ($fail == "" && isset($_POST['submitted'])) {
          echo <<<_SUCCESS
          <tr>
            <td><p><font color=green>Validation Sucess</font></p></td>
          </tr>
_SUCCESS;
} else if (isset($fail)) {
        echo <<<_FAIL
        <tr>
          <td colspan="2">
            <p><font color=red>$fail</font></p>
          </td>
        </tr>
_FAIL;
}
        ?>
        <form method="POST" action="register" onSubmit="">
          <input type="hidden" name="submitted" value="true"/>
          <tr>
            <td>Username</td>
            <td><input type="text" maxlength="32" name="username"/></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><input type="text" maxlength="32" name="email"/></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="password" maxlength="32" name="password"/></td>
          </tr>
          <tr>
            <td><input class="button" type="submit" value="Signup"/></td>
          </tr>
        </form>
      </table>

      <div class="center"><span >Already Have an Account? <a href="login">Login Now</a></span></div>
  </div>
</div>
