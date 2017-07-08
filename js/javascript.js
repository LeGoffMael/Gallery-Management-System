/**
 * Set values in the search auto complete
 */
function setTypahead(input, categories, tags) {
    var categoriesList = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: categories
    });

    var tagsList = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local : tags
    });
    
    $('.search-input').typeahead({
        highlight: true,
        hint: false
    },
    {
        name: 'categories',
        display: 'name',
        source: categoriesList,
        limit: 5,
        templates: {
            header: '<h3 class="typeSearch-name">Categories</h3>',
            suggestion: Handlebars.compile('<div><strong>{{name}}</strong> - {{nb}}<i class="fa fa-picture-o" aria-hidden="true"></i></div>')
        }
    },
    {
        name: 'tags',
        display: 'name',
        source: tagsList,
        limit: 5,
        templates: {
            header: '<h3 class="typeSearch-name">Tags</h3>',
            suggestion: Handlebars.compile('<div><strong>{{name}}</strong> - {{nb}}<i class="fa fa-picture-o" aria-hidden="true"></i></div>')
        }
    });
}