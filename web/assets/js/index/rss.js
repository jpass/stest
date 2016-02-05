$(document).ready(function(){
    $.get(Routing.generate('rss'), function(data){
        if(data)
        {
            var $ul = $('<ul>');
            $.each(data.articles, function(key, item){
                var $li = $('<li>');
                var $a = $('<a>').attr('href', item.link).html('<small>'+item.date+'</small> '+item.title);
                $li.html($a);
                $ul.append($li);
            });
            $('#rss-content').html($ul);
        }
    });
});
