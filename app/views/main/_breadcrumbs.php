<nav class="breadcrumb">
  <?php $last = ''; ?>
  <ul itemscope itemtype="http://schema.org/BreadcrumbList">
    <?php foreach ($crumbs as $i => $crumb): ?>
      <?php if ( $i == sizeof($this->breadcrumbs)-1 ): ?>
        <?php $last = $crumb; ?>
        <li class="" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
          <span itemprop="name"><?= $crumb['title'] ?></span>
          <meta itemprop="position" content="<?= $i+1 ?>" />
        </li>
      <?php else: ?>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="<?= $crumb['url'] ?>">
            <span itemprop="name"><?= $crumb['title'] ?></span>
          </a>
          <meta itemprop="position" content="<?= $i+1 ?>" />
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul><!-- .breadcrumbs -->
</nav>
