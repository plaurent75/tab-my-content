(function( $ ) {
	'use strict';

  $(function() {
    $( "#tab_post_parent_selector" ).autocomplete({
      delay: 500,
      minLength: 3,
      source: function(req, response){
        $.getJSON(TabMCAutocomplete.url+'?callback=?&action=tabmc_lookup', req, response);
      },
      select: function(event, ui) {
        $('#tabmc_parent_post_id').val(ui.item.post_id);
        $('#tab_post_parent_link').attr('href',ui.item.link);

        var edit_post_url = TabMCAutocomplete.edit_post_url + '&post=' + ui.item.post_id;

        $('#tab_post_parent_edit_link').attr('href',edit_post_url);
        $('.tabmc_metabox a').show();
      },

    });
  });

  $(document).on('click', '#tab_post_parent_link_delete', function(e){
  	e.preventDefault();
    if (confirm('Are you sure ?')) {
      $('#tab_post_parent_selector').val('');
      $('#tabmc_parent_post_id').val('');
      $('.tabmc_metabox a').hide();
    }
	});
  $(document).ready(function($){
    const TabmcSortableItem = $( "#tabmc_sortable" );
    TabmcSortableItem.sortable({
      revert: true,
      update: function () { save_new_order() }
    }).disableSelection();

  });
  function save_new_order() {
    var a = [];
    $('#tabmc_sortable').children().each(function (i) {
      a.push($(this).attr('data-tab-id') + ':' + i);
    });
    var menu_order = a.join(',');
    jQuery.post('admin-ajax.php', {order:menu_order,action:'tabmc_order'});
  }

})( jQuery );
