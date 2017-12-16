<div class="container center">
    <h1>Test a File</h1>
    <form method="POST" action="home/scan" enctype='multipart/form-data'>
      <input type="hidden" name="scansubmit">
      <input type="file" name="scan_filename">
      <input type="submit" value="Upload File">
    </form>
</div>
<?php
  if (isset($_SESSION['userID'])) {
    if ($_SESSION['userID'] == 1) {
      echo <<<_UPLOAD
      <div class="container center">
          <h1>Add to Malware Database</h2>
          <table class="center">
            <form method="POST" action="home/store" enctype='multipart/form-data'>
              <input type="hidden" name="storesubmit">
              <tr>
                <td>Virus Name: <input type="text" maxlength="32" name="virus_name"></td>
              </tr>
              <tr>
                <td><input type="file" name="store_filename"></td>
                <td><input type="submit" value="Upload File"></td>
              </tr>
            </form>
          </table>
      </div>
_UPLOAD;
    }
  }
?>
