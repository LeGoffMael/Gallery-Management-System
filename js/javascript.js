/**
 * Set values in the search auto complete
 */
function setTypahead(input) {
    var categoriesList = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: './php/functions/getCategoriesByValue.php?value=%QUERY',
            wildcard: '%QUERY'
        }
    });

    var tagsList = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: './php/functions/getTagsByValue.php?value=%QUERY',
            wildcard: '%QUERY'
        }
    });
    
    input.typeahead({
        highlight: true,
        hint: false
    },
    {
        name: 'categories',
        display: 'name',
        source: categoriesList,
        templates: {
            header: '<h3 class="typeSearch-name">Categories</h3>',
            suggestion: Handlebars.compile('<div><strong>{{name}}</strong> - {{nb}}<i class="fa fa-picture-o" aria-hidden="true"></i></div>')
        }
    },
    {
        name: 'tags',
        display: 'name',
        source: tagsList,
        templates: {
            header: '<h3 class="typeSearch-name">Tags</h3>',
            suggestion: Handlebars.compile('<div><strong>{{name}}</strong> - {{nb}}<i class="fa fa-picture-o" aria-hidden="true"></i></div>')
        }
    });

    /* If no data found : https://github.com/twitter/typeahead.js/issues/780 */
    const emptyMessage = '<div class="empty-message">No matches found.</div>';
    const emptyMessageNode = $(emptyMessage);
    // hide empty message by default
    emptyMessageNode.hide();
    // get menu element and append hidden empty messsage element
    const menuNode = input.data('tt-typeahead').menu.$node;
    menuNode.append(emptyMessageNode);

    input.on('typeahead:asyncreceive', function () {
        if ($(this).data('tt-typeahead').menu._allDatasetsEmpty()) {
            // hide dataset result containers
            menuNode.find('.tt-dataset').hide();
            // show empty message and menu
            emptyMessageNode.show();
            menuNode.show();
        } else {
            // show dataset result containers
            menuNode.find('.tt-dataset').show();
            // hide empty message
            emptyMessageNode.hide();
        }
    });
}