$(document).ready(function(){
    $('body').delegate('.tooltip-open-button', 'mouseover', function(e){
        removeTooltip();
        
        var tooltipContent = $(this).attr('ref');
        var posLeft = e.pageX+10;
        var posTop = e.pageY+10;
        
        var tooltipBox = '<div id="tooltip" style="top:' + posTop + 'px;left:' + posLeft + 'px">'
            + tooltipContent
            + '</div>';
        
        $('body').append(tooltipBox);
        $('.tooltip-open-button').mouseout(function(e){
            removeTooltip();
        });
    });
});

var removeTooltip = function(){
    $('#tooltip').fadeOut('slow').delay(200).remove();
}