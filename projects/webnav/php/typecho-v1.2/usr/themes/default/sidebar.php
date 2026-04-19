<div class="sidebar-menu toggle-others fixed">
  <div class="sidebar-menu-inner">
    <header class="logo-env">
      <!-- logo -->
      <div class="logo">
        <img class="logo_size" src="<?php echo empty($this->options->Biglogo()) ? THEME_URL . '/images/logo@2x.png' : $this->options->Biglogo(); ?>" width="100%" alt="<?php $this->options->IndexName(); ?>" />
      </div>
    </header>
    <?php // \Widget\Metas\Category\Rows::alloc('current=2')->listCategories('wrapClass=widget-list'); ?>
    <?php // \Widget\Metas\Category\Rows::alloc('current=2')->listCategories('wrapClass=widget-list'); ?>
    <ul id="main-menu" class="main-menu mobile-is-visible">
      <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
      <?php $defaultCategoryMid = null; ?>

      <?php $navs = $categorys->getAllChildren(THEME_RELATION_META); ?>
      <?php foreach ($navs as $index => $mid) { ?>
        <?php $nav = $categorys->getCategory($mid);
        if ($nav['levels'] != 1)
          continue; ?>
        <?php
        if (empty($defaultCategoryMid)) {
          if (!empty($this->request->get('slug'))) {
            if ($this->request->get('slug') === $nav['slug'])
              $defaultCategoryMid = $nav['mid'];
          } else {
            $defaultCategoryMid = $nav['mid'];
          }
        }
        ?>
        <?php if ($mid == $defaultCategoryMid): ?>

          <?php $sides = $categorys->getAllChildren($nav['mid']); ?>

          <?php foreach ($sides as $side):
            $side = $categorys->getCategory($side); ?>
            <?php if ($side['levels'] != 2)
              continue; ?>
            <?php $children = $categorys->getAllChildren($side['mid']); ?>
            <?php if (empty($children)) { ?>
              <li>
                <a href="#<?php echo $side['name']; ?>" class="smooth">
                  <i class="fa <?php echo str_replace('--', ' ', $side['slug']); ?>"></i>
                  <span class="title"><?php echo $side['name']; ?></span>
                </a>
              </li>
            <?php } else { ?>
              <li>
                <a>
                  <i class="fa <?php echo str_replace('--', ' ', $side['slug']); ?>"></i>
                  <span class="title"><?php echo $side['name']; ?></span>
                </a>
                <ul>
                  <?php foreach ($children as $mid) { ?>
                    <?php $child = $categorys->getCategory($mid); ?>
                    <li>
                      <a href="#<?php echo $child['name']; ?>" class="smooth"><?php echo $child['name']; ?></a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
          <?php endforeach; ?>

        <?php endif; ?>
      <?php } ?>


      <li class="submit-tag">
        <a href="<?php $this->options->Isabout(); ?>">
          <i class="linecons-heart"></i>
          <span class="smooth">关于本站</span>
        </a>
      </li>
    </ul>
  </div>
</div>