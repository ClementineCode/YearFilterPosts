<?php
// Register shortcode
add_shortcode('filter_posts_by_year', 'filter_posts_by_year_shortcode');
 ?> 
<?php
// Shortcode function
function filter_posts_by_year_shortcode() { ob_start();
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $query = new WP_Query($args);
    ?>

<style>
.filter-links {
    display: flex;
    flex-direction: row;
    align-content: center;
    align-items: center;
    justify-content: center;
}

.filter-links a{
    padding-left: 10px;
    padding-right: 10px;
    margin-right: 5px;
    margin-left: 5px;
    border: 4px solid #717171;
    color: #717171;
    font-weight: 700;
}
</style>

    <div class="filter-links">
        <a href="#" data-year="all" class="active">All</a>
        <?php
        $years = array();
        while ($query->have_posts()) {
            $query->the_post();
            $year = get_the_date('Y');
            if (!in_array($year, $years)) {
                $years[] = $year;
                echo '<a href="#" data-year="' . $year . '">' . $year . '</a>';
            }
        }
       
        ?>
    </div>
    <div class="posts-container">
        <?php
        while ($query->have_posts()) {
            $query->the_post();
            $year = get_the_date('Y');
            ?>
            <div class="post" data-year="<?php echo $year; ?>">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </div> <?php } ?>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.filter-links a').click(function(e) {
                e.preventDefault();
                $('.filter-links a').removeClass('active');
                $(this).addClass('active');
                var year = $(this).data('year');
                if (year == 'all') {
                    $('.post').show();
                } else {
                    $('.post').hide();
                    $('.post[data-year="' + year + '"]').show();
                }
            });
        });
    </script>

<?php return ob_get_clean();
    wp_reset_postdata(); 
};

