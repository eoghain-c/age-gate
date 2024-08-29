<?php 
session_start(); 
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html(get_bloginfo('name')); ?> - Age Verification</title>
    <?php wp_head(); ?>
    <style>
        .sr-only {
            position: absolute;
            left: -10000px;
            top: auto;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }
    </style>
</head>
<body <?php body_class('age-gate-body'); ?>>
    <section class="age-gate">
        <header class="age-gate__header">
            <img src="<?php echo esc_url(wp_get_attachment_image_src(get_field('logo', 'options'))[0]); ?>" alt="Company Logo" class="age-gate__logo"/>
            <h1 class="sr-only">Age Gate</h1>
            <h2 class="age-gate__heading"><?php echo esc_html(get_field('ag_heading', 'options')); ?></h2>
            <p class="age-gate__message"><?php echo esc_html(get_field('ag_message', 'options')); ?></p>
            <?php if (!empty($_SESSION['age-gate-error'])): ?> 
                <p class='error-message' aria-live='assertive'><?php echo esc_html(get_field('ag_error_message', 'options')); ?></p>
            <?php endif; ?>
        </header>

        <?php if (!isset($_POST['province'])): ?>
        <form id="age-gate-form" method="post" action="<?php echo esc_url(home_url('/age-gate')); ?>">
            <div class="tab">
                <div class="ag-select-wrapper field">
                    <select name="province" id="province" class="age-gate-location" required>
                        <option value="" disabled selected>Province</option>
                        <option value="ab">Alberta</option>
                        <option value="bc">British Columbia</option>
                        <option value="mb">Manitoba</option>
                        <option value="nb">New Brunswick</option>
                        <option value="nl">Newfoundland and Labrador</option>
                        <option value="nt">Northwest Territories</option>
                        <option value="ns">Nova Scotia</option>
                        <option value="nu">Nunavut</option>
                        <option value="on">Ontario</option>
                        <option value="pe">Prince Edward Island</option>
                        <option value="qc">Quebec</option>
                        <option value="sk">Saskatchewan</option>
                        <option value="yt">Yukon</option>
                    </select>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn--age-gate" id="nextBtn" name="submit">Next</button>
            </div>
        </form>
        <?php else: ?>
        <form id="age-gate-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="agegate">
            <input type="hidden" name="province" value="<?php echo esc_attr($_POST['province']); ?>">
            
            <div class="tab">	
                <label for="m" class="sr-only">Date of Birth</label>
                <div class="field">
                    <label for="m" class="sr-only">Month</label>
                    <input type="number" id="m" min="1" max="12" class="age-gate-date" size="2" name="month" placeholder="MM" required>
                </div>
                <div class="field">
                    <label for="d" class="sr-only">Day</label>
                    <input type="number" id="d" min="1" max="31" class="age-gate-date" size="2" name="day" placeholder="DD" required>
                </div>
                <div class="ag-select-wrapper field">
                    <label for="y" class="sr-only">Year</label>
                    <select id="y" class="age-gate-date" name="year" required>
                        <option value="" disabled selected hidden>YYYY</option>
                        <?php for($i = intval(date("Y")); $i >= 1900; $i--): ?>
                            <option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn--age-gate" id="nextBtn" name="submit">Enter Site</button>
            </div>
        </form>
        <?php endif; ?>
    </section>
    <?php wp_footer(); ?>
</body>
</html>