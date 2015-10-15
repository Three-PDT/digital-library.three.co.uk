
  </main>
  <footer>

    <div class="footer-inner">

      Value: 
<?php
// This isn't a database pull because I'm lazy and there's no caching in place.
$value = rand(1,9);

switch ($value) {
  case 1:
    echo "<b>Fearless challengemongering</b> - This person fights for what they believe in - constructively, with conviction, and with humility.";
  break;

  case 2:
    echo "<b>Authenticity</b> - This person is their same authentic self at the office as they are at home or in the pub, no matter who's around.";
  break;

  case 3:
    echo "<b>Giving a damn</b> - This isn't a 'job' for this person; it’s a calling. They're driven intrisincally and care deeply about their work.";
  break;

  case 4:
    echo "<b>Being a kind guru, not a selfish genius</b> - This person shares their expertise generously - enabling the team to flourish.";
  break;

  case 5:
    echo "<b>Macro-leading, not micro-managing</b> - This person has a clear vision, and trusts and inspires people to deliver it.";
  break;

  case 6:
    echo "<b>Collaboration</b> - This person proactively seeks collaboration, leading to thinking which is greater than the sum of its parts.";
  break;

  case 7:
    echo "<b>Genchi genbutsu</b> - This person seeks insight for themselves. They don't just rely on assumptions and opinions.";
  break;

  case 8:
    echo "<b>Outcomes over artefacts</b> - This person impacts KPIs without creating bloat.";
  break;

  case 9:
    echo "<b>Weniger aber besser</b> - This person focuses on the essence of the problem and nails it. They do less, but better.";
  break;
  
  default:
    # code...
  break;
}
?>

    </div>

  </footer>

  <script src="/amys/assets/js/amy.min.js"></script>

</body>

</html>