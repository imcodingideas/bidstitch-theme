<div class="dokan-form-group">
  <label for="post_content" class="control-label">{{ _e('Description', 'dokan-lite') }} <i class="fa fa-question-circle tips" data-title="{{ esc_attr_e('Add your product description', 'dokan-lite') }}" aria-hidden="true"></i></label>
  @php wp_editor( htmlspecialchars_decode( $post_content, ENT_QUOTES ), 'post_content', array('editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_content') ) @endphp
</div>
