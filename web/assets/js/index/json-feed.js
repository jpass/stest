$(document).ready(function(){
    $.get(Routing.generate('json-feed'), function(data){
        if(data)
        {
            data.sort(function(a, b) {
                a = new Date(a.date + ' ' + a.time);
                b = new Date(b.date + ' ' + b.time);

                if(a == b)
                {
                    return 0;
                }

                return a>b ? -1 : 1;
            });

            var $ul = $('<ul>');
            $.each(data, function(key, item){
                var $li = $('<li>');
                var $a = $('<a>').attr('href', item.link).html('<small>'+item.date+' '+item.time+'</small> '+item.title);
                $li.html($a);
                $ul.append($li);
            });
            $('#json-content').html($ul);
        }
    });
});
