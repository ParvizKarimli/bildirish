// This is file is used in credits/index view

function getCreditsBySearchTerm(search_term) {
    var search_term = document.getElementById('search_term').value;

    if(search_term == '') {
        document.getElementById('credits_table').innerHTML = 'empty';
        return;
    } else {
        document.getElementById('credits_table').innerHTML = search_term;
        return;
    }
}