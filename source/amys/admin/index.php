<?php
// php needs a timezone set otherwise it freaks
date_default_timezone_set("Europe/London");

// The database wrapper
require_once ('../inc/db/MysqliDb.php');

// environment settings
require_once ('../inc/env_set.php');

// COnnect to the DB
$db = new MysqliDb ($db_location, $db_user, $db_pass, $db_data);

// Get the awards given in this month or as defined in the (valid) querystring.

$m = $_GET['m'];
$y = $_GET['y'];
if ( isset($m) && is_numeric($m) && $m <= 12 && isset($y) && is_numeric($y) && $y < 2050 ) { // Fuck me, I hope this is dead by 2050
  
  $params = array($m, $y);
  $db->orderBy("id","desc");
  $awards = $db->rawQuery("SELECT * FROM awards WHERE MONTH(award_date) = ? AND YEAR(award_date) = ?", $params);

  // Allow link back to previous year
  if ( $m == 1 ) {
    $prev_month = 12;
    $prev_year = $y - 1;
  } else {
    $prev_month = $m - 1;
    $prev_year = $y;
  }

  // If nothing awarded, deal with the title
  if ( !$awards ){
    $empty_month = $m;
    $empty_year = $y;
  }
  

} else {

  // $db->where ("MONTH(award_date) = 8");
  $db->where ("MONTH(award_date) = MONTH( now() ) AND YEAR(award_date) = YEAR( now() )");
  $db->orderBy("id","desc");
  $awards = $db->get ("awards");

  $current_month = date("n");
  $current_year = date("Y");
  if ( $current_month == 1 ) {
    $prev_month = 12;
    $prev_year = $current_year - 1;
  } else {
    $prev_month = $current_month - 1;
    $prev_year = $current_year;
  }
  

}

// The header
$header_style = 'slim';
require_once('../inc/header.php');
?>


    <section>
      <div class="section-inner">

        <?php
        if ( $awards ) {
        ?>
        <hgroup>
          <h1 class="u-text-size-3">Recipients in <?php 
          echo $empty_month ;
          if ( $empty_month != "" ) {
            $empty_date = $empty_year . "-" . $empty_month . "-00 00:00:00";
            echo date("F Y", strtotime( $empty_date ));
          } else {
            echo date("F Y", strtotime( $awards[0]['award_date'] ));
          }
          ?></h1>
        </hgroup>
        
        <table>
          <thead>
            <tr>
              <th class="left-align">Awarded to</th>
              <th class="left-align">Awarded by</th>
              <th class="">Date</th>
              <th class="">Processed</th>
              <th class=""></th>
              <th class=""></th>
            </tr>
          </thead>

          <?php foreach ($awards as $award) { 
            // print_r($award);
          ?>
          <tr <?php if ($award['void_date']) { ?>class="void"<?php } ?> >
            <td><?php echo trim($award['recipient_name']); ?></td>
            <td><?php echo trim($award['giver_name']); ?></td>
            <td class="center-align"><?php echo date("jS M Y", strtotime( $award['award_date'] ));?></td>
            <td class="center-align">
            <?php
            if ($award['processed_date']) {
              echo 'Yes';
            } else {
              echo 'No';
            }
            ?>
            </td>
            <td>
            <?php if (!$award['processed_date']) { ?>
              <?php if (!$award['void_date']) { ?>
              <a href="process.php?id=<?php echo $award['ID']; ?>" title="Mark this award as processed.">Process.</a>
              <?php } else { ?>
              Process
              <?php } ?>
            <?php } ?>
            </td>
            <td>
            <?php if (!$award['void_date']) { ?>
              <a href="void.php?id=<?php echo $award['ID']; ?>" title="Void this award." class="void">Void.</a>
            <?php } ?>
            </td>
          </tr>
        <?php } ?>

        </table>
        <?php
        }else{
        ?>

        <hgroup>
          <h1 class="u-text-size-3">Recipients in <?php 
            $empty_date = $empty_year . "-" . str_pad($empty_month, 2, '0', STR_PAD_LEFT) . "-01 00:00:00";
            echo date("F Y", strtotime( $empty_date )); ?></h1>
        </hgroup>
        <p>Nothing awarded so far this month.</p>

        <?php
        }
        ?>

        <?php if ( isset($m) ) {?>
        <a href="/amys/admin/" style="float:right;">Current month.</a>
        <?php } ?>
        <a href="?m=<?php echo $prev_month; ?>&y=<?php echo $prev_year; ?>">Previous month.</a>
        

      </div>
    </section>

<?php
require_once('../inc/footer.php');
?>