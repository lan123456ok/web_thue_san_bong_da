function formatDateTimeToDate(date) {
    let cr = new Date(date);
    return ("0" + (cr.getUTCMonth()+1)).slice(-2) + "/" + ("0" + cr.getUTCDate()).slice(-2) + "/" + cr.getUTCFullYear() ;
}

function renderPagination(links) {
    links.forEach(function(each) {
        $('#pagination').append($('<li>').attr('class', `page-item ${each.active ? 'active' : ''}`)
            .append(`<a class="page-link">${each.label}</a>`));
    });
}
