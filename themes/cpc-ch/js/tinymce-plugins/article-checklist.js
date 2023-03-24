/*
 * Adds a new custom blockquote button.
 * If text is selected, the button will toggle blockquote markup around the selection.
 * If no text is selected, a pop-up will display options for quote, citation, citation link.
 */

(function() {
        tinymce.create('tinymce.plugins.formatted_checklist', {
            init : function(ed, url) {
              ed.addButton('formatted_checklist', {
                title: "Checklist",
                icon: "checkmark",
        onclick : function() {

          var body = [
            {
              type: 'textbox',
              name: 'checklist_title',
              label: 'Checklist Title'
            },
            {
              type: 'textbox',
              name: 'checklist',
              label: 'Checklist Item'
            }
          ];

          ed.windowManager.open({
            title: 'Checklist Item',
            body: body,
            onsubmit: function( e ) {         
              ed.insertContent('<h4 style="font-family: Roboto; font-size: 18px; font-weight: 400; line-height: 28px; letter-spacing: 0.8px;"><span class="ch-article-checklist">' + e.data.checklist_title + '</span></h4><ul class="ch-article-checklist-list"><li>' + e.data.checklist + '</li></ul>');
            }
          });
        }
              });
            },
            createControl : function(n, cm) {
               return null;
            },
            getInfo : function() {
               return {
                  longname : "Checklist",
                  author : 'Josh Doodnauth',
                  authorurl : 'http://www.canadapost-postescanada.ca',
                  infourl : '',
                  version : "1.0"
               };
            }
    });
    
   tinymce.PluginManager.add('formatted_checklist', tinymce.plugins.formatted_checklist);
})();