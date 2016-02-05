$(document).ready(function(){
    $.get(Routing.generate('varnish'), function(data){
        if(data)
        {
            var $ol = $('<ol>');
            $.each(data.topHosts, function(key, item){
                var $li = $('<li>');
                $li.text(key + ' with ' + item + ' hits');
                $ol.append($li);
            });
            $('#varnishTopHosts').html($ol);

            var $ol = $('<ol>');
            $.each(data.topFiles, function(key, item){
                var $li = $('<li>');
                $li.text(key + ' with ' + item + ' hits');
                $ol.append($li);
            });
            $('#varnishTopFiles').html($ol);
        }
    });
});
