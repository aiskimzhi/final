/**
 * Gets image path
 *
 * @param i
 * @returns {*|jQuery}
 */
function getImage(i)
{
    var sel = 'div#car' + i + ' div div.active img';
    var sel2 = '#avatar_' + i;
    var im = $(sel).attr('src');
    return $(sel2).attr('value', im);
}

/**
 * Inserts path of the avatar into database
 *
 * @param id
 * @param i
 */
function setAvatar(id, i)
{
    var sel1 = '#avatar_' + i;
    var p = $(sel1).attr('value');
    $.ajax({
        url: 'modal?id=' + id,
        type: 'post',
        data: 'img=' + p
    });
}
