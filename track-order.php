<?php
session_start();
error_reporting(0);
include 'connection.php';

$oid = intval($_GET['oid']);
?>
<script language="javascript" type="text/javascript">
  function f2() {
    window.close();
  }
  ser

  function f3() {
    window.print();
  }
</script>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<style>
  .orderTrack {
    font-size: large;
    color: red;
  }
</style>

<body style=" background-color:#D3D3D3;">

  <div style="margin-left:50px;">
    <form name="updateticket" id="updateticket" method="post">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr height="50">
          <td colspan="2" class="fontkink2" style="padding-left:0px;">
            <div class="orderTrack"> <b>Order Tracking Details !</b></div>
          </td>
        </tr>
        <hr>
        <tr height="30">
          <td class="fontkink1"><b>order Id:</b></td>
          <td class="fontkink"><?php echo $oid; ?></td>
        </tr>

        <?php
        $st = 'delivered';
        $rt = mysqli_query($conn, "SELECT * FROM orders WHERE orderId='$oid'");
        while ($num = mysqli_fetch_array($rt)) {
?>
          <tr height="30">
          <td class="fontkink1"><b>order Id:</b></td>
          <td class="fontkink"><?php echo $oid; ?></td>
        </tr>

<?
          $currrentSt = $num['orderStatus'];
          if ($currrentSt == '') { ?>
            <tr height="30">
              <td class="fontkink1"><b>Status:</b></td>
              <td class="fontkink" style="color: red;">Order Is Not Processed Yet!!!</td>
            </tr>


          <?php } else { ?>
            <tr height="30">
              <td class="fontkink1"><b>Status:</b></td>
              <td class="fontkink" style="color:green"><?php echo $currrentSt ?></td>
            </tr>


        <? }
        } ?>


      </table>

      <hr>
    </form>
  </div>

</body>

</html>