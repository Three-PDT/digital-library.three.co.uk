<?php
// The database wrapper
require_once ('inc/db/MysqliDb.php');

// environment settings
require_once ('inc/env_set.php');

// COnnect to the DB
$db = new MysqliDb ($db_location, $db_user, $db_pass, $db_data);
//$db = new MysqliDb ('127.0.0.1:3307', 'root', 'pa55word', 'the_amys');

// Get the culture values
$cols = Array ("id", "full_name", "shortened_name", "description");
$amy_values = $db->get ("amy_values", null, $cols);

// Get the number of awards given in this month. (DEBUG = August)
// $db->where ("MONTH(award_date) = 8");
$db->where ("MONTH(award_date) = MONTH( now() ) AND YEAR(award_date) = YEAR( now() )");
$db->where ("void_date is NULL");
$awards_in_month = $db->get("awards");
$awards_in_month_count = $db->count;
$awards_per_month = 15;
$awards_in_month_left = $awards_per_month - $awards_in_month_count;

// Get the previous winners (FIXME previous month, or querystrong month?)
$db->where ("MONTH(award_date) = MONTH( CURRENT_DATE - INTERVAL 1 MONTH ) AND YEAR(award_date) = YEAR( CURRENT_DATE - INTERVAL 1 MONTH )");
$db->where ("void_date is NULL");
$db->orderBy("id","desc");
$awards = $db->get ("awards", 6);

// php needs a timezone set otherwise it freaks
date_default_timezone_set("Europe/London");

// The header
require_once('inc/header.php');
?>

    <section id="amy-award-intro">
      <div class="section-inner">

        <div class="group">
          <div class="amy-award-intro__copy">
            
            <h1 class="u-text-size-2 u-text-pacifico">What are they?</h1>
            <p>The Amys are our reward scheme for recognising people who nail our <a href="http://culture.three-digital.co.uk">cultural values</a>. <strong>Anyone can reward anyone else.</strong> It's a system with high impact and minimum bureaucracy, built on trust and transparency - there are <em>no</em> approvals.</p>
            <p>We have a set amount of vouchers to give out each month, they don't roll over. When they're gone they're gone.</p>
            <p>So go, get out there, start rewarding those excellent people you work with. </p>

          </div>
          <div class="amy-award-intro__number">

              <div class="amy-process">
                <span class="amy-process__count u-text-size-000"><b><?php echo $awards_in_month_left; ?></b></span>
                <span class="amy-process__explain u-text-size-5">Amys left this month.</span>
                <p class="u-text-knockback">This will reset on the 1st of <?php echo date("F", strtotime('next month'));?>.</p>

                <?php if ($awards_in_month_left > 0) { ?>
                <button id="js-amy-award-open" tabindex="1">Send someone an Amy.</button>
                <?php } ?>
              </div>

          </div>
        </div>

      </div>
    </section>

    <?php if ($awards_in_month_left > 0) { ?>
    <section id="amy-award-start" style="display:none;">
      <div class="section-inner">

        <form action="process.php" method="post" name="amy-award-form" id="amy-award-form">
          <input type="hidden" name="poohbear" value="">

          <div class="grid grid--gutters med-grid--gutters large-grid--gutters">
            <div class="grid-cell grid-cell--1of3">
              

              <label>
                <span>What's your name? <em class="u-text-knockback">(required)</em></span>
                <input type="text" required name="amy_giver" class="text" tabindex="2">
              </label>
              <label>
                <span>What's your email address? <em class="u-text-knockback">(required)</em></span>
                <input type="email" required name="amy_giver_email" class="text" tabindex="3">
              </label>
              <label>
                <span>Who would you like to reward? <em class="u-text-knockback">(required)</em></span>
                <input type="text" required name="amy_recipient" class="text" tabindex="4">
              </label>
              <label>
                <span>What's their email address? <em class="u-text-knockback">(required)</em></span>
                <input type="email" required name="amy_recipient_email" class="text" tabindex="5">
              </label>


            </div>
            <div class="grid-cell grid-cell--2of3">

              <label class="large-check-block_label">
                <span>Which cultural values has this person exhibited? <em class="u-text-knockback">(required)</em></span>
                <span class="explainer">You can choose up to a maxmium of three.</span>
              </label>

              <fieldset class="large-check-block" id="js-amy-award-values">

              <?php 
                $tabindex = 6;

                foreach ($amy_values as $amy_value) { 

                ?>
                <label class="check">
                  <input type="checkbox" name="amy_value_id[]" value="<?php echo $amy_value['id']; ?>" tablindex="<?php echo $tabindex; ?>">
                  <span><?php echo $amy_value['full_name']; ?></span>
                  <span class="explainer"><?php echo $amy_value['description']; ?></span>
                </label>
              <?php 
                $tabindex++;
                } ?>

              </fieldset>

              <label>
                <span>Tell us more. <em class="u-text-knockback">(256 characters max)</em></span>
                <textarea required maxlength="256" class="text" name="explanation" value="" tabindex="<?php echo $tabindex; ?>"></textarea>
              </label> 


              <p>Make sure the details are correct - you won't have a chance to review.</p>

              <button tabindex="<?php echo $tabindex + 1; ?>">Send this Amy!</button>

              <p><a href="#" id="js-amy-award-cancel">Cancel.</a></p>

            </div>
          </div>

        </form>

      </div>
    </section>
    <?php } ?>

    <section>
      <div class="section-inner">

        <h1 class="u-text-size-2 u-text-center u-text-pacifico">How to give someone an Amy.</h1>

        <ul class="steps claire-faye-lisa-lee-h">
          <li>
            <span>1</span>
            <div>Spot someone hitting our values.</div>
          </li>
          <li>
            <span>2</span>
            <div>Come here and click the button.</div>
          </li>
          <li>
            <span>3</span>
            <div>Fill in all the details.</div>
          </li>
          <li>
            <span>4</span>
            <div>They'll get an virtual hi-five.</div>
          </li>
          <li>
            <span>5</span>
            <div>Give them a real world hi-five too.</div>
          </li>
        </ul>

      </div>
    </section>

<!--
    <section class="video-container">
      <div class="section-inner">
        
        <div class="video-embed">
          <div class="video-embed__content">
            <iframe src="https://player.vimeo.com/video/136019707" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        </div>

      </div>
    </section>
-->

    <section class="previous-winners">
      <div class="section-inner">
        
        <hgroup>
          <h1 class="u-text-center u-text-pacifico">Previous winners</h1>
          <h2 class="u-text-center u-text-meek u-text-size-4"><?php echo date("F", strtotime('last month'));?></h2>
        </hgroup>

        <ul class="block-list">

          <?php foreach ($awards as $award) { ?>
          <li>
            <article class="card">
              <h1 class="u-text-size-4"><?php echo $award['recipient_name']; ?></h1>
              <ul class="skills">
                <?php
                $awarded_amy_values = array($award['amy_value_1'], $award['amy_value_2'], $award['amy_value_3']);
                foreach ($amy_values as $amy_value) {

                  $tag_class = strtolower( str_replace(" ", "-", $amy_value['shortened_name']) );

                  if (in_array($amy_value['id'], $awarded_amy_values)) {
                    echo "<li><span class='skills-tag skills-tag--".$tag_class."'>".$amy_value['shortened_name']."</span></li>";
                  }
                }
                ?>
              </ul>
              <p>&ldquo;<?php echo trim($award['explanation']); ?>&rdquo;</p>
              <cite><?php echo trim($award['giver_name']); ?></cite>
              
              <span class="corners"></span>
            </article>
          </li>
        <?php } ?>

        </ul>

      </div>
    </section>

    <section>
      <div class="section-inner">
        
        <h1 class="u-text-center u-text-size-2 u-text-pacifico">Still confused?</h1>

        <div class="grid grid--full grid--gutters med-grid--gutters large-grid--gutters med-grid--fit">
          <div class="grid-cell">

            <dl>
              <dt>Q: You said there are no approvals, are you sure?</dt>
              <dd>A: Of course. There are none, nil, nada. You do not need any kind of approval from anyone at all to reward a colleague.</dd>
              <dt>Q: But surely someone needs to approve it?</dt>
              <dd>A: No, they really don't. Really.</dd>
              <dt>Q: Can I reward more than one person each month?</dt>
              <dd>A: Yes, if you think they deserve it you can reward as many people as you want.</dd>
              <dt>Q: What happens when the vouchers run out?</dt>
              <dd>A: Nobody else can be rewarded for the rest of the month.</dd>
            </dl>

          </div>
          <div class="grid-cell">

            <dl>
              <dt>Q: What happens to any leftover "Amys" at the end of the month?</dt>
              <dd>A: They'll be destroyed. No rollovers. Use them or lose them. We have OPEX saving targets you know.</dd>
              <dt>Q: So I should reward the people who work the hardest and do the longest hours then?</dt>
              <dd>A: No, you should reward the people who inspire you, make a difference to our customers, make you smile and make you proud to be part of this team.</dd>
              <dt>Q: What are these cultural values I'm hearing about?</dt>
              <dd>A: You're already on the website. Take a look here: <a href="http://culture.three-digital.co.uk">culture.three-digital.co.uk</a></dd>
            </dl>

          </div>
        </div>

      </div>
    </section>

<?php
require_once('inc/footer.php');
?>