<div class="container">
  <h1 class="center">Store Results</h1>
  <?php if (isset($file)) {?>
  <table class= "center">
    <tr>
      <td style="text-align: left">File Name</td>
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
      <td style="text-align: left">Virus Name</td>
      <td style="text-align: left"><?php echo $virusName ?></td>
    </tr>
    <tr>
      <td style="vertical-align: top;text-align: left">Signature</td>
      <td style="text-align: left"><?php echo $twentybytes ?></td>
    </tr>
  </table>
<?php } else {
  echo '<p class="center">No File Scanned</p>';
  echo '<p class="center">' .$fail.'</p>';
}?>
</div>
