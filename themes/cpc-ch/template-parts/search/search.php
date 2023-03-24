<?php if ( has_nav_menu( 'navigation' ) ) : ?>

<section id="cpcSearchModal">
  <div id="searchPopup" aria-live="assertive" role="dialog" aria-hidden="true">
    <div id="searchModalInputRow">
      <div id="searchModalClose" aria-label="<?php echo __('Close', 'cpc-ch') ?>" tabindex="0"></div>
      <div id="searchModalInputContainer">
        <label for="searchModalInput" class="visually-hidden"><?php echo __('Search products, related articles and support topics', 'cpc-ch') ?></label>
        <input id="searchModalInput" class="searchInputCommonArea" type="text" placeholder="<?php echo __('Search our website', 'cpc-ch') ?>" />
        <span id="searchInputError" class="searchInputCommonArea" aria-live="assertive" role="alert"><?php echo __('Please enter a topic. Examples: send packages, change my address', 'cpc-ch') ?></span>
      </div>
      <div id="searchModalBtn" aria-label="<?php echo __('Search', 'cpc-ch') ?>" tabindex="0"></div>
    </div>
    <div id="searchResultsRow">
      <div id="searchModalResults">
      </div>
      <div id="searchModalQuickLinks">
        <h2>
        <?php 

           if ( is_plugin_active( 'cmb2/init.php') ) {
              if ( preg_match('/fr/', get_locale()) ) {
                $set_lang = 'french';
                echo cmb2_get_option( 'cpc_ch_theme_options', 'cpc_search_tag_title_french' );
              } else {
                $set_lang = 'english';
                echo cmb2_get_option( 'cpc_ch_theme_options', 'cpc_search_tag_title_english' );
              }
            }
        ?>
        </h2>
        <?php 

          if ( is_plugin_active( 'cmb2/init.php') ) {
            $entries = cmb2_get_option( 'cpc_ch_theme_options', 'cpc_search_tag_group_' . $set_lang );
            if ($entries[0] && isset($entries[0]['label'])) {
              foreach ( (array) $entries as $key => $entry ) {
                echo '<div class="search-modal-quick-link" role="link" tabindex="0" data-href="' . esc_html( $entry['url'] ) . '">' . esc_html( $entry['label'] ) . '</div>';
              }
            }
          }
        ?>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>