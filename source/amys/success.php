<?php
require_once('inc/header.php');
?>

    <section class="amy-success">
      <div class="section-inner">
        
        <hgroup>
          <h1 class="u-text-center u-text-pacifico">Hurrah!</h1>
          <h2 class="u-text-center u-text-meek u-text-size-4">Your amy has been awarded</h2>
        </hgroup>

        <div class="restricted-width">
          <?php $voucher = rand(1, 7); ?>

          <p>Now why not print the voucher and go present it to them in person to really show how awesome they are. Don't forget to give them a hug or hi five.</p>
          <a href="/amys/vouchers/voucher-<?php echo $voucher; ?>.pdf" class="button">Print their award.</a>
          <figure>
            <a href="/amys/vouchers/voucher-<?php echo $voucher; ?>.pdf"><img src="assets/img/voucher-<?php echo $voucher; ?>.png" alt="Award"></a>
          </figure>
        </div>

      </div>
    </section>

    <section class="amy-success-next">
      <div class="section-inner">

        <h1 class="u-text-center u-text-size-2 u-text-pacifico">What happens next?</h1>

        <div class="restricted-width">
          <ol>
            <li>You'll receive a confirmation email.</li>
            <li>Angela Shaw will receive an email enabling her to process the award. She will request 2,000 WoW points (worth &pound;20.00) from HR on the recipient's behalf. This happens on the 11th of each month. The WoW points should arrive in about 6-8 weeks.</li>
            <li>The recipient will receive an email telling them that they've received an Amy. You can present the voucher in person as soon as you choose to.</li>
          </ol>
        </div>

      </div>
    </section>

<?php
require_once('inc/footer.php');
?>