<?php

namespace Core;

defined('ROOT') or die('Direct script access denied');

/**
 * Pager Class
 *
 * This class provides pagination functionality for generating and displaying pagination links.
 */
class Pager
{

    public array $links      = [];
    public int $limit        = 10;
    public int $offset       = 0;
    public int $start        = 1;
    public int $end          = 1;
    public int $page_number  = 1;

   
    /**
     * Constructor for Pager class.
     *
     * @param int $limit   The number of items per page.
     * @param int $extras  Additional pages to display before and after the current page.
     */
    public function __construct(int $limit = 10, $extras = 1)
    {
        $page_number = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        $page_number = $page_number < 1 ? 1 : $page_number;

        $this->start = $page_number - $extras;
        $this->end = $page_number + $extras;

        $this->page_number = $page_number;

        $this->offset = ($page_number - 1) * $limit;

        $url = $_GET['url'] ?? 'home';
        $query_string = str_replace("url=", "", $_SERVER['QUERY_STRING']);
        $current_link = ROOT . '/' . $url . '?' . trim(str_replace($url, "", $query_string), '&');
        if (!strstr($current_link, 'page='))
            $current_link .= '&page=' . $page_number;

        $first_link = preg_replace("/page=[0-9]+/", "page=1", $current_link);
        $next_link = preg_replace("/page=[0-9]+/", "page=" . ($page_number + $extras + 1), $current_link);

        $this->links['current'] = $current_link;
        $this->links['first']   = $first_link;
        $this->links['next']    = $next_link;
    }

    /**
     * Display pagination links in Bootstrap style (default).
     */
	public function display()
	{
	    ?>
	    <!-- Implement Bootstrap pagination links here -->
	    <nav aria-label="Page navigation example">
	        <ul class="pagination">
	            <li class="page-item"><a class="page-link" href="<?= $this->links['first'] ?>">First</a></li>

	            <?php for ($x = $this->start; $x <= $this->end; $x++) : ?>
	                <li class="page-item <?= $x === $this->page_number ? 'active' : '' ?>">
	                    <a class="page-link" href="<?= preg_replace("/page=[0-9]+/", "page=" . $x, $this->links['current']) ?>"><?= $x ?></a>
	                </li>
	            <?php endfor ?>

	            <li class="page-item"><a class="page-link" href="<?= $this->links['next'] ?>">Next</a></li>
	        </ul>
	    </nav>
	    <?php
	}


    /**
     * Display pagination links in Tailwind CSS style.
     */
    public function displayTailwind()
    {
        ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="<?= $this->links['first'] ?>">First</a></li>

                <?php for ($x = $this->start; $x <= $this->end; $x++) : ?>
                    <li class="page-item <?= $x == $this->page_number ? 'active' : '' ?>">
                        <a class="page-link" href="<?= preg_replace("/page=[0-9]+", "page=" . $x, $this->links['current']) ?>"><?= $x ?></a>
                    </li>
                <?php endfor ?>

                <li class="page-item"><a class="page-link" href="<?= $this->links['next'] ?>">Next</a></li>
            </ul>
        </nav>
        <?php
    }



    /**
     * Display custom pagination links.
     */
    public function displayCustom()
    {
        ?>
                <!-- Implement custom pagination links here -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="<?= $this->links['first'] ?>">First</a></li>

                <?php for ($x = $this->start; $x <= $this->end; $x++) : ?>
                    <li class="page-item <?= $x == $this->page_number ? 'active' : '' ?>">
                        <a class="page-link" href="<?= preg_replace("/page=[0-9]+", "page=" . $x, $this->links['current']) ?>"><?= $x ?></a>
                    </li>
                <?php endfor ?>

                <li class="page-item"><a class="page-link" href="<?= $this->links['next'] ?>">Next</a></li>
            </ul>
        </nav>
        <?php
    }
}
