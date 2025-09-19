<?php
    // get total amount of posts -- $all_posts_count defined in home.php

    // define how many posts on page -- $posts_per_page defined in home.php

    // get how many pages there'll be -- $pages defined in home.php

    // define current page somewhere -- $current_page defined in home.php
    
    // show Prev & Next conditionally -- DONE

    // highlight current page in html below and disable this btn -- DONE

    // make all other btns functional -- DONE
?>

<!-- ======================================================================================================================== -->

<?= 'current page is ' . $current_page ?>
<div class="flex justify-center space-x-2 my-10 pagination">
  <!-- Previous button -->
   <?php if ($current_page > 1):?>
  <button class="px-3 py-1 rounded border border-gray-600 bg-gray-800 text-gray-200 hover:bg-gray-700 active:bg-gray-500 outline-none btn-prev" data-page="prev">
    < Prev
  </button>
  <?php endif; ?>

  <!-- Page numbers -->
   <?php for($i = 0; $i < $pages; $i++): ?>
        <button class="px-3 py-1 rounded border border-gray-600 text-gray-200 outline-none btn-page <?= (int) $current_page === $i+1 ? 'bg-black' : 'bg-gray-800 hover:bg-gray-700 active:bg-gray-500' ?>" 
            <?= (int) $current_page === $i+1 ? 'disabled' : '' ?>
            data-page="<?= $i+1 ?>"
            <?= (int) $current_page === $i+1 ? 'aria-current="page"' : '' ?>
        >
            <?= $i+1; ?>
        </button>
   <?php endfor; ?>

  <!-- Next button -->
   <?php if ($current_page < $pages):?>
  <button class="px-3 py-1 rounded border border-gray-600 bg-gray-800 text-gray-200 hover:bg-gray-700 active:bg-gray-500 outline-none btn-next" data-page="next">
    Next >
  </button>
  <?php endif; ?>
</div>

<!-- 

Minor considerations to potentially improve later:

- Query parameters: currently I rebuild ?current_page=..., losing other GET parameters if present.
- Performance: for very large tables, COUNT(*) might slow queries — can be optimized with indexes.
- Edge case: when $all_posts_count = 0, $pages will be 0, which might break if ($current_page > $pages) logic. I may want max(1, ceil(...)).

-->