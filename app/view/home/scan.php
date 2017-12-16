<div class="container">
  <h1 class="center">Scan Results</h1>
  <?php if (isset($file)) {?>
  <table class= "center">
    <tr>
      <td style="text-align: left">Name</td>
      <td style="text-align: left"><?php echo $file['name'] ?></td>
    </tr>
    <tr>
      <td style="text-align: left">Type</td>
      <td style="text-align: left"><?php echo $file['type'] ?></td>
    </tr>
    <tr>
      <td style="text-align: left">Size</td>
      <td style="text-align: left"><?php echo $file['size'] ?></td>
    </tr>
    <tr>
      <td style="text-align: left">Result</td>
      <td style="text-align: left"><?php if (count($result) != 0) echo 'Infected'; else echo 'Clean'; ?></td>
    </tr>
  </table>
  <table class="center">
    <?php if(isset($result)) {
      if (count($result) != 0) {
echo <<<_HEADER
      <tr>
        <th>Name</th>
        <th>Byte Location</th>
      </tr>
_HEADER;
}
      foreach($result as $key => $val) {
echo <<<_ROW
      <tr>
        <td>$key</td>
        <td>$val</td>
      </tr>
_ROW;
        }
      }?>
  </table>
<?php } else {
  echo '<p class="center">No File Scanned</p>';
}?>
</div>
