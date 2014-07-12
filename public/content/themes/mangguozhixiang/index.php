<?php get_header() ?>
    <!--
      The nav bar that will be updated as we navigate between views.
    -->
    <ion-nav-bar class="bar-stable nav-title-slide-ios7 bar-assertive">
      <ion-nav-back-button class="button-icon icon  ion-ios7-arrow-back">
        后退
      </ion-nav-back-button>
    </ion-nav-bar>
    <!--
      The views will be rendered in the <ion-nav-view> directive below
      Templates are in the /templates folder (but you could also
      have templates inline in this html file if you'd like).
    -->
    <ion-nav-view>
      <div  ng-bind="error">
      </div>
    </ion-nav-view>
    <?php get_footer(); ?>

