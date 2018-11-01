<article <?php post_class('entry'); ?>>
  <div class="entry-wrapper">
    <header>
      <h1 class="entry-title">Page Not Found</h1>
    </header>
    <div class="entry-content">
      <div class="alert alert-warning">Sorry, but we couldn't find the page that you're looking for.</div>
      <p>This could have happened for a few reasons:</p>
      <ul>
        <li>You may have followed an outdated link.</li>
        <li>The page you're looking for might have been moved or deleted.</li>
        <li>There might be a typo in your browser's address bar if you typed the URL.</li>
      </ul>
      <p>Please <a href="<?= home_url(); ?>">return to the homepage</a> or use the navigation menu to find what you're looking for.</p>
    </div>
  </div>
</article>
