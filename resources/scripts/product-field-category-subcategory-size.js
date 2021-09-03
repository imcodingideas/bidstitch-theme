export default function () {
  if (!document.getElementById('product-field-category-subcategory-size'))
    return;

  jQuery(document).ready(function ($) {

    $("#product_cat").change(function (e) {

      var data = $(this).select2('data');

      var category_slug = data[0].element.attributes.slug.value;

      $("#product_cat_sub option:not(:first-child)").remove();
      $("#product_size option:not(:first-child)").remove();

      $("#product_cat_sub").select2("destroy");
      $("#product_size").select2("destroy");


      // set loading
      $('.product-field-category-subcategory-size__loading-sub').show();
      $.ajax({
        type: 'POST',
        url: bidstitchSettings.ajaxUrl,
        data: {
          action: 'get_a_child_category',
          category_slug: category_slug,
        },
        success: function (response) {

          $.each(response, function () {
            $("#product_cat_sub").append('<option value="' + this.id + '" slug="' + this.slug + '">' + this.name + '</option>');
          });
          $('.product-field-category-subcategory-size__loading-sub').hide();
        }
      });

      $('.product-field-category-subcategory-size__loading-size').fadeIn();
      $.ajax({
        type: 'POST',
        url: bidstitchSettings.ajaxUrl,
        data: {
          action: 'get_tag_size_by_category',
          category_slug: category_slug,
        },
        success: function (response) {

          $.each(response, function () {
            $("#product_size").append('<option value="' + this.id + '" slug="' + this.slug + '">' + this.name + '</option>');
          });
          $('.product-field-category-subcategory-size__loading-size').hide();
        }
      });


      $("#product_cat_sub").select2();
      $("#product_size").select2();

    });

  });
}



