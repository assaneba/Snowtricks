var $collectionHolder2;

// setup an "add a tag" link
var $addTagButton = $('<button type="button" class="btn btn-sm btn-primary btn-add" data-rel="#videos">Ajout embed d\'une vidéo</button>');
var $newLinkLi = $('<p></p>').append($addTagButton);

function addTagForm($collectionHolder2, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder2.data('prototype');

    // get the new index
    var index = $collectionHolder2.data('index');

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder2.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<p></p>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<i class="fas fa-trash"></i>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder2 = $('div.videos');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder2.find('video-input').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder2.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder2.data('index', $collectionHolder2.find(':input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder2, $newLinkLi);
    });
});